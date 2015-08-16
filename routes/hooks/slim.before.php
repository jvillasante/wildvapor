<?php

$app->hook('slim.before', function () use ($app, $availableLangs, $db, $config) {
  $env = $app->environment();

  // setup default lang based on first in the list
  $lang = $availableLangs[0];

  // if they are accessing the root, you could try and direct them to the correct language
  if ($env['PATH_INFO'] == '/') {
    if (isset($env['ACCEPT_LANGUAGE'])) {
      // try and auto-detect, find the language with the lowest offset as they are in order of priority
      $priority_offset = strlen($env['ACCEPT_LANGUAGE']);

      foreach($availableLangs as $availableLang) {
        $i = strpos($env['ACCEPT_LANGUAGE'], $availableLang);
        if ($i !== false) {
          $lang = $availableLang;
        }
      }
    }
  } else {
    $pathInfo = $env['PATH_INFO'] . (substr($env['PATH_INFO'], -1) !== '/' ? '/' : '');

    // extract lang from PATH_INFO
    foreach($availableLangs as $availableLang) {
      $match = '/'.$availableLang;
      if (strpos($pathInfo, $match.'/') === 0) {
        $lang = $availableLang;
        $env['PATH_INFO'] = substr($env['PATH_INFO'], strlen($match));

        if (strlen($env['PATH_INFO']) == 0) {
          $env['PATH_INFO'] = '/';
        }
      }
    }
  }

  $base_url = $config['base_url'];
  if ($app->environment()['slim.url_scheme'] == 'https' ) {
    define('BASE_URL', str_replace('http', 'https', $base_url));
  } else {
    define('BASE_URL', $base_url);
  }

  $uid = \Helpers\User::user_id();
  $cart_items = \Data\CartRepository::get_shopping_cart_contents($db, $uid);
  if ($cart_items && count($cart_items)) {
    $cart = \Helpers\Util::parse_cart_items($cart_items);
  }

  $app->view()->setLang($lang);
  $app->view()->setAvailableLangs($availableLangs);
  $app->view()->setPathInfo($env['PATH_INFO']);
  $app->view()->appendData(array(
    'page_title' => NULL,
    'cart' => isset($cart) ? $cart : NULL,
    'db' => $db
  ));
});



