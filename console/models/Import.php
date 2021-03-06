<?php

namespace console\models;

use SplFileObject;
use yii\base\Model;

class Import extends Model
{
    public const FILE_PATH = __DIR__ . '/../../data/';

    public static $titles;

    public static function readCSV($filename)
    {
        $file = new SplFileObject(self::FILE_PATH . $filename . '.csv');
        $file->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY);
        self::$titles = $file->current();
        $resultArray = [];
        foreach ($file as $row) {
            if ($row && $file->key()) {
                $resultArray[] = array_combine(self::$titles, $row);
            }
        }
        print_r($resultArray);
        return $resultArray;
        /*$arrayFromCSV = file(self::FILE_PATH . $filename . '.csv');
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
        print_r($resultArray);
        return $resultArray;*/
    }
}
