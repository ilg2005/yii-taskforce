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
                    <li class="user__search-item <?= (Yii::$app->request->get('rating') && !(Yii::$app->request->get('name'))) ? 'user__search-item--current' : '' ?>">
                        <a href="/users?rating=1" class="link-regular">Рейтингу</a>
                    </li>
                    <li class="user__search-item <?= (Yii::$app->request->get('tasks') && !(Yii::$app->request->get('name'))) ? 'user__search-item--current' : '' ?>">
                        <a href="/users?tasks=1" class="link-regular">Числу заказов</a>
                    </li>
                    <li class="user__search-item <?= (Yii::$app->request->get('views') && !(Yii::$app->request->get('name'))) ? 'user__search-item--current' : '' ?>">
                        <a href="/users?views=1" class="link-regular">Популярности</a>
                    </li>
                </ul>
            </div>
            <?php foreach ($users as $user): ?>
            <div class="content-view__feedback-card user__search-wrapper">
                <div class="feedback-card__top">
                    <div class="user__search-icon">
                        <a href="#"><img src="../img/man-glasses.jpg" width="65" height="65"></a>
                        <span><?= $user->statistics->tasks_count ?> заданий</span>
                        <span><?= $user->statistics->testimonials_count ?> отзывов</span>
                    </div>
                    <div class="feedback-card__top--name user__search-card">
                        <p class="link-name"><a href="#" class="link-regular"><?= $user->name ?></a></p>
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <span <?= ($i > floor($user->statistics->rating)) ? 'class="star-disabled"' : '' ?>></span>
                        <?php endfor; ?>
                        <b><?= $user->statistics->rating ?></b>
                        <p class="user__search-content">
                            <?= $user->profile->about ?>
                        </p>
                    </div>
                    <span class="new-task__time">Был на сайте <?= Yii::$app->formatter->asRelativeTime($user->statistics->latest_activity_time) ?></span>
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
                            <input class="visually-hidden checkbox__input" id="<?= $category['id'] ?>" type="checkbox" name="category[]" value="<?= $category['id'] ?>" <?= (Yii::$app->request->get('category') && !(Yii::$app->request->get('name')) && in_array($category['id'], Yii::$app->request->get('category'))) ? 'checked' : '' ?>>
                            <label for="<?= $category['id'] ?>"><?= $category['name'] ?></label>
                        <?php endforeach; ?>
                    </fieldset>
                    <br>
                    <fieldset class="search-task__categories">
                        <legend>Дополнительно</legend>
                        <input class="visually-hidden checkbox__input" id="free" type="checkbox" name="free" value="<?= (Yii::$app->request->get('free', 1)) ?>" <?= (Yii::$app->request->get('free') && !(Yii::$app->request->get('name'))) ? 'checked' : '' ?>>
                        <label for="free">Сейчас свободен</label>
                        <input class="visually-hidden checkbox__input" id="online" type="checkbox" name="online" value="<?= (Yii::$app->request->get('online', 1)) ?>" <?= (Yii::$app->request->get('online') && !(Yii::$app->request->get('name'))) ? 'checked' : '' ?>>
                        <label for="online">Сейчас онлайн</label>
                        <input class="visually-hidden checkbox__input" id="testimonials" type="checkbox" name="testimonials" value="<?= (Yii::$app->request->get('testimonials', 1)) ?>" <?= (Yii::$app->request->get('testimonials') && !(Yii::$app->request->get('name'))) ? 'checked' : '' ?>>
                        <label for="testimonials">Есть отзывы</label>
                        <input class="visually-hidden checkbox__input" id="favorite" type="checkbox" name="favorite" value="<?= (Yii::$app->request->get('favorite', 1)) ?>" <?= (Yii::$app->request->get('favorite') && !(Yii::$app->request->get('name'))) ? 'checked' : '' ?>>
                        <label for="favorite">В избранном</label>
                    </fieldset>
                    <br>
                    <label class="search-task__name" for="name">Поиск по имени</label>
                    <input class="input-middle input" id="name" type="search" name="name" placeholder="" value="<?= Yii::$app->request->get('name') ?>">
                    <button class="button" type="submit">Искать</button>
                </form>
            </div>
        </section>
    </div>
</main>
