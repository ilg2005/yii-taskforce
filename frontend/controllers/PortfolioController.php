<?php


namespace frontend\controllers;


use frontend\models\Portfolio;
use frontend\models\User;
use yii\web\Controller;

class PortfolioController extends Controller
{
    public $layout = 'basic';
    public function actionShow()
    {
        $users = User::find()
            ->with('portfolio')
            ->all();

        return $this->render('show', compact('users'));
    }

}
