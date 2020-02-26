<?php
?>
<h1>Show Users with Portfolio</h1>
<?php foreach ($users as $key => $user): ?>
    <ol><?= $user->name ?></ol>
    <?php foreach ($user->portfolio as $array): ?>
        <li> <?= $array->filename ?></li>
    <?php endforeach; ?>
<hr>
<?php endforeach; ?>

