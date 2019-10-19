<?php
namespace app\models;

use app\models\abstracts\SelectModels;

/**
 * Модель города
 *
 * Class Towns
 *
 * @property int    $id
 * @property string $name
 *
 * @package app\models
 */
class Towns extends SelectModels
{
    public static function tableName()
    {
        return '{{%towns}}';
    }
}
