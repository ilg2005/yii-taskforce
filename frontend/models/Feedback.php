<?php


namespace frontend\models;


use DateTime;
use yii\behaviors\AttributeTypecastBehavior;
use yii\db\ActiveRecord;

class Feedback extends ActiveRecord
{

    public function rules()
    {
        return [
            [['task_id', 'worker_id', 'customer_id', 'rate', 'comment', 'feedback_date'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            'typecast' => [
                'class' => AttributeTypecastBehavior::class,
                'attributeTypes' => [
                    'feedback_date' => static function ($value) {
                        return ($value instanceof DateTime) ? $value->format('Y-m-d') : DateTime::createFromFormat('Y-m-d', $value);
                    },
                    'task_id' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'worker_id' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'customer_id' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'rate' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'comment' => AttributeTypecastBehavior::TYPE_STRING,
                ],
                'typecastAfterValidate' => true,
                'typecastBeforeSave' => true,
                'typecastAfterFind' => false,
            ],
        ];
    }

    public function getCustomer() {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }

    public function getTask() {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    public function getAvatar() {
        return $this->hasOne(Profile::class, ['id' => 'customer_id']);
    }



    public static function tableName()
    {
        return 'feedbacks';
    }
}
