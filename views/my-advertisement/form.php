<?php
use app\models\AdsImages;
use app\models\Categories;
use app\models\Towns;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
$model->isNewRecord ? $this->title = 'Создать объявление' : $this->title = 'Изменить объявление';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
   <div align="center"><h1><?= Html::encode($this->title) ?></h1></div>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'userId')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>
            <?= $form->field($model, 'title')->textInput() ?>
            <?= $form->field($model, 'amount')->textInput() ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
            <?= $form->field($model, 'cityId')->widget(Select2::classname(), [
                'data' => Towns::getList(),
                'options' => ['placeholder' => 'Выберите город', 'value' => Yii::$app->user->identity->cityId],
            ]); ?>
            <?= $form->field($model, 'categoryId')->widget(Select2::classname(), [
                'data' => Categories::getList(),
                'options' => ['placeholder' => 'Выберите категорию'],
            ]); ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить данные', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
        </div>
        <div class="col-lg-6">
            <p>Вы можете загрузить фотографию в формате jpeg, jpg, png. весом не более 10 Мб</p>
            <?= $form->field($model, 'mainFile')->widget(FileInput::classname(), [
                'language' => 'ru',
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'maxFileSize' =>  10485760,
                    'deleteUrl' => Url::toRoute(['/my-advertisement/delete-image?id=' . $model->id . '&attribute=mainImage']),
                    'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                    'showUpload' => true,
                    'maxFileCount' => 1,
                    'initialPreview' => [
                        $model->mainImage ? Html::img($model->mainImage, ['style' => ['width' => '200px', 'height' => '200px']]) : null,
                    ],
                ]
            ]); ?>
            <?= $form->field($model, 'files')->widget(FileInput::classname(), [
                'language' => 'ru',
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'maxFileSize' => 10485760,
                    'deleteUrl' => Url::toRoute(['/my-advertisement/delete-image?id=' . $model->id . '&attribute=path']),
                    'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                    'showUpload' => true,
                    'maxFileCount' => 10,
                    'initialPreview' => $model->images ? AdsImages::getListImagesForWidget($model->id) : [],
                ]
            ]); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
