<?php
use app\assets\AppAsset;
use app\models\Categories;
use app\models\StatusModel;
use yii\widgets\LinkPager;
use kartik\select2\Select2;
$this->title = 'Мои объявления';
AppAsset::register($this);
?>
<h1><?= $this->title ?></h1>
<?= Yii::$app->session->getFlash('success'); ?>
<div class="container" style="margin-top: 2%">
    <div align="center" class="row">
        <form class="form-inline">
            <div class="form-group">
                <?= Select2::widget([
                    'name' => 'statusId',
                    'data' => StatusModel::getList(),
                    'options' => [
                        'placeholder' => 'Выберите статус']]); ?>
            </div>
            <div class="form-group">
                <?= Select2::widget([
                    'name' => 'categoryId',
                    'data' => Categories::getList(),
                    'options' => [
                        'placeholder' => (key_exists('categoryId', $params) && !empty($params['categoryId']))
                            ? Categories::getValue((int)$params['categoryId'])
                            : 'Выберите категорию']]); ?>
            </div>
            <div class="form-group">
                <label class="sr-only" for="inputEmail">Поиск</label>
                <input name="query" value="<?= (key_exists('query', $params) && !empty($params['query']))
                    ? $params['query']
                    : null ?>"
                       type="text" class="form-control" id="inputEmail" placeholder="Поиск">
            </div>
            <button type="submit" class="btn btn-primary">Фильтр</button>
            <a href="/advertisement">
                <button class="btn btn-primary">Сбросить фильтры</button>
            </a>
        </form>
    </div>
    <?php $counter = 1 ?>
    <?php foreach ($posts as $model) : ?>
        <div class="row">
            <div class="col-xs-12 col-sm-8" style="margin-top: 5%">
                <h4><strong><?= $model->title ?></strong>
                    &nbsp
                    <?php if ($model->statusId !== StatusModel::STATUS_CLOSED) : ?>
                        <a href="update?id=<?= $model->id; ?>">
                            <span class="glyphicon glyphicon-pencil"> </span>
                        </a>
                        &nbsp
                        <a href="/my-advertisement/set-status?id=<?= $model->id ?>&status=<?= StatusModel::STATUS_CLOSED ?>">
                            <button id="close-data" class="btn btn-primary">Закрыть</button>
                        </a>
                    <?php endif; ?>
                </h4>
                <p><strong><?= Yii::$app->formatter->asDateTime($model->dateAdd, 'medium'); ?></strong>
                    &nbsp<strong>Категория</strong>:<?= $model->category->name ?>&nbsp<strong>
                        Город</strong>:<?= $model->city->name ?>
                    &nbsp<strong>Статус</strong>:<?= $model->status() ?>
                </p>
                <p style="margin-top: 5%"><?= $model->description ?></p>
            </div>
            <div class="col-xs-12 col-sm-3 carousel slide" id="myCarousel<?= $counter ?>" style="margin-top: 5%">
                <p align="center"><strong>Цена:</strong> <?= $model->amount ?> руб</p>
                <div class="carousel-inner ">
                    <div class="item active">
                        <img style="width: 100%; height: 250px"
                            <?php if (!empty($model->mainImage)): ?>
                                src="<?= $model->mainImage ?>"
                            <?php else : ?>
                                src="/images/no-photo.gif"
                            <?php endif; ?>
                        />
                    </div>
                    <?php if (!empty($model->images)) : ?>
                        <?php foreach ($model->images as $image) : ?>
                            <div class="item">
                                <img style="width: 100%; height: 250px" src="<?= $image->path ?>"/>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php if ($model->getImages()->count() > 0) : ?>
                    <div class="control-box">
                        <a data-slide="prev" href="#myCarousel<?= $counter ?>" class="carousel-control left">‹</a>
                        <a data-slide="next" style="right: 15px" href="#myCarousel<?= $counter ?>"
                           class="carousel-control right">›</a>
                    </div>
                    <p>Фотографий: <?= $model->getImages()->count() ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php $counter++; ?>
    <?php endforeach; ?>
</div>
<div align="center">
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>

<script>
    $(function () {
        $('#close-data').on('click', function () {
            var id = $(this).val();
            $.ajax({
                url: 'my-advertisement/set-status.php',
                data: {
                    id: id,
                    status: 0
                },
                dataType: 'json'
            });
        });
    });
</script>
