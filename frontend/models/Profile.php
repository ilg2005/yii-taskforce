<?php


namespace frontend\models;


use DateTime;
use yii\behaviors\AttributeTypecastBehavior;
use yii\db\ActiveRecord;

class Profile extends ActiveRecord
{

    public function rules()
    {
        return [
            [['user_id', 'avatar_file', 'address', 'birthday', 'about', 'phone', 'skype', 'messenger'], 'safe'],
            [['avatar_file'], 'string'],
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(USER::class, ['id' => 'user_id']);
    }

    public function behaviors()
    {
        return [
            'typecast' => [
                'class' => AttributeTypecastBehavior::class,
                'attributeTypes' => [
                    'birthday' => static function ($value) {
                        return ($value instanceof DateTime) ? $value->format('Y-m-d') : DateTime::createFromFormat('Y-m-d', $value);
                    },
                    'avatar_file' => AttributeTypecastBehavior::TYPE_STRING,
                    'phone' => AttributeTypecastBehavior::TYPE_STRING,
                    'skype' => AttributeTypecastBehavior::TYPE_STRING,
                ],
                'typecastAfterValidate' => true,
                'typecastBeforeSave' => true,
                'typecastAfterFind' => false,
            ],
        ];
    }

    public static function tableName()
    {
        return 'users_profiles';
    }
}
