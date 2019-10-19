<?php

namespace app\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Базовый класс КРУДов
 *
 * Class BaseController
 *
 * @package app\controllers
 */
abstract class BaseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'delete-image' => [
                'class' => 'app\controllers\actions\DeleteImageAction',
                'model' => $this->getModel()
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'controllers' => ['site'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Лист записей
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $params = \Yii::$app->request->get();
        $model = $this->getModel();
        $model->load($params, '');
        $query = $model->getData();
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 20]);
        $posts = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', compact('posts', 'pages', 'params'));
    }

    /**
     * Отобращает одну запись модели.
     *
     * @param int $id id записи
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id) : string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание записи
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        $model = $this->getModel();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', "Данные успешно сохранены");
                return $this->redirect(['index', 'id' => $model->id]);
            }
        }
        return $this->render('form', [
            'model' => $model,
        ]);
    }

    /**
     * Обновление записи
     *
     * @param int $id id записи
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = $this->getModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Данные успешно сохранены");
            return $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->render('form', [
            'model' => $model,
        ]);
    }

    /**
     * Удаление записи
     *
     * @param int $id id записи
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', "Данные успешно удалены");
        return $this->redirect(['index']);
    }

    /**
     * Получение модели
     *
     * @param int|null $id
     *
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function getModel(int $id = null)
    {
        if (null == $id) {
            $modelName = $this->getModelName();
            return new $modelName;
        }
        return $this->findModel($id);
    }

    /**
     * Находит модель.
     *
     * @param int|null $id id записи
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id = null)
    {
        $modelName = $this->getModelName();
        $model = new $modelName;
        $result = call_user_func([
            $model,
            'findOne',
        ], $id);
        if ($result !== null) {
            return $result;
        }
        throw new NotFoundHttpException('Страница не найдена.');
    }

    /**
     * Возвращает имя основной модели.
     *
     * @return string
     */
    abstract protected function getModelName(): string;
}
