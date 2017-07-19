<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
$tapinamburAPI=new tapinamburAPI();
$title='Пожертвування | tapinambur API';
$style_less=array("system-style.less");
include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
?>
<div id="myContainer">
<h1>Пожертвування</h1>
<p>Якщо Ви хочете підтримати tapinambur API та зробити пожертвування, будь ласка, натисніть на кнопку “Donate” нижче. Вітається будь-яка сума пожертвування. Усі кошти підуть на підтримку та покращення роботи сервісу, що допоможе наповнювати Ваші сайт ще якіснішим та цікавішим контентом.</p>
<a href="https://sendmoney.privatbank.ua/ua/?hash=3972334510" target="_blank" class="btn-donate">Donate&nbsp;<i class="fa fa-heart" aria-hidden="true"></i></a>
<p>Ми завжди намагаємось бути кращим для Вас. Завжди! Дякуємо за Вашу підтримку.</p>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
