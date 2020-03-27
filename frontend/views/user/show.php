<?php
?>
    <h1>Show Users</h1>
<?php foreach($users as $user): ?>
<h3><?= $user['id']?>) <?= $user['name']?> | <?= count($user->tasks)?></h3>
<hr>
<?php endforeach; ?>
<?php var_dump($users) ?>

