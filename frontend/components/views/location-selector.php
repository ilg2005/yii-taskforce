<div class="header__town">

    <select class="multiple-select input town-select" size="1" name="town[]">
        <?php foreach ($locations as $location) : ?>
        <option value="<?= $location['town'] ?>"  <?= $location['town'] === $userTown ? 'selected' : '' ?> ><?= $location['town'] ?></option>
        <?php endforeach; ?>
    </select>
</div>
