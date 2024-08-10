<?php

require_once("Config.php");

class IPLocation {
  private PDO $pdo;

  function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  function getCountry(string $ip): ?string {
    $stmt = $this->pdo->prepare("SELECT country FROM " . \Config\IP_COUNTRY_TABLE . " WHERE :ip BETWEEN start AND end");
    $stmt->execute([":ip" => $ip]);
    if ($stmt->rowCount() === 0) {
      return null;
    }
    return $stmt->fetch()["country"];
  }
}
