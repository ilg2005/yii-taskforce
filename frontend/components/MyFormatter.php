<?php


namespace frontend\components;


use Yii;
use yii\i18n\Formatter;

class MyFormatter extends Formatter
{

    public function asPhone($number)
    {
        return preg_replace("/(\d)(\d{3})(\d{3})(\d{2})(\d{2})/",
            '$1 ($2) $3 $4 $5', $number);
    }

    public function asAge($birthday)
    {
        $birthdayTimestamp = strtotime($birthday);
        $age = date('Y') - date('Y', $birthdayTimestamp);
        if (date('md', $birthdayTimestamp) > date('md')) {
            $age--;
        }
        return $age;
    }

    public function asTimeSinceRegistration($registrationDate)
    {
        $relativeTime = Yii::$app->formatter->asRelativeTime($registrationDate);
        return str_replace('назад', '', $relativeTime);
    }

}
