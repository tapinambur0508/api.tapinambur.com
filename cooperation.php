<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
$tapinamburAPI=new tapinamburAPI("vitalijm_api_tapinambur");
$title='Співробітництво | tapinambur API';
$style_less=array("system-style.less");
include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
?>
<div id="myContainer">
<h1>Співробітництво</h1>
<p>Якщо ви бажаєте стати нашим партнером, пишіть нам:&nbsp;<a href="mailto:admin@tapinambur.com">admin@tapinambur.com</a></p>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
