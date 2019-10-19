<?php
namespace app\models;

use app\models\abstracts\SelectModels;

/**
 * Категории модель
 *
 * Class Categories
 *
 * @property int    $id
 * @property string $name
 *
 * @package app\models
 */
class Categories extends SelectModels
{
    /**
     * Получить имя таблицы
     *
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%categories}}';
    }
}
