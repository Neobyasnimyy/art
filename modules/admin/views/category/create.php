<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'Создание Категориии';
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['/admin/category']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'status'=>'1',
    ]) ?>

</div>
