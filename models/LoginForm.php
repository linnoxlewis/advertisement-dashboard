<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Форма логина
 *
 * Class LoginForm
 *
 * @property User|null $_user
 * @property string    $email
 * @property string    $password
 *
 */
class LoginForm extends Model
{
    /**
     * Email пользователя
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
     * Поле пользователя
     *
     * @var bool
     */
    private $_user = false;

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
            [['email', 'password'], 'required','message'=>'{attribute} не может быть пустым'],
            ['email', 'email','message'=>'Неверный шаблон почты'],
            ['password', 'validatePassword'],
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
            'email' => 'Email',
            'password' => 'Пароль'
        ];
    }

    /**
     * Проверка пароля
     *
     * @param string $attribute атрибут формы
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверное имя пользователя или пароль');
            }
        }
    }

    /**
     * Логин пользователя
     *
     * @return bool
     */
    public function login() : bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(),3600*24*30 );
        }
        return false;
    }

    /**
     * Получить пользователя
     *
     * @return User|bool|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }
        return $this->_user;
    }
}
