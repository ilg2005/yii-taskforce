<?php

namespace console\controllers;

use console\models\Import;
use Yii;
use yii\console\Controller;
use yii\db\Exception;

class ImportController extends Controller
{
    const DATA_MODEL_MAP = [
        'categories' => 'Category',
        'cities' => 'Location',
        'profiles' => 'Profile',
        'users' => 'User',
        'tasks' => 'Task',
        'replies' => 'Grade',
        'reactions' => 'Reaction',
        'users-statistics' => 'Statistics'
    ];

    const DATA_TABLE_MAP = [
        'users-categories' => 'users_categories',
    ];

    public function directImport2Table($filename, $tableName)
    {
        $values = [];
        foreach (Import::readCSV($filename) as $array) {
            $values[] = array_values($array);
        }
        $columnNames = Import::$titles;
        try {
            Yii::$app->db->createCommand()->batchInsert($tableName, $columnNames, $values)->execute();
        } catch (Exception $e) {
            die("Error: $e");
        }
    }

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
            foreach (self::DATA_TABLE_MAP as $filename => $tableName) {
                $this->directImport2Table($filename, $tableName);
            }
        }
    }
}
