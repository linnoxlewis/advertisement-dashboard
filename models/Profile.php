<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Форма Профиля
 *
 * Class Profile
 *
 * @property int    $cityId
 * @property string $name
 * @property string $phone
 * @property string $description
 *
 * @package app\models
 */
class Profile extends Model
{
    /**
     * Имя пользователя
     *
     * @var string
     */
    protected $name;

    /**
     * Описание пользователя
     *
     * @var string
     */
    protected $description;

    /**
     * Телефон пользователя
     *
     * @var string
     */
    protected $phone;

    /**
     * Город
     *
     * @var integer
     */
    protected $cityId;

    /**
     * Аватарка
     *
     * @var array
     */
    protected $avatar;

    /**
     * Получение имени
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Установка имени
     *
     * @param string $value новое значение
     *
     * @return $this
     */
    public function setName(string $value)
    {
        $this->name = $value;
        return $this;
    }

    /**
     * Получение описания
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Установка описания
     *
     * @param string $value новое значение
     *
     * @return $this
     */
    public function setDescription(string $value)
    {
        $this->description = $value;
        return $this;
    }

    /**
     * Получение телефона
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Установка телефона
     *
     * @param string $value новое значение
     *
     * @return $this
     */
    public function setPhone(string $value)
    {
        $this->phone = $value;
        return $this;
    }

    /**
     * Получение города
     *
     * @return int
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Установка города
     *
     * @param int $value новое значение
     *
     * @return $this
     */
    public function setCityId(int $value)
    {
        $this->cityId = $value;
        return $this;
    }

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
     * Правила валидации
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'required','message'=>'{attribute} не может быть пустым'],
            ['name', 'string', 'min' => 2, 'max' => 255],
            ['cityId', 'required','message'=>'{attribute} не может быть пустым'],
            ['cityId', 'integer'],
            [['description', 'phone'], 'string'],
            ['phone', 'required','message'=>'{attribute} не может быть пустым'],
        ];
    }

    /**
     * Лейблы
     *
     * @return array
     */
    public function attributeLabels() : array
    {
        return [
            'name' => 'Имя',
            'cityId' => 'Город',
            'image' => 'Фото',
            'description' => 'О себе',
            'phone' => 'Телефон',
        ];
    }

    /**
     * Сохранение профиля
     *
     * @return bool|null
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = Yii::$app->user->identity;
        $user->phone = $this->phone;
        $user->name = $this->name;
        $user->description = $this->description;
        $user->cityId = $this->cityId;

        return $user->save();
    }
}
