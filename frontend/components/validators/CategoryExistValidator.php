<?php


namespace frontend\components\validators;


use yii\db\Query;
use yii\validators\Validator;

class CategoryExistValidator extends Validator
{
    public $message;

    public function validateAttribute($model, $attribute)
    {
        $this->message = 'Выбранная категория должна существовать на сайте.';
        $categoriesID = (new Query())->select('id')->from('categories')->column();

        if (!in_array($model->$attribute, $categoriesID, false)) {
            $model->addError($attribute, $this->message);
        }
    }
}
