<?php

/* @var $this yii\web\View */

use frontend\models\Location;
use yii\widgets\ActiveForm;

$this->title = 'TaskForce-Account';
?>

<main class="page-main">
    <div class="main-container page-container">
        <section class="account__redaction-wrapper">
            <h1>Редактирование настроек профиля</h1>
            <?php $form = ActiveForm::begin([
                'id' => 'account',
                'fieldConfig' => [
                    'template' => '<p>{label}</p><div>{input}</div><span>{error}</span>',

                    'errorOptions' => [
                        'class' => 'text-danger'
                    ],
                ],
            ]); ?>
                <div class="account__redaction-section">
                <h3 class="div-line">Настройки аккаунта</h3>
                <div class="account__redaction-section-wrapper">
                    <div class="account__redaction-avatar">
                        <img src="./img/no-image-available.jpg" width="156" height="156">
                        <?= $form->field($modelUploadFile, 'avatar')
                            ->label('Сменить аватар', ['class' => 'link-regular', 'for' => 'upload-avatar'])
                            ->fileInput(['hidden' => '', 'name' => 'avatar', 'id' => 'upload-avatar'])
                        ?>
                    </div>
                    <div class="account__redaction">
                        <div class="account__input account__input--name">
                            <?= $form->field($model, 'name')
                                ->label('Ваше имя')
                                ->textInput([
                                    'placeholder' => 'Введите имя и фамилию',
                                    'value' => $user->name,
                                    'name' => 'name',
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
                                    'value' => $user->email,
                                    'name' => 'email',
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
                                    'value' => $user->town,
                                    'name' => 'town[]',
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
                            <input class="visually-hidden checkbox__input" id="<?= $category['id'] ?>" type="checkbox" name="category[]" value="<?= $category['id'] ?>" <?= (Yii::$app->request->get('category') && in_array($category['id'], Yii::$app->request->get('category'))) ? 'checked' : '' ?>>
                            <label for="<?= $category['id'] ?>"><?= $category['name'] ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <h3 class="div-line">Безопасность</h3>
                <div class="account__redaction-section-wrapper account__redaction">
                    <div class="account__input">
                        <label for="211">Новый пароль</label>
                        <input class="input textarea" type="password" id="211" name="" value="moiparol">
                    </div>
                    <div class="account__input">
                        <label for="212">Повтор пароля</label>
                        <input class="input textarea" type="password" id="212" name="" value="moiparol">
                    </div>
                </div>

                <h3 class="div-line">Фото работ</h3>

                <div class="account__redaction-section-wrapper account__redaction">
                    <span class="dropzone link-regular">Выбрать фотографии</span>
                </div>

                <h3 class="div-line">Контакты</h3>
                <div class="account__redaction-section-wrapper account__redaction">
                    <div class="account__input">
                        <label for="213">Телефон</label>
                        <input class="input textarea" type="tel" id="213" name="" placeholder="8 (555) 187 44 87">
                    </div>
                    <div class="account__input">
                        <label for="214">Skype</label>
                        <input class="input textarea" type="password" id="214" name="" placeholder="DenisT">
                    </div>
                    <div class="account__input">
                        <label for="215">Telegram</label>
                        <input class="input textarea" id="215" name="" placeholder="@DenisT">
                    </div>
                </div>
                <h3 class="div-line">Настройки сайта</h3>
                <h4>Уведомления</h4>
                <div class="account__redaction-section-wrapper account_section--bottom">
                    <div class="search-task__categories account_checkbox--bottom">
                        <input class="visually-hidden checkbox__input" id="216" type="checkbox" name="" value="" checked>
                        <label for="216">Новое сообщение</label>
                        <input class="visually-hidden checkbox__input" id="217" type="checkbox" name="" value="" checked>
                        <label for="217">Действия по заданию</label>
                        <input class="visually-hidden checkbox__input" id="218" type="checkbox" name="" value="" checked>
                        <label for="218">Новый отзыв</label>
                    </div>
                    <div class="search-task__categories account_checkbox account_checkbox--secrecy">
                        <input class="visually-hidden checkbox__input" id="219" type="checkbox" name="" value="">
                        <label for="219">Показывать мои контакты только заказчику</label>
                        <input class="visually-hidden checkbox__input" id="220" type="checkbox" name="" value="" checked>
                        <label for="220">Не показывать мой профиль</label>
                    </div>
                </div>
            </div>
                <button class="button" type="submit">Сохранить изменения</button>
            <?php ActiveForm::end(); ?>

            <form enctype="multipart/form-data" id="account" method="post">
                <div class="account__redaction-section">
                    <h3 class="div-line">Настройки аккаунта</h3>
                    <div class="account__redaction-section-wrapper">
                        <div class="account__redaction-avatar">
                            <img src="./img/no-image-available.jpg" width="156" height="156">
                            <input type="file" name="avatar" id="upload-avatar">
                            <label for="upload-avatar" class="link-regular">Сменить аватар</label>
                        </div>
                        <div class="account__redaction">
                            <div class="account__input account__input--name">
                                <label for="200">Ваше имя</label>
                                <input class="input textarea" id="200" name="" placeholder="Введите имя и фамилию" value="<?= $user->name ?>" disabled>
                            </div>
                            <div class="account__input account__input--email">
                                <label for="201">email</label>
                                <input class="input textarea" id="201" name="" placeholder="DenisT@bk.ru">
                            </div>
                            <div class="account__input account__input--name">
                                <label for="202">Город</label>
                                <select class="multiple-select input multiple-select-big" size="1" id="202" name="town[]">
                                    <option value="Moscow">Москва</option>
                                    <option selected="" value="SPB">Санкт-Петербург</option>
                                    <option value="Krasnodar">Краснодар</option>
                                    <option value="Irkutsk">Иркутск</option>
                                    <option value="Vladivostok">Владивосток</option>
                                </select>
                            </div>
                            <div class="account__input account__input--date">
                                <label for="203">День рождения</label>
                                <input id="203" class="input-middle input input-date" type="date" placeholder="15.08.1987">
                            </div>
                            <div class="account__input account__input--info">
                                <label for="204">Информация о себе</label>
                                <textarea class="input textarea" rows="7" id="204" name="" placeholder="Place your text"></textarea>
                            </div>
                        </div>
                    </div>
                    <h3 class="div-line">Выберите свои специализации</h3>
                    <div class="account__redaction-section-wrapper">
                        <div class="search-task__categories account_checkbox--bottom">
                            <?php foreach ($categories as $category): ?>
                            <input class="visually-hidden checkbox__input" id="<?= $category['id'] ?>" type="checkbox" name="category[]" value="<?= $category['id'] ?>" <?= (Yii::$app->request->get('category') && in_array($category['id'], Yii::$app->request->get('category'))) ? 'checked' : '' ?>>
                            <label for="<?= $category['id'] ?>"><?= $category['name'] ?></label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <h3 class="div-line">Безопасность</h3>
                    <div class="account__redaction-section-wrapper account__redaction">
                        <div class="account__input">
                            <label for="211">Новый пароль</label>
                            <input class="input textarea" type="password" id="211" name="" value="moiparol">
                        </div>
                        <div class="account__input">
                            <label for="212">Повтор пароля</label>
                            <input class="input textarea" type="password" id="212" name="" value="moiparol">
                        </div>
                    </div>

                    <h3 class="div-line">Фото работ</h3>

                    <div class="account__redaction-section-wrapper account__redaction">
                        <span class="dropzone link-regular">Выбрать фотографии</span>
                    </div>

                    <h3 class="div-line">Контакты</h3>
                    <div class="account__redaction-section-wrapper account__redaction">
                        <div class="account__input">
                            <label for="213">Телефон</label>
                            <input class="input textarea" type="tel" id="213" name="" placeholder="8 (555) 187 44 87">
                        </div>
                        <div class="account__input">
                            <label for="214">Skype</label>
                            <input class="input textarea" type="password" id="214" name="" placeholder="DenisT">
                        </div>
                        <div class="account__input">
                            <label for="215">Telegram</label>
                            <input class="input textarea" id="215" name="" placeholder="@DenisT">
                        </div>
                    </div>
                    <h3 class="div-line">Настройки сайта</h3>
                    <h4>Уведомления</h4>
                    <div class="account__redaction-section-wrapper account_section--bottom">
                        <div class="search-task__categories account_checkbox--bottom">
                            <input class="visually-hidden checkbox__input" id="216" type="checkbox" name="" value="" checked>
                            <label for="216">Новое сообщение</label>
                            <input class="visually-hidden checkbox__input" id="217" type="checkbox" name="" value="" checked>
                            <label for="217">Действия по заданию</label>
                            <input class="visually-hidden checkbox__input" id="218" type="checkbox" name="" value="" checked>
                            <label for="218">Новый отзыв</label>
                        </div>
                        <div class="search-task__categories account_checkbox account_checkbox--secrecy">
                            <input class="visually-hidden checkbox__input" id="219" type="checkbox" name="" value="">
                            <label for="219">Показывать мои контакты только заказчику</label>
                            <input class="visually-hidden checkbox__input" id="220" type="checkbox" name="" value="" checked>
                            <label for="220">Не показывать мой профиль</label>
                        </div>
                    </div>
                </div>
                <button class="button" type="submit">Сохранить изменения</button>
            </form>
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
