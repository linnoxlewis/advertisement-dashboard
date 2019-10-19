<?php
namespace app\controllers\actions;

use yii\base\Action;

/**
 * Метод удаления изображения
 *
 * Class DeleteImageAction
 *
 * @package app\controllers
 */
class DeleteImageAction extends Action
{
    /**
     * Модель данных
     *
     * @var object
     */
    protected $model;

    /**
     * Получение модели
     *
     * @return $this
     */
    public function getModel()
    {
        return $this->setModel();
    }

    /**
     * Установка модели
     *
     * @param object $value модель
     * @return $this
     */
    public function setModel($value)
    {
        $this->model = $value;
        return $this;
    }

    /**
     * Запуск метода удаления файла
     *
     * @param int $id id Записи
     * @param string $attribute название аттри
     *
     * @return bool
     */
    public function run(int $id, string $attribute)
    {
        $model = $this->model::findOne($id);
        if (unlink(substr($model->{$attribute},1))) {
            $model->{$attribute} = '';
            return $model->save();
        }
    }
}
