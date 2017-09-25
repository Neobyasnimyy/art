<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Обо мне'; // имя страницы
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

<!--    --><?php //debug($about); ?>

    <?= Html::tag('h2',($about['title']), ['class' => 'about-title']) ?>

    <?= Html::img('/web/uploads/about/'.$about['image'], ['alt' => 'My foto']) ?>

    <?= Html::tag('div',($about['text']), ['class' => 'about-text']) ?>

    <code><?= __FILE__ ?></code>
</div>
