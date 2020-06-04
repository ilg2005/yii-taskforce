<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Files extends ActiveRecord
{
    public function rules(): array
    {
        return [
            ['task_id', 'integer'],
            ['filename', 'string', 'max' => 255],
        ];
    }

    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    public static function tableName()
    {
        return 'tasks_files';
    }
}
