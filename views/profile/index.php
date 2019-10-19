<?php
use app\models\Towns;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;
$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <?= Yii::$app->session->getFlash('success'); ?>
    <h1 align="center"><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <div class="col-lg-3">
            <img class="avatar" alt="140x140"
                <?php if (!empty($userModel->image)): ?>
                    src="<?= $userModel->image ?>"
                <?php else : ?>
                    src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjcwIiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE0MHgxNDA8L3RleHQ+PC9zdmc+"
                <?php endif; ?>
                 style="width: 140px; height: 140px; margin-bottom: 5%"
            />
            <p class="error-avatar"></p>
            <?= $form->field($model, 'avatar')->fileInput()->label('') ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'name')->textInput(['value' => $userModel->name, 'autofocus' => true]) ?>
            <?= $form->field($model, 'cityId')->widget(Select2::classname(), [
                'data' => Towns::getList(),
                'options' => ['placeholder' => 'Выберите город', 'value' => $userModel->cityId],
            ]); ?>
            <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                'mask' => '+7 (999) 999-99-99',
                'options' => [
                    'class' => 'form-control placeholder-style',
                    'id' => 'phone',
                    'value' => $userModel->phone,
                    'placeholder' => ('Телефон')
                ],
                'clientOptions' => [
                    'clearIncomplete' => true
                ]
            ]) ?>
            <?= $form->field($model, 'description')->textarea(['value' => $userModel->description, 'rows' => 4]) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить данные', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script>
    var files;
    $('input[type=file]').change(function () {
        file = this.files[0];
        event.stopPropagation(); // Остановка происходящего
        event.preventDefault(); // Полная остановка происходящего
        if (typeof file == 'undefined') return;
        var data = new FormData();
        data.append('file', file);
        $.ajax({
            url: '/profile/set-avatar',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                if (data['success']) {
                    $('.error-avatar').html("<span style='color:green'>" + 'Аватар успешно загружен' + '</span>')
                    $('.avatar').attr('src', data['data']);
                } else {
                    $('.error-avatar').html("<span style='color:red'>" + data['message'] + '</span>')
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('ОШИБКИ AJAX запроса: ' + textStatus);
            }
        });
    });
</script>
