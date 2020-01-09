<?php

namespace console\models;

use yii\base\Model;

class Import extends Model
{
    const FILE_PATH = 'D:\OSPanel\domains\yii-taskforce\data\\';

    public static function readCSV($filename)
    {
        $arrayFromCSV = file(self::FILE_PATH . $filename . '.csv');
        $titleLine = array_shift($arrayFromCSV);
        $titles = str_getcsv($titleLine);
        $newData = [];
        $resultArray = [];
        foreach ($arrayFromCSV as $line) {
            $data = str_getcsv($line);
            foreach ($titles as $key => $title) {
                $newData[$title] = $data[$key];
            }
            $resultArray[] = $newData;
        }
        return $resultArray;
    }
}
