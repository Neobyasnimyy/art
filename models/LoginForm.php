<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
//    public $username;
    public $password;
    public $email;
    public $rememberMe = true;

    private $_user = false;

    public function attributeLabels()
    {
        return [
//            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'E-mail',
            'rememberMe' => 'Запомнить',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // a1 должен быть уникальным в столбце, который представляет "email" атрибут,
            // работает только с атрибутами модели Active Record
//            ['email', 'unique'],

            [['password', 'email'],'trim'],
            // username and password are both required
            [[ 'password', 'email'], 'required'],
//            ['username', 'string', 'length' => [4, 24]],
//            ['username', 'validateName'],

            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],

            // password is validated by validatePassword()
            ['password', 'validatePassword'],
//            [['password'], 'string', 'max' => 30,'tooShort' => 'Пароль слишком длинный'],
//            [['password'], 'string', 'min' => 6,'tooShort' => 'Пароль слишком короткий'],

            // атрибут email указывает, что в переменной email должен быть корректный адрес электронной почты
            ['email', 'email'],

        ];
    }

//    // наша созданная валидация, она будет работать на сервере уже
//    public function validateName($attribute)
//    {
//        if (preg_match('/[^(\w) | (\x7F-\xFF) | (\s)]/', $this->$attribute)) {
//            $this->addError($attribute, 'Имя может содержать только буквенные символы, знаки подчеркивания и пробелы.');
//        }
//    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Проверьте правильность ввода E-mail и пароля.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if ($this->rememberMe){
                $u = $this->getUser();
                $u->generateAuthKey();
                $u->save();
            }
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0); // записываем на месяц
        }
        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
//            $this->_user = User::findByUsername($this->username);
            $this->_user = User::findByEmail($this->email);
            if ($this->_user==null){
                $this->addErrors(['email'=>'Пользователя с таким E-mail не существует']);
            }
        }
        return $this->_user;
    }
}
