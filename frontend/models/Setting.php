<?php

namespace frontend\models;


use yii\db\ActiveRecord;

class Setting extends ActiveRecord
{

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id']);
    }

    public static function tableName()
    {
        return 'users_settings';
    }
}
