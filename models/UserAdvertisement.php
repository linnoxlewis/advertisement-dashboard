<?php
namespace app\models;

use app\models\interfaces\DataInterface;

/**
 * Модель объявлений
 *
 * Class UserAdvertisement
 *
 * @property int    $id
 * @property string $title
 * @property string $description
 * @property int    $cityId
 * @property int    $amount
 * @property string $mainImage
 * @property int     $categoryId
 * @property int    $statusId
 * @property int    $userId
 * @property string $dateAdd
 *
 * @package app\models
 */
class UserAdvertisement extends Advertisement implements DataInterface
{
    /**
     * Получить объявления по пользователю
     *
     * @return \yii\db\ActiveQuery|null
     */
    public function getData()
    {
        $userId = \Yii::$app->user->getId();
        if (!empty($userId)) {
            $query = static::find()->where(['userId' => $userId]);
            if (!empty($this->query)) {
                $query->andFilterWhere(['like', 'title', $this->query]);
            }
            if (!empty($this->categoryId)) {
                $query->andFilterWhere(['=', 'categoryId', (int)$this->categoryId]);
            }
            if (!empty($this->statusId)) {
                $query->andFilterWhere(['=', 'statusId', (int)$this->statusId]);
            }
            $query->orderBy(['dateAdd' => SORT_DESC]);
            return $query;
        }
        return null;
    }
}
