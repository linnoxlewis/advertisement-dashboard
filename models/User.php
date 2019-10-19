<?php
namespace app\models;

use app\components\DateUpdater;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;

/**
 * Модель пользователя
 *
 * Class User
 *
 * @property int    $id
 * @property string $name
 * @property string $password
 * @property string $image
 * @property int    $cityId
 * @property string $description
 * @property string $phone
 * @property string $dateAdd
 * @property array  $avatar
 *
 * @package app\models
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * Аватарка
     *
     * @var array
     */
    protected $avatar;

    /**
     * Получить аватар
     *
     * @return array
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Установить Аватар
     *
     * @param  array $value значение
     *
     * @return $this
     */
    public function setAvatar($value)
    {
        $this->avatar = $value;
        return $this;
    }

    /**
     * Имя таблицы
     *
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user}}';
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
     * Identity метод
     *
     * @param int $id id юзера
     *
     * @return User|\yii\web\IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     *
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Найти по почте
     *
     * @param string $email почта пользователя
     *
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Получение id
     *
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return false;
    }

    /**
     * Проверка ключа
     *
     * @param string $authKey ключ
     *
     * @return bool|void
     *
     * @throws NotSupportedException
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }

    /**
     * Проверка пароля
     *
     * @param string $password Входящий пароль
     *
     * @return bool
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Установка пароля
     *
     * @param string $password пароль
     *
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Генерация запомнить меня
     *
     * @throws NotSupportedException
     */
    public function generateAuthKey()
    {
        throw new NotSupportedException('Auth token is not implemented.');
    }

    /**
     * Получение создателя
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertisements()
    {
        return $this->hasMany(Advertisement::class, ['userId' => 'id']);
    }

    /**
     * Проверка незаполнености профиля
     *
     * @return bool
     */
    public function isEmptyProfile(): bool
    {
        return (empty($this->name)
            || empty($this->phone)
            || empty($this->cityId));
    }

    /**
     * Загрузка аватарки
     *
     * @return array
     * @throws \yii\base\Exception
     */
    public function ajaxUploadAvatar() : array
    {
        $filename = Yii::$app->getSecurity()->generateRandomString(10)
            . '_' . (string)$this->avatar['name'];
        $allowed =  ['gif','png' ,'jpg'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array($ext,$allowed) ) {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Неверный формат файла'
            ];
        }
        if($this->avatar['size'] > 3145728)
        {
            return [
                'success' => false,
                'data' => null,
                'message' => 'Размер файла не должен превышать 3 МБ'
            ];
        }

        $path = '/uploads/' . $filename;
        $uploadPath = Yii::getAlias('@app') . '/web' . $path;
        $this->image = $path;

        (move_uploaded_file($this->avatar['tmp_name'], $uploadPath) && $this->save(false))
            ? $result = [
            'success' => true,
            'data' => $path,
            'message' => 'Аватар успешно загружен'
            ]
            : $result = [
                'success' => false,
                'data' => null,
                'message' => 'Не удалось загрузить аватар'
            ];
        return $result;
    }
}
