<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'registration_date', 'profile_id'], 'safe'],
            ['email', 'email'],
        ];
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['customer_id' => 'id']);
    }

    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->viaTable('users_categories', ['user_id' => 'id']);
    }


    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }

    public function getStatistics()
    {
        return $this->hasMany(Statistics::class, ['user_id' => 'id']);
    }

    public static function tableName()
    {
        return 'users';
    }
}
