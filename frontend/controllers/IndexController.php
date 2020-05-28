<?php


namespace frontend\controllers;


use frontend\models\EnterForm;
use frontend\models\Task;
use Yii;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;

class IndexController extends SecureController
{


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

}
