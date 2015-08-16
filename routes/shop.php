<?php

function add_to_cart($app, $db, $params) {
  if (isset($params['id'], $params['attributes'])) {
    $pid = (filter_var($params['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $params['id'] : NULL;
    if (empty($params['attributes']) || ($params['attributes'] === '0')) { // product don't have attributes
      $attributes = NULL;
    } elseif ($params['attributes'] === '1') { // product needs attributes
      $app->flash('info', 'You need to choose the attributes of your product before adding it to your Cart.');
      $category = \Data\ProductsRepository::get_category($db, $pid);
      $app->redirect($app->view()->url('/products/' . $category .'/' . $pid));
    } else { // actual attributes string
      $attributes = $params['attributes'];
    }
  }

  if (isset($pid, $params['action']) && ($params['action'] == 'add')) {
    $stmt = \Data\CartRepository::add_to_cart($db, $_SESSION['user_id'], $pid, 1, $attributes);
    $app->flash('info', 'Your cart have been updated. A new product have been added.');
    $app->redirect($app->view()->url('/shop/cart'));
  } elseif (isset($pid, $params['action']) && ($params['action'] == 'remove')) {
    $stmt = \Data\CartRepository::remove_from_cart($db, $_SESSION['user_id'], $pid, $attributes);
    $app->flash('info', 'Your cart have been updated. The selected product have been removed.');
    $app->redirect($app->view()->url('/shop/cart'));
  } elseif (isset($pid, $params['action'], $params['qty']) && ($params['action'] == 'move')) {
    $qty = (filter_var($params['qty'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $params['qty'] : 1;
    $stmt = \Data\CartRepository::remove_from_cart($db, $_SESSION['user_id'], $pid, $attributes);
    $stmt = \Data\WishListRepository::add_to_wish_list($db, $_SESSION['user_id'], $pid, $qty, $attributes);
    $app->flash('info', 'Your cart have been updated. The product selected have been moved to your Wish List.');
    $app->redirect($app->view()->url('/shop/cart'));
  } elseif (isset($params['action']) && ($params['action'] == 'clear')) {
    $stmt = \Data\CartRepository::clear_cart($db, $_SESSION['user_id']);
    $app->flash('info', 'Your cart have been updated. Your cart is now empty.');
    $app->redirect($app->view()->url('/shop/cart'));
  } else { // show cart
    $app->view()->set_template('layouts/basic.php');
    $app->render('shop/cart.php', array(
      'page_title' => 'Your Cart'
    ));
    $app->stop();
  }
}

function add_to_wish_list($app, $db, $params) {
  if (isset($params['id'], $params['attributes'])) {
    $pid = (filter_var($params['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $params['id'] : NULL;

    if (empty($params['attributes']) || ($params['attributes'] === '0')) { // product don't have attributes
      $attributes = NULL;
    } elseif ($params['attributes'] === '1') { // product needs attributes
      $app->flash('info', 'You need to choose the attributes of your product before adding it to your Wish List.');
      $category = \Data\ProductsRepository::get_category($db, $pid);
      $app->redirect($app->view()->url('/products/' . $category .'/' . $pid));
    } else { // actual attributes string
      $attributes = $params['attributes'];
    }
  }

  if (isset($pid, $params['action']) && ($params['action'] == 'add')) {
    $stmt = \Data\WishListRepository::add_to_wish_list($db, $_SESSION['user_id'], $pid, 1, $attributes);
    $app->flash('info', 'Your Wish List have been updated. A new product have been added.');
    $app->redirect($app->view()->url('/shop/wishlist'));
  } elseif (isset($pid, $params['action']) && ($params['action'] == 'remove')) {
    $stmt = \Data\WishListRepository::remove_from_wish_list($db, $_SESSION['user_id'], $pid, $attributes);
    $app->flash('info', 'Your Wish List have been updated. The selected product have been removed.');
    $app->redirect($app->view()->url('/shop/wishlist'));
  } elseif (isset($pid, $params['action'], $params['qty']) && ($params['action'] == 'move')) {
    $qty = (filter_var($params['qty'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $params['qty'] : 1;
    $stmt = \Data\WishListRepository::remove_from_wish_list($db, $_SESSION['user_id'], $pid, $attributes);
    $stmt = \Data\CartRepository::add_to_cart($db, $_SESSION['user_id'], $pid, $qty, $attributes);
    $app->flash('info', 'Your Wish List have been updated. The product selected have been moved to your Cart.');
    $app->redirect($app->view()->url('/shop/wishlist'));
  } elseif (isset($params['action']) && ($params['action'] == 'clear')) {
    $stmt = \Data\WishListRepository::clear_wish_list($db, $_SESSION['user_id']);
    $app->flash('info', 'Your Wish List have been updated. Your Wish List is now empty.');
    $app->redirect($app->view()->url('/shop/wishlist'));
  } else { // show Wish List
    $wish_list_items = \Data\WishListRepository::get_wish_list_contents($db, $_SESSION['user_id']);
    $wish_list = NULL;
    if ($wish_list_items && count($wish_list_items)) {
      $wish_list = \Helpers\Util::parse_wish_list_items($wish_list_items);
    }

    $app->view()->set_template('layouts/basic.php');
    $app->render('shop/wishlist.php', array(
      'page_title' => 'Your WishList',
      'wish_list' => $wish_list
    ));
  }
}

$app->map('/shop/cart', function() use ($app, $db) {
  $request = $app->request();

  if ($request->isGet()) {
    $params = $request->get();
    add_to_cart($app, $db, $params);
  } elseif ($request->isPost()) {
    $params = $app->request()->post();

    if (isset($params['quantity'], $params['attributes'])) {
      foreach ($params['quantity'] as $md5 => $qty) {
        $id_attributes = explode('|', $params['attributes'][$md5]);
        if (empty($id_attributes[1])) { $id_attributes[1] = NULL; }
        $pid = (filter_var($id_attributes[0], FILTER_VALIDATE_INT, array('min_range' => 1)) !== false) ?  $id_attributes[0] : NULL;

        if (isset($pid)) {
          $qty = (filter_var($qty, FILTER_VALIDATE_INT, array('min_range' => 0)) !== false) ? $qty : 1;
          $stmt = \Data\CartRepository::update_cart($db, $_SESSION['user_id'], $pid, $qty, $id_attributes[1]);
        }
      }
    }

    $app->flash('info', 'Your cart have been updated.');
    $app->redirect($app->view()->url('/shop/cart'));
  }
})->via('GET', 'POST');

$app->map('/shop/wishlist', function() use ($app, $db) {
  $request = $app->request();

  if ($request->isGet()) {
    $params = $request->get();
    add_to_wish_list($app, $db, $params);
  } elseif ($request->isPost()) {
    $params = $request->post();

    if (isset($params['quantity'], $params['attributes'])) {
      foreach ($params['quantity'] as $md5 => $qty) {
        $id_attributes = explode('|', $params['attributes'][$md5]);
        if (empty($id_attributes[1])) { $id_attributes[1] = NULL; }
        $pid = (filter_var($id_attributes[0], FILTER_VALIDATE_INT, array('min_range' => 1)) !== false) ?  $id_attributes[0] : NULL;

        if (isset($pid)) {
          $qty = (filter_var($qty, FILTER_VALIDATE_INT, array('min_range' => 0)) !== false) ? $qty : 1;
          $stmt = \Data\WishListRepository::update_wish_list($db, $_SESSION['user_id'], $pid, $qty, $id_attributes[1]);
        }
      }
    }

    $app->flash('info', 'Your wish list have been updated.');
    $app->redirect($app->view()->url('/shop/wishlist'));
  }
})->via('GET', 'POST');;

$app->post('/shop/add_product', function() use ($app, $db) {
  $params = $app->request()->post();

  $wrong_posting = false;
  $attributes = '';
  if (isset($params['type']) && ($params['type'] == 'kit')) {
    foreach ($params['products'] as $k => $v) {
      $attributes .= '[' . $v . '.';
      foreach ($params['product_attrs'] as $kattr => $vattr) {
        if (strpos($kattr, $k) !== false) {
          if (empty($vattr)) {
            $wrong_posting = true;
            break;
          }
          $attr = substr($kattr, strlen($k) + strlen('_attr_'), strlen($kattr));
          $attributes .= ' ' . $attr . ': ' . $vattr;
        }
      }
      $attributes .= '], ';
    }
  } else {
    foreach ($params as $k => $v) {
      if (strpos($k, 'attr_') !== false) {
        if (empty($v)) {
          $wrong_posting = true;
          break;
        }
        $key = substr($k, 5, strlen($k));
        $attributes .= '[' . $key . ': ' . $v . '], ';
        unset($params[$k]);
      }
    }
  }

  if ($wrong_posting) {
    $attributes = '1';
  } else {
    $attributes = substr($attributes,0,(strLen($attributes)-2)); //this will eat the last ', '
  }
  $params['attributes'] = $attributes;

  if (isset($params['cart'])) {
    add_to_cart($app, $db, $params);
  } elseif (isset($params['wishlist'])) {
    add_to_wish_list($app, $db, $params);
  }
});

$app->get('/shop/checkout', $require_ssl, function() use ($app, $db) {
  $app->view()->set_template('layouts/basic.php');
  $app->render('shop/checkout.php', array(
    'page_title' => 'Checkout Options'
  ));
});

$app->get('/shop/cccheckout', $require_ssl, function() use ($app, $db) {
  $flash = $app->view()->getData('flash');
  if (!isset($flash['data'])) {
    $user = \Data\UserRepository::get_user_by_id($db, $_SESSION['user_id']);
    if ($user) {
      \Helpers\User::copy_user_to_flash($user);
    }
  }
  $checkout_errors = (isset($flash['checkout_errors'])) ? $flash['checkout_errors'] : array();

  $app->view()->set_template('layouts/basic.php');
  $app->render('shop/cccheckout.php', array(
    'page_title' => 'Checkout',
    'checkout_errors' => $checkout_errors
  ));
});

$app->post('/shop/cccheckout', $require_ssl, function() use ($app, $db, $config) {
  $cart = $app->view()->getData('cart');
  $data = $app->request()->post();

  if (isset($cart['messages']) && count($cart['messages'])) {
    $app->flash('checkout_errors', $cart['messages']);
    $app->flash('data', $data);
    $app->redirect($app->view()->url_secure('/shop/checkout'));
  }

  include BASE_URI . DS . 'routes' . DS . 'validators' . DS . 'checkout.php';
  $errors = validate($data);
  if ($errors) {
    $app->flash('checkout_errors', $errors);
    $app->flash('data', $data);
    $app->redirect($app->view()->url_secure('/shop/cccheckout'));
  }

  if (!empty($data['use_same_address'])) {
    $data['billing_address1'] = $data['shipping_address1'];
    $data['billing_address2'] = empty($data['shipping_address2']) ? NULL : $data['shipping_address2'];
    $data['billing_city'] = $data['shipping_city'];
    $data['billing_state'] = $data['shipping_state'];
    $data['billing_zip_code'] = $data['shipping_zip_code'];
  }

  $payment = new \Helpers\Payment($config);
  try {
    $response = $payment->direct_payment($cart['total'], $data);
    if ($response) {
      $order_id = \Data\OrderRepository::add_order($db, $_SESSION['user_id'], $cart['total'], $cart['tax']);
      if ($order_id) {
        $order_total = $cart['total'];
        $result = $payment->send_direct_payment_mails($order_id, $cart, $data);
        // \Data\ProductsRepository::update_stock($db, $cart);
        \Data\CartRepository::clear_cart($db, $_SESSION['user_id']);
        if (!is_array($result)) {
          $app->view()->set_template('layouts/basic.php');
          $app->render('shop/cccheckout_final.php', array(
            'page_title' => 'Checkout - Your Order is Complete',
            'order_id' => $order_id,
            'order_total' => $order_total
          ));
        } else {
          $app->error(new \Exception($result['error']));
        }
      } else {
        $app->error(new \Exception('Your order could not be processed due to a system error. We apologize for the inconvenience.'));
      }
    } else {
      $app->error(new \Exception('Your order could not be processed due to a system error. We apologize for the inconvenience.'));
    }
  } catch (\Exception $e) {
    $app->error($e);
  }
});

$app->get('/shop/expresscheckout', $require_ssl, function() use ($app, $db, $config) {
  $cart = $app->view()->getData('cart');
  if (isset($cart) && count($cart['cart_items'])) {
    $payment = new \Helpers\Payment($config);
    try {
      $payment->set_express_checkout($app, $cart);
    } catch (\Exception $e) {
      $app->error($e);
    }
  } else {
    $app->flash('info', 'Your cart is empty. Please, fill up your cart with some of our products and come back to the checkout later.');
    $app->redirect($app->view()->url('/'));
  }
});

$app->get('/shop/expresscheckout/return', $require_ssl, function() use ($app, $db, $config) {
  if(isset($_GET["token"]) && isset($_GET["PayerID"])) {
    $token = $_GET["token"];
    $payerid = $_GET["PayerID"];
    $cart = $app->view()->getData('cart');

    $payment = new \Helpers\Payment($config);
    try {
      $result = $payment->do_express_checkout($token, $payerid, $cart);
      \Data\OrderRepository::add_order($db, $_SESSION['user_id'], $cart['total'], $cart['tax']);
      // \Data\ProductsRepository::update_stock($db, $cart);
      \Data\CartRepository::clear_cart($db, $_SESSION['user_id']);
      unset($_SESSION['user_id']);

      $app->view()->set_template('layouts/basic.php');
      $app->render('shop/payment.php', array(
        'page_title' => 'ORDER CONFIRMATION',
        'title' => 'ORDER',
        'subtitle' => 'Thank you for placing your order at WildVapor Inc',
        'message' => $result
      ));
    } catch (\Exception $e) {
      $app->error($e);
    }
  } else {
    $app->error(new \Exception('This is an error. Don\'t panic!!!!!!!!!!...'));
  }
});

$app->get('/shop/expresscheckout/cancel', $require_ssl, function() use ($app, $db, $config) {
  $app->view()->set_template('layouts/basic.php');
  $app->render('shop/payment.php', array(
    'page_title' => 'Payment Cancel',
    'title' => 'Cancel',
    'subtitle' => 'You have canceled your payment at WildVapor Inc.',
    'message' => 'We are very sorry for your cancelation, we hope that you start buying our products again soon.'
  ));
});

