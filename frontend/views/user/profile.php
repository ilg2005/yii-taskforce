<?php

/* @var $this yii\web\View */

const RATE_THRESHOLD = 3;

$this->title = 'TaskForce-Profile';

use frontend\components\Pager;
use frontend\components\Rating;
?>
<main class="page-main">
    <div class="main-container page-container">
        <section class="content-view">
            <div class="user__card-wrapper">
                <div class="user__card">
                    <img src="./uploads/<?= $user->avatar ?>" width="120" height="120" alt="Аватар пользователя">
                    <div class="content-view__headline">
                        <h1><?= $user->name ?></h1>
                        <p>Россия, Санкт-Петербург, <?= Yii::t('app', '{n, plural, one{# год} few{# года} other{# лет}}', ['n' => Yii::$app->formatter->asAge($user->profile->birthday)]) ?></p>
                        <div class="profile-mini__name five-stars__rate">
                            <?= Rating::widget(['rating' => $user->rating]) ?>
                        </div>
                        <b class="done-task"><?= Yii::t('app', 'Выполнил {n, plural, one{# заказ} few{# заказа} other{# заказов}}', ['n' => $tasksCount]) ?></b><b class="done-review"><?= Yii::t('app', 'Получил {n, plural, one{# отзыв} few{# отзыва} other{# отзывов}}', ['n' => $feedbacksCount]) ?></b>
                    </div>
                    <div class="content-view__headline user__card-bookmark <?= (Yii::$app->request->get('is_favorite') || $user->is_favorite) ? 'user__card-bookmark--current' : '' ?>">
                        <?php if (strtotime($user->latest_activity_time) >= strtotime('-1 minute')) : ?>
                        <span>Сейчас на сайте</span>
                        <?php else : ?>
                        <span>Был на сайте <?= Yii::$app->formatter->asRelativeTime($user->latest_activity_time) ?></span>
                        <?php endif; ?>
                        <a href="/profile?user_id=<?= $user->id ?>&is_favorite=<?= Yii::$app->request->get('is_favorite') ? '0' : '1' ?>"><b></b></a>
                    </div>
                </div>
                <div class="content-view__description">
                    <p><?= $user->profile->about ?></p>
                </div>
                <div class="user__card-general-information">
                    <div class="user__card-info">
                        <h3 class="content-view__h3">Специализации</h3>
                        <div class="link-specialization">
                            <?php foreach ($user->categories as $category): ?>
                                <a href="/browse?category[]=<?= $category->id ?>" class="link-regular"><?= $category->name ?></a>
                            <?php endforeach; ?>
                        </div>
                        <h3 class="content-view__h3">Контакты</h3>
                        <div class="user__card-link">
                            <a class="user__card-link--tel link-regular" href="tel:<?= $user->profile->phone ?>"><?= Yii::$app->formatter->asPhone($user->profile->phone) ?></a>
                            <a class="user__card-link--email link-regular" href="mailto: <?= $user->email ?>"><?= $user->email ?></a>
                            <a class="user__card-link--skype link-regular" href="skype: <?= $user->profile->skype ?>?call"><?= $user->profile->skype ?></a>
                        </div>
                    </div>
                    <div class="user__card-photo">
                        <h3 class="content-view__h3">Фото работ</h3>
                        <?php foreach ($user->portfolio as $file): ?>
                        <a href="/image?filename=<?= $file->filename ?>"><img src="./uploads/<?= $file->filename ?>" width="85" height="86" alt="Фото работы"></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php if ($feedbacksCount): ?>
            <div class="content-view__feedback">
                <h2>Отзывы<span> (<?= $feedbacksCount ?>)</span></h2>
                <div class="content-view__feedback-wrapper reviews-wrapper">
                    <?php foreach ($feedbacks as $feedback): ?>
                    <div class="feedback-card__reviews">
                        <p class="link-task link">Задание <a href="#" class="link-regular">«<?= $feedback->task->title ?>»</a></p>
                        <div class="card__review">
                            <a href="/profile?user_id=<?= $feedback->customer_id ?>"><img src="../uploads/<?= $feedback->avatar->avatar_file ?>" width="55" height="54"></a>
                            <div class="feedback-card__reviews-content">
                                <p class="link-name link"><a href="/profile?user_id=<?= $feedback->customer_id ?>" class="link-regular"><?= $feedback->customer->name ?></a></p>
                                <p class="review-text"><?= $feedback->comment ?></p>
                            </div>
                            <div class="card__review-rate">
                                <p class="<?= ($feedback->rate <= RATE_THRESHOLD) ? 'three' : 'five'?>-rate big-rate"><?= $feedback->rate ?><span></span></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="feedbacks__pagination">
                        <?= Pager::widget(['pagination' => $pages]) ?>
                    </div>


                </div>
            </div>
            <?php endif; ?>
        </section>
    </div>
</main>

