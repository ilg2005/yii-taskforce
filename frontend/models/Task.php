<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Task extends ActiveRecord
{
    public function rules()
    {
        return [
            [['creation_date', 'title', 'description', 'category', 'address', 'budget', 'deadline', 'latitude', 'longitude', 'customer_id'], 'safe'],
        ];
    }

    public static function tableName()
    {
        return 'tasks';
    }
}
