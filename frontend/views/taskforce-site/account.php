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
                    'options' => ['enctype' => 'multipart/form-data'],
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
                            ->fileInput(['hidden' => '', 'id' => 'upload-avatar', 'name' => 'avatar'])
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
                                    'value' => $user->town,
                                    'style' => ['width' => '350px'],
                                ])
                            ?>
                        </div>
                        <div class="account__input account__input--date">
                            <?= $form->field($model, 'birthday')
                                ->label('День рождения')
                                ->input('date', [
                                    'placeholder' => 'дд.мм.гггг',
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
                    <?= $form->field($model,'categories[]')
                            ->checkboxList(
                        $allCategories,
                        ['class' => 'search-task__categories account_checkbox--bottom',
                            'item' =>  function ($index, $category, $name) use ($user) {
                        return Html::checkbox(
                        $name,
                        in_array($category->id, $user->getCategories()->select('id')->column()),
                        [
                        'value' => $category->id,
                        'id' => 'accountForm-categories_' . $index,
                        'class' => 'visually-hidden checkbox__input',
                        ]) .
                        Html::label($category->name, 'accountForm-categories_' . $index);
                        }]
                        )->label(false)
                    ?>
                  </div>
                <h3 class="div-line">Безопасность</h3>
                <div class="account__redaction-section-wrapper account__redaction">
                    <div class="account__input">
                        <?= $form->field($model, 'password')->passwordInput([
                            'class' => 'input textarea',
                            'style' => ['width' => '280px'],
                            'placeholder' => '********',
                        ])
                            ->label('Новый пароль') ?>
                    </div>
                    <div class="account__input">
                        <?= $form->field($model, 'password_repeat')->passwordInput([
                            'class' => 'input textarea',
                            'style' => ['width' => '280px'],
                            'placeholder' => '********',
                        ])
                            ->label('Повтор пароля') ?>
                    </div>
                </div>

                <h3 class="div-line">Фото работ</h3>

                    <?php if ($user->portfolio) : ?>
                    <p class="user__card-photo">
                        <?php foreach($user->portfolio as $portfolio) : ?>
                        <img src="<?= $portfolio->filename ?>" width="120" height="120" alt="Фото работы">
                        <?php endforeach; ?>
                    </p>
                    <?php endif; ?>

                <div class="account__redaction-section-wrapper account__redaction">
                   <span class="dropzone link-regular"></span>

                    <?/*= $form->field($model, 'imageFiles[]')
                   ->label('', ['class' => 'dropzone link-regular'])
                   ->fileInput(['hidden' => '', 'disabled' => true, 'name' => 'imageFiles'])
                    */?>

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
                                        'placeholder' => '8 (999) 999 99 99',
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
                                'class' => 'visually-hidden checkbox__input'
                            ])
                        ?>

                        <?= $form->field($model, 'actions_on_task')
                            ->checkbox([
                                'class' => 'visually-hidden checkbox__input'
                            ])
                        ?>

                        <?= $form->field($model, 'new_feedback')
                            ->checkbox([
                                'class' => 'visually-hidden checkbox__input'
                            ])
                        ?>
                    </div>
                    <div class="search-task__categories account_checkbox account_checkbox--secrecy">
                        <?= $form->field($model, 'show_to_customer')
                            ->checkbox([
                                'class' => 'visually-hidden checkbox__input'
                            ])
                        ?>
                        <?= $form->field($model, 'hide_user_profile')
                            ->checkbox([
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
    var dropzone = new Dropzone(".dropzone", {
        url: window.location.href,
        paramName: 'imageFiles',
        dictDefaultMessage: 'Выбрать фотографии',
        uploadMultiple: true,
        parallelUploads: 6,
        maxFiles: 6,
        addRemoveLinks: true,
        dictRemoveFile: 'Удалить файл',
        removedfile: function (file) {
            file.previewElement.remove();
            if (this.files.length < 6) {
                document.querySelector('.dz-default').classList.remove('visually-hidden');
            }
        },
        maxfilesreached: function() {
            document.querySelector('.dz-default').classList.add('visually-hidden');
        },
        maxfilesexceeded: function(file) {
            dropzone.removeFile(file);
        },
        autoProcessQueue: true,
        acceptedFiles: 'image/*',
        previewTemplate: '<div class="dz-preview dz-file-preview file-preview">' +
            '<div><img data-dz-thumbnail alt="Фото работы"></div>' +
            '</div>',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });

    var formElement = document.querySelector('#account');
    var submitBtnElement = formElement.querySelector('button[type="submit"]');
    submitBtnElement.addEventListener('click', function (evt) {
        evt.preventDefault();
        var formData = new FormData(formElement);
        var imageFiles = dropzone.files;
        imageFiles.forEach((file) => {
           formData.append('imageFiles[]', file);
        })
        var request = new XMLHttpRequest();
        request.open("POST", window.location.href);
        request.send(formData);
        setTimeout(() => {
            window.location.reload();
        }, 100);
    });


</script>
