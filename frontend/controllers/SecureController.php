<?php


namespace frontend\controllers;


use frontend\constants\UserRoles;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                        'matchCallback' => function () {
                            return $this->redirect('/browse');
                        }
                    ],
/*                    [
                        'allow' => false,
                        'actions' => ['create'],
                        'roles' => ['@'],
                        'matchCallback' => function () {
                               return (Yii::$app->user->identity->role === UserRoles::WORKER);
                        },
                        'denyCallback' => function () {
                            throw new NotFoundHttpException('Задание может создать только заказчик');
                        },
                    ],*/

                ],
                'denyCallback' => function () {
                    Yii::$app->response->redirect(['/index']);
                },
            ],
        ];
    }

}
