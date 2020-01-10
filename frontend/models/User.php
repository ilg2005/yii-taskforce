<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'registration_date'], 'safe'],
            ['email', 'email'],
        ];
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['customer_id' => 'id']);
    }

    public static function tableName()
    {
        return 'users';
    }
}
