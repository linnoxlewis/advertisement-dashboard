<?php
namespace app\models\abstracts;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Категории модель
 *
 * Class SelectModels
 *
 * @property int $id
 * @property string $name
 *
 * @package app\models\abstracts
 */
class SelectModels extends ActiveRecord
{
    /**
     * Список модели
     *
     * @return array
     */
    public static function getList(): array
    {
        $result = static::find()
            ->select(['name', 'id'])
            ->indexBy('id')
            ->column();
        return ArrayHelper::merge([0 => 'Все записи'],$result);
    }

    /**
     * Получение значения по ключу
     *
     * @param int $id ключ списка
     *
     * @return string
     */
    public static function getValue($id): string
    {
        return ArrayHelper::getValue(static::getList(), $id);
    }
}
