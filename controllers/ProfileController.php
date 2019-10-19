<?php
namespace app\controllers;

use app\models\Profile;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Контроллер профиля
 *
 * Class ProfileController
 *
 * @package app\controllers
 */
class ProfileController extends BaseController
{
    /**
     * Обновление данных в профиле
     *
     * @return string|Response
     *
     * @throws \yii\base\Exception
     */
    public function actionIndex()
    {
        $model = $this->getModel();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->save()) {
                Yii::$app->session->setFlash('success', "Данные успешно сохранены");
                return $this->redirect(['/profile']);
            }
        }
        return $this->render('index', [
            'model' => $model,
            'userModel' => Yii::$app->user->identity
        ]);
    }

    /**
     * Получить имя модели
     *
     * @return string
     */
    protected function getModelName(): string
    {
        return Profile::class;
    }

    /**
     * Установка аватара у пользователя
     *
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionSetAvatar(): string
    {
        if(Yii::$app->request->isAjax) {
            $user = Yii::$app->user->identity;
            $user->avatar = $_FILES['file'];
            return json_encode($user->ajaxUploadAvatar());
        }
        throw new ForbiddenHttpException('method is not ajax');
    }
}
