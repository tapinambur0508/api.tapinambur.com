<!DOCTYPE HTML>
<html lang="uk">
<head>
<meta charset="UTF-8">
<meta http-equiv="reply-to" content="admin@tapinambur.com" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?=$title; ?></title>
<?php if (isset($meta)): ?>
<?=$meta; ?>
<?php else: ?>
<meta property="og:url" content="http://www.api.tapinambur.com/" />
<meta property="og:title" content="<?=$title; ?>" />
<meta property="og:description" content="Супермаркет свіжих новин зі світу інформаційних технологій, автомобілів та багато іншого" />
<meta property="og:image" content="http://api.tapinambur.com/public/images/logo.jpg/" />
<meta property="og:site_name" content="tapinambur API" />
<meta property="fb:app_id" content="1886523204902308"/>
<meta property="fb:admins" content="100002982444589"/>
<meta name="twitter:card" content="summary"/>
<meta name="twitter:url" content="http://www.api.tapinambur.com/" />
<meta itemprop="image" content="http://api.tapinambur.com/public/images/logo.jpg/" />
<meta itemprop="name" content="tapinambur API" />
<meta itemprop="description" content="Супермаркет свіжих новин зі світу інформаційних технологій, автомобілів та багато іншого" />
<meta itemprop="image" content="http://api.tapinambur.com/public/images/logo.jpg/" />
<?php endif; ?>
<meta name="description" content="Супермаркет свіжих новин зі світу інформаційних технологій, автомобілів та багато іншого" />
<meta name="distribution" content="web" />
<meta name="robots" content="index" />
<meta name="author" content="Віталій Мудрий" />
<meta name="copyright" content="Всі права належать Віталію Мудрому" />
<meta name="application-name" content="tapinambur API" />
<meta name="revisit-after" content="1 days"/>
<link rel="shortcut icon" href="/public/images/favicon.ico" type="image/x-icon" />
<link href=/public/css/bootstrap.min.css rel="stylesheet" />
<link href=/public/css/font-awesome.min.css rel="stylesheet" />
<?php if (isset($style_less)): ?>
<?php foreach ($style_less as $item): ?>
<link href="/public/less/<?=$item; ?>" rel="stylesheet/less" />
<?php endforeach; ?>
<?php endif; ?>
<?php if (isset($style_css)): ?>
<?php foreach ($style_css as $item): ?>
<link href="/public/css/<?=$item; ?>" rel="stylesheet" />
<?php endforeach; ?>
<?php endif; ?>
<script src=/public/js/less.js></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<header class="navbar navbar-fixed-top">
<div class="container-fluid">
<a href="/cart/" class="cart"><i class="fa fa-shopping-basket" aria-hidden="true"></i><span class="circle">0</span></a>
<div class="navbar-header">
<button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="/">tapinambur API</a>
</div>
<div id="navbar" class="collapse navbar-collapse">
<ul class="nav navbar-nav navbar-left">
<li><a href="/news/"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp;Новини</a></li>
<li class="hidden-sm"><a href="/apple/"><i class="fa fa-apple" aria-hidden="true"></i>&nbsp;Apple</a></li>
<li class="hidden-sm"><a href="/google/"><i class="fa fa-google" aria-hidden="true"></i>&nbsp;Google</a></li>
<li class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Публікації&nbsp;<span class="caret"></span></a>
<ul class="dropdown-menu">
<?php foreach ($tapinamburAPI->getPublications() as $item): ?>
<li><a href="/<?=$item["href"] ?>/"><?=$item["name"] ?></a></li>
<?php endforeach; ?>
</ul>
</li>
</ul>
<ul class="nav navbar-nav navbar-right">
<li>
<a href="/donation/"><i class="fa fa-heart" aria-hidden="true"></i>&nbsp;Donate</a>
</li>
<?php if (isset($_COOKIE["name"]) && (isset($_COOKIE["social_id"]))): ?>
<li class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$_COOKIE["name"]; ?></a>
<ul class=dropdown-menu>
<li><a href="/cabinet/"><i class="fa fa-briefcase" aria-hidden="true"></i>&nbsp;Мій кабінет</a></li>
<li><a role="button" name="btn-exit"><i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;Вийти</a></li>
</ul>
</li>
<?php else: ?>
<li><a href="/cabinet/"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;Увійти</a></li>
<?php endif; ?>
</ul>
</div>
</div>
</header>
<a class="fa fa-chevron-up" aria-hidden="true" id="up" title="Вгору"></a>
