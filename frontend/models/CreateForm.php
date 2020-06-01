<?php


namespace frontend\models;


use frontend\components\validators\NonblankCharsValidator;
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

/*                        ['title', 'string', 'length' => [10], 'message' => 'Длина текста должна быть не менее 10 непробельных символов.'],
                        ['description', 'string', 'length' => [30], 'message' => 'Длина текста должна быть не менее 30 непробельных символов.'],*/

            [['title', 'description'], NonblankCharsValidator::class],

            ['category', 'each', 'rule' => ['integer']],

            ['files', 'file', 'skipOnEmpty' => true],

            ['budget', 'integer', 'min' => 1, 'message' => 'Должно быть целое положительное число'],
            ['deadline', 'date', 'format' => 'Y-m-d'],

        ];
    }

/*    public function validateNonblankChars()
    {
        $nonblankChars = strlen($this->title) - substr_count($this->title, ' ');
        if ($nonblankChars < 10) {
            $errorMsg = 'Длина текста должна быть не менее 10 непробельных символов.';
            $this->addError('title', $errorMsg);
        }
        if ($nonblankChars < 30) {
            $errorMsg = 'Длина текста должна быть не менее 30 непробельных символов.';
            $this->addError('description', $errorMsg);
        }

    }*/
}
