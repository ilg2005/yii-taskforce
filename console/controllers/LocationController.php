<?php

namespace console\controllers;

use console\models\Import;
use frontend\models\Location;
use yii\console\Controller;

class LocationController extends Controller
{
    public function actionImport($filename)
    {
        $arrayFromCSV = Import::readCSV($filename);
        $titleLine = array_shift($arrayFromCSV);
        $titles = str_getcsv($titleLine);


        foreach ($arrayFromCSV as $line) {
            foreach ($titles as $key => $title) {
                $location = new Location();
                $data = str_getcsv($line);
                $location->$title = $data[$key];
                $location->save();
            }
        }
    }
}
