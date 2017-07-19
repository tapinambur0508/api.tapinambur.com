<?php
if (isset($_COOKIE["name"]) && isset($_COOKIE["social_id"])) {
    include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
    $tapinamburAPI=new tapinamburAPI();
    $user=$tapinamburAPI->getUser($_COOKIE["name"], $_COOKIE["social_id"]);
    if ($user) {
        $title='Кабінет | tapinambur API';
        $style_less=array("system-style.less");
        $style_css=array("masonry-small.css");
        include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
        $articles=$tapinamburAPI->getArticlesToTranslate();
    } else {
        exit(header("Location: /login/"));
    }
} else {
    exit(header("Location: /login/"));
}
?>
<div id="myContainer">
<h1>Кабінет</h1>
<h2>Збережені ключі</h2>
<?php if ($keys=$tapinamburAPI->getSavedKeys($user["id"])): ?>
<?php foreach ($keys as $key): ?>
<div id="key-<?=$key["id"]; ?>">
<div class="row row-flex">
<div class="col-xs-6">
<h3><?=$key["key_name"]; ?></h3>
</div>
<div class="col-xs-6">
<p align="right"><i class="fa fa-calendar" aria-hidden="true">&nbsp;<?=$key["date"]; ?></i></p>
</div>
</div>
<figure class="highlight">
<p class="text-center"><?=$key["key"]; ?></p>
</figure>
<button class="btn btn-danger btn-block" data-id="<?=$key["id"]; ?>" name="delete-key">Видалити ключ</button>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>Ви не маєте збережених ключів</p>
<?php endif; ?>
<?php if ($articles): ?>
<hr/>
<h3>Допоможіть нам перекласти одну з наступних статей</h3>
<div class="row masonry" data-columns>
<?php foreach ($articles as $item): ?>
<div>
<div class="image">
<a href="/preview-article/<?=translit($item["header"]); ?>/<?=$item["id"]; ?>/" target="_blank"><img src="<?=$item["cover_image"]; ?>"></a>
</div>
<h2 align="center"><a href="/preview-article/<?=translit($item["header"]); ?>/<?=$item["id"]; ?>/" target="_blank"><?=$item["header"]; ?></a></h2>
<p><?=$item["content"]; ?></p>
<a href="/sandbox/<?=translit($item["header"]); ?>/<?=$item["id"]; ?>/" class="btn btn-primary btn-block">Перекласти</a>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
<script>
    $(document).ready(function() {
        $("button[name='delete-key']").click(function() {
            let id = $(this).attr("data-id");

            $.ajax({
                url: '/public/php/remove-key.php',
                type: 'POST',
                data: {id},
                success: function() {
                    $(`#key-${id}`).remove();

                    if ($('[id^="key-"]').length == 0) {
                        $("#myContainer h2:first").after("<p>Ви не маєте збережених ключів</p>");
                    }
                }
            });
        });
    });
</script>
