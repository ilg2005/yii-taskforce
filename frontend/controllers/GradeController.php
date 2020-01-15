<?php


namespace frontend\controllers;


use frontend\models\Grade;
use yii\base\Controller;

class GradeController extends Controller
{
    public $layout = 'basic';
    public function actionShow()
    {
        $grades = Grade::find()->asArray()->all();
        return $this->render('show', compact('grades'));
    }
}
