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
//                'skipOnEmpty' => false, // обязательная загрузка файла
                'maxSize' => 1024 * 1024 * 3,
                'tooBig' => "Файл «{file}» слишком большой. Размер не должен превышать 3 MB.",
                'mimeTypes' => ['image/gif', 'image/jpeg', 'image/png']
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


    /**
     * этот метот сохраняет изображение в папке с id категории и занимается валидацией
     * @param string $modelName
     * @param integer $idCategory
     * @return bool
     */
    public function upload($modelName, $idCategory=null)
    {
        switch ($modelName){
            case ('image'):
                if ($this->validate() and isset($idCategory)) {
                    if (!file_exists(Yii::getAlias('@uploads'). "/images/{$idCategory}")){
                        mkdir(Yii::getAlias('@uploads')."/images/{$idCategory}", 0775, true);
                    }
                    $this->image->name= rand(0,9999)."-". date('YmdHi', time()).'.'.$this->image->extension;
//                    $this->image->saveAs(Yii::getAlias('@uploads')
//                        . "/images/{$idCategory}/{$this->image->baseName}-"
//                        . date('YmdHi', time()) . ".{$this->image->extension}");
                    $this->image->saveAs(Yii::getAlias('@uploads')
                        . "/images/{$idCategory}/{$this->image->name}");
                    return true;
                } else {
                    return false;
                }
                break;
            case ('article'):
                if ($this->validate()) {
                    $this->image->name= rand(0,9999)."-". date('YmdHi', time()).'.'.$this->image->extension;
                    $this->image->saveAs(Yii::getAlias('@uploads')
                        . "/article/{$this->image->name}");
                    return true;
                } else {
                    return false;
                }
                break;
            case ('about'):
                if ($this->validate()) {
                    $this->image->name= rand(0,9999)."-". date('YmdHi', time()).'.'.$this->image->extension;
                    $this->image->saveAs(Yii::getAlias('@uploads')
                        . "/about/{$this->image->name}");
                    return true;
                } else {
                    return false;
                }
                break;
        }

    }

//    /**
//     * добавляем к имени дату и время
//     * для того чтобы можно было добавлять одинаковые картинки
//     * @return string
//     */
//    public function newName()
//    {
//        $str = $this->image->name;
//        $spos = strrpos($str, '.');
//        $this->image->name = rand(0,9999). date('YmdHi', time()) . substr($str, $spos);
//        return $this->image->name;
//    }

}