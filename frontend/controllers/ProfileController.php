<?php


namespace frontend\controllers;


use frontend\models\Profile;
use yii\base\Controller;

class ProfileController extends Controller
{
    public $layout = 'basic';
    public function actionShow()
    {
        $profiles = Profile::find()->asArray()->all();
        return $this->render('show', compact('profiles'));
    }
}
