<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            [['name', 'email', 'subject'], 'string', 'max' => 255],
            [['name'], 'validateName'],
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }
    // наша созданная валидация, она будет работать на сервере уже
    public function validateName($attribute)
    {
        if (preg_match('/[^(\w) | (\x7F-\xFF) | (\s)]/', $this->$attribute)) {
            $this->addError($attribute, 'Имя может содержать только буквенные символы, знаки подчеркивания и пробелы.');
        }
    }
    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name'=>'Имя',
            'verifyCode' => 'Проверочный Код',
            'subject'=>'Тема',
            'body'=> 'Текст сообщения'
        ];
    }

//    /**
//     * Sends an email to the specified email address using the information collected by this model.
//     * @param string $email the target email address
//     * @return bool whether the model passes validation
//     */
//    public function contact($email)
//    {
//        if ($this->validate()) {
//            Yii::$app->mailer->compose()
//                ->setTo($email)
//                ->setFrom([$this->email => $this->name])
//                ->setSubject($this->subject)
//                ->setTextBody($this->body)
//                ->send();
//
//            return true;
//        }
//        return false;
//    }
}
