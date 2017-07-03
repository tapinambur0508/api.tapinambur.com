<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
$tapinamburAPI=new tapinamburAPI();
$title='Реклама | tapinambur API';
$style_less=array("system-style.less");
include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
?>
<div id="myContainer">
<h1>Реклама</h1>
<p>Якщо ви бажаєте розмістити свою рекламу, пишіть нам:&nbsp;<a href="mailto:admin@tapinambur.com">admin@tapinambur.com</a></p>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
