<?php

namespace frontend\models;


use yii\db\ActiveRecord;

class Setting extends ActiveRecord
{
public function rules()
{
    return [
        [['user_id', 'new_message', 'actions_on_task', 'new_feedback', 'show_to_customer', 'hide_user_profile'], 'safe'],
    ];
}

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id']);
    }

    public static function tableName()
    {
        return 'users_settings';
    }
}
