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
            [['task_id', 'grade', 'comment', 'feedback_date'], 'safe'],
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
                    'grade' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'comment' => AttributeTypecastBehavior::TYPE_STRING,
                ],
                'typecastAfterValidate' => true,
                'typecastBeforeSave' => true,
                'typecastAfterFind' => false,
            ],
        ];
    }

    public static function tableName()
    {
        return 'feedbacks';
    }
}
