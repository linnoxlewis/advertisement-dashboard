<?php
$this->params['breadcrumbs'][] = $model->category->name;
use app\models\StatusModel; ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 list-group-item">
            <p align="center"><h3><?= $model->title;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp Цена:<?= $model->amount;?> руб </h3></p>
            <p><strong><?= Yii::$app->formatter->asDateTime($model->dateAdd, 'medium');?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp <strong>Город</strong>:<?= $model->city->name;?></p>

            <div align="center" class="carousel slide"  style="width: 100%; height:600px " id="myCarousel">
                <div class="carousel-inner ">
                    <div class="item active">
                        <img style="width: 100%; height: 600px" src="<?= $model->mainImage?>" />
                    </div>
                    <?php foreach ($model->images as $image) : ?>
                        <div class="item">
                            <img style="width: 100%; height: 600px" src="<?= $image->path ?>" />
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="control-box">
                    <a data-slide="prev" href="#myCarousel" class="carousel-control left">‹</a>
                    <a data-slide="next" href="#myCarousel" class="carousel-control right">›</a>
                </div>
            </div>
            <p style="margin-top: 5%"><?=$model->description?></p>
        </div>
        <div class=" col-xs-12 col-sm-4">
            <div class="list-group-item">
                <p><img src="<?=$model->user->image?>" style="width: 200px; height: 200px;"></p>
                <p><strong>Имя</strong>: <?= $model->user->name?></p>
                <p><strong>На сайте</strong>: с <?=  Yii::$app->formatter->asDate($model->user->dateAdd, 'medium')?></p>
                <p><strong>Объявлений</strong>: <?= $model->user->getAdvertisements()->where(['statusId' => StatusModel::STATUS_ACTIVE])->count()?></p>
                <p><strong>Телефон</strong>: <?= $model->user->phone?></p>
                <p><strong>О себе</strong>: <?= $model->user->description?></p>
            </div>
        </div><!--/span-->
    </div>
</div>
