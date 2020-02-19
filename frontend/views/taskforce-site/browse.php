<?php

/* @var $this yii\web\View */

use frontend\components\Pager;

$this->title = 'TaskForce-Browse';

const TRIM_WIDTH = 70;

?>
<main class="page-main">
    <div class="main-container page-container">
        <section class="new-task">
            <div class="new-task__wrapper">
                <h1>Новые задания</h1>
                <?php foreach ($tasks as $task): ?>
                <div class="new-task__card">
                    <div class="new-task__title">
                        <a href="#" class="link-regular"><h2><?= $task->title ?></h2></a>
                        <a  class="new-task__type link-regular" href="/browse?category[]=<?= $task->category_id ?>"><p><?= $task->category->name ?></p></a>
                    </div>
                    <div class="new-task__icon new-task__icon--<?= $task->category->icon ?>"></div>
                    <p class="new-task_description">
                        <?= mb_strimwidth($task->description, 0, TRIM_WIDTH, '...') ?>
                    </p>
                    <b class="new-task__price new-task__price--<?= $task->category->name ?>"><?= $task->budget ?><b> ₽</b></b>
                    <p class="new-task__place">Санкт-Петербург, Центральный район</p>
                    <span class="new-task__time"><?= Yii::$app->formatter->asRelativeTime($task->creation_date) ?></span>
                </div>
                <?php endforeach; ?>

            </div>
            <div class="new-task__pagination">
                <?= Pager::widget([
                    'pagination' => $pages,
                ]) ?>
            </div>
        </section>
        <section  class="search-task">
            <div class="search-task__wrapper">
                <form class="search-task__form" name="test" method="get" action="/browse">
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
                        <input class="visually-hidden checkbox__input" id="6" type="checkbox" name="" value="">
                        <label for="6">Без откликов </label>
                        <input class="visually-hidden checkbox__input" id="7" type="checkbox" name="" value="">
                        <label for="7">Удаленная работа </label>
                    </fieldset>
                    <br>
                    <label class="search-task__name" for="8">Период</label>
                    <select class="multiple-select input" id="8"size="1" name="time[]">
                        <option value="day">За день</option>
                        <option selected value="week">За неделю</option>
                        <option value="month">За месяц</option>
                    </select>
                    <br>
                    <label class="search-task__name" for="9">Поиск по названию</label>
                    <input class="input-middle input" id="9" type="search" name="q" placeholder="">
                    <button class="button" type="submit">Искать</button>
                </form>
            </div>
        </section>
    </div>
</main>

