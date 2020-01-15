<?php


namespace frontend\controllers;


use frontend\models\Task;
use yii\base\Controller;

class TaskController extends Controller
{
    public $layout = 'basic';
    public function actionShow()
    {
        $tasks = Task::find()->asArray()->all();
        return $this->render('show', compact('tasks'));
    }
}
