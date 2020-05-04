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
            [['avatar_file', 'address', 'birthday', 'about', 'phone', 'skype', 'messenger'], 'safe'],
            [['avatar_file'], 'string'],
            [['avatar_file'], 'default', 'value' => './img/no-image-available.jpg'],
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(USER::class, ['profile_id' => 'id']);
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
