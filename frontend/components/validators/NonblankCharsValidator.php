<?php

namespace frontend\components\validators;

use yii\validators\Validator;

class NonblankCharsValidator extends Validator
{
    public $limit;
    public $message;

    public function validateAttribute($model, $attribute)
    {
        $this->limit = ($attribute === 'title') ? 10 : 30;
        $nonblankCharsCountCondition = (strlen($model->$attribute) - substr_count($model->$attribute, ' ') < $this->limit);
        $this->message = "Длина текста должна быть не менее {$this->limit} непробельных символов.";
        if ($nonblankCharsCountCondition) {
            $model->addError($attribute, $this->message);
        }
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $this->limit = ($attribute === 'title') ? 10 : 30;
        $status = json_encode(strlen($model->$attribute) - substr_count($model->$attribute, ' ') < $this->limit);
        $this->message = "Длина текста должна быть не менее {$this->limit} непробельных символов.";
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return "if ($status) {
    messages.push($message)
}";
    }

}
