<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'icon'], 'safe'],
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'id'])->viaTable('users_categories', ['category_id' => 'id']);
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['category_id' => 'id']);
    }

    public static function tableName()
    {
        return 'categories';
    }
}
