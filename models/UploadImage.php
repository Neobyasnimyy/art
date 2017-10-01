<?php

namespace app\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

class UploadImage extends Model
{

    public $image;

    public function rules()
    {
        return [
            [['image'],
                'file',
                'extensions' => 'png, jpg, gif, bmp',
                'maxSize' => 1024 * 1024 * 3,
                'tooBig' => "Файл «{file}» слишком большой. Размер не должен превышать 3 MB.",
                'mimeTypes' => ['image/gif','image/jpeg','image/png']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image' => 'Изображение',
        ];
    }

    // этот метот сохраняет изображение в папке с id категории и занимается валидацией
    public function upload($idCategory)
    {
        if ($this->validate() and isset($idCategory)) {
            $this->image->saveAs(Yii::getAlias('@uploads')."/images/{$idCategory}/{$this->image->baseName}.{$this->image->extension}");
        } else {
            return false;
        }
    }

}