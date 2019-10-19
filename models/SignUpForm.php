<?php
namespace app\models;

use yii\base\Model;

/**
 * Форма регистрации
 *
 * Class SignupForm
 *
 * @property string $email
 * @property string $password
 *
 * @package app\models
 */
class SignupForm extends Model
{
    /**
     * Почта пользователя
     *
     * @var string
     */
    protected $email;

    /**
     * Пароль пользователя
     *
     * @var string
     */
    protected $password;

    /**
     * Получить email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Установить email
     *
     * @param string $value значение
     *
     * @return $this
     */
    public function setEmail(string $value)
    {
        $this->email = $value;
        return $this;
    }

    /**
     * Получить пароль
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Установить пароль
     *
     * @param string $value значение
     *
     * @return $this
     */
    public function setPassword(string $value)
    {
        $this->password = $value;
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
            ['email', 'trim'],
            ['email', 'required','message'=>'{attribute} не может быть пустым'],
            ['email', 'email','message'=>'{attribute} не является email`ом'],
            [['email'], 'string'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Адрес уже зарегистрирован.'],
            ['password', 'required','message'=>'{attribute} не может быть пустым'],
            ['password', 'string', 'min' => 5],
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
            'email'=> 'Email',
            'password' => 'Пароль'
        ];
    }

    /**
     * Регистрация пользователя
     *
     * @return User|null
     *
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->email = $this->email;
        $user->setPassword($this->password);
        return $user->save() ? $user : null;
    }
}
