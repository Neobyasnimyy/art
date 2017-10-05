<?php

namespace app\models;

use yii\base\Model;
use yii\helpers\HtmlPurifier;

class RegisterForm extends Model
{

    public $username;
    public $password;
    public $email;


    public function rules()
    {
        return [

            [['username', 'password','email'], 'trim'],
            [['username', 'password','email'], 'required'],
            ['username', 'string', 'length' => [4, 24]],
            ['username', 'filter', 'filter' => function ($value) {
                return HtmlPurifier::process($value);
            }],
            ['username', 'validateName'],

            ['password', 'filter', 'filter' => function ($value) {
                return HtmlPurifier::process($value);
            }],
            // password is validated by passwordStrength()
            ['password', 'validatePassword'],
//            [['password'], 'string', 'max' => 30,'tooShort' => 'Пароль слишком длинный'],
            [['password'], 'string', 'min' => 6,'tooShort' => 'Пароль слишком короткий.'],

            // атрибут email указывает, что в переменной email должен быть корректный адрес электронной почты
            ['email', 'email'],
            // проверка на уникальность
            ['email', 'unique', 'targetClass' => User::className(),  'message' => 'Пользователь с таким E-mail уже существует.'],
        ];
    }

    /**
     * Метод проверяет силу пароля
     * Этот метод является валидатором 'validatePassword' для метода rules().
     */
    public function validatePassword($attribute)
    {
        $pattern = '/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}/';
        if(!preg_match($pattern, $this->$attribute))
            $this->addError($attribute, 'Пароль должен содержать латинские буквы в верхнем и нижнем регистре, и хотя бы одно число.');


    }

    // наша созданная валидация, она будет работать на сервере уже
    public function validateName($attribute)
    {
        if (preg_match('/[^(\w) | (\x7F-\xFF) | (\s)]/', $this->$attribute)) {
            $this->addError($attribute, 'Имя может содержать только буквенные символы, знаки подчеркивания и пробелы.');
        }
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'E-mail',
        ];
    }

}