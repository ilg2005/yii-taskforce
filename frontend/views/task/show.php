<h1>Show Tasks</h1>
<?php use frontend\components\Pager;

echo Pager::widget([
    'pagination' => $pages,
]);

foreach ($tasks as $task) {
    var_dump($task);
}

?>
<p></p>




