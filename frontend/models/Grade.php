<?php


namespace frontend\models;


use DateTime;
use yii\behaviors\AttributeTypecastBehavior;
use yii\db\ActiveRecord;

class Grade extends ActiveRecord
{
    public function rules()
    {
        return [
            [['grade', 'grading_comment', 'grading_date'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            'typecast' => [
                'class' => AttributeTypecastBehavior::class,
                'attributeTypes' => [
                    'grading_date' => static function ($value) {
                        return ($value instanceof DateTime) ? $value->format('Y-m-d') : DateTime::createFromFormat('Y-m-d', $value);
                    },
                    'grade' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'grading_comment' => AttributeTypecastBehavior::TYPE_STRING,
                ],
                'typecastAfterValidate' => true,
                'typecastBeforeSave' => true,
                'typecastAfterFind' => false,
            ],
        ];
    }

    public static function tableName()
    {
        return 'grades';
    }
}
