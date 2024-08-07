<?php

require_once("Config.php");
require_once("Lang.php");

class Controller {
  private \Twig\Environment $twig;
  private Lang $lang;

  function __construct(string $templates_path, Lang $lang) {
    $this->lang = $lang;
    $this->twig = new \Twig\Environment(
      new \Twig\Loader\FilesystemLoader($templates_path),
    );
  }

  function ip_leak(): void {
    $this->twig->display("ip_leak.html", [
      "s" => $this->lang->strings,
      "ip" => $_SERVER["REMOTE_ADDR"],
    ]);
  }
}
