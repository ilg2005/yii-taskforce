<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class File extends ActiveRecord
{
    public function rules(): array
    {
        return [
            ['user_id', 'integer'],
            ['filename', 'string']
        ];
    }

    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id'])
            ->viaTable('tasks_files', ['file_id' => 'id']);
    }


    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])
            ->viaTable('users_portfolio', ['file_id' => 'id']);;
    }


    public static function tableName()
    {
        return 'files';
    }
}
