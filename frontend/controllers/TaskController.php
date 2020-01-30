<?php


namespace frontend\controllers;


use frontend\constants\TaskStatuses;
use frontend\models\Task;
use yii\base\Controller;
use yii\data\Pagination;

class TaskController extends Controller
{
    public $layout = 'basic';

    public function actionShow()
    {
        $tasks = Task::find()->with(['category']);
        $pages = new Pagination(['totalCount' => $tasks->count(), 'pageSize' => 1]);
        $tasks = $tasks->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('show', compact('tasks', 'pages'));
    }

    public static function getLatestTasks($numberToGet = '')
    {
        $tasks = Task::find()->orderBy(['creation_date' => SORT_DESC]);
        if ($numberToGet) {
            $tasks = $tasks->limit($numberToGet);
        }
        return $tasks->with('category')->asArray()->all();
    }

    public static function getNewTasks()
    {
        $tasksCountPerPage = 5;
        $tasks = Task::find()
            ->where(['status' => TaskStatuses::NEW])
            ->orderBy(['creation_date' => SORT_DESC])
            ->with(['category'])
            ->asArray();
        $pages = new Pagination(['totalCount' => $tasks->count(), 'pageSize' => $tasksCountPerPage]);
        $tasks = $tasks->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return array($tasks, $pages);
    }
}
