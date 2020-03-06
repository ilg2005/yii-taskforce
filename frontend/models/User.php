<?php


namespace frontend\models;


use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'town', 'email', 'password', 'registration_date', 'profile_id', 'role', 'latest_activity_time', 'is_favorite', 'rating', 'feedbacks_count', 'tasks_count', 'views_count'], 'safe'],
            ['email', 'email'],
        ];
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['worker_id' => 'id']);
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


    public function getPortfolio()
    {
        return $this->hasMany(Portfolio::class, ['user_id' => 'id']);
    }

    public function getFeedbacks()
    {
        return $this->hasMany(Feedback::class, ['worker_id' => 'id']);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }


    public static function tableName()
    {
        return 'users';
    }
}
