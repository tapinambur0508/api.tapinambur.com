<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
$tapinambur=new tapinambur();
$tapinamburAPI=new tapinamburAPI();
$article=$tapinambur->getArticle($_GET["id"]);
if ($article) {
    $title=$article["header"].' | tapinambur API';
    $style_less=array("article-style.less");
    $meta = '
    <meta property="og:url" content="'.$_SERVER["HTTP_HOST"].''.$_SERVER["REQUEST_URI"].'"/>
    <meta property="og:title" content="'.$title.'" />
    <meta property="og:description" content="'.$article["header"].'"/>
    <meta property="og:image" content="'.$article["cover_image"].'"/>
    <meta property="og:site_name" content="tapinambur API"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:url" content="'.$_SERVER["HTTP_HOST"].''.$_SERVER["REQUEST_URI"].'"/>
    <meta itemprop="image" content="'.$article["cover_image"].'"/>
    <meta itemprop="name" content="tapinambur API"/>
    <meta itemprop="description" content="'.$article["header"].'"/>
    <meta itemprop="image" content="'.$article["cover_image"].'"/>';
    include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
} else {
    exit(header("Location: /404"));
}
?>
<div id="myContainer">
<div class="img-wrapper">
<img src="<?=$article["cover_image"]; ?>" alt="<?=$article["header"]; ?>">
<p class="header"><?=$article["header"]; ?></a></p>
<p class="views"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?=$article["views"]; ?></p>
<p class="date"><?=date("d.m.Y", strtotime($article["date_time"])); ?></p>
</div>
<?=$article["full_content"]; ?>
<p><a target="_blank" href="<?=$article['source']; ?>">Джерело</a></p>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
