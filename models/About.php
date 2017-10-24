<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "about".
 *
 * @property integer $id
 * @property string $text
 * @property string $image
 */
class About extends \yii\db\ActiveRecord
{
    /**
     * @return string tableName
     */
    public static function tableName()
    {
        return 'about';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['image_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Текст',
            'image_name' => 'Фото',
        ];
    }

    public function getImage(){
        $defaultImageUrl='/web/uploads/images/default.jpg';
        $imageUrl = Yii::getAlias('@uploads').'/about/'.$this->image_name;
        if (file_exists($imageUrl)&& is_file($imageUrl)) {
            return '/web/uploads/about/'.$this->image_name;
        } else {
            return $defaultImageUrl;
        }
    }
}
