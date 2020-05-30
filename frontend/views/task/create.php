<?php


use frontend\models\Category;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

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

                <label>Файлы</label>
                <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
                <div id="previews"></div>
                <div class="create__file dropzone">
                    <span>Добавить новый файл</span>
                </div>


                <?php ActiveForm::end(); ?>
                <form class="create__task-form form-create" action="/" enctype="multipart/form-data" id="task-form">
                    <label for="10">Мне нужно</label>
                    <textarea class="input textarea" rows="1" id="10" name="" placeholder="Повесить полку"></textarea>
                    <span>Кратко опишите суть работы</span>
                    <label for="11">Подробности задания</label>
                    <textarea class="input textarea" rows="7" id="11" name="" placeholder="Place your text"></textarea>
                    <span>Укажите все пожелания и детали, чтобы исполнителям было проще соориентироваться</span>
                    <label for="12">Категория</label>
                    <select class="multiple-select input multiple-select-big" id="12"size="1" name="category[]">
                        <option value="day">Уборка</option>
                        <option selected value="week">Курьерские услуги</option>
                        <option value="month">Доставка</option>
                    </select>
                    <span>Выберите категорию</span>
                    <label>Файлы</label>
                    <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
                    <div class="create__file">
                        <span>Добавить новый файл</span>
                        <!--                          <input type="file" name="files[]" class="dropzone">-->
                    </div>
                    <label for="13">Локация</label>
                    <input class="input-navigation input-middle input" id="13" type="search" name="q" placeholder="Санкт-Петербург, Калининский район">
                    <span>Укажите адрес исполнения, если задание требует присутствия</span>
                    <div class="create__price-time">
                        <div class="create__price-time--wrapper">
                            <label for="14">Бюджет</label>
                            <textarea class="input textarea input-money" rows="1" id="14" name="" placeholder="1000"></textarea>
                            <span>Не заполняйте для оценки исполнителем</span>
                        </div>
                        <div class="create__price-time--wrapper">
                            <label for="15">Срок исполнения</label>
                            <input id="15"  class="input-middle input input-date" type="date" placeholder="10.11, 15:00">
                            <span>Укажите крайний срок исполнения</span>
                        </div>
                    </div>
                </form>
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
                    <div class="warning-item warning-item--error">
                        <h2>Ошибки заполнения формы</h2>
                        <h3>Категория</h3>
                        <p>Это поле должно быть выбрано.<br>
                            Задание должно принадлежать одной из категорий</p>
                    </div>
                </div>
            </div>
            <button form="task-form" class="button" type="submit">Опубликовать</button>
        </section>
    </div>
</main>
<script src="js/dropzone.js"></script>
<script>
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
        previewsContainer: "#previews",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });

    var formElement = document.querySelector('#task-form');
    var submitBtnElement = formElement.querySelector('button[type="submit"]');
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
    });
</script>
