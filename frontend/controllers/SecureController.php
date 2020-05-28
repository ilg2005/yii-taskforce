<?php


namespace frontend\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SecureController extends Controller
{
    public $layout = 'basic';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'signup', 'error'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'logout', 'account', 'browse', 'create', 'mylist', 'profile', 'users', 'view', 'image', 'error'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['signup'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->redirect('/browse');
                        }
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    Yii::$app->response->redirect(['/index']);
                },
            ],
        ];
    }

}
