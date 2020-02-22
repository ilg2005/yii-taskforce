<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Statistics extends ActiveRecord
{
    public function rules()
    {
        return [
            [['user_id', 'role', 'latest_activity_time', 'is_favorite', 'rating', 'reviews_count', 'tasks_count', 'views_count'], 'safe'],
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(USER::class, ['id' => 'user_id']);
    }

    public static function tableName()
    {
        return 'users_statistics';
    }
}
