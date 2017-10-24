<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Image */

$this->title = 'Добавление изображения';
?>
<div class="images-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelImage' => $modelImage,
        'categoryList' => $categoryList,
        'uploadImage'=>$uploadImage,
    ]) ?>



</div>
