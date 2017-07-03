<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
$tapinamburAPI=new tapinamburAPI();
$article=$tapinamburAPI->getArticle($_GET["id"]);
if ($article) {
    $title=$article["header"].' | tapinambur API';
    $style_less=array("article-style.less");
    $style_css=array("masonry-small.css");
    $meta = '
<meta property="og:url" content="'.$_SERVER["HTTP_HOST"].''.$_SERVER["REQUEST_URI"].'"/>
<meta property="og:title" content="'.$title.'" />
<meta property="og:description" content="'.$article["header"].'"/>
<meta property="og:image" content="'.$article["cover_image"].'"/>
<meta property="og:site_name" content="tapinambur API"/>
<meta property="fb:app_id" content="1886523204902308"/>
<meta property="fb:admins" content="100002982444589"/>
<meta name="twitter:card" content="summary"/>
<meta name="twitter:url" content="'.$_SERVER["HTTP_HOST"].''.$_SERVER["REQUEST_URI"].'"/>
<meta itemprop="image" content="'.$article["cover_image"].'"/>
<meta itemprop="name" content="tapinambur API"/>
<meta itemprop="description" content="'.$article["header"].'"/>
<meta itemprop="image" content="'.$article["cover_image"].'"/>';
    include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
    $ip = $_SERVER["REMOTE_ADDR"];
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $article["views"] = $tapinamburAPI->setVisits($_GET["id"], $article["views"], $ip, $browser);
} else {
    exit(header("Location: /404/"));
}
?>
<div id="myContainer">
<div class="img-wrapper">
<img src="<?=$article["cover_image"]; ?>" alt="<?=$article["header"]; ?>" style="width: 100%">
<p class="header"><?=$article["header"]; ?></p>
<p class="views"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<?=$article["views"]; ?></p>
<p class="date"><?=date("d.m.Y", strtotime($article["date_time"])); ?></p>
</div>
<?=$article["full_content"]; ?>
<p><a target="_blank" href="<?=$article['source']; ?>">Джерело</a></p>
<button class="btn btn-block" name="set-to-cart" data-id="<?=$article['id']; ?>"></button>
<!-- AddToAny BEGIN -->
<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
<a class="a2a_button_facebook"></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_linkedin"></a>
<a class="a2a_button_email"></a>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END -->
<div class="row">
<div class="col-md-6 col-xs-12">
<?php if ($header=$tapinamburAPI->getPrevNews($article["id"])): ?>
<a class="direction" href="/article/<?=translit($header[1]); ?>/<?=$header[0]; ?>/">
<i class="fa fa-angle-double-left" aria-hidden="true"></i>&nbsp;<?=$header[1]; ?>
</a>
<?php endif; ?>
</div>
<div class="col-md-6 col-xs-12">
<?php if ($header=$tapinamburAPI->getNextNews($article["id"])): ?>
<a class="direction" href="/article/<?=translit($header[1]); ?>/<?=$header[0]; ?>/">
<?=$header[1]; ?>&nbsp;<i class="fa fa-angle-double-right" aria-hidden="true"></i>
</a>
<?php endif; ?>
</div>
</div>
<h1>Читайте також:</h1>
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
<div id="disqus_thread"></div>
<script>(function(){var d=document,s=d.createElement('script');s.src='//http-www-tapinambur-com.disqus.com/embed.js';s.setAttribute('data-timestamp',+new Date());(d.head||d.body).appendChild(s);})();</script>
</div>
<script id="dsq-count-scr" src="//http-www-tapinambur-com.disqus.com/count.js" async></script>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
<script>
    $(document).ready(function() {
      	if (isInLocalStorage(<?php echo($_GET["id"]); ?>)) {
    	    $("button[name='set-to-cart']").addClass("btn-danger");
    	    $("button[name='set-to-cart']").text("Видалити з кошика")
      	} else {
          	$("button[name='set-to-cart']").addClass("btn-success");
    	    $("button[name='set-to-cart']").text("Додати у кошик");
      	}

        getReadMoreNews(<?php echo($_GET["id"]); ?>, 6);

        $("button[name='set-to-cart']").click(function() {
        	let button = $(this);
        	let id = $(button).attr("data-id");

        	$.ajax({
        		url: '/public/php/get-article.php',
        		type: 'POST',
        		data: {id},
        		success: function(data) {
        			try {
        				setToLocalStorage(JSON.parse(data));

        				if ($(button).hasClass("btn-danger")) {
        					$(button).removeClass("btn-danger");
        					$(button).addClass("btn-success");
    	    				$(button).text("Додати у кошик")
        				} else {
        					$(button).removeClass("btn-success");
        					$(button).addClass("btn-danger");
    	    				$(button).text("Видалити з кошика")
        				}
        			} catch(error) {
        				console.log(error);
        			}
        		}
        	});
        });
    });
</script>
