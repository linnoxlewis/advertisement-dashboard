<?php
namespace app\models\abstracts;

use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class ListAbstract
 *
 * Абстрактный класс построение модели статичных списков.
 *
 * @package app\models\abstracts
 */
abstract class ListAbstract extends Model
{
    /**
     * Идентификатор значения.
     *
     * @var int|null
     */
    protected $id;

    /**
     * Получить массив допустимых значений.
     *
     * @return array
     */
    abstract public static function getList();


    /**
     * Получить массив правил валидации.
     *
     * @return array
     */
    public function rules()
    {
        return [['id', 'required']];
    }

    /**
     * Получить идентификатор значения.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Указать идентификатор значения.
     *
     * @param int|null $value
     *
     * @return static
     */
    public function setId(int $value = null)
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Получить значение.
     *
     * @return mixed|string
     */
    public function getValue()
    {
        if (!$this->validate()) {
            return '';
        }
        return ArrayHelper::getValue(static::getList(), $this->getId());
    }

    /**
     * @return mixed|string
     */
    public function __toString()
    {
        return $this->getValue();
    }
}
