<?php

/* @var $this yii\web\View */

use frontend\components\Rating;
use frontend\components\TaskBtn;
use taskforce\constants\TaskStatuses;
use taskforce\constants\UserRoles;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'TaskForce-View';

?>
<main class="page-main">
    <div class="main-container page-container">
        <section class="content-view">
            <div class="content-view__card">
                <div class="content-view__card-wrapper">
                    <div class="content-view__header">
                        <div class="content-view__headline">
                            <h1><?= $task->title ?></h1>
                            <span>Размещено в категории
                                    <a href="/browse?category[]=<?= $task->category_id ?>" class="link-regular"><?= $task->category->name ?></a>
                                    <?= Yii::$app->formatter->asRelativeTime($task->creation_date) ?></span>
                        </div>
                        <b class="new-task__price new-task__price--<?= $task->category->icon ?> content-view-price"><?= $task->budget ?><b> ₽</b></b>
                        <div class="new-task__icon new-task__icon--<?= $task->category->icon ?> content-view-icon"></div>
                    </div>
                    <div class="content-view__description">
                        <h3 class="content-view__h3">Общее описание</h3>
                        <p><?= $task->description ?></p>
                    </div>

                    <?php if (count($task->files)) : ?>
                    <div class="content-view__attach">
                        <h3 class="content-view__h3">Вложения</h3>
                        <?php foreach ($task->files as $taskFile) : ?>
                        <a href="/download?filename=<?= $taskFile->filename ?>"><?= $taskFile->filename ?></a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="content-view__location">
                        <h3 class="content-view__h3">Расположение</h3>
                        <div class="content-view__location-wrapper">
                            <div class="content-view__map">
                                <a href="#"><img src="./img/map.jpg" width="361" height="292"
                                                 alt="Москва, Новый арбат, 23 к. 1"></a>
                            </div>
                            <div class="content-view__address">
                                <span class="address__town">Москва</span><br>
                                <span>Новый арбат, 23 к. 1</span>
                                <p>Вход под арку, код домофона 1122</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-view__action-buttons">
                    <?= TaskBtn::widget(['currentUserId' => Yii::$app->user->id, 'task' => $task]) ?>

                    <?php /*if (Yii::$app->user->identity->role === UserRoles::WORKER && $task->status === TaskStatuses::NEW && !in_array(Yii::$app->user->id, ArrayHelper::getColumn($task->replies, 'applicant_id'))) : */?><!--
                    <button class=" button button__big-color response-button open-modal"
                            type="button" data-for="response-form">Откликнуться</button>
                    <?php /*endif; */?>

                    <?php /*if ($isWorker && $task->status === TaskStatuses::ACTIVE) : */?>
                    <button class="button button__big-color refusal-button open-modal"
                            type="button" data-for="refuse-form">Отказаться</button>
                    <?php /*endif; */?>

                    <?php /*if ($isAuthor && $task->status === TaskStatuses::ACTIVE) : */?>
                    <button class="button button__big-color request-button open-modal"
                            type="button" data-for="complete-form">Завершить</button>
                    --><?php /*endif; */?>

                </div>
            </div>
            <?php if ($task->replies && ($isAuthor || (in_array(Yii::$app->user->id,
                        ArrayHelper::getColumn($task->replies, 'applicant_id'), true)))) : ?>
            <div class="content-view__feedback">
                <h2>Отклики
                    <?php if ($isAuthor) : ?>
                        <span><?= '(' . count($task->replies) . ')' ?></span>
                    <?php endif; ?>
                </h2>
                <div class="content-view__feedback-wrapper">
                    <?php foreach ($task->replies as $reply) : ?>
                    <div class="content-view__feedback-card <?= ((Yii::$app->user->id !== $reply->applicant_id) && !$isAuthor)  ? 'visually-hidden' : '' ?>">
                        <div class="feedback-card__top">
                            <a href="/profile?user_id=<?= $reply->applicant_id ?>"><img src="./uploads/<?= $reply->applicant->avatar ?>" width="55" height="55"></a>
                            <div class="feedback-card__top--name">
                                <p><a href="/profile?user_id=<?= $reply->applicant_id ?>" class="link-regular"><?= $reply->applicant->name ?></a></p>
                                <?= Rating::widget(['rating' => $reply->applicant->rating]) ?>
                            </div>
                            <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($reply->reply_time) ?></span>
                        </div>
                        <div class="feedback-card__content">
                            <p><?= $reply->applicant_comment ?></p>
                            <span><?= $reply->applicant_price ?> ₽</span>
                        </div>
                        <?php if ($isAuthor && $task->status === TaskStatuses::NEW) : ?>
                        <div class="feedback-card__actions <?= $reply->is_refused ? 'visually-hidden' : '' ?>">
                            <?= Html::a('Подтвердить', ['/confirm', 'taskId' => $task->id, 'currentUserId' => Yii::$app->user->id, 'applicantId' => $reply->applicant_id], ['class' => 'button__small-color request-button button', 'type' => 'button']) ?>
                            <?= Html::a('Отказать', ['/refuse', 'taskId' => $task->id, 'currentUserId' => Yii::$app->user->id, 'applicantId' => $reply->applicant_id], ['class' => 'button__small-color refusal-button button', 'type' => 'button']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </section>
        <?php if ($task->worker_id) : ?>
        <section class="connect-desk">
            <div class="connect-desk__profile-mini">
                <div class="profile-mini__wrapper">
                    <h3><?= $isAuthor ? 'Исполнитель' : 'Заказчик' ?></h3>
                    <div class="profile-mini__top">
                        <img src="./uploads/<?= $user->avatar ?>" width="62" height="62" alt="Аватар <?= $isAuthor ? 'исполнителя' : 'заказчика' ?>">
                        <div class="profile-mini__name five-stars__rate">
                            <p><?= $user->name ?></p>
                            <?= $isAuthor ? Rating::widget(['rating' => $user->rating]) : '' ?>
                        </div>
                    </div>
                    <p class="info-customer"><span><?= Yii::t('app', '{n, plural, one{# задание} few{# задания} other{# заданий}}', ['n' => count($user->tasks)]) ?></span><span class="last-"><?= Yii::$app->formatter->asTimeSinceRegistration($user->registration_date) ?> на сайте</span></p>
                    <?php if ($isAuthor) : ?>
                    <a href="/profile?user_id=<?= $user->id ?>" class="link-regular">Смотреть профиль</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($isAuthor || $isWorker) : ?>
            <div class="connect-desk__chat">
                <h3>Переписка</h3>
                <div class="chat__overflow">
                    <div class="chat__message chat__message--out">
                        <p class="chat__message-time">10.05.2019, 14:56</p>
                        <p class="chat__message-text">Привет. Во сколько сможешь
                            приступить к работе?</p>
                    </div>
                    <div class="chat__message chat__message--in">
                        <p class="chat__message-time">10.05.2019, 14:57</p>
                        <p class="chat__message-text">На задание
                            выделены всего сутки, так что через час</p>
                    </div>
                    <div class="chat__message chat__message--out">
                        <p class="chat__message-time">10.05.2019, 14:57</p>
                        <p class="chat__message-text">Хорошо. Думаю, мы справимся</p>
                    </div>
                </div>
                <p class="chat__your-message">Ваше сообщение</p>
                <form class="chat__form">
                    <textarea class="input textarea textarea-chat" rows="2" name="message-text" placeholder="Текст сообщения"></textarea>
                    <button class="button chat__button" type="submit">Отправить</button>
                </form>
            </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>
    </div>
</main>
<section class="modal response-form form-modal" id="response-form">
    <h2>Отклик на задание</h2>
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "<p>{label}</p>{input}{error}",
            'errorOptions' => [
                'class' => 'has-error'
            ],
            'labelOptions' => [
                  'class' =>  'form-modal-description'
            ],

        ],
    ]); ?>
    <?= $form->field($model, 'action')
        ->textInput([
            'class' => 'visually-hidden',
            'value' => 'reply'
        ])->label(false)

    ?>
    <?= $form->field($model, 'price')
        ->textInput([
            'class' => 'response-form-payment input input-middle input-money',
        ])
    ?>
    <?= $form->field($model, 'comment')
        ->textArea([
            'class' => 'input textarea',
            'placeholder' => 'Ваш комментарий к отклику',
            'rows' => 4,
            'style' => ['width' => '450px']
        ])
    ?>
    <?= Html::submitButton('Отправить', ['class'=> 'button modal-button']) ?>
    <?= Html::button('Закрыть', ['class'=> 'form-modal-close']) ?>
    <?php ActiveForm::end(); ?>

<!--    <form action="#" method="post">
        <p>
            <label class="form-modal-description" for="response-payment">Ваша цена</label>
            <input class="response-form-payment input input-middle input-money" type="text" name="response-payment" id="response-payment">
        </p>
        <p>
            <label class="form-modal-description" for="response-comment">Комментарий</label>
            <textarea class="input textarea" rows="4" id="response-comment" name="response-comment" placeholder="Place your text"></textarea>
        </p>
        <button class="button modal-button" type="submit">Отправить</button>
    </form>
    <button class="form-modal-close" type="button">Закрыть</button>
-->

</section>
-->


<section class="modal completion-form form-modal" id="complete-form">
    <h2>Завершение задания</h2>
    <p class="form-modal-description">Задание выполнено?</p>
    <form action="#" method="post">
        <input class="visually-hidden completion-input completion-input--yes" type="radio" id="completion-radio--yes" name="completion" value="yes">
        <label class="completion-label completion-label--yes" for="completion-radio--yes">Да</label>
        <input class="visually-hidden completion-input completion-input--difficult" type="radio" id="completion-radio--yet" name="completion" value="difficulties">
        <label  class="completion-label completion-label--difficult" for="completion-radio--yet">Возникли проблемы</label>
        <p>
            <label class="form-modal-description" for="completion-comment">Комментарий</label>
            <textarea class="input textarea" rows="4" id="completion-comment" name="completion-comment" placeholder="Place your text"></textarea>
        </p>
        <p class="form-modal-description">
            Оценка
        <div class="feedback-card__top--name completion-form-star">
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
            <span class="star-disabled"></span>
        </div>
        </p>
        <input type="hidden" name="rating" id="rating">
        <button class="button modal-button" type="submit">Отправить</button>
    </form>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
<section class="modal form-modal refusal-form" id="refuse-form">
    <h2>Отказ от задания</h2>
    <p>
        Вы собираетесь отказаться от выполнения задания.
        Это действие приведёт к снижению вашего рейтинга.
        Вы уверены?
    </p>
    <button class="button__form-modal button" id="close-modal"
            type="button">Отмена</button>
   <?= Html::a('Отказаться', ['/fail', 'taskId' => $task->id, 'currentUserId' => Yii::$app->user->id], ['class' => 'button__form-modal refusal-button button', 'style' => ['float' => 'right'], 'type' => 'button']) ?>
    <button class="form-modal-close" type="button">Закрыть</button>
</section>
<div class="overlay"></div>
