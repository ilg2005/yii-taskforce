<?php


namespace frontend\controllers;


use Yii;

class ImageController extends BehaviorsController
{
    public function actionImage()
    {
        $filename = Yii::$app->request->get('filename');
        return $this->render('image', compact('filename'));
    }

}
