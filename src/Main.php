<?php

require_once("Controller.php");

$router = new \Bramus\Router\Router();

$router->get("/", function () {
  Controller::ip_leak();
});

$router->run();

