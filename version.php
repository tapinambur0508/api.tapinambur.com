<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
$tapinamburAPI = new tapinamburAPI();
$title='Історія версій | tapinambur API';
$style_less=array("system-style.less");
include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
?>
<div id="myContainer">
<h1>Історія версій</h1>
<h2>Версія 1.0 від 13 січня 2017</h2>
<p>Початкова версія API</p>
<hr noshade size="2">
<h3>Якщо маєте якісь побажання щодо проекту, поділіться ними у коментарях</h3>
<div id="disqus_thread"></div>
<script>(function(){var b=document,a=b.createElement("script");a.src="//http-www-tapinambur-com.disqus.com/embed.js";a.setAttribute("data-timestamp",+new Date());(b.head||b.body).appendChild(a)})();</script>
</div>
<script id="dsq-count-scr" src="//http-www-tapinambur-com.disqus.com/count.js" async></script>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
