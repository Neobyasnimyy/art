<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = "Просмотр сообщений"

?>
<div class="message-view">

    <h1>Сообщение от <?= Html::encode($model->name) ?></h1>

    <p>
        <?php echo Html::a('Вернутся к списку сообщений', ['/admin/message'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Точно, удалить сообщение?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'email:email',
            'subject',
            'body:ntext',
        ],
    ]) ?>

</div>
