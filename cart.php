<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
$tapinamburAPI=new tapinamburAPI();
$articles=$tapinamburAPI->getArticlesToTranslate();
$title='Кошик | tapinambur API';
$style_less=array("system-style.less");
$style_css=array("masonry-small.css");
include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
?>
<div id="myContainer">
<h1>Кошик</h1>
<div class="row row-flex">
<div class="cart-panel">
<div class="col-sm-6 col-xs-12">
<button class="btn btn-primary btn-block" name="get-key" data-toggle="modal" data-target="#myKey">Отримати ключ</button>
</div>
<div class="col-sm-6 col-xs-12">
<button class="btn btn-warning btn-block" name="clear-cart">Очистити кошик</button>
</div>
</div>
</div>
<div class="modal fade" id="myKey" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<button class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
<h3 class="modal-title" id="myModalLabel">Ключ</h3>
</div>
<div class="modal-body">
<div class="highlight">
<p class="text-center"></p>
</div>
<?php if (isset($_COOKIE["name"]) && isset($_COOKIE["social_id"])): ?>
<button class="btn btn-success btn-block" name="save-key">Зберегти ключ</button>
<?php else: ?>
<p>Авторизуйтесь, щоб мати можливість зберегти ключ</p>
<div class="social-icons">
<button class="btn btn-facebook">Увійти за допомогою Facebook</button>
</div>
<?php endif; ?>
<h3>Допоможіть нам перекласти одну з наступних статей</h3>
<div class="row masonry" data-columns>
<?php foreach ($articles as $item): ?>
<div>
<div class="image">
<a href="/preview-article/<?=translit($item["header"]); ?>/<?=$item["id"]; ?>" target="_blank"><img src="<?=$item["cover_image"]; ?>"></a>
</div>
<h2 align="center"><a href="/preview-article/<?=translit($item["header"]); ?>/<?=$item["id"]; ?>" target="_blank"><?=$item["header"]; ?></a></h2>
<p><?=$item["content"]; ?></p>
<a href="/sandbox/<?=translit($item["header"]); ?>/<?=$item["id"]; ?>" class="btn btn-primary btn-block">Перекласти</a>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
</div>
<div class="row masonry" data-columns>
<div class="news-item-template" style="display:none">
<div>
<div class="image">
<a href="" target="_blank"><img src=""></a>
<p class="date"></p>
<p class="views"><i class="fa fa-eye" aria-hidden="true"></i></p>
</div>
<h2><a href="" target="_blank"></a></h2>
<p></p>
<button class="btn btn-danger btn-block" name="remove-from-cart">Видалити з кошика</button>
</div>
</div>
</div>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
<script>
  if (getCountArticleInCart()) {
    getArticleFromLocalStorage();
  } else {
      $(".cart-panel").hide();
      $("#myContainer").append("<p>Ваш кошик поки що порожній</p>");
  }

  $(document).ready(function () {
    $("button[name='get-key']").click(function() {
      let key = generateKey();
      $paragraph = $("#myKey .modal-body .highlight p");

      $.ajax({
        url: '/public/php/generate-key.php',
        type: "POST",
        data: {key},
        beforeSend: function() {
          $paragraph.html("<i class='fa fa-cog fa-spin fa-2x fa-fw'></i>");
        },
        success: function(data) {
          try {
            data = JSON.parse(data);
            $paragraph.text(data.key);

            if (data.check == 1) {
              $("button[name='save-key']").hide();
            }
          } catch (error) {
              console.log(error);
          }
        }
      });
    });

    $("button[name='clear-cart']").click(function() {
      clearLocalStorage();
      location.href = "/news/";
    });

    $("button[name='save-key']").click(function() {
      let key = generateKey();

      $.ajax({
        url: '/public/php/generate-key.php',
        type: "POST",
        data: {key},
        success: function(data) {
          try {
            data = JSON.parse(data);
            let key = data.key;
            let keyId = data["key_id"];
            let userId = data["user_id"];
            let keyName = prompt("Введіть назву ключа");

            if (key && keyName) {
              $.ajax({
                url: '/public/php/set-key.php',
                type: "POST",
                data: {key_name : keyName, key, key_id : keyId, user_id : userId},
                success: function(data) {
                  if (data == 1) {
                    $("button[name='save-key']").hide();
                    alert("Ваш ключ успішно збережен");
                  } else {
                      alert("Помилка при збережені ключа. Спробуйте ще раз");
                  }
                }
              });
            }
          } catch (error) {
              console.log(error);
          }
        }
      });
    });
  });
</script>
