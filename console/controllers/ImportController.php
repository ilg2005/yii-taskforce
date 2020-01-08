<?php

namespace console\controllers;

use console\models\Import;
use yii\console\Controller;

class ImportController extends Controller
{

    public function actionIndex($filename, $modelName)
    {
        $arrayFromCSV = Import::readCSV($filename);
        $titleLine = array_shift($arrayFromCSV);
        $titles = str_getcsv($titleLine);

        $modelClass = 'frontend\models\\' . $modelName;
        $values = [];
        foreach ($arrayFromCSV as $line) {
            $instance = new $modelClass();
            $data = str_getcsv($line);

            foreach ($titles as $key => $title) {
                $values[$title] = $data[$key];
            }
            $instance->attributes = $values;
            $instance->save();
        }
    }
}
