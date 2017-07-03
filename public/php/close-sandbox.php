<?php
    if (isset($_POST["article_id"])) {
        include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
        $tapinamburAPI = new tapinamburAPI();
        $tapinamburAPI->closeSandbox($_POST["article_id"]);
    }
