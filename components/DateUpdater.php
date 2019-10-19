<?php
namespace app\components;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Компонент автоматического добавления даты
 *
 * Class DateUpdater
 *
 * @package app\components
 */
class DateUpdater extends TimestampBehavior
{
    /**
     * Атрибут даты создания
     *
     * @var string
     */
    public $createdAtAttribute = 'dateAdd';

    /**
     * Атрибут даты обновления
     *
     * @var null|string
     */
    public $updatedAtAttribute = NULL;

    /**
     * Значение даты
     *
     * @var string
     */
    public $value;

    /**
     * Мктод установки значения
     *
     * @param $event
     * @return false|int|mixed|string|Expression
     */
    protected function getValue($event)
    {
        if ($this->value instanceof Expression) {
            return $this->value;
        } else {
            return $this->value !== null ? call_user_func($this->value, $event) : date('Y-m-d H:i:s');
        }
    }
}
