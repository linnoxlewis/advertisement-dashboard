<?php

namespace app\models\interfaces;

/**
 * Интерфейс получения данных
 *
 * Interface DataInterface
 *
 * @package app\models\interfaces
 */
interface DataInterface
{
    /**
     * Вывод контента с фильтром
     *
     * @return \yii\db\ActiveQuery
     */
    public function getData();
}
