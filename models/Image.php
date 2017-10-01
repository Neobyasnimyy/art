<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property integer $id_category
 * @property string $image_path
 *
 * @property Category $idCategory
 */
class Image extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_category'], 'integer'],
            [['image_path'], 'required'],
//            ['image_path', 'string', 'max' => 255],
            // проверяет, что "image_path" - это загруженное изображение в формате PNG,bmp, JPG или GIF
            // размер файла должен быть меньше 3MB
            // https://yiiframework.com.ua/ru/doc/guide/2/tutorial-core-validators/#file
//            ['imageFile', 'file', 'extensions' => ['png', 'jpg', 'gif','bmp'], 'maxSize' => 1024*1024*3],
            ['id_category','required','message'=>'Необходимо выбрать категорию!'],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['id_category' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'id_category' => 'Категория',
            'image_path' => 'Путь к изображению',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'id_category']);
    }

    // getter проверяет существует ли картинка на сервере,
    // если нет то возвращает дефолтное изображение
    public function getImagePath(){
        $defaultImageUrl='web/uploads/images/default.jpg';
        $imageUrl = Yii::getAlias('@uploads').'/images/'.$this->id_category.'/'.$this->image_path;
        if (file_exists($imageUrl)) {
            return 'web/uploads/images/'.$this->id_category.'/'.$this->image_path;
        } else {
            return $defaultImageUrl;
        }
    }


}
