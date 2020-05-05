<?php

namespace frontend\models;


use yii\db\ActiveRecord;

class Setting extends ActiveRecord
{
public function rules()
{
    return [
        [['new_message', 'actions_on_task', 'new_feedback', 'show_to_customer', 'hide_user_profile'], 'safe'],
    ];
}

    public function getUsers()
    {
        return $this->hasMany(User::class, ['settings_id' => 'id']);
    }

    public static function tableName()
    {
        return 'users_settings';
    }
}
