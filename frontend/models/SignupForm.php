<?php
namespace frontend\models;

use yii\base\Model;


class SignupForm extends Model
{
    public $email;
    public $name;
    public $town;
    public $password;

    public function rules()
    {
        return [

            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот электронный адрес уже используется'],

            ['name', 'trim'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['password', 'string', 'min' => 8, 'tooShort' => 'Пароль должен быть не менее 8 символов'],


            [['email', 'name', 'town','password'], 'required', 'message' => 'Это поле должно быть заполнено!'],
        ];
    }

}
