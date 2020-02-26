<?php

/* @var $this yii\web\View */

$this->title = 'TaskForce-Profile';

?>
<main class="page-main">
    <div class="main-container page-container">
        <section class="content-view">
            <div class="user__card-wrapper">
                <div class="user__card">
                    <img src="../img/<?= $user->profile->avatar_file ?>" width="120" height="120" alt="Аватар пользователя">
                    <div class="content-view__headline">
                        <h1><?= $user->name ?></h1>
                        <p>Россия, Санкт-Петербург, 30 лет</p>
                        <div class="profile-mini__name five-stars__rate"><?php for ($i = 1; $i <= 5; $i++) : ?>
                                <span <?= ($i > floor($user->statistics->rating)) ? 'class="star-disabled"' : '' ?>></span>
                            <?php endfor; ?>
                            <b><?= $user->statistics->rating ?></b>
                        </div>
                        <b class="done-task"><?= Yii::t('app', 'Выполнил {n, plural, one{# заказ} few{# заказа} other{# заказов}}', ['n' => $user->statistics->tasks_count]) ?></b><b class="done-review"><?= Yii::t('app', 'Получил {n, plural, one{# отзыв} few{# отзыва} other{# отзывов}}', ['n' => $user->statistics->testimonials_count]) ?></b>
                    </div>
                    <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                        <span>Был на сайте <?= Yii::$app->formatter->asRelativeTime($user->statistics->latest_activity_time) ?></span>
                        <a href="#"><b></b></a>
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
                            <a class="user__card-link--tel link-regular" href="tel:<?= $user->profile->phone ?>">+<?= $user->profile->phone ?></a>
                            <a class="user__card-link--email link-regular" href="mailto: <?= $user->email ?>"><?= $user->email ?></a>
                            <a class="user__card-link--skype link-regular" href="skype: <?= $user->profile->skype ?>?call"><?= $user->profile->skype ?></a>
                        </div>
                    </div>
                    <div class="user__card-photo">
                        <h3 class="content-view__h3">Фото работ</h3>
                        <a href="#"><img src="../img/rome-photo.jpg" width="85" height="86" alt="Фото работы"></a>
                        <a href="#"><img src="../img/smartphone-photo.png" width="85" height="86" alt="Фото работы"></a>
                        <a href="#"><img src="../img/dotonbori-photo.png" width="85" height="86" alt="Фото работы"></a>
                    </div>
                </div>
            </div>
            <div class="content-view__feedback">
                <h2>Отзывы<span>(2)</span></h2>
                <div class="content-view__feedback-wrapper reviews-wrapper">
                    <div class="feedback-card__reviews">
                        <p class="link-task link">Задание <a href="#" class="link-regular">«Выгулять моего боевого петуха»</a></p>
                        <div class="card__review">
                            <a href="#"><img src="../img/man-glasses.jpg" width="55" height="54"></a>
                            <div class="feedback-card__reviews-content">
                                <p class="link-name link"><a href="#" class="link-regular">Астахов Павел</a></p>
                                <p class="review-text">
                                    Кумар сделал всё в лучшем виде.  Буду обращаться к нему в будущем, если
                                    возникнет такая необходимость!
                                </p>
                            </div>
                            <div class="card__review-rate">
                                <p class="five-rate big-rate">5<span></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="feedback-card__reviews">
                        <p class="link-task link">Задание <a href="#" class="link-regular">«Повесить полочку»</a></p>
                        <div class="card__review">
                            <a href="#"><img src="../img/woman-glasses.jpg" width="55" height="54"></a>
                            <div class="feedback-card__reviews-content">
                                <p class="link-name link"><a href="#" class="link-regular">Морозова Евгения</a></p>
                                <p class="review-text">
                                    Кумар приехал позже, чем общал и не привез с собой всех
                                    инстументов. В итоге пришлось еще ходить в строительный магазин.
                                </p>
                            </div>
                            <div class="card__review-rate">
                                <p class="three-rate big-rate">3<span></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

