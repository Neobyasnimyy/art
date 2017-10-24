<?php
//debug($modelArticle)
use yii\widgets\LinkPager;
$this->title="Статьи";

?>



<?php foreach ($modelArticle as $article):?>

    <p>Заголовок <?php echo $article['title'];?></p>
    <p>число<?php echo date("d",strtotime($article['data'])); ?></p>
    <p>месяц <?php echo getMouth(date("m",strtotime($article['data']))); ?></p>
    <img src="<?php echo $article['image']; ?>" alt="Изображение отсутствует" style="max-width:450px;"><br>
    <div>
        Описание
        <div><?php
            // выведем все предложенные которые поместились до 300 символов
            if (mb_strlen($article['description']) > 300) {
                echo mb_substr($article['description'], 0,
                        mb_strripos(mb_substr($article['description'], 0,300),'. ')
                    ). ' ...';
            }else{
                echo $article['description'];
            }?>
        </div>
    </div>
    <a href="/article/view?id=<?php echo $article['id']?>">Читать дальше </a>


<?php endforeach;?>

<?php echo LinkPager::widget([
    'pagination' => $pages,
    'registerLinkTags' => true
]);?>