<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Location extends ActiveRecord
{
/*    public $id;
    public $city;
    public $latitude;
    public $longitude;*/

    public static function tableName()
    {
        return 'locations';
    }
}
