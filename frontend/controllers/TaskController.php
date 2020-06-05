<?php


namespace frontend\controllers;


use frontend\models\Category;
use frontend\models\CreateForm;
use frontend\models\Files;
use frontend\models\Task;
use frontend\models\UploadFiles;
use taskforce\constants\TaskStatuses;
use taskforce\constants\TaskStrategy;
use taskforce\constants\UserActions;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class TaskController extends SecureController
{

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
        if (!TaskStrategy::checkAccess(Yii::$app->user->identity, UserActions::CREATE)) {
            throw new NotFoundHttpException('Задание может создать только заказчик');
        }
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');

        $model = new CreateForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (isset($_FILES)) {
                $taskFiles = UploadedFile::getInstancesByName('files');
                $files = UploadFiles::upload($taskFiles);
            }
        }

        return $this->render('create', compact('model', 'categories'));
    }

    public function actionView()
    {
        return $this->render('view');
    }

    public function actionMylist()
    {
        return $this->render('mylist');
    }

}
