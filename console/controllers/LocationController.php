<?php

namespace console\controllers;

use frontend\models\Location;
use yii\console\Controller;

class LocationController extends Controller
{
    public function actionImport()
    {
        $lines = file('D:\OSPanel\domains\yii-taskforce\data\cities.csv');
        array_shift($lines);
        foreach ($lines as $line) {
            $location = new Location();
            $data = str_getcsv($line);
            $location->city = $data[0];
            $location->latitude = $data[1];
            $location->longitude = $data[2];
            $location->save();
        }
    }
}
