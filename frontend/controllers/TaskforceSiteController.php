<?php


namespace frontend\controllers;

use frontend\constants\TaskStatuses;
use frontend\constants\UserRoles;
use frontend\models\Category;
use frontend\models\Feedback;
use frontend\models\SignupForm;
use frontend\models\Task;

use frontend\models\User;
use Yii;
use yii\web\Response;
use yii\data\Pagination;
use yii\web\Controller;
use yii\widgets\ActiveForm;

class TaskforceSiteController extends Controller
{
    public $layout = 'basic';
    /**
     * @var string
     */

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $tasksNumberToShow = 4;
        $tasks = Task::find()
            ->orderBy(['creation_date' => SORT_DESC])
            ->limit($tasksNumberToShow)
            ->with('category')
            ->all();
        return $this->render('index', compact('tasks'));
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $user = new User();
            $user->email = $model->email;
            $user->name = $model->name;
            $user->town = $model->town[0];
            $user->setPassword($model->password);
            $user->save();

            Yii::$app->session->setFlash('success', 'Регистрация успешна!');
            return $this->goHome();
        }

        return $this->render('signup', ['model' => $model,]);

    }

    /**
     * Displays account settings.
     *
     * @return mixed
     */
    public function actionAccount()
    {
        return $this->render('account');
    }

    /**
     * Displays new tasks page.
     *
     * @return mixed
     */
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

    /**
     * Displays new task publication page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->render('create');
    }

    /**
     * Displays user' tasks list page.
     *
     * @return mixed
     */
    public function actionMylist()
    {
        return $this->render('mylist');
    }

    /**
     * Displays user' profile page.
     *
     * @return mixed
     */
    public function actionProfile()
    {
        $user = User::find()
            ->where(['users.id' => Yii::$app->request->get('user_id')])
            ->with([
                'tasks' => function ($query) {
                    $query->andWhere(['status' => TaskStatuses::COMPLETED]);
                }
            ])
            ->one();

        $tasksCount = count($user->tasks);

        $feedbacks = Feedback::find()
            ->where(['worker_id' => Yii::$app->request->get('user_id')])
            ->with(['customer', 'avatar', 'task']);

        $feedbacksCount = count($feedbacks);
        $feedbacksCountPerPage = 3;
        $pages = new Pagination([
            'totalCount' => $feedbacksCount,
            'pageSize' => $feedbacksCountPerPage,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $feedbacks = $feedbacks->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if (Yii::$app->request->get('is_favorite') !== null) {
            $user->is_favorite = Yii::$app->request->get('is_favorite');
            $user->save();
        }

        return $this->render('profile', compact('user', 'feedbacks', 'pages', 'feedbacksCount', 'tasksCount'));
    }

    /**
     * Displays users' list page.
     *
     * @return mixed
     */
    public function actionUsers()
    {
        $users = User::find()
            ->where(['role' => UserRoles::WORKER])
            ->orderBy(['registration_date' => SORT_DESC])
            ->with(['profile', 'categories'])
            ->groupBy(['id', 'rating', 'tasks_count', 'views_count']);

        if (Yii::$app->request->get('rating')) {
            $users->orderBy(['rating' => SORT_DESC]);
        }

        if (Yii::$app->request->get('tasks')) {
            $users->orderBy(['tasks_count' => SORT_DESC]);
        }

        if (Yii::$app->request->get('views')) {
            $users->orderBy(['views_count' => SORT_DESC]);
        }

        if (Yii::$app->request->get('category')) {
            $users->joinWith('categories')
                ->andWhere(['users_categories.category_id' => Yii::$app->request->get('category')]);
        }

        if (Yii::$app->request->get('free')) {
            $users->joinWith('tasks')
                ->andWhere(['not in', 'status', TaskStatuses::ACTIVE]);
        }

        if (Yii::$app->request->get('online')) {
            $users->andWhere(['>=', 'latest_activity_time', date('Y-m-d H:i:s', strtotime('-30 minutes'))]);
        }

        if (Yii::$app->request->get('feedbacks')) {
            $users->andWhere(['>', 'feedbacks_count', 0]);
        }

        if (Yii::$app->request->get('favorite')) {
            $users->andWhere(['is_favorite' => 1]);
        }

        $searchByName = Yii::$app->request->get('name');
        if (!empty($searchByName)) {
            $users->where(['like', 'name', $searchByName]);
        }

        $usersCountPerPage = 5;
        $pages = new Pagination([
            'totalCount' => $users->count(),
            'pageSize' => $usersCountPerPage,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $users = $users->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $categories = Category::find()->all();

        return $this->render('users', compact('users', 'pages', 'categories'));
    }

    /**
     * Displays task view page.
     *
     * @return mixed
     */
    public function actionView()
    {
        return $this->render('view');
    }

    /**
     * Displays image file view page.
     *
     * @return mixed
     */
    public function actionImage()
    {
        $filename = Yii::$app->request->get('filename');
        return $this->render('image', compact('filename'));
    }
}
