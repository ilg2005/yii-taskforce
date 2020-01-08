<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'icon'], 'safe'],
        ];
    }

    public static function tableName()
    {
        return 'categories';
    }
}