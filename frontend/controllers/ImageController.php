<?php


namespace frontend\controllers;


use Yii;

class ImageController extends SecureController
{
    public function actionImage()
    {
        $filename = Yii::$app->request->get('filename');
        return $this->render('image', compact('filename'));
    }

}
