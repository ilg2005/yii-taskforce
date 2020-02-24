<?php


namespace frontend\controllers;


use frontend\models\Statistics;
use yii\base\Controller;

class StatisticsController extends Controller
{
    public $layout = 'basic';

    public function actionShow()
    {
        $statistics = Statistics::find()->asArray()->with('users')->all();
        return $this->render('show', compact('statistics'));
    }
}
