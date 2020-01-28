<?php


namespace frontend\controllers;


use frontend\models\Task;
use yii\base\Controller;

class TaskController extends Controller
{
    public $layout = 'basic';

    public function actionShow()
    {
       $tasks = Task::find()->with('category')->asArray()->all();
       return $this->render('show', compact('tasks'));
    }

    public static function getLatestTasks($numberToGet = '')
    {
        $tasks = Task::find()->with('category')->orderBy(['creation_date' => SORT_DESC]);
        if ($numberToGet) {
            $tasks = $tasks->limit($numberToGet);
        }
        return $tasks->all();
    }
}
