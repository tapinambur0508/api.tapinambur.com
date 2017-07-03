<?php
if (isset($_COOKIE["name"]) && isset($_COOKIE["social_id"])) {
    exit(header("Location: /cabinet/"));
} else {
    include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
    $tapinamburAPI=new tapinamburAPI();
    $title='Авторизація | tapinambur API';
    $style_less=array("system-style.less");
    include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
}
?>
<div id="myContainer">
<h1>Авторизація</h1>
<div class="social-icons">
<button class="btn btn-facebook">Увійти за допомогою Facebook</button>
</div>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
