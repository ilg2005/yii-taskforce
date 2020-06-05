<?php


namespace frontend\models;


use frontend\components\validators\NonblankCharsValidator;
use frontend\components\validators\CategoryExistValidator;
use yii\base\Model;

class CreateForm extends Model
{
    public $title;
    public $description;
    public $category;
    public $files;
    public $budget;
    public $deadline;

    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'files' => 'Файлы',
            'budget' => 'Бюджет',
            'deadline' => 'Срок исполнения',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'description', 'budget', 'deadline'], 'trim'],

            [['title', 'description', 'category'], 'required', 'message' => 'Это поле должно быть заполнено!'],

            [['title', 'description'], 'string'],
            [['title', 'description'], NonblankCharsValidator::class, 'skipOnEmpty' => true],

            ['category', 'integer'],
            ['category', CategoryExistValidator::class, 'skipOnEmpty' => true],


            ['files', 'file', 'maxFiles' => 6, 'skipOnEmpty' => true ],

            ['budget', 'integer', 'min' => 1, 'message' => 'Должно быть целое положительное число'],
            ['deadline', 'date', 'format' => 'Y-m-d'],

        ];
    }

}
