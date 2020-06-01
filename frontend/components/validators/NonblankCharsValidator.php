<?php

namespace frontend\components\validators;

use yii\validators\Validator;

class NonblankCharsValidator extends Validator
{
    public $limit;
    public $message;


    public function setValidationSettings($model, $attribute)
    {
        $this->limit = ($attribute === 'title') ? 10 : 30;
        $this->message = "Длина текста должна быть не менее {$this->limit} непробельных символов.";
    }

    public function validateAttribute($model, $attribute)
    {
        $this->setValidationSettings($model, $attribute);
        $condition = (strlen($model->$attribute) - substr_count($model->$attribute, ' ') < $this->limit);
        if ($condition) {
            $model->addError($attribute, $this->message);
        }
    }


    public function clientValidateAttribute($model, $attribute, $view)
    {
        $this->setValidationSettings($model, $attribute);
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return <<<JS
                if (value.length - (value.split(' ').length - 1) < $this->limit) {
                messages.push($message);
                }
JS;

    }

}
