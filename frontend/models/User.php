<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'registration_date'], 'safe'],
        ];
    }

    public static function tableName()
    {
        return 'users';
    }
}
