<?php


namespace frontend\models;


use yii\behaviors\AttributeTypecastBehavior;
use yii\db\ActiveRecord;

class Profile extends ActiveRecord
{


    public function rules()
    {
        return [
            [['address', 'birthday', 'about', 'phone', 'skype'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            'typecast' => [
                'class' => AttributeTypecastBehavior::className(),
                'attributeTypes' => [
                    'phone' => AttributeTypecastBehavior::TYPE_STRING,
                    'skype' => AttributeTypecastBehavior::TYPE_STRING,
                    'birthday' => strtotime($this->birthday),
                ],
                'typecastAfterValidate' => true,
                'typecastBeforeSave' => true,
                'typecastAfterFind' => false,
            ],
        ];
    }

    public static function tableName()
    {
        return 'users_profile';
    }
}
