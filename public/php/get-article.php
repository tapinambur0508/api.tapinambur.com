<?php
  if (isset($_POST["id"])) {
      include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
      $tapinamburAPI = new tapinamburAPI();
      echo(json_encode($tapinamburAPI->getArticle($_POST["id"])));
  }
