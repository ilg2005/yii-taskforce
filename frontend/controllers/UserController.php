<?php


namespace frontend\controllers;


use frontend\models\User;
use yii\base\Controller;

class UserController extends Controller
{
    public $layout = 'basic';
    public function actionShow()
    {
        $users = User::find()->asArray()
            ->with('statistics')
            ->with('categories')
            ->all();
        return $this->render('show', compact('users'));
    }
}
