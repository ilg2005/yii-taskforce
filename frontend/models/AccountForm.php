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
    public $new_message;
    public $actions_on_task;
    public $new_feedback;
    public $show_to_customer;
    public $hide_user_profile;

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'password' => 'Новый пароль',
            'password_repeat' => 'Повтор пароля',
            'phone' => 'Телефон',
            'new_message' => 'Новое сообщение',
            'actions_on_task' => 'Действия по заданию',
            'new_feedback' => 'Новый отзыв',
            'show_to_customer' => 'Показывать мои контакты только заказчику',
            'hide_user_profile' => 'Не показывать мой профиль'
        ];
    }

    public function rules()
    {
        return [
            ['avatar_file', 'image'],
            [['email', 'name', 'about', 'phone', 'skype', 'telegram' ], 'trim'],
            [['email', 'name'], 'required', 'message' => 'Это поле должно быть заполнено!'],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['name', 'string', 'min' => 2, 'max' => 255],

            ['password', 'string', 'min' => 8, 'tooShort' => 'Пароль должен быть не менее 8 символов'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],

            ['skype', 'match', 'pattern' => '/^[a-z\d]{3,}$/i', 'message' => 'Skype должен быть строкой из латинских символов и цифр от 3-х знаков'],

            ['telegram', 'string'],

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
