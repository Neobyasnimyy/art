<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $modelArticle->title;

?>
<div class="article-update">

    <?= Html::a('Вернутся к списку статей', ['/admin/article'], ['class' => 'btn btn-primary text-left']) ?>
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelArticle' => $modelArticle,
        'uploadImageArticle' =>$uploadImageArticle,
    ]) ?>

</div>
