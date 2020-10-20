<?php


namespace frontend\controllers;


use Yii;

class ErrorController extends BehaviorsController
{
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}
