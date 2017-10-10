<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $data
 * @property string $title
 * @property string $image_name
 * @property string $description
 * @property integer $is_active
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['date'], 'default', 'value' => date('d-m-Y')],
//            [['date'], 'date', 'format' => 'd-m-Y'],

            [['data','title', 'description'], 'required'],
            [['description'], 'string'],
            [['is_active'], 'boolean'],
            ['is_active', 'default', 'value' => 1],
            [['title', 'image_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Дата',
            'title' => 'Заголовок',
            'image_name' => 'Имя картинки',
            'description' => 'Описание',
            'is_active' => 'Активность',
        ];
    }
}
