<?php


namespace frontend\controllers;


use frontend\models\Statistics;
use yii\base\Controller;

class StatisticsController extends Controller
{
    public $layout = 'basic';
    public static function getStatistics()
    {
        return Statistics::find()->asArray()->with('users')->all();
    }

    public function actionShow()
    {
        $statistics = self::getStatistics();
        return $this->render('show', compact('statistics'));
    }
}
