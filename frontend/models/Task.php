<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Task extends ActiveRecord
{
    public function rules()
    {
        return [
            [['creation_date', 'title', 'description', 'category_id', 'address', 'budget', 'deadline', 'latitude', 'longitude', 'customer_id', 'worker_id', 'location_id', 'status'], 'safe'],
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getReactions() {
        return $this->hasMany(Reaction::class, ['task_id' => 'id']);
    }

    public function getFiles() {
        return $this->hasMany(File::class, ['id' => 'file_id'])
            ->viaTable('tasks_files', ['task_id' => 'id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }

    public function getWorker()
    {
        return $this->hasOne(User::class, ['id' => 'worker_id']);
    }

    public static function tableName()
    {
        return 'tasks';
    }
}
