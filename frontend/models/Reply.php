<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class Reply extends ActiveRecord
{
    public function rules()
    {
        return [
            [['task_id', 'applicant_id', 'applicant_price', 'applicant_comment', 'reply_time', 'is_refused'], 'safe'],
        ];
    }

    public function getApplicant() {
        return $this->hasOne(User::class, ['id' => 'applicant_id']);
    }

    public function getTask() {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    public static function tableName()
    {
        return 'tasks_replies';
    }
}
