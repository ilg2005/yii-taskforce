<?php


namespace frontend\controllers;


use frontend\models\User;
use yii\base\Controller;

class UserController extends Controller
{
    public $layout = 'basic';
    public function actionShow()
    {
        $users = User::find()
            ->joinWith('tasks')
            ->orderBy(['tasks.id' => SORT_DESC])
            ->all();
        return $this->render('show', compact('users'));
    }
}
