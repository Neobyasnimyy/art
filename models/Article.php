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
            [['is_active'], 'integer','max'=>1,'min'=>0],
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

    // getter проверяет существует ли картинка на сервере,
    // если нет то возвращает дефолтное изображение
    public function getImage(){
        $defaultImageUrl='/web/uploads/images/default.jpg';
        $imageUrl = Yii::getAlias('@uploads').'/article/'.$this->image_name;
        if (file_exists($imageUrl)&& is_file($imageUrl)) {
            return '/web/uploads/article/'.$this->image_name;
        } else {
            return $defaultImageUrl;
        }
    }

    /**
     * @return array
     */
    public static function getStatusList(){
        return [''=>'все',0=>'off',1=>'on'];
    }

    public function getStatus()
    {
        $list= self::getStatusList();
        return $list[$this->is_active];
    }
}
