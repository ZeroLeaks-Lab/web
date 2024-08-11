<?php

require_once("Config.php");
require_once("Lang.php");

class View {
  private \Twig\Environment $twig;
  private Lang $lang;

  function __construct(Lang $lang) {
    $this->lang = $lang;
    $this->twig = new \Twig\Environment(
      new \Twig\Loader\FilesystemLoader(\Config\TEMPLATES_LOCATION),
      [
        "cache" => \Config\TEMPLATES_CACHE,
        "strict_variables" => true,
      ]
    );
    $this->twig->addFunction(new \Twig\TwigFunction("l", function($id) {
      $a = explode(".", $id);
      return $this->lang->getString($a[0], $a[1]);
    }));
    $this->twig->addFunction(new \Twig\TwigFunction("s", function($key) {
      return $this->lang->getString("strings", $key);
    }));
  }

  function ip_leak(string $ip, ?string $country): void {
    $this->twig->display("ip_leak.html", [
      "ip" => $ip,
      "country" => $country,
    ]);
  }

  function webrtc(): void {
    $this->twig->display("webrtc.html", [
      "stun_server" => \Config\STUN_SERVER,
    ]);
  }
}
