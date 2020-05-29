<?php


namespace frontend\models;


use yii\base\Model;

class CreateForm extends Model
{
    public $title;

    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
        ];
    }

    public function rules()
    {
        return [
            [['title', ], 'trim'],

            [['title', ], 'required', 'message' => 'Это поле должно быть заполнено!'],

            [
                'title',
                'match',
                'pattern' => '/^[^\S]{10,}$/i',
                'message' => 'Длина текста не менее 10 непробельных символов.'
            ],
        ];
    }
}
