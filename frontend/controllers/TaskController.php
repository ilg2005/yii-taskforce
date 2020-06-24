<?php


namespace frontend\controllers;


use frontend\models\Category;
use frontend\models\CompletionForm;
use frontend\models\CreateForm;
use frontend\models\Feedback;
use frontend\models\File;
use frontend\models\Profile;
use frontend\models\ReplyForm;
use frontend\models\Reply;
use frontend\models\Task;
use frontend\models\UploadFiles;
use frontend\models\User;
use taskforce\constants\TaskStatuses;
use taskforce\constants\TaskStrategy;
use taskforce\constants\UserActions;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class TaskController extends BehaviorsController
{

    public $currentTaskID;

    public function actionBrowse()
    {
        $tasksCountPerPage = 5;
        $tasks = Task::find()
            ->where(['status' => TaskStatuses::NEW])
            ->orderBy(['creation_date' => SORT_DESC])
            ->with('category');

        if (Yii::$app->request->get('category')) {
            $tasks->andWhere(['category_id' => Yii::$app->request->get('category')]);
        }

        /*Потенциальная ошибка tasks_reactions -> tasks_replies */
        if (Yii::$app->request->get('no-responses')) {
            $tasks->joinWith('reactions');
            $tasks->andWhere('tasks_reactions.id IS NULL');
        }

        if (Yii::$app->request->get('no-location')) {
            $tasks->andWhere(['location_id' => null]);
        }

        $timePeriod = Yii::$app->request->get('time');
        $subquery = date('Y-m-d H:i:s', strtotime("-1 $timePeriod"));
        if ($timePeriod && $timePeriod !== 'all') {
            $tasks->andWhere(['>=', 'creation_date', $subquery]);
        }

        $search = Yii::$app->request->get('q');
        if (!empty($search)) {
            $tasks->andWhere(['like', 'title', $search]);
        }

        $pages = new Pagination([
            'totalCount' => $tasks->count(),
            'pageSize' => $tasksCountPerPage,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $tasks = $tasks->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $categories = Category::find()->all();

        return $this->render('browse', compact('tasks', 'pages', 'categories'));
    }

    public function actionCreate()
    {
        $user = Yii::$app->user->identity;

        if (!TaskStrategy::checkAccess($user, UserActions::CREATE)) {
            throw new NotFoundHttpException('Задание может создать только заказчик');
        }
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');

        $model = new CreateForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $task = new Task();

            $task->customer_id = $user->id;
            $task->title = $model->title;
            $task->description = $model->description;
            $task->category_id = $model->category;


            if (isset($model->budget)) {
                $task->budget = $model->budget;
            }

            if (isset($model->deadline)) {
                $task->deadline = $model->deadline;
            }

            if ($task->save() && isset($_FILES)) {
                $taskFiles = UploadedFile::getInstancesByName('files');
                UploadFiles::upload($taskFiles);
                foreach ($taskFiles as $taskFile) {
                    $file = new File();
                    $file->user_id = $user->id;
                    $file->filename = "{$taskFile->baseName}_" . date('Y-m-d') . '.' . $taskFile->extension;
                    $file->save();
                    $task->link('files', $file);
                }
            }

            Yii::$app->response->redirect(Url::to("/view?task_id={$task->id}"));
        }

        return $this->render('create', compact('model', 'categories'));
    }

    public function actionView()
    {
        $task = Task::findOne(Yii::$app->request->get('task_id'));
        $this->currentTaskID = $task->id;

        $isAuthor = Yii::$app->user->id === $task->customer_id;
        $isWorker = Yii::$app->user->id === $task->worker_id;

        if ($task->worker_id && $isAuthor) {
            $user = User::findOne($task->worker_id);
        } else {
            $user = User::findOne($task->customer_id);
        }

        $model = $this->actionReply();
        $completionForm = new CompletionForm();

        return $this->render('view', compact('task', 'isAuthor', 'isWorker', 'user', 'model', 'completionForm'));
    }

    public function actionReply()
    {
        $model = new ReplyForm();
        $reply = new Reply();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $reply->task_id = $this->currentTaskID;
            $reply->applicant_id = Yii::$app->user->id;
            $reply->applicant_price = $model->price;
            $reply->applicant_comment = $model->comment;
            $reply->save();
            Yii::$app->response->redirect(Url::to("/view?task_id={$reply->task_id}"));
        }
        return $model;
    }

    public function actionConfirm($taskId, $currentUserId, $applicantId)
    {
        $task = Task::findOne($taskId);
        if ($task->customer_id == $currentUserId && $task->status === TaskStatuses::NEW) {

            /* 1) Сменить статус задания: «На исполнении».*/
            $task->status = TaskStatuses::ACTIVE;

            /* 2) Назначить автора отклика исполнителем этого задания.*/
            $task->worker_id = $applicantId;

            $task->save();

            /* 3) Инициировать процесс «отправка уведомления».
               4) Переадресовать на главную страницу*/
            Yii::$app->response->redirect(["/view?task_id={$taskId}"]);
        }
    }

    public function actionRefuse($taskId, $currentUserId, $applicantId)
    {
        $task = Task::findOne($taskId);
        if ($task->customer_id == $currentUserId && $task->status === TaskStatuses::NEW) {

            /* 1) Cкрывать кнопки-действия с этого отклика*/
            $reply = Reply::find()->where(['task_id' => $task->id])->one();
            $reply->is_refused = true;
            $reply->save();

            Yii::$app->response->redirect(["/view?task_id={$taskId}"]);
        }
    }

    public function actionCancel($taskId, $currentUserId)
    {
        $task = Task::findOne($taskId);
        if ($task->customer_id == $currentUserId && $task->status === TaskStatuses::NEW) {

            /* Статус задания меняется на «Отменено». Отмена заданий со статусом «На исполнении» невозможна. */
            $task->status = TaskStatuses::CANCELED;
            $task->save();

            /*Затем следует переадресация на страницу просмотра.*/
            Yii::$app->response->redirect(["/view?task_id={$taskId}"]);
        }
    }

    public function actionFail($taskId, $currentUserId)
    {
        $task = Task::findOne($taskId);
        if ($task->worker_id == $currentUserId && $task->status === TaskStatuses::ACTIVE) {

            /* Отказ меняет статус задания на «Провалено»*/
            $task->status = TaskStatuses::FAILED;
            $task->save();

            /* и увеличивает у исполнителя счётчик проваленных заданий.*/

            /*Затем следует переадресация на страницу просмотра.*/
            Yii::$app->response->redirect(["/view?task_id={$taskId}"]);
        }
    }

    public function actionComplete()
    {

        if (Yii::$app->request->getIsPost()) {
            $completionForm = new CompletionForm();
            $completionForm->load(Yii::$app->request->post());
            $task = Task::findOne($completionForm->task_id);

            if ($task && $completionForm->validate()) {
                $feedback = new Feedback();
                $feedback->task_id = $completionForm->task_id;
                $feedback->worker_id = $task->worker_id;
                $feedback->customer_id = $task->customer_id;
                $feedback->rate = $completionForm->rate;
                $feedback->comment = $completionForm->comment;
                $feedback->save();

                $task->status = ($completionForm->completionStatus === 'yes') ? TaskStatuses::COMPLETED : TaskStatuses::FAILED;
                $task->save();

            }
        }

        return $this->redirect(["/view?task_id={$completionForm->task_id}"]);

    }

    public function actionMylist()
    {
        return $this->render('mylist');
    }

}
