<?php


namespace frontend\controllers;


use frontend\models\Category;
use yii\base\Controller;

class CategoryController extends Controller
{
    public $layout = 'basic';
    public static function getCategories()
    {
        return Category::find()->asArray()->with('users')->all();
    }

    public function actionShow()
    {
        $categories = self::getCategories();
        return $this->render('show', compact('categories'));
    }
}
