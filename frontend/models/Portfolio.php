<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Portfolio extends ActiveRecord
{
    public function rules()
    {
        return [
            [['user_id', 'filename'], 'safe'],
        ];
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function tableName()
    {
        return 'users_portfolio';
    }
}
