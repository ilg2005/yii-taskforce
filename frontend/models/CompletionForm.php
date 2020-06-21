<?php


namespace frontend\models;


use yii\base\Model;

class CompletionForm extends Model
{
    public $completionStatus;
    public $comment;
    public $rating;
    public $task_id;

    public function attributeLabels()
    {
        return [
            'completionStatus' => 'Задание выполнено?',
            'comment' => 'Комментарий',
            'rating' => 'Оценка'
        ];
    }

    public function rules()
    {
        return [
            [['completionStatus', 'task_id'], 'required'],
            [['comment', 'completionStatus'], 'string'],
            [['rating', 'task_id'], 'integer'],
            [['completionStatus', 'comment', 'rating', 'task_id'], 'safe'],
        ];
    }

}
