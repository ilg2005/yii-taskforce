<?php


namespace frontend\components;


use yii\base\Widget;

class Rating extends Widget
{
    const maxRate = 5;
    public $rating;

    public function run()
    {
        return $this->render('rating', ['rating' => $this->rating, 'maxRate' => self::maxRate]);
    }
}
