<?php
use app\assets\AppAsset;
use app\models\Categories;
use app\models\Towns;
use yii\widgets\LinkPager;
use kartik\select2\Select2;
$this->title = 'Актуальные объявления';
AppAsset::register($this);
$counter = 1;
?>
<div class="container marketing" style="margin-top: 10%">
    <div align="center" class="row">
        <form class="form-inline">
            <div class="form-group">
                <?= Select2::widget([
                    'name' => 'cityId',
                    'data' => Towns::getList(),
                    'options' => [
                        'placeholder' => (key_exists('cityId', $params) && !empty($params['cityId']))
                            ? Towns::getValue((int)$params['cityId'])
                            : 'Выберите город']]); ?>
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
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Фильтр</button>
                <a href="/advertisement/">
                    <button class="btn btn-primary empty-filter">Сбросить фильтры</button>
                </a>
            </div>
        </form>
        <h1 align="center"><?= $this->title ?></h1>
    </div>
    <?php foreach ($posts as $post) : ?>
        <?php if ($counter % 2 == 0) : ?>
            <div class="row">
                <div class="col-lg-6" style="margin-top: 5%">
                    <a href="/advertisement/<?= $post->id ?>">
                        <div class="ad-image">
                            <img
                                <?php if (!empty($post->images)): ?>
                                    src="<?= $post->mainImage ?>"
                                <?php else : ?>
                                    src="/images/no-photo.gif"
                                <?php endif; ?>
                            />
                        </div>
                    </a>
                    <h4><?= $post->title ?></h4>
                    <p>Цена:<?= $post->amount ?> Руб</p>
                    <p><?= Yii::$app->formatter->asDatetime($post->dateAdd, 'medium'); ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="col-lg-6" style="margin-top: 5%">
                <a href="/advertisement/<?= $post->id ?>">
                    <div class="ad-image">
                        <img
                            <?php if (!empty($post->images)): ?>
                                src="<?= $post->mainImage ?>"
                            <?php else : ?>
                                src="/images/no-photo.gif"
                            <?php endif; ?>
                        />
                    </div>
                </a>
                <h4><?= $post->title ?></h4>
                <p>Цена:<?= $post->amount ?> Руб</p>
                <p><?= Yii::$app->formatter->asDatetime($post->dateAdd, 'medium'); ?></p>
            </div>
        <?php endif; ?>
        <?php $counter++; ?>
    <?php endforeach; ?>
</div>
<div align="center">
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>
