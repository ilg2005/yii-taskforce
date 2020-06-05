<?php


use frontend\models\Category;
use frontend\models\CreateForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'TaskForce-Create';

?>
<main class="page-main">
    <div class="main-container page-container">
        <section class="create__task">
            <h1>Публикация нового задания</h1>
            <div class="create__task-main">
                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data', 'class' => 'create__task-form form-create'],
                    'id' => 'task-form',
                    'fieldConfig' => [
                        'template' => "<p>{label}</p>{input}{hint}{error}",
                        'inputOptions' => [
                            'style' => ['width' => '520px'],
                            'class' => 'input textarea',
                        ],
                        'errorOptions' => [
                            'class' => 'has-error'
                        ],
                        'labelOptions' => [
                        ],
                        'hintOptions' => [
                            'tag' => 'span',
                            'class' => 'form-create'
                        ],

                    ],
                ]); ?>
                <?= $form->field($model, 'title')
                    ->textArea([
                        'placeholder' => 'Повесить полку',
                        'rows' => 1,
                    ])
                    ->hint('Кратко опишите суть работы')
                ?>

                <?= $form->field($model, 'description')
                    ->textArea([
                        'placeholder' => 'Подробное описание',
                        'rows' => 7,
                    ])
                    ->hint('Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться')
                ?>


                <?= $form->field($model, 'category')
                    ->dropDownList($categories, [
                        'class' => 'multiple-select input multiple-select-big',
                        'prompt' => 'Выберите из списка...',
                        'size' => 1,
                    ])
                    ->hint('Выберите категорию')
                ?>

               <?= $form->field($model, 'files[]')
                    ->fileInput([
                            'multiple' => true,
                            'class' => 'create__file',
                            'name' => 'files[]',

                    ])
                    ->hint('Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу')
                ?>


               <!--<label>Файлы</label>
                <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
                <div class="task-files-preview"></div>
                <div class="create__file dropzone">
                    <span>Добавить новый файл</span>
                </div>-->

                    <label for="13">Локация</label>
                    <input class="input-navigation input-middle input" id="13" type="search" name="q" placeholder="Санкт-Петербург, Калининский район">
                    <span>Укажите адрес исполнения, если задание требует присутствия</span>



                    <div class="create__price-time">
                        <div class="create__price-time--wrapper">

                            <?= $form->field($model, 'budget')
                                ->textArea([
                                    'placeholder' => '1000',
                                    'rows' => 1,
                                    'class' => 'input textarea input-money',
                                    'style' => ['width' => '200px']
                                ])
                                ->hint('Не заполняйте для оценки исполнителем')
                            ?>

                        </div>
                        <div class="create__price-time--wrapper">

                            <?= $form->field($model, 'deadline')
                                ->input('date', [
                                    'placeholder' => 'дд.мм.гггг',
                                    'class' => 'input-middle input input-date',
                                    'style' => ['width' => '200px']
                                ])
                                ->hint('Укажите крайний срок исполнения')
                            ?>

                        </div>
                    </div>
                <?php ActiveForm::end(); ?>

                <div class="create__warnings">
                    <div class="warning-item warning-item--advice">
                        <h2>Правила хорошего описания</h2>
                        <h3>Подробности</h3>
                        <p>Друзья, не используйте случайный<br>
                            контент – ни наш, ни чей-либо еще. Заполняйте свои
                            макеты, вайрфреймы, мокапы и прототипы реальным
                            содержимым.</p>
                        <h3>Файлы</h3>
                        <p>Если загружаете фотографии объекта, то убедитесь,
                            что всё в фокусе, а фото показывает объект со всех
                            ракурсов.</p>
                    </div>
                    <?php if (!empty($model->errors)) : ?>
                        <div class="warning-item warning-item--error">
                            <h2>Ошибки заполнения формы</h2>
                            <?php foreach ($model->errors as $attribute => $error) : ?>
                                <h3>Поле "<?= $model->getAttributeLabel($attribute) ?>"</h3>
                                <p><?= $error[0] ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?= Html::submitButton('Опубликовать', ['form' => 'task-form', 'class'=> 'button']) ?>

        </section>
    </div>
</main>
<script src="js/dropzone.js"></script>
<!--<script>
    Dropzone.autoDiscover = false;
    var fileUploadElement = document.querySelector('.create__file')
    var dropzone = new Dropzone(fileUploadElement, {
        url: window.location.href,
        paramName: 'files',
        uploadMultiple: true,
        parallelUploads: 6,
        maxFiles: 6,
        addRemoveLinks: true,
        dictRemoveFile: 'Удалить',
        removedfile: function (file) {
            file.previewElement.remove();
            if (this.files.length < 6) {
                document.querySelector('.dz-default').classList.remove('visually-hidden');
            }
        },
        maxfilesreached: function() {
            document.querySelector('.dz-default').classList.add('visually-hidden');
        },
        maxfilesexceeded: function(file) {
            dropzone.removeFile(file);
        },
        autoProcessQueue: true,
        previewsContainer: ".task-files-preview",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });


    /*
        var formElement = document.querySelector('form');
        var submitBtnElement = document.querySelector('.button');
        submitBtnElement.addEventListener('click', function (evt) {
            evt.preventDefault();
            var formData = new FormData(formElement);
            var imageFiles = dropzone.files;
            imageFiles.forEach((file) => {
                formData.append('files[]', file);
            })
                var request = new XMLHttpRequest();
                request.open("POST", window.location.href);
                request.send(formData);
            setTimeout(() => {
                window.location.reload();
            }, 100);
        })
    */


</script>
-->
