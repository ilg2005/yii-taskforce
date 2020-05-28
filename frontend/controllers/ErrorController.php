<?php


namespace frontend\controllers;


use Yii;

class ErrorController extends SecureController
{
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}
