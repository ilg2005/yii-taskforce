<?php

namespace console\controllers;

use console\models\Import;

use frontend\models\Location;
use yii\console\Controller;

class ImportController extends Controller
{

    public function actionIndex($filename)
    {
        $arrayFromCSV = Import::readCSV($filename);
        $titleLine = array_shift($arrayFromCSV);
        $titles = str_getcsv($titleLine);

        //$className = $currentModel;
        $values = [];
        foreach ($arrayFromCSV as $line) {
            $instance = new Location();
            $data = str_getcsv($line);

            foreach ($titles as $key => $title) {
                $values[$title] = $data[$key];
            }
            $instance->attributes = $values;
            $instance->save();
        }
    }
}
