<?php


namespace app\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;

class UploadMusic extends Model
{

    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Композиция',
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'],
                'file',
                'extensions' => 'mp3, ogg, mp4, m4a, m4b',
                'skipOnEmpty' => false, // обязательная загрузка файла
                'maxSize' => 1024 * 1024 * 20,
                'tooBig' => "Файл «{file}» слишком большой. Размер не должен превышать 15 MB.",
                'mimeTypes' => ['audio/ogg','audio/mpeg','audio/aac','audio/mp4','audio/mp3'],
            ],

        ];
    }

    /**
     * этот метот сохраняет музыку в папке с music и занимается валидацией
     * @param string
     * @return bool
     */
    public function upload($name)
    {
        if ($this->validate()) {
            $this->file->saveAs(Yii::getAlias('@uploads')."/music/{$name}.{$this->file->extension}");
        } else {
            return false;
        }
    }
}