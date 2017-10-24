<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelCategory app\models\Category */

$this->title = 'Создание Категориии';

?>
<div class="categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-category', [
        'modelCategory' => $modelCategory,
        'status'=>'1',
    ]) ?>

</div>
