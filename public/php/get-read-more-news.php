<?php
    if (isset($_POST["id"]) && isset($_POST["count"])) {
        include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
        $tapinamburAPI = new tapinamburAPI();
        echo(json_encode($tapinamburAPI->getRandNews($_POST["id"], $_POST["count"])));
    }
