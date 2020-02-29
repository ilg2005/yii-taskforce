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
                    'options' => [
                        'class' => 'registration__user-form form-create'
                    ],
                    'fieldConfig' => [
                        'template' => '<p>{label}</p><div>{input}</div><span>{hint}</span><span>{error}</span>',
                    ],
                ]); ?>

                <?= $form->field($model, 'email')
                    ->label('Электронная почта', ['class' => 'form-create', 'for' => 'email'])
                    ->input('email', [
                        'class' => 'input textarea',
                        'style' => ['width' => '330px'],
                        'placeholder' => 'kumarm@mail.ru',
                        'id' => 'email'
                    ])
                    ->hint('Введите валидный адрес электронной почты')
                ?>

                <?= $form->field($model, 'name')
                    ->label('Ваше имя', ['for' => 'name'])
                    ->textInput([
                        'class' => 'input textarea',
                        'style' => ['width' => '330px'],
                        'placeholder' => 'Мамедов Кумар',
                        'id' => 'name'
                    ])
                    ->hint('Введите ваше имя и фамилию')
                ?>

                <?= $form->field($model, 'town[]')
                    ->label('Город проживания', ['for' => 'town'])
                    ->dropDownList(Location::find()->select('town')->indexBy('id')->column(), [
                        'prompt' => 'Выберите город...',
                        'class' => 'multiple-select input town-select registration-town',
                        'style' => ['width' => '360px'],
                        'id' => 'town'
                    ])
                    ->hint('Укажите город, чтобы находить подходящие задачи')
                ?>

                <?= $form->field($model, 'password')
                    ->label('Пароль', ['for' => 'password'])
                    ->passwordInput(['class' => 'input textarea', 'style' => ['width' => '330px'], 'id' => 'password'])
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
