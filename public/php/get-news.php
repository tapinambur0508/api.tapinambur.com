<?php
    if (isset($_POST["pos"]) && isset($_POST["count"])) {
        include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
        $tapinamburAPI = new tapinamburAPI();

        if ($_POST["href"]) {
            echo(json_encode($tapinamburAPI->getPublication($_POST['href'], $_POST["pos"], $_POST["count"])));
        } else {
            echo(json_encode($tapinamburAPI->getNews($_POST["pos"], $_POST["count"])));
        }
    }
