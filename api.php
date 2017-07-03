<?php
    if (isset($_REQUEST["news-key"])) {
        include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
        $tapinamburAPI = new tapinamburAPI();
        $news_key = $_REQUEST["news-key"];

        if (preg_match("/^[a-f0-9]{32}$/i", $news_key)) {
            if ($article_arr = $tapinamburAPI->getArticlesByKey($news_key)) {
                $result = array(
                    "code" => 200,
                    "response" => $article_arr
                );

                echo(json_encode($result));
            } else {
                $result = array(
                    "code" =>  403
                );

                echo(json_encode($result));
            }
        } else {
            $result = array(
                "code" =>  402
            );

            echo(json_encode($result));
        }
    }

    if (isset($_REQUEST["count"])) {
        include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
        $tapinamburAPI = new tapinamburAPI();
        $count = $_REQUEST["count"];

        if (preg_match("/^[0-9-]+/", $count)) {
            echo(json_encode($tapinamburAPI->getArticlesByCount($count)));
        } else {
            $result = array(
                "code" =>  401
            );

            echo(json_encode($result));
        }
    }
