<?php
    if (isset($_POST["key"]) && isset($_POST["key_name"]) && isset($_POST["key_id"]) && isset($_POST["user_id"])) {
        include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
        $tapinamburAPI = new tapinamburAPI();
        echo($tapinamburAPI->setSavedKey($_POST["key"], $_POST["key_name"], $_POST["key_id"], $_POST["user_id"]));
    }
