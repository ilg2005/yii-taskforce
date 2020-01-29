<h1>Show Tasks</h1>
<?php use yii\widgets\LinkPager;

// display pagination
echo LinkPager::widget([
    'pagination' => $pages,
    'hideOnSinglePage' => true,
    'pageCssClass' => 'pagination__item',
    'activePageCssClass' => 'pagination__item--current',
    'nextPageLabel' => '',
    'nextPageCssClass' => 'pagination__item new-task__pagination-list',
    'prevPageLabel' => '',
    'prevPageCssClass' => 'pagination__item new-task__pagination-list',
    'options' => ['class' => 'new-task__pagination-list'],
]);

foreach ($tasks as $task) {
    var_dump($task);
}

?>
<p></p>




