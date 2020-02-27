<?php
?>
    <h1>Show Users</h1>
<?php foreach($users as $user): ?>
<h3><?= $user['id']?>) <?= $user['name']?> | <?= $user['statistics']['feedbacks_count']?></h3>
<hr>
<?php endforeach; ?>

