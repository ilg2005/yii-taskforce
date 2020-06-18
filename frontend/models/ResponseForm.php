<?php


namespace frontend\models;


use yii\base\Model;

class ResponseForm extends Model
{
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
            [['comment', 'price'], 'trim'],
            ['comment', 'string'],
            ['price', 'integer', 'min' => 1, 'message' => 'Должно быть целое положительное число'],
            ];
    }
}
