<?php


namespace frontend\controllers;


use frontend\models\Category;
use yii\base\Controller;

class CategoryController extends Controller
{
    public $layout = 'basic';
    public function actionShow()
    {
        $categories = Category::find()->asArray()->all();
        return $this->render('show', compact('categories'));
    }
}
