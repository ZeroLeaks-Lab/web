<?php

require_once("DB.php");
require_once("IPLocation.php");
require_once("View.php");

class Controller {
  static private function get_ip_country(string $ip): ?string {
    return (new IPLocation(DBConnection::new()))->getCountry($ip);
  }

  static function ip_leak(View $view): void {
    $ip = $_SERVER["REMOTE_ADDR"];
    $view->ip_leak($ip, Controller::get_ip_country($ip));
  }

  static function api_ip_country(string $ip, Lang $lang): void {
    $country = Controller::get_ip_country($ip);
    $data = [
      "code" => $country,
    ];
    if ($country !== null) {
      $data["name"] = $lang->getString("countries", $country);
    }
    echo json_encode($data);
  }
}
