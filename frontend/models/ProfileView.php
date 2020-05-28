<?php


namespace frontend\models;


use DateTime;
use yii\behaviors\AttributeTypecastBehavior;
use yii\db\ActiveRecord;

class ProfileView extends ActiveRecord
{
    public function rules()
    {
        return [
            [['current_user_id', 'viewed_user_id', 'viewing_time'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            'typecast' => [
                'class' => AttributeTypecastBehavior::class,
                'attributeTypes' => [
                    'viewing_time' => static function ($value) {
                        return ($value instanceof DateTime) ? $value->format('Y-m-d') : DateTime::createFromFormat('Y-m-d', $value);
                    },
                    'current_user_id' => AttributeTypecastBehavior::TYPE_INTEGER,
                    'viewed_user_id' => AttributeTypecastBehavior::TYPE_INTEGER,
                ],
                'typecastAfterValidate' => true,
                'typecastBeforeSave' => true,
                'typecastAfterFind' => false,
            ],
        ];
    }


    public static function tableName()
    {
        return 'profile_views';
    }
}
