<?php


namespace frontend\models;


use Yii;
use yii\base\Model;

class AccountForm extends Model
{
    public $avatar_file;
    public $name;
    public $email;
    public $town;
    public $birthday;
    public $about;
    public $categories;
    public $password;
    public $password_repeat;
    public $portfolio;
    public $phone;
    public $skype;
    public $telegram;
    public $settings;

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'password' => 'Новый пароль',
            'password_repeat' => 'Повтор пароля',
        ];
    }

    public function rules()
    {
        return [
            [['email', 'name', 'about', 'phone', 'skype', 'telegram'], 'trim'],
            [['email', 'name'], 'required', 'message' => 'Это поле должно быть заполнено!'],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['name', 'string', 'min' => 2, 'max' => 255],

            ['password', 'string', 'min' => 8, 'tooShort' => 'Пароль должен быть не менее 8 символов'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],


        ];
/*        return [

            [['email', 'name', 'about', 'phone', 'skype', 'telegram'], 'trim'],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['name', 'string', 'min' => 2, 'max' => 255],

            ['birthday', 'format' => 'dd.MM.yyyy'],

            ['password', 'string', 'min' => 8, 'tooShort' => 'Пароль должен быть не менее 8 символов'],
            ['password', 'compare'],

            [['email', 'name'], 'required', 'message' => 'Это поле должно быть заполнено!'],

            ['phone', 'match', 'pattern' => '/(\d\s*){11}', 'message' => 'Телефон должен быть строкой из 11 цифр'],

            ['skype', 'match', 'pattern' => '/\w{3,}', 'message' => 'Skype должен быть строкой из латинских символов и цифр от 3-х знаков'],

            ['telegram', 'match', 'pattern' => '/^.+$', 'message' => 'Telegram должен быть любой непустой строкой'],
        ];*/
    }
}
