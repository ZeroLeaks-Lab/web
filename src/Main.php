<?php

require_once("Config.php");
require_once("Lang.php");
require_once("Controller.php");

$controller = new Controller(\Config\TEMPLATES_LOCATION, new Lang());

$router = new \Bramus\Router\Router();

$router->get("/", function () {
  global $controller;
  $controller->ip_leak();
});

$router->run();

