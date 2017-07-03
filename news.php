<?php
include($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
$tapinamburAPI=new tapinamburAPI();
$href="";
if (isset($_GET["href"])) {
    $href=strtolower($_GET["href"]);
    $heading=$tapinamburAPI->getPublicationName($href);
    if ($heading) {
        $title=$heading.' | tapinambur API';
        $news_count=$tapinamburAPI->getCountPublication($href);
    } else {
        exit(header("Location: /404"));
    }
} else {
    $title='Новини | tapinambur API';
    $heading="Новини";
    $news_count=$tapinamburAPI->getCountNews();
}
$style_less=array("news-style.less");
$style_css=array("masonry-big.css");
include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
?>
<div id="myContainer">
<h1><?=$heading; ?></h1>
<div class="row masonry" data-columns>
<div class="news-item-template" style="display:none">
<div>
<div class="image">
<a href=""><img src=""></a>
<p class="date"></p>
<p class="views"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;</p>
</div>
<h2><a href=""></a></h2>
<p></p>
<button class="btn btn-success" name="add-to-cart" style="width: 100%;">Додати у кошик</button>
<button class="btn btn-danger" name="remove-from-cart" style="width: 100%;">Видалити з кошика</button>
</div>
</div>
</div>
</div>
<button name="load-news" class="btn btn-default">Завантажити ще</button>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
<script>
    let pos=0;
    let count=48;
    let href="<?php echo($href); ?>";
    let newsCount=<?php echo($news_count); ?>;
    getNews(pos, count, href);
    pos+=count;
    loadNewsButtonHide($("button[name='load-news']"), pos, newsCount);

    $(document).ready(function() {
        $("button[name='load-news']").click(function() {
            $(this).blur();

            if (loadNewsButtonHide($(this), pos, newsCount) == false) {
                getNews(pos, count, href);
                pos += count;
                loadNewsButtonHide($(this), pos, newsCount);
            }
        });
    });

    function loadNewsButtonHide(button, pos, newsCount) {
        if (pos >= newsCount) {
            $(button).hide();

            return true;
        } else {
            return false;
        }
    }
</script>
