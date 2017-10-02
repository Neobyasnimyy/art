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
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'image' => 'Image',
        ];
    }
}
