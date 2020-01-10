<?php

namespace console\controllers;

use console\models\Import;
use yii\console\Controller;

class ImportController extends Controller
{
    const DATA_MODEL_MAP = [
        'categories' => 'Category',
        'cities' => 'Location',
        'profiles' => 'Profile',
        'users' => 'User',
        'tasks' => 'Task',
        'replies' => 'Grade',
    ];

    public function importData($filename, $modelName)
    {
        $arrayFromCSV = Import::readCSV($filename);

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

    public function actionIndex($file = '', $model = '') {
        if ($file && $model) {
            $this->importData($file, $model);
        } else {
            foreach (self::DATA_MODEL_MAP as $filename => $modelName) {
                $this->importData($filename, $modelName);
            }
        }
    }
}
