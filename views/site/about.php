<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Обо мне'; // имя страницы

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>


    <?= Html::img($about->image, ['alt' => 'My foto']) ?>

    <?= Html::tag('div',($about->text), ['class' => 'about-text']) ?>

    <code><?= __FILE__ ?></code>
</div>
