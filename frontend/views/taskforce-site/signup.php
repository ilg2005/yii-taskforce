<?php
/* @var $this yii\web\View */


$this->title = 'TaskForce-Signup';

use frontend\models\Location;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<main class="page-main">
    <div class="main-container page-container">
        <section class="registration__user">
            <h1>Регистрация аккаунта</h1>
            <div class="registration-wrapper">

                <?php $form = ActiveForm::begin([
                    'id' => 'signup',
                    'options' => [
                        'class' => 'registration__user-form form-create'
                    ],
                    'fieldConfig' => [
                        'template' => '<p>{label}</p><div>{input}</div><span>{hint}</span><span>{error}</span><br>',
                        'inputOptions' => [
                            'class' => 'input textarea',
                            'style' => ['width' => '330px'],
                        ],
                        'errorOptions' => [
                            'class' => 'text-danger'
                        ],
                    ],
                ]); ?>

                <?= $form->field($model, 'email', ['enableAjaxValidation' => 'true'])
                    ->label('Электронная почта')
                    ->input('email', [
                        'placeholder' => 'example@gmail.com',
                    ])
                    ->hint('Введите валидный адрес электронной почты')
                ?>

                <?= $form->field($model, 'name')
                    ->label('Ваше имя')
                    ->textInput([
                        'placeholder' => 'Иванов Иван',
                    ])
                    ->hint('Введите ваше имя и фамилию')
                ?>

                <?= $form->field($model, 'town[]')
                    ->label('Город проживания')
                    ->dropDownList(Location::find()->select('town')->indexBy('town')->column(), [
                        'prompt' => 'Выберите город...',
                        'class' => 'multiple-select input town-select registration-town',
                        'style' => ['width' => '360px'],
                    ])
                    ->hint('Укажите город, чтобы находить подходящие задачи')
                ?>

                <?= $form->field($model, 'password')
                    ->label('Пароль')
                    ->passwordInput()
                    ->hint('Длина пароля от 8 символов')
                ?>

                <div class="form-group">
                    <?= Html::submitButton('Cоздать аккаунт', ['class' => 'button button__registration']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </section>

    </div>
</main>
