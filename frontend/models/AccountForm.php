<?php


namespace frontend\models;


use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

class AccountForm extends Model
{
    public $avatar;
    public $name;
    public $email;
    public $town;
    public $birthday;
    public $about;
    public $categories;
    public $password;
    public $password_repeat;
    public $imageFiles;
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
            ['avatar', 'file', 'extensions' => 'png, jpg', 'skipOnEmpty' => true],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 6],

            [['email', 'name', 'about', 'phone', 'skype', 'telegram'], 'trim'],

            ['name', 'default', 'value' => Yii::$app->user->identity->name],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['email', 'default', 'value' => Yii::$app->user->identity->email],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            [['name', 'email'], 'required', 'message' => 'Это поле должно быть заполнено!'],

            ['town', 'string'],
            ['birthday', 'date', 'format' => 'Y-m-d'],
            ['birthday', 'default', 'value' => Yii::$app->user->identity->profile->birthday],

            ['about', 'default', 'value' => Yii::$app->user->identity->profile->about],

            ['password', 'string', 'min' => 8, 'tooShort' => 'Пароль должен быть не менее 8 символов'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],

            ['phone', 'default', 'value' => Yii::$app->user->identity->profile->phone],

            [
                'skype',
                'match',
                'pattern' => '/^[a-z\d]{3,}$/i',
                'message' => 'Skype должен быть строкой из латинских символов и цифр от 3-х знаков'
            ],
            ['skype', 'default', 'value' => Yii::$app->user->identity->profile->skype],

            ['telegram', 'string'],
            ['telegram', 'default', 'value' => htmlspecialchars_decode(Yii::$app->user->identity->profile->messenger)],

            [['new_message', 'actions_on_task', 'new_feedback', 'show_to_customer', 'hide_user_profile'], 'number'],
            ['new_message', 'default', 'value' => Yii::$app->user->identity->settings->new_message],
            ['actions_on_task', 'default', 'value' => Yii::$app->user->identity->settings->actions_on_task],
            ['new_feedback', 'default', 'value' => Yii::$app->user->identity->settings->new_feedback],
            ['show_to_customer', 'default', 'value' => Yii::$app->user->identity->settings->show_to_customer],
            ['hide_user_profile', 'default', 'value' => Yii::$app->user->identity->settings->hide_user_profile],
            ['categories', 'each', 'rule' => ['integer']],

        ];

    }

    public function uploadFile()
    {
        $dir = './uploads';
        if (!is_dir($dir)) {
            FileHelper::createDirectory($dir, 0755, true);
        }

        if ($this->avatar) {
            $this->avatar->saveAs("{$dir}/{$this->avatar->baseName}.{$this->avatar->extension}");
        }

    }

    public function uploadImages()
    {
        if ($this->imageFiles) {
            foreach ($this->imageFiles as $file) {
                $file->saveAs('./uploads/' . $file->baseName . '.' . $file->extension);
            }
        }
    }
}

