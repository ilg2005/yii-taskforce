<?php


namespace frontend\controllers;

use frontend\models\EnterForm;
use frontend\models\Task;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\Controller;
use yii\widgets\ActiveForm;

class TaskforceSiteController extends Controller
{
    public $layout = 'basic';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'signup', 'error'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'logout', 'account', 'browse', 'create', 'mylist', 'profile', 'users', 'view', 'image', 'error'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['signup'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->redirect('/browse');
                        }
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    Yii::$app->response->redirect(['/index']);
                },
            ],
        ];
    }

    public function actionIndex()
    {
        $tasksNumberToShow = 4;
        $tasks = Task::find()
            ->orderBy(['creation_date' => SORT_DESC])
            ->limit($tasksNumberToShow)
            ->with('category')
            ->all();

        $model = new EnterForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = $model->getUser();
            Yii::$app->user->login($user);
            Yii::$app->response->redirect(Url::to('/browse'));
        }

        return $this->render('index', compact('tasks', 'model'));
    }

    public function actionImage()
    {
        $filename = Yii::$app->request->get('filename');
        return $this->render('image', compact('filename'));
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

}
