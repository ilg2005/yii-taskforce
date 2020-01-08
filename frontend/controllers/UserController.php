<?php


namespace frontend\controllers;


use frontend\models\User;
use yii\base\Controller;

class UserController extends Controller
{
    public function actionShow()
    {
        $users = User::find()->asArray()->all();
        return $this->render('show', compact('users'));
    }
}