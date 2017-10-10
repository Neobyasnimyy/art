<?php
/* @var $this yii\web\View */
?>
<h1>music/index</h1>


<?php foreach ($modelMusic as $item): ?>

    <?php echo $item['id'];?>.- <?php echo $item['name'];?>
    <audio controls>
        <source src='/web/uploads/music/<?php echo $item['file_name'];?>' type='<?php echo $item['type'];?>'>
        Ваш браузер не поддерживает аудио элемент.
    </audio><br>
<?php endforeach;?>