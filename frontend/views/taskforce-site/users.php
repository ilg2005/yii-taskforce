<?php

/* @var $this yii\web\View */

$this->title = 'TaskForce-Users';

use frontend\components\Pager; ?>
<main class="page-main">
    <div class="main-container page-container">
        <section class="user__search">
            <div class="user__search-link">
                <p>Сортировать по:</p>
                <ul class="user__search-list">
                    <li class="user__search-item user__search-item--current">
                        <a href="#" class="link-regular">Рейтингу</a>
                    </li>
                    <li class="user__search-item">
                        <a href="#" class="link-regular">Числу заказов</a>
                    </li>
                    <li class="user__search-item">
                        <a href="#" class="link-regular">Популярности</a>
                    </li>
                </ul>
            </div>
            <?php foreach ($users as $user): ?>
            <div class="content-view__feedback-card user__search-wrapper">
                <div class="feedback-card__top">
                    <div class="user__search-icon">
                        <a href="#"><img src="../img/man-glasses.jpg" width="65" height="65"></a>
                        <span>17 заданий</span>
                        <span>6 отзывов</span>
                    </div>
                    <div class="feedback-card__top--name user__search-card">
                        <p class="link-name"><a href="#" class="link-regular"><?= $user->name ?></a></p>
                        <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
                        <b>4.25</b>
                        <p class="user__search-content">
                            <?= $user->profile->about ?>
                        </p>
                    </div>
                    <span class="new-task__time">Был на сайте 25 минут назад</span>
                </div>
                <div class="link-specialization user__search-link--bottom">
                    <?php foreach ($user->categories as $category): ?>
                    <a href="/browse?category[]=<?= $category->id ?>" class="link-regular"><?= $category->name ?></a>
                   <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="new-task__pagination">
                <?= Pager::widget([
                    'pagination' => $pages,
                ]) ?>
            </div>
        </section>
        <section  class="search-task">
            <div class="search-task__wrapper">
                <form class="search-task__form" name="users" method="get" action="/users">
                    <fieldset class="search-task__categories">
                        <legend>Категории</legend>
                        <?php foreach ($categories as $category): ?>
                            <input class="visually-hidden checkbox__input" id="<?= $category['id'] ?>" type="checkbox" name="category[]" value="<?= $category['id'] ?>" <?= (Yii::$app->request->get('category') && in_array($category['id'], Yii::$app->request->get('category'))) ? 'checked' : '' ?>>
                            <label for="<?= $category['id'] ?>"><?= $category['name'] ?></label>
                        <?php endforeach; ?>
                    </fieldset>
                    <br>
                    <fieldset class="search-task__categories">
                        <legend>Дополнительно</legend>
                        <input class="visually-hidden checkbox__input" id="106" type="checkbox" name="" value="" disabled>
                        <label for="106">Сейчас свободен</label>
                        <input class="visually-hidden checkbox__input" id="107" type="checkbox" name="" value="" checked>
                        <label for="107">Сейчас онлайн</label>
                        <input class="visually-hidden checkbox__input" id="108" type="checkbox" name="" value="" checked>
                        <label for="108">Есть отзывы</label>
                        <input class="visually-hidden checkbox__input" id="109" type="checkbox" name="" value="" checked>
                        <label for="109">В избранном</label>
                    </fieldset>
                    <br>
                    <label class="search-task__name" for="110">Поиск по имени</label>
                    <input class="input-middle input" id="110" type="search" name="q" placeholder="">
                    <button class="button" type="submit">Искать</button>
                </form>
            </div>
        </section>
    </div>
</main>
