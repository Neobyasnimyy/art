<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property string $genre
 * @property string $description
 *
 * @property Image[] $images
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['name', 'genre'], 'string', 'max' => 255,'tooShort' => 'Уменьшите количество символов'],
            [['name'], 'required', 'message' => 'Поле должно быть заполненно'],
            [['name','genre'], 'validateName'],
            [['name','genre','description'],'trim'], // очищает от пробелов по краям
            ['is_active', 'integer'],
            ['is_active','required','message' => 'Поле должно быть заполненно'],
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'name' => 'Названия',
            'genre' => 'Жанр',
            'description' => 'Описание',
            'is_active' => 'Активность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::className(), ['id_category' => 'id']);
    }

    /**
     * @return array Categories.name
     */
    public static function getCategoriesList()
    {
        $categories = Category::find()->select(['id', 'name'])->all();
        return ArrayHelper::map($categories, 'id', 'name');
    }

    /**
     * @return string 'Вкл' or 'Выкл' with Categori.is_active
     */
    public function getIsActive()
    {
        return $this->is_active ? 'Вкл' : 'Выкл';
    }
}
