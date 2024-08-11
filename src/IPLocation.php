<?php

require_once("Config.php");

class IPLocation {
  private PDO $pdo;
  private array $override;

  function __construct(PDO $pdo) {
    $this->pdo = $pdo;
    if (\Config\IP_COUNTRY_OVERRIDE_FILE === false) {
      $this->override = [];
    } else {
      $f = fopen(\Config\IP_COUNTRY_OVERRIDE_FILE, "r");
      if ($f === false) {
        throw new Exception("Failed to open IP country override file");
      }
      while (($row = fgetcsv($f)) !== false) {
        $this->override[$row[0]] = $row[1];
      }
      fclose($f);
    }
  }

  function getCountry(string $ip): ?string {
    if (key_exists($ip, $this->override)) {
      return $this->override[$ip];
    }
    $stmt = $this->pdo->prepare("SELECT country FROM " . \Config\IP_COUNTRY_TABLE . " WHERE :ip BETWEEN start AND end");
    $stmt->execute([":ip" => $ip]);
    if ($stmt->rowCount() === 0) {
      return null;
    }
    return $stmt->fetch()["country"];
  }
}
