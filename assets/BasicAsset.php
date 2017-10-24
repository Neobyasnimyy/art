<?php

namespace app\assets;

use yii\web\AssetBundle;


class BasicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/basic.css',
    ];
    public $js = [
//        'js/bootstrap-filestyle.min.js'
    ];
    public $depends = [ // массив, перечисляющий имена комплектов ресурсов, от которых зависит данный комплект.
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
//        'yii\bootstrap\BootstrapPluginAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
