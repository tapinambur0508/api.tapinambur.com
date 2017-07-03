<?php
  class tapinamburAPI
  {
      public $mysqli = false;

      public function __construct()
      {
          $this->connectDB("vitalijm_api_tapinambur");
      }

      public function __destruct()
      {
          $this->disconnectDB();
      }

      public function connectDB($db_name)
      {
          $this->mysqli = new mysqli('localhost', 'vitalijm_98', 'vitalikm0508', $db_name);
          $this->mysqli->query("SET NAMES 'utf8'");
      }

      public function disconnectDB()
      {
          mysqli_close($this->mysqli);
      }

      public function getUser($full_name, $social_id)
      {
          $result = $this->mysqli->query("SELECT * FROM `users` WHERE `full_name` = '$full_name' AND `social_id` = $social_id");

          if (mysqli_num_rows($result) == 0) {
              if ($this->setUser($full_name, $social_id)) {
                  $this->getUser($full_name, $social_id);
              }
          }

          return $result->fetch_assoc();
      }

      private function setUser($full_name, $social_id)
      {
          $this->mysqli->query("INSERT INTO `users` SET `full_name` = '$full_name', `social_id` = $social_id");

          return mysqli_insert_id($this->mysqli);
      }

      public function getNews($pos, $count)
      {
          $result = $this->mysqli->query("SELECT `id`, `header`, `content`, `cover_image`, DATE_FORMAT(`date_time`, '%d.%m.%Y') AS `date`, `views`
                                      FROM `news`
                                      ORDER BY `id` DESC
                                      LIMIT $pos, $count");

          return $this->resultToArray($result);
      }

      public function getCountNews()
      {
          return mysqli_fetch_row($this->mysqli->query("SELECT count(`id`) FROM `news`"))[0];
      }

      public function getPublication($href, $poss, $count)
      {
          $result = $this->mysqli->query("SELECT `id`, `header`, `content`, `cover_image`, DATE_FORMAT(`date_time`, '%d.%m.%Y') AS `date`, `views`
                                      FROM `news`
                                      WHERE `key_word` LIKE '$href'
                                      ORDER BY `id` DESC
                                      LIMIT $poss, $count");

          return $this->resultToArray($result);
      }

      public function getCountPublication($href)
      {
          return mysqli_fetch_row($this->mysqli->query("SELECT count(`id`) FROM `news` WHERE `key_word` LIKE '$href'"))[0];
      }

      public function getPublicationName($href)
      {
          return mysqli_fetch_row($this->mysqli->query("SELECT `name` FROM `publications` WHERE `href` = '$href'"))[0];
      }

      public function getArticle($id)
      {
          return $this->mysqli->query("SELECT * FROM `news` WHERE `id` = $id")->fetch_assoc();
      }

      public function getArticlesByKey($key)
      {
          $result = mysqli_fetch_row($this->mysqli->query("SELECT `article_id` FROM `keys` WHERE `key` = '$key'"))[0];

          if ($result) {
              $arr = explode("&", $result);
              $response = [];

              for ($i = 0, $count = count($arr); $i < $count; ++$i) {
                  $row = $this->mysqli->query("SELECT `header`, `content`, `full_content`, `image`, `cover_image`, `source`, `key_word`
                                       FROM `news`
                                       WHERE `id` = $arr[$i]");

                  if ($article = $row->fetch_assoc()) {
                      $response[] = $article;
                  }
              }

              return $response;
          }

          return 0;
      }

      public function getArticlesByCount($count)
      {
          $result = $this->mysqli->query("SELECT `header`, `content`, `full_content`, `image`, `cover_image`, `source`, `key_word`
                                      FROM `news`
                                      ORDER BY `id` DESC
                                      LIMIT $count");

          return $this->resultToArray($result);
      }

      public function setVisits($article_id, $value, $ip, $browser)
      {
          $result = $this->mysqli->query("SELECT * FROM `visits` WHERE `article_id` = $article_id AND `ip` = '$ip' AND `date` = CURDATE()");

          if (mysqli_num_rows($result) == 0) {
              ++$value;
              $this->mysqli->query("INSERT INTO `visits` SET `article_id` = $article_id, `ip` = '$ip', `date` = CURDATE(), `browser` = '$browser'");
              $this->mysqli->query("UPDATE `news` SET `views` = '$value' WHERE `id` = $article_id");
          }

          return $value;
      }

      public function getPublications()
      {
          $result = $this->mysqli->query("SELECT * FROM `publications`");

          return $this->resultToArray($result);
      }

      public function getPrevNews($id)
      {
          return mysqli_fetch_row($this->mysqli->query("SELECT `id`, `header` FROM `news` WHERE `id` < $id ORDER BY `id` DESC"));
      }

      public function getNextNews($id)
      {
          return mysqli_fetch_row($this->mysqli->query("SELECT `id`, `header` FROM `news` WHERE `id` > $id ORDER BY `id` ASC"));
      }

      public function getRandNews($id, $count)
      {
          $result = $this->mysqli->query("SELECT `id`, `header`, `content`, `cover_image`, `views`, DATE_FORMAT(`date_time`, '%d.%m.%Y') AS `date`
                                      FROM `news`
                                      WHERE `id` != $id AND DATE_ADD(DATE(`date_time`), Interval 10 DAY) >= CURDATE()
                                      ORDER BY RAND()
                                      LIMIT $count");

          return $this->resultToArray($result);
      }

      public function getKey($key)
      {
          $md5Key = md5($key);
          $result = $this->mysqli->query("SELECT `id`, `key` FROM `keys` WHERE `key` = '$md5Key'");

          if (mysqli_num_rows($result) == 0) {
              $this->mysqli->query("INSERT INTO `keys` SET `key` = '$md5Key', `article_id` = '$key'");

              if (mysqli_insert_id($this->mysqli)) {
                  $result = $this->mysqli->query("SELECT `id`, `key` FROM `keys` WHERE `key` = '$md5Key'");
              }
          }

          return $result->fetch_assoc();
      }

      public function getSavedKeys($user_id)
      {
          $result = $this->mysqli->query("SELECT `keys`.`key`, `saved_keys`.`id`, DATE_FORMAT(`saved_keys`.`date_time`, '%d.%m.%Y') AS `date`, `saved_keys`.`key_name`
                                      FROM `saved_keys`
                                      INNER JOIN `keys` ON `saved_keys`.`user_id` = $user_id AND
                                          `saved_keys`.`key_id` = `keys`.`id`");

          if (mysqli_num_rows($result) > 0) {
              return $this->resultToArray($result);
          }

          return 0;
      }

      public function setSavedKey($key, $key_name, $key_id, $user_id)
      {
          $this->mysqli->query("INSERT INTO `saved_keys` SET `key_name` = '$key_name', `key_id` = $key_id, `user_id` = $user_id");

          if (mysqli_insert_id($this->mysqli) > 0) {
              return 1;
          }

          return 0;
      }

      public function removeSavedKey($id)
      {
          $this->mysqli->query("DELETE FROM `saved_keys` WHERE `id` = $id");
      }

      public function checkKey($key, $user_id)
      {
          $result = $this->mysqli->query("SELECT `saved_keys`.`id`
                                      FROM `saved_keys`
                                      INNER JOIN `keys` ON `saved_keys`.`user_id` = $user_id AND
                                          `saved_keys`.`key_id` = `keys`.`id` AND
                                              `keys`.`key` = '$key'");

          if (mysqli_num_rows($result) > 0) {
              return 1;
          }

          return 0;
      }

      public function getArticlesToTranslate()
      {
          $result = $this->mysqli->query("SELECT `table_2`.`id`, `table_2`.`header`, `table_2`.`content`, `table_2`.`cover_image`
                                      FROM `vitalijm_api_tapinambur`.`need_to_translate_articles` AS `table_1`
                                      INNER JOIN`vitalijm_tapinambur`.`news` AS `table_2` ON `table_2`.`id` = `table_1`.`article_id` AND
                                        `table_2`.`id` = `table_1`.`article_id` AND
                                          `table_1`.`translate` = 0");

          return $this->resultToArray($result);
      }

      public function setTranslateArticle($header, $content, $full_content, $article_id)
      {
          $header = str_replace("'", "’", $header);
          $content = str_replace("'", "’", $content);
          $full_content = str_replace("'", "’", $full_content);

          $this->mysqli->query("DELETE FROM `translate_articles` WHERE `article_id` = $article_id");
          $this->mysqli->query("INSERT INTO `translate_articles` SET `header` = '$header', `content` = '$content', `full_content` = '$full_content', `article_id` = $article_id");

          if (mysqli_insert_id($this->mysqli) > 0) {
              return 1;
          }

          return 0;
      }

      public function openSandbox($article_id)
      {
          $this->mysqli->query("UPDATE `need_to_translate_articles`
                            SET `translate` = 1
                            WHERE `article_id` = $article_id");
      }

      public function closeSandbox($article_id)
      {
          $result = $this->mysqli->query("SELECT `id`
                                      FROM `translate_articles`
                                      WHERE `article_id` = $article_id");

          if (mysqli_num_rows($result) == 0) {
              $this->mysqli->query("UPDATE `need_to_translate_articles`
                              SET `translate` = 0
                              WHERE `article_id` = $article_id");
          }
      }

      public function resultToArray($result)
      {
          $array = array();

          while ($row = $result->fetch_assoc()) {
              $array[] = $row;
          }

          return $array;
      }
  }

  class tapinambur extends tapinamburAPI
  {
      public function __construct()
      {
          $this->connectDB("vitalijm_tapinambur");
      }

      public function __destruct()
      {
          parent::__destruct();
      }
  }

  function translit($insert)
  {
      $insert = mb_strtolower($insert);
      $replase = array(
      'а'=>'a',
      'б'=>'b',
      'в'=>'v',
      'г'=>'h',
      'ґ'=>'g',
      'д'=>'d',
      'е'=>'e',
      'є'=>'ie',
      'ж'=>'zh',
      'з'=>'z',
      'и'=>'y',
      'і'=>'i',
      'ї'=>'yi',
      'й'=>'i',
      'к'=>'k',
      'л'=>'l',
      'м'=>'m',
      'н'=>'n',
      'о'=>'o',
      'п'=>'p',
      'р'=>'r',
      'с'=>'s',
      'т'=>'t',
      'у'=>'u',
      'ф'=>'f',
      'х'=>'kh',
      'ц'=>'c',
      'ч'=>'ch',
      'ш'=>'sh',
      'щ'=>'shch',
      'ъ'=>'j',
      'ь'=>'’',
      'ю'=>'iu',
      'я'=>'ya',
      ' '=>'-',
      ' - '=>'-',
      '_'=>'-',
      '.'=>'',
      ':'=>'',
      ';'=>'',
      ','=>'',
      '!'=>'',
      '?'=>'',
      '>'=>'',
      '<'=>'',
      '&'=>'',
      '*'=>'',
      '%'=>'',
      '$'=>'',
      '"'=>'',
      '\''=>'',
      '('=>'',
      ')'=>'',
      '`'=>'',
      '+'=>'',
      '/'=>'',
      '\\'=>''
    );

      $insert = preg_replace("/ + /", " ", $insert);
      $insert = strtr($insert, $replase);

      return $insert;
  }
