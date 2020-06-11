<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DownloadController extends Controller
{
    public function actionDownload($filename)
    {
        $path = './uploads/';
        $file = $path . $filename;

        if (file_exists($file)) {
            return Yii::$app->response->sendFile($file);
        }

        throw new NotFoundHttpException('Файл не найден');
    }
}


