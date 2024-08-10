<?php

require_once("Config.php");

class Lang {
  private array $strings;
  private ?Lang $fallback;

  private function __construct(string $locale) {
    $dir = "locales/$locale";
    $content = scandir($dir);
    if ($content === false) {
      throw new Exception("Locale not found", 1);
    }
    $this->strings = array();
    foreach ($content as $file) {
      $path = "$dir/$file";
      if (is_file($path)) {
        $this->strings[pathinfo($file, PATHINFO_FILENAME)] = json_decode(file_get_contents($path), true);
      }
    }
    if ($locale === \Config\FALLBACK_LOCALE) {
      $this->fallback = null;
    } else {
      $this->fallback = new Lang(\Config\FALLBACK_LOCALE);
    }
  }

  private static function get_client_langs(): array {
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

  static function getCurrent(): Lang {
    foreach (Lang::get_client_langs() as $lang) {
      try {
        return new Lang($lang);
      } catch (Exception $_) {}
    }
  }

  function getString(string $file, string $key): string {
    if (key_exists($file, $this->strings) && key_exists($key, $this->strings[$file])) {
      return $this->strings[$file][$key];
    }
    return $this->fallback->getString($file, $key);
  }
}
