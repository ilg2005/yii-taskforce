<?php

namespace frontend\components\validators;

use yii\validators\Validator;

class NonblankCharsValidator extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'Длина текста должна быть не менее 10 непробельных символов.';
    }

    public function validateAttribute($model, $attribute)
    {
        $nonblankCharsCountCondition = (strlen($model->$attribute) - substr_count($model->$attribute, ' ') < 10);
        if ($nonblankCharsCountCondition) {
            $model->addError($attribute, $this->message);
            $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            return <<<JS
                    messages.push($message)
JS;
        }
    }
}
