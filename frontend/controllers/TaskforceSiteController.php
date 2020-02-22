<?php


namespace frontend\controllers;

use frontend\constants\TaskStatuses;
use frontend\models\Reaction;
use frontend\models\Task;

use frontend\models\User;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

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
        /*$model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);*/

        return $this->render('signup');
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
            ->with(['category']);

        if(Yii::$app->request->get('category')) {
            $tasks->where(['category_id' => Yii::$app->request->get('category')]);
        }

        if(Yii::$app->request->get('no-responses')) {
            $arrayFromDB = array_values(Reaction::find()->select('task_id')->asArray()->all());
            $res = [];
            foreach ($arrayFromDB as $value) {
                $res[] = (int)$value['task_id'];
            }
            $tasks->andWhere(['not in', 'id', $res]);
        }

        if(Yii::$app->request->get('no-location')) {
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

        $pages = new Pagination(['totalCount' => $tasks->count(), 'pageSize' => $tasksCountPerPage, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $tasks = $tasks->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $categories = CategoryController::getCategories();
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
        return $this->render('profile');
    }

    /**
     * Displays users' list page.
     *
     * @return mixed
     */
    public function actionUsers()
    {
        $usersCountPerPage = 5;
        $users = User::find()
            ->with(['profile'])
            ->with(['categories']);

        $pages = new Pagination(['totalCount' => $users->count(), 'pageSize' => $usersCountPerPage, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $users = $users->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('users', compact('users', 'pages'));
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
}
