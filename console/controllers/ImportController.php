<?php

namespace console\controllers;

use console\models\Import;
use yii\console\Controller;

class ImportController extends Controller
{
    public function actionIndex($filename, $modelName)
    {
        $arrayFromCSV = Import::readCSV($filename);
        print_r($arrayFromCSV);

        $modelClass = 'frontend\models\\' . $modelName;

        foreach ($arrayFromCSV as $data) {
            $values = [];
            $instance = new $modelClass();
            foreach ($data as $key => $value) {
                $values[$key] = $value;
            }
            $instance->attributes = $values;
            $instance->save();
        }
    }
}
