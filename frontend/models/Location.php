<?php


namespace frontend\models;

use yii\db\ActiveRecord;

class Location extends ActiveRecord
{
    public function rules()
    {
        return [
            [['town', 'latitude', 'longitude'], 'safe'],
        ];
    }

    public static function tableName()
    {
        return 'locations';
    }
}
