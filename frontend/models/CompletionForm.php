<?php


namespace frontend\models;


use yii\base\Model;

class CompletionForm extends Model
{
    public $completionStatus;
    public $comment;
    public $rate;
    public $task_id;

    public function attributeLabels()
    {
        return [
            'completionStatus' => 'Задание выполнено?',
            'comment' => 'Комментарий',
            'rate' => 'Оценка'
        ];
    }

    public function rules()
    {
        return [
            [['completionStatus', 'task_id'], 'required'],
            [['comment', 'completionStatus'], 'string'],
            [['rate', 'task_id'], 'integer'],
            [['completionStatus', 'comment', 'rate', 'task_id'], 'safe'],
        ];
    }

}
