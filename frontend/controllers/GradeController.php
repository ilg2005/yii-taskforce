<?php


namespace frontend\controllers;


use frontend\models\Feedback;
use yii\base\Controller;

class FeedbackController extends Controller
{
    public $layout = 'basic';
    public function actionShow()
    {
        $feedbacks = Feedback::find()->asArray()->all();
        return $this->render('show', compact('feedbacks'));
    }
}
