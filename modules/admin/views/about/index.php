<?php


use yii\helpers\Html;

$this->title = 'Обо мне';

?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>

<h1 class="text-center"><?php echo Html::encode($this->title) ?></h1>

<div class="about-index row">

        <?= $this->render('_form', [
            'modelAbout' => $modelAbout,
            'uploadImageAbout' =>$uploadImageAbout,
        ]); ?>



</div>