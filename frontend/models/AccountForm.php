<?php


namespace frontend\models;


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

    public function rules()
    {
        return [

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
        ];
    }
}
