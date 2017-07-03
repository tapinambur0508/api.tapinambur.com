<?php
  if (isset($_POST["key"])) {
      include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
      $tapinamburAPI = new tapinamburAPI();
      $key = $tapinamburAPI->getKey($_POST["key"]);
      $check = 0;
      $user_id = 0;

      if (isset($_COOKIE["name"]) && isset($_COOKIE["social_id"])) {
          $user_id = $tapinamburAPI->getUser($_COOKIE["name"], $_COOKIE["social_id"])["id"];
          $check = $tapinamburAPI->checkKey($key["key"], $user_id);
      }

      echo(
      json_encode(
        array(
          "key" => $key["key"],
          "key_id" => $key["id"],
          "check" => $check,
          "user_id" => $user_id,
        )
      )
    );
  }
