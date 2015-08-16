<?php

$authenticate = function(\Slim\Route $route) {
  $app = \Slim\Slim::getInstance();
  if (!\Helpers\User::is_logged_in()) {
    $app->flash('error', $app->view()->tr('authentication.required'));
    $app->redirect($app->view()->url_secure('/session/login'));
  }
};

return $authenticate;

