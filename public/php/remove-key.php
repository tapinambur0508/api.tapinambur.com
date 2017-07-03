<?php
    if (isset($_POST["id"])) {
        include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
        $tapinamburAPI = new tapinamburAPI();
        $tapinamburAPI->removeSavedKey($_POST["id"]);
    }
