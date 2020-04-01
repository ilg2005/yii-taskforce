<?php


namespace frontend\models;


use yii\base\Model;

class EnterForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [

            ['email', 'trim'],
            ['email', 'email'],

            [['email', 'password'], 'required', 'message' => 'Это поле должно быть заполнено!'],
        ];
    }
}
