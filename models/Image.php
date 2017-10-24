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
            [['id'], 'integer'],
            [['id_category'], 'integer'],
//            [['image_path'], 'required'],
            ['image_path', 'string', 'max' => 255],
            ['name_for_slider', 'trim'],
            ['name_for_slider', 'string', 'max' => 255],
            [['slider_up'], 'integer'],
            [['slider_down'], 'integer'],
//            [['slider_up','	slider_down'],'default', 'value' => 0],
            ['id_category', 'required', 'message' => 'Необходимо выбрать категорию!'],
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
            'image_path' => 'Имя файла',
            'name_for_slider' => 'Текст для слайда',
            'slider_up' => 'Верхний слайдер',
            'slider_down' => 'Нижний слайдер',

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
    public function getImagePath()
    {
        $defaultImageUrl = 'web/uploads/images/default.jpg';
        $imageUrl = Yii::getAlias('@uploads') . '/images/' . $this->id_category . '/' . $this->image_path;
        if (file_exists($imageUrl)) {
            return 'web/uploads/images/' . $this->id_category . '/' . $this->image_path;
        } else {
            return $defaultImageUrl;
        }
    }


}
