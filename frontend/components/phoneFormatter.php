<?php


namespace frontend\components;


use yii\i18n\Formatter;

class phoneFormatter extends Formatter
{

    public function asPhone($number)
    {
        return preg_replace("/(\d)(\d{3})(\d{3})(\d{2})(\d{2})/",
            '$1 ($2) $3 $4 $5', $number);
    }
}
