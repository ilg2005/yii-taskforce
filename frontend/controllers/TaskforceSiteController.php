<?php


namespace frontend\controllers;

use frontend\constants\TaskStatuses;
use frontend\models\Response;
use frontend\models\Task;

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
            $arrayFromDB = array_values(Response::find()->select('task_id')->asArray()->all());
            $res = [];
            foreach ($arrayFromDB as $value) {
                $res[] = (int)$value['task_id'];
            }
            $tasks->where(['not in', 'id', $res]);
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
        return $this->render('users');
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
