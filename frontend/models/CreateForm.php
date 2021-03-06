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
    public $address;
    public $latitude;
    public $longitude;
    public $locality;
    public $budget;
    public $deadline;

    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'files' => 'Файлы',
            'address' => 'Локация',
            'budget' => 'Бюджет',
            'deadline' => 'Срок исполнения',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'description', 'address', 'budget', 'deadline'], 'trim'],

            [['title', 'description', 'category'], 'required', 'message' => 'Это поле должно быть заполнено!'],

            [['title', 'description', 'address', 'locality'], 'string'],
            [['title', 'description'], NonblankCharsValidator::class, 'skipOnEmpty' => true],

            ['category', CategoryExistValidator::class, 'skipOnEmpty' => true],

            ['files', 'file', 'maxFiles' => 6, 'skipOnEmpty' => true ],

            [['latitude', 'longitude'], 'double'],

            ['budget', 'integer', 'min' => 1, 'message' => 'Должно быть целое положительное число'],

            ['deadline', 'date', 'format' => 'Y-m-d',   'message' => 'Неверный формат даты'] /*, 'min' => date('Y-m-d', strtotime('today')), 'tooSmall' => 'Срок исполнения должен быть не раньше сегодняшней даты'],*/
            /* Нестабильно валидирует минимальную дату*/

        ];
    }

}
