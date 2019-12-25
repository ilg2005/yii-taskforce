<?php

namespace console\controllers;

use console\models\Import;
use frontend\models\Location;
use yii\console\Controller;

class LocationController extends Controller
{
    public function actionImport($filename)
    {
        $lines = Import::readCSV($filename);
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
