<?php

/* @var $this yii\web\View */

use frontend\models\Location;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\web\UploadedFile;

$this->title = 'TaskForce-Account';
?>
<main class="page-main">
    <div class="main-container page-container">
        <section class="account__redaction-wrapper">
            <h1>Редактирование настроек профиля</h1>
            <?php $form = ActiveForm::begin([
                    'id' => 'account',
                    'fieldConfig' => [
                        'template' => '{label}{input}{error}',
                        'checkboxTemplate' => "\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n",

                        'errorOptions' => [
                            'class' => 'text-danger'
                         ],
                         'labelOptions' => [
                                 'class' => 'accountform-label',
                         ],
                    ],
            ]); ?>
                <div class="account__redaction-section">
                <h3 class="div-line">Настройки аккаунта</h3>
                <div class="account__redaction-section-wrapper">
                    <div class="account__redaction-avatar">
                        <img src="<?= $user->profile->avatar_file ?>" width="156" height="156">
                        <?= $form->field($model, 'avatar')
                            ->label('Сменить аватар', ['class' => 'link-regular', 'for' => 'upload-avatar', 'style' => ['display' => 'block']])
                            ->fileInput(['hidden' => '', 'id' => 'upload-avatar'])
                        ?>
                    </div>
                    <div class="account__redaction">
                        <div class="account__input account__input--name">
                            <?= $form->field($model, 'name')
                                ->label('Ваше имя')
                                ->textInput([
                                    'placeholder' => 'Введите имя и фамилию',
                                    'class' => 'input textarea',
                                    'style' => ['width' => '410px'],
                                ])
                            ?>
                        </div>
                        <div class="account__input account__input--email">
                            <?= $form->field($model, 'email')
                                ->label('email')
                                ->input('email', [
                                    'placeholder' => 'example@gmail.com',
                                    'class' => 'input textarea',
                                    'style' => ['width' => '350px'],
                                ])
                            ?>
                        </div>
                        <div class="account__input account__input--name">
                            <?= $form->field($model, 'town[]')
                                ->label('Город')
                                ->dropDownList(Location::find()->select('town')->indexBy('town')->column(), [
                                    'prompt' => 'Выберите город...',
                                    'class' => 'multiple-select input town-select registration-town',
                                    'style' => ['width' => '350px'],
                                ])
                            ?>
                        </div>
                        <div class="account__input account__input--date">
                            <?= $form->field($model, 'birthday')
                                ->label('День рождения')
                                ->input('date', [
                                    'placeholder' => 'дд.мм.гггг',
                                    'value' => $user->profile->birthday,
                                    'name' => 'birthday',
                                    'class' => 'input-middle input input-date',
                                    'style' => ['width' => '250px'],
                                ])
                            ?>
                        </div>
                        <div class="account__input account__input--info">
                            <?= $form->field($model, 'about')
                                ->label('Информация о себе')
                                ->textarea([
                                    'placeholder' => 'Place your text',
                                    'value' => $user->profile->about,
                                    'name' => 'about',
                                    'class' => 'input textarea',
                                    'rows' => 7,
                                    'style' => ['width' => '820px'],
                                ])
                            ?>
                        </div>
                    </div>
                </div>
                <h3 class="div-line">Выберите свои специализации</h3>
                <div class="account__redaction-section-wrapper">
                    <div class="search-task__categories account_checkbox--bottom">
                        <?php foreach ($categories as $category): ?>
                            <?= $form->field($model, 'categories[]')
                                ->checkbox([
                                        'id' => $category['id'],
                                        'checked' => Yii::$app->request->get('category'),
                                        'name' => 'categories[]',
                                        'value' => $category['id'],
                                        'label' => $category['name'],
                                        'class' => 'visually-hidden checkbox__input'
                                        ])
                            ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <h3 class="div-line">Безопасность</h3>
                <div class="account__redaction-section-wrapper account__redaction">
                    <div class="account__input">
                        <?= $form->field($model, 'password')->passwordInput([
                            'class' => 'input textarea',
                            'style' => ['width' => '280px'],
                        ])
                            ->label('Новый пароль') ?>
                    </div>
                    <div class="account__input">
                        <?= $form->field($model, 'password_repeat')->passwordInput([
                            'class' => 'input textarea',
                            'style' => ['width' => '280px'],
                        ])
                            ->label('Повтор пароля') ?>
                    </div>
                </div>

                <h3 class="div-line">Фото работ</h3>

                <div class="account__redaction-section-wrapper account__redaction">
                    <span class="dropzone link-regular">Выбрать фотографии</span>
                </div>

                <h3 class="div-line">Контакты</h3>
                <div class="account__redaction-section-wrapper account__redaction">
                    <div class="account__input">
                        <?= $form->field($model, 'phone')
                            ->widget(MaskedInput::class,
                                [
                                    'mask' => '9 (999) 999 99 99',
                                    'options' => [
                                        'class' => 'input textarea',
                                        'style' => ['width' => '280px'],
                                        'placeholder' => '8 (555) 187 44 87',
                                        'name' => 'phone',
                                    ],
                                    'value' => Yii::$app->formatter->asPhone($user->profile->phone),

                                ])
                        ?>
                    </div>
                    <div class="account__input">
                        <?= $form->field($model, 'skype')
                            ->label('Skype')
                            ->textInput([
                                'placeholder' => 'skypename',
                                'value' => $user->profile->skype,
                                'name' => 'skype',
                                'class' => 'input textarea',
                                'style' => ['width' => '280px'],
                            ])
                        ?>
                    </div>
                    <div class="account__input">
                        <?= $form->field($model, 'telegram')
                            ->label('Telegram')
                            ->textInput([
                                'placeholder' => '@Username',
                                'value' => $user->profile->messenger,
                                'name' => 'telegram',
                                'class' => 'input textarea',
                                'style' => ['width' => '280px'],
                            ])
                        ?>
                    </div>
                </div>
                <h3 class="div-line">Настройки сайта</h3>
                <h4>Уведомления</h4>
                <div class="account__redaction-section-wrapper account_section--bottom">
                    <div class="search-task__categories account_checkbox--bottom">
                        <?= $form->field($model, 'new_message')
                            ->checkbox([
                                'name' => 'new_message',
                                'value' => $user->settings->new_message,
                                'class' => 'visually-hidden checkbox__input'
                            ])
                        ?>

                        <?= $form->field($model, 'actions_on_task')
                            ->checkbox([
                                'name' => 'actions_on_task',
                                'value' => $user->settings->actions_on_task,
                                'class' => 'visually-hidden checkbox__input'
                            ])
                        ?>

                        <?= $form->field($model, 'new_feedback')
                            ->checkbox([
                                'name' => 'new_feedback',
                                'value' => $user->settings->new_feedback,
                                'class' => 'visually-hidden checkbox__input'
                            ])
                        ?>
                    </div>
                    <div class="search-task__categories account_checkbox account_checkbox--secrecy">
                        <?= $form->field($model, 'show_to_customer')
                            ->checkbox([
                                'name' => 'show_to_customer',
                                'value' => $user->settings->show_to_customer,
                                'class' => 'visually-hidden checkbox__input'
                            ])
                        ?>
                        <?= $form->field($model, 'hide_user_profile')
                            ->checkbox([
                                'name' => 'hide_user_profile',
                                'value' => $user->settings->hide_user_profile,
                                'class' => 'visually-hidden checkbox__input'
                            ])
                        ?>
                    </div>
                </div>
            </div>

            <?= Html::submitButton('Сохранить изменения', ['class'=> 'button']) ?>
            <?php ActiveForm::end(); ?>
        </section>
    </div>
</main>
<script src="js/image-upload.js"></script>
<script src="js/dropzone.js"></script>
<script>
    Dropzone.autoDiscover = false;

    var dropzone = new Dropzone(".dropzone", {url: window.location.href, maxFiles: 6, uploadMultiple: true, autoProcessQueue: false,
        acceptedFiles: 'image/*', previewTemplate: '<a href="#"><img data-dz-thumbnail alt="Фото работы"></a>'});
</script>
