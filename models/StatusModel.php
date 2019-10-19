<?php
namespace app\models;

use app\models\abstracts\ListAbstract;

/**
 * Класс модели "Статус".
 *
 * Class StatusModel
 *
 * @package common\models
 */
class StatusModel extends ListAbstract
{
    /**
     * Статус "Активное".
     */
    const STATUS_ACTIVE = 1;

    /**
     * Статус "Закрытое".
     */
    const STATUS_CLOSED = 2;


    /**
     * Правила валидации.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            ['id', 'in', 'range' => [static::STATUS_ACTIVE, static::STATUS_CLOSED]],
            ['id', 'required'],
        ];
    }

    /**
     * Лист значений.
     *
     * @return array
     */
    public static function getList(): array
    {
        return [
            static::STATUS_ACTIVE => 'Активное',
            static::STATUS_CLOSED => 'Закрытое',
        ];
    }
}
