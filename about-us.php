<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
$tapinamburAPI=new tapinamburAPI();
$title='Про нас | tapinambur API';
$style_less=array("system-style.less");
include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
?>
<div id="myContainer">
<h1>Про нас</h1>
<p>Привіт. Мене звати Віталій Мудрий. Я захоплююсь Web програмуванням. Одного разу я захотів створити невеличкий проект, на якому зможу шліфувати набуті навички та отримувати нові знання. На думку спало зробити сайт новин. Комусь може здатися, що зробити сайт такої тематики легко, але повірте - це не так. Сайт я почав створювати у липні 2016. Коли я дізнаюсь щось нове, я намагаюсь втілити отримані знання у покращення та розбудову сайту. Взагалі, початок роботи сайту був запланований на 7 вересня під час презентації iPhone 7, але через брак часу відкриття довелося перенести. Потім якраз почався університет і про сайт я взагалі забув. Але під час навчання я дізнався багато чого і після здачі сесії на початку 2017 року я можу запустити свій сайт. У впровадженні мого проекту мені допомагав технічний директор сайту Андрій Гоменюк. Ось його <a target="_blank" href="https://github.com/renair">GitHub</a>. Ми будемо намагатися наповнювати контент гарними, корисними та цікавими новинами. Це наш перший глобальний проект, нам цікаво його розкрути, щоб набратися досвіду для втілення наступних ідей, а вони є.</p>
<hr noshade size="2">
<h3>Якщо маєте якісь побажання щодо проекту, поділіться ними у коментарях</h3>
<div id="disqus_thread"></div>
<script>(function(){var b=document,a=b.createElement("script");a.src="//http-www-tapinambur-com.disqus.com/embed.js";a.setAttribute("data-timestamp",+new Date());(b.head||b.body).appendChild(a)})();</script>
</div>
<script id="dsq-count-scr" src="//http-www-tapinambur-com.disqus.com/count.js" async></script>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
