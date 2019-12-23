<?php


namespace frontend\controllers;


use frontend\models\Location;
use yii\base\Controller;

class LocationController extends Controller
{
   public function actionShow() {
       $locations = Location::find()->all();
       return $this->render('show', compact('locations'));
   }

}
