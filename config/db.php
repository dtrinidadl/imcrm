<?php

class Database {

  public static function connect() {
    $db = new mysqli('localhost', 'root', 'root', 'imsupport');
    // $db = new mysqli('https://databases-auth.000webhost.com/index.php', 'id19511391_root', 'imaGT123*root', 'id19511391_imsupport_prod');
    $db->query("SET NAMES 'utf8'");

    return $db;
  }

}
