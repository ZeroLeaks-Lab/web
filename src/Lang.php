<?php

class Lang {
  public object $strings;

  function __construct() {
    $langs = $this->get_client_langs();
    array_push($langs, "en");
    foreach ($langs as $lang) {
      $content = file_get_contents("locales/$lang.json");
      if ($content === false) {
        continue;
      }
      $this->strings = json_decode($content);
      break;
    }
  }

  private function get_client_langs(): array {
    if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        return [];
    }
    // Example: fr-CH, fr;q=0.9, en;q=0.8, de;q=0.7, *;q=0.5
    $langs = [];
    foreach (explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) as $_ => $i) {
        $lang = explode(';', $i);
        if (count($lang) === 0) {
            continue;
        }
        array_push($langs, $lang[0]);
    }
    return $langs;
  }
}
