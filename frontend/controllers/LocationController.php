<?php


namespace frontend\controllers;

require_once '../../functions.php';

use frontend\models\Location;
use yii\base\Controller;

class LocationController extends Controller
{
    public function actionImport()
    {
        $lines = file('../../data/cities.csv');
        array_shift($lines);
        foreach ($lines as $line) {
            $location = new Location();
            $data = str_getcsv($line);
            $location->city = $data[0];
            $location->latitude = $data[1];
            $location->longitude = $data[2];
            $location->save();
        }
        $locations = Location::find()->asArray()->all();
        return $this->render('import', compact('locations'));
    }

    public function actionShow()
    {
        $locations = Location::find()->asArray()->all();
        return $this->render('show', compact('locations'));
    }

}
