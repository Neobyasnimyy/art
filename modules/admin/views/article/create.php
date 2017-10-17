<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Создание статей';

?>
<div class="article-create">

<!--    <h1>--><?php //echo Html::encode($this->title) ?><!--</h1>-->

    <?= $this->render('_form', [
        'modelArticle' => $modelArticle,
        'uploadImage' => $uploadImage,

    ]) ?>

</div>
