<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "music".
 *
 * @property string $id
 * @property string $file_name
 * @property string $name
 * @property string $type
 */
class Music extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'music';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['file_name', 'name', 'type'], 'trim'],
            [['file_name', 'name', 'type'], 'required'],
            [['file_name', 'name', 'type'], 'string', 'max' => 200],
            [['name'], 'validateName'],
            [['name'], 'unique'],
        ];
    }

    // наша созданная валидация, она будет работать на сервере уже
    public function validateName($attribute)
    {
        if (preg_match('/[^(\w) | (\x7F-\xFF) | (\s)]/', $this->$attribute)) {
            $this->addError($attribute, 'Имя может содержать только буквенные символы, знаки подчеркивания, пробелы, скобки.');
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'Имя файла',
            'name' => 'Название композиции',
            'type' => 'Формат',
        ];
    }

}
