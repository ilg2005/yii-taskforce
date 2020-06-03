<?php


namespace frontend\components\validators;


use frontend\models\Category;
use yii\validators\Validator;

class CategoryExistValidator extends Validator
{
    public $message;

    public function validateAttribute($model, $attribute)
    {
        $this->message = 'Выбранная категория должна существовать на сайте.';

        if (in_array($model->$attribute, Category::find()->select(['id'])->asArray()->all(), false)) {
            $model->addError($attribute, $this->message);
        }
    }
}
