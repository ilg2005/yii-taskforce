<?php


namespace frontend\models;


use yii\base\Model;

class EnterForm extends Model
{
    public $email;
    public $password;

    private $_user;

    public function rules()
    {
        return [

            ['email', 'trim'],
            ['email', 'email'],

            [['email', 'password'], 'required', 'message' => 'Это поле должно быть заполнено!'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Вы ввели неверный email/пароль');
            }
        }
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }
}
