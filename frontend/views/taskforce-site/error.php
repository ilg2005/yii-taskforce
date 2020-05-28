<?php
$this->title = $exception->getName();
?>
<div class="exception">
    <h1>Ошибка <?= $exception->statusCode ?: $exception->code ?>!</h1>
    <p><?= $exception->getMessage() ?: $this->title ?></p>
</div>
