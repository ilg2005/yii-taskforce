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
            ['email', 'validateEmail'],
            ['password', 'validatePassword'],
        ];
    }

    public function validateEmail($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, 'Несуществующий пользователь');
            }
        }
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный пароль');
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
