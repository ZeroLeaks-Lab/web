<?php

require_once("DB.php");
require_once("IPLocation.php");
require_once("View.php");

class Controller {
  static function ip_leak(): void {
    $iplocation = new IPLocation(DBConnection::new());
    $ip = $_SERVER["REMOTE_ADDR"];
    $country = $iplocation->getCountry($ip);
    (new View())->ip_leak($ip, $country);
  }
}
