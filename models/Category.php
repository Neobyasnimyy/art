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
            [['name','genre','description'],'trim'], // очищает от пробелов по краям
            ['name','unique'], // должен быть уникальным в столбце
            [['name', 'genre'], 'string', 'max' => 255,'tooShort' => 'Уменьшите количество символов'],
            [['name'], 'required', 'message' => 'Поле должно быть заполненно'],
            [['name','genre'], 'validateName'],
            ['is_active', 'integer','max'=>1,'min'=>0],
            // Проверяет, что "deleted" - это тип данных boolean и содержит true или false
//            ['is_active', 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => true],
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
     * @return mixed
     */
    public function getStatus()
    {
        $list= self::getStatusList();
        return $list[$this->is_active];
    }

    /**
     * @return array
     */
    public static function getStatusList(){
        return [0=>'off',1=>'on'];
    }

    /**
     * @return array
     */
    public static function getGenreList(){
        $result = [];
        $arr = self::find()->select('genre')->asArray()->all();
        foreach ($arr as $item){
            $result[$item['genre']]=$item['genre'];
        }
        return array_unique($result);
    }
}
