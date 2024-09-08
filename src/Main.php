<?php

require_once("Controller.php");

$lang = Lang::getCurrent();
$view = new View($lang);

$router = new \Bramus\Router\Router();

$router->get("/", function () use ($view) {
  Controller::ip_leak($view);
});

$router->get("/dns", function () use ($view) {
  $view->dns();
});

$router->get("/webrtc", function () use ($view) {
  $view->webrtc();
});

$router->get("/bittorrent", function () use ($view) {
  $view->bittorrent();
});

$router->get("/api/country/([a-f0-9:.]+)", function ($ip) use ($lang) {
  Controller::api_ip_country($ip, $lang);
});

$router->run();

