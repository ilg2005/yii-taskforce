<?php

namespace frontend\components;

use frontend\models\AccountForm;
use Yii;
use yii\base\Widget;
use frontend\models\Location;

class LocationSelector extends Widget
{
    public function run()
    {
        $locations = Location::find()->all();
        $userTown = Yii::$app->user->identity->town;
        return $this->render('location-selector', compact('locations', 'userTown'));
    }
}

