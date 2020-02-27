<?php
for ($i = 1; $i <= $maxRate; $i++) : ?>
    <span <?= ($i > floor($rating)) ? 'class="star-disabled"' : '' ?>></span>
<?php endfor; ?>
<b><?= $rating ?></b>
