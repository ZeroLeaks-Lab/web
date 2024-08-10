<?php

require_once("Config.php");

class DBConnection {
  static function new(): PDO {
    $pdo = new PDO(\Config\DB_DSN, \Config\DB_USER, \Config\DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
  }
}
