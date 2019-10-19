<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * Модель картинок объявлений
 *
 * Class AdsImages
 *
 * @property int $id
 * @property int $adId
 * @property string $path
 *
 * @package app\models
 */
class AdsImages extends ActiveRecord
{
    /**
     * Имя таблицы
     *
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%ad_images}}';
    }

    /**
     * Правила валидации
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [['adId', 'path'], 'required'],
            ['path', 'string'],
            ['adId', 'integer']
        ];
    }

    /**
     * Получение объявления
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisement()
    {
        return $this->hasOne(Advertisement::class, ['id'=> 'adId']);
    }

    /**
     * Список картинок для виджета
     *
     * @param int $id id родительской модели
     *
     * @return array
     */
    public static function getListImagesForWidget(int $id) : array
    {
        $result = [];
        $images = static::find()->where(['adId' => $id])->all();
        foreach ($images as $image) {
            $result[] = Html::img($image->path, ['style' => ['width' => '200px', 'height' => '200px']]);
        }
        return $result;
    }
}
