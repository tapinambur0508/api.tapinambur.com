<?php
    if (isset($_POST["header"]) && isset($_POST["content"]) && isset($_POST["full_content"]) && isset($_POST["article_id"])) {
        include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
        $tapinamburAPI = new tapinamburAPI();
        $_POST["header"] = str_replace("'", "’", $_POST["header"]);
        $_POST["content"] = str_replace("'", "’", $_POST["content"]);
        $_POST["full_content"] = str_replace("'", "’", $_POST["full_content"]);
        echo($tapinamburAPI->setTranslateArticle($_POST["header"], $_POST["content"], $_POST["full_content"], $_POST["article_id"]));
    }
