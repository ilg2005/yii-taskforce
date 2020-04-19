<?php
$this->title = $exception->getName();
?>
<div class="exception">
    <h1>Ошибка <?= $exception->statusCode ?>!</h1>
    <p><?= $exception->getMessage() ?></p>
</div>
