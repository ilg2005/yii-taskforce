<?php


namespace frontend\components;


use yii\i18n\Formatter;

class MyFormatter extends Formatter
{

    public function formatAsPhone($number)
    {
        return preg_replace("/(\d)(\d{3})(\d{3})(\d{2})(\d{2})/",
            '$1 ($2) $3 $4 $5', $number);
    }

    public function calculateAge($birthday)
    {
        $birthdayTimestamp = strtotime($birthday);
        $age = date('Y') - date('Y', $birthdayTimestamp);
        if (date('md', $birthdayTimestamp) > date('md')) {
            $age--;
        }
        return $age;
    }
}
