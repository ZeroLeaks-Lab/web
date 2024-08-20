<?php

require_once("Config.php");

function isIPv4(string $ip) {
  return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
}

function isIPv6(string $ip) {
  return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
}

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
    if (isIPv4($ip)) {
      $table = \Config\IPV4_COUNTRY_TABLE;
    } else if (isIPv6($ip)) {
      $table = \Config\IPV6_COUNTRY_TABLE;
    } else {
      throw new Exception("Invalid IP:" . $ip);
    }
    $stmt = $this->pdo->prepare("SELECT country FROM " . $table . " WHERE :ip BETWEEN start AND end");
    $stmt->execute([":ip" => $ip]);
    if ($stmt->rowCount() === 0) {
      return null;
    }
    return $stmt->fetch()["country"];
  }
}
