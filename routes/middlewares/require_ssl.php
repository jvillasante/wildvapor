<?php

$require_ssl = function(\Slim\Route $route) {
  $app = \Slim\Slim::getInstance();

  // if ($app->environment()['slim.url_scheme'] !== 'https' ) {
    // $app->error(new \Exception($app->view()->tr('ssl.required')));
  // }
};

return $require_ssl;

