<?php


namespace frontend\controllers;

require_once '../../functions.php';

use frontend\models\Location;
use yii\base\Controller;

class LocationController extends Controller
{
    public function actionImport()
    {
        $locations = getArrayFromCSV('../../data/cities.csv');
        foreach ($locations as $key => $values) {
            $location = new Location();
            $location->id = $key++;
            foreach ($values as $k => $v) {
                $location->$k = $v;
            }
            $location->save();
        }
        $locations = Location::find()->asArray()->all();
        return $this->render('import', compact('locations'));
    }

    public function actionShow()
    {
        $locations = Location::find()->asArray()->all();
        return $this->render('show', compact('locations'));
    }

}
