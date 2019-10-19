<?php
namespace app\controllers;

use app\models\Advertisement;

/**
 * Главная страница
 *
 * Class SiteController
 *
 * @package app\controllers
 */
class SiteController extends BaseController
{
    /**
     * Получить имя модели
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Advertisement::class;
    }
}
