<?php


namespace frontend\models;


use yii\base\Model;

class ReplyForm extends Model
{
    public $action;
    public $price;
    public $comment;

    public function attributeLabels()
    {
        return [
            'price' => 'Ваша цена',
            'comment' => 'Комментарий'
        ];
    }

    public function rules()
    {
        return [
            ['action', 'default', 'value' => 'response'],
            [['comment', 'price'], 'trim'],
            ['comment', 'string'],
            ['price', 'integer', 'min' => 1, 'message' => 'Должно быть целое положительное число'],
            ];
    }
}
