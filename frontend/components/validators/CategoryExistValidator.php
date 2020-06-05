<?php


namespace frontend\components\validators;


use frontend\models\Category;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\validators\Validator;

class CategoryExistValidator extends Validator
{
    public $message;

    public function validateAttribute($model, $attribute)
    {
        $this->message = 'Выбранная категория должна существовать на сайте.';
        $query = (new Query())->from('categories')->select(['id']);
        $provider = new ActiveDataProvider(['query' => $query]);
        $categories = $provider->getModels();

        if (!in_array($model->$attribute, $categories, false)) {
            $model->addError($attribute, $this->message);
        }
    }
}
