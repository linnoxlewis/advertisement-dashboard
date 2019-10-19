<?php
namespace app\models;

use app\components\DateUpdater;
use app\models\interfaces\DataInterface;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * Модель объявлений
 *
 * Class Advertisement
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $cityId
 * @property int $amount
 * @property string $mainImage
 * @property int $categoryId
 * @property int $statusId
 * @property int $userId
 * @property string $dateAdd
 *
 * @package app\models
 */
class Advertisement extends ActiveRecord implements DataInterface
{
    /**
     * Запрос поиска
     *
     * @var string
     */
    protected $query;

    /**
     * Картинки объявлений
     *
     * @var array
     */
    protected $files;

    /**
     * Главная картинка объявлений
     *
     * @var array
     */
    protected $mainFile;

    /**
     * Имя таблицы
     *
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%advertisement}}';
    }

    /**
     * Получение запроса поиска
     *
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Установка запроса поиска
     *
     * @param string $value значения
     *
     * @return $this
     */
    public function setQuery(string $value)
    {
        $this->query = $value;
        return $this;
    }

    /**
     * Получение файлов
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Установка файлов
     *
     * @param array $value значения файлов
     *
     * @return $this
     */
    public function setFiles($value)
    {
        $this->files = $value;
        return $this;
    }

    /**
     * Получение файлов
     *
     * @return array
     */
    public function getMainFile()
    {
        return $this->mainFile;
    }

    /**
     * Установка файлов
     *
     * @param array $value значения файлов
     *
     * @return $this
     */
    public function setMainFile($value)
    {
        $this->mainFile = $value;
        return $this;
    }

    /**
     * Правила валидации
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title', 'amount', 'categoryId', 'userId'], 'required', 'message' => 'Запоните поле {attribute}'],
            [['title', 'description', 'dateAdd', 'query'], 'string'],
            [['files'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 10, 'maxSize' => 10485760, 'tooBig' => 'Лимит 10МБ'],
            [['mainFile'], 'safe'],
            [['mainFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, gif, png', 'maxSize' => 10485760, 'tooBig' => 'Лимит 10МБ'],
            [['cityId', 'categoryId', 'amount', 'userId', 'statusId'], 'integer']
        ];
    }

    /**
     * Поведение модели
     *
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => DateUpdater::class
            ],
        ];
    }

    /**
     * Лейблы
     *
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'title' => 'Название',
            'description' => 'Описание',
            'cityId' => 'Город',
            'amount' => 'Сумма',
            'categoryId' => 'Категория',
            'statusId' => 'Статус',
            'userId' => 'Пользователь',
            'dateAdd' => 'Дата создания',
            'mainFile' => 'Главное изображение',
            'files' => 'Дополн. изображения объявления'
        ];
    }

    /**
     * Получение создателя
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }

    /**
     * Получение категории
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'categoryId']);
    }

    /**
     * Получение города
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Towns::class, ['id' => 'cityId']);
    }

    /**
     * Получение картинок
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(AdsImages::class, ['adId' => 'id']);
    }

    /**
     * Вывод контента с фильтром
     *
     * @return \yii\db\ActiveQuery
     */
    public function getData()
    {
        $query = static::find()
            ->where([
                'statusId' => StatusModel::STATUS_ACTIVE
            ]);

        if (!empty($this->query)) {
            $query->andFilterWhere(['like', 'title', $this->query]);
        }
        if (!empty($this->categoryId)) {
            $query->andFilterWhere(['=', 'categoryId', (int)$this->categoryId]);
        }
        if (!empty($this->cityId)) {
            $query->andFilterWhere(['=', 'cityId', (int)$this->cityId]);
        }
        if (!\Yii::$app->user->isGuest
            && !empty(\Yii::$app->user->identity->cityId)
            && $this->cityId == '') {
            $query->andWhere(['cityId' => \Yii::$app->user->identity->cityId]);
        }
        $query->orderBy(['dateAdd' => SORT_DESC]);

        return $query;
    }

    /**
     * Получение статуса объявления
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function status(): string
    {
        $statusModel = \Yii::createObject([
            'class' => StatusModel::class,
            'id' => $this->statusId
        ]);

        return $statusModel->getValue();
    }

    /**
     * Метод перед сохранением
     *
     * @param bool $insert
     *
     * @return bool
     *
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        $this->mainFile = UploadedFile::getInstance($this, 'mainFile');
        if (!empty($this->mainFile) && $this->validate()) {
            $filename = \Yii::$app->getSecurity()->generateRandomString(10)
                . '_' . $this->mainFile->baseName;
            $path = $filename . '.' . $this->mainFile->extension;
            if ($this->mainFile->saveAs('uploads/' . $path)) {
                $this->mainImage = '/uploads/' . $path;
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * Загрузка изображений объявлений
     *
     * @param bool $insert
     * @param array $changedAttributes
     *
     * @throws \yii\base\Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->files = UploadedFile::getInstances($this, 'files');
        if ($this->files) {
            foreach ($this->files as $image) {
                $model = new AdsImages();
                $filename = \Yii::$app->getSecurity()->generateRandomString(10)
                    . '_' . $image->baseName;
                $path = $filename . '.' . $image->extension;
                $model->path = '/uploads/' . $path;
                $model->adId = $this->id;
                $image->saveAs('uploads/' . $path);
                $model->save();

            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
