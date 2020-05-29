<?php


namespace frontend\models;


use yii\base\Model;

class CreateForm extends Model
{
    public $title;
    public $description;
    public $category;

    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'description'], 'trim'],

            [['title', 'description', 'category' ], 'required', 'message' => 'Это поле должно быть заполнено!'],

            [
                'title',
                'match',
                'pattern' => '/^[\S]{10,}$/i',
                'message' => 'Длина текста должна быть не менее 10 непробельных символов.'
            ],

            [
                'description',
                'match',
                'pattern' => '/^[\S]{30,}$/i',
                'message' => 'Длина текста должна быть не менее 30 непробельных символов.'
            ],

            ['category', 'each', 'rule' => ['integer']],

        ];
    }
}
