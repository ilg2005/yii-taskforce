<?php
namespace frontend\models;

use Yii;
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

            ['password', 'string', 'min' => 8, 'message' => 'Длина пароля должна быть более 8 символов!'],


            [['email', 'name', 'town','password'], 'required', 'message' => 'Это поле должно быть заполнено!'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->email = $this->email;
        $user->name = $this->name;
        $user->town = $this->town;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user->save() && $this->sendEmail($user);

    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
