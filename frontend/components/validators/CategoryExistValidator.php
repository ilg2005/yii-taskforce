<?php


namespace frontend\components\validators;


use frontend\models\Category;
use yii\data\ActiveDataProvider;
use yii\validators\Validator;

class CategoryExistValidator extends Validator
{
    public $message;

    public function validateAttribute($model, $attribute)
    {
        $this->message = 'Выбранная категория должна существовать на сайте.';
        $provider = new ActiveDataProvider([
            'query' => Category::find(),
        ]);
        $categories = $provider->getKeys();

        if (!in_array($model->$attribute, $categories, false)) {
            $model->addError($attribute, $this->message);
        }
    }
}
