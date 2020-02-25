<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Reaction extends ActiveRecord
{
    public function rules()
    {
        return [
            [['task_id', 'worker_id', 'worker_price', 'worker_comment'], 'safe'],
        ];
    }

    public function getTasks() {
        return $this->hasMany(Task::class, ['id' => 'task_id']);
    }

    public static function tableName()
    {
        return 'tasks_reactions';
    }
}
