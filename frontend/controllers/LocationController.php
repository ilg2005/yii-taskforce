<?php


namespace frontend\controllers;

use frontend\models\Location;
use yii\base\Controller;

class LocationController extends Controller
{
    public $layout = 'basic';
    public function actionShow()
    {
        $locations = Location::find()->asArray()->all();
        return $this->render('show', compact('locations'));
    }

}
