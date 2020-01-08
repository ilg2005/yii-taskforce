<?php

namespace console\models;

use yii\base\Model;

class Import extends Model
{
    public static function readCSV($filename)
    {
        $arrayFromCSV = file('D:\OSPanel\domains\yii-taskforce\data\\' . $filename . '.csv');
        // array_shift($arrayFromCSV);
        echo print_r($arrayFromCSV);
        return $arrayFromCSV;
    }

}
