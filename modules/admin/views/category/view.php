<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->name;

?>
<div class="categories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Вернутся к списку категорий', ['/admin/category'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Добавить изображение', ['/admin/image/create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить категорию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'genre',
            'description:html',

            ['label' => 'Активность',
                'value' =>$model->getStatus()
                ],

        ],
    ]) ?>

</div>
