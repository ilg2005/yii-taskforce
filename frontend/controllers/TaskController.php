<?php


namespace frontend\controllers;

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

}
