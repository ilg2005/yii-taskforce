<?php

namespace frontend\controllers;

use frontend\models\Location;
use Yii;

class AddressController extends BehaviorsController
{

    public function beforeAction($action)
    {
        $request = Yii::$app->request;

        if ($request->isAjax) {
            return parent::beforeAction($action);
        }
        return false;
    }

    public function actionIndex($query)
    {
        $town = Yii::$app->user->identity->town;
        $userLocation = Location::find()->where(['town' => $town])->one();
        $ll = $userLocation->longitude . ',' . $userLocation->latitude;


        $parameters = [
            'apikey' => 'e666f398-c983-4bde-8f14-e3fec900592a',
            'geocode' => $query,
            'll' => $ll,
            'spn' => '3.552069,2.400552',
            'format' => 'json',
            'results' => '5',
            'lang' => 'ru_RU'
        ];

        return file_get_contents('https://geocode-maps.yandex.ru/1.x/?' . http_build_query($parameters));

    }

}
