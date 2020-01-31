<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Task extends ActiveRecord
{
    public function rules()
    {
        return [
            [['creation_date', 'title', 'description', 'category_id', 'address', 'budget', 'deadline', 'latitude', 'longitude', 'customer_id'], 'safe'],
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category']);
    }

    public function getCustomer()
    {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }

    public static function tableName()
    {
        return 'tasks';
    }
}
