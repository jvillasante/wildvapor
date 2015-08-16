<?php

$app->get('/users/:id', $authenticate, function($id) use ($app) {
  if ($id != $_SESSION['user_id']) { $app->notFound(); }

  $app->render('users/account.php', array(
    'page_title' => $app->view()->tr('pages.account'),
  ));
});

$app->get('/users/:id/changepassword', $require_ssl, $authenticate, function($id) use ($app) {
  if ($id != $_SESSION['user_id']) { $app->notFound(); }

  $flash = $app->view()->getData('flash');
  $errors = (isset($flash['errors'])) ? $flash['errors'] : array();

  $app->view()->set_template('layouts/basic.php');
  $app->render('users/changepassword.php', array(
    'page_title' => $app->view()->tr('pages.changepassword'),
    'errors' => $errors
  ));
});

$app->post('/users/:id/changepassword', $require_ssl, $authenticate, function($id) use ($app, $db) {
  if ($id != $_SESSION['user_id']) { $app->notFound(); }

  include BASE_URI . DS . 'routes' . DS . 'validators' . DS . 'changepassword.php';

  $data = $app->request()->post();
  $errors = validate($data);
  if ($errors) {
    $app->flash('errors', $errors);
    $app->redirect($app->view()->url_secure('/users/' . $id. '/changepassword'));
  }

  $user = \Data\UserRepository::get_user_by_password($db, $data['password']);
  if ($user) {
    if (\Data\UserRepository::update_password($db, $data['new_password'], $_SESSION['user_id'])) {
      $app->flash('info', $app->view()->tr('session.change.success'));
      $app->redirect($app->view()->url('/users/' . $id));
    } else {
      $app->error(new \Exception($app->view()->tr('session.change.system.error')));
    }
  } else {
    $app->flash('error', $app->view()->tr('session.change.password.error'));
    $app->redirect($app->view()->url_secure('/session/' . $id . '/changepassword'));
  }
});

$app->get('/users/:id/account', $require_ssl, $authenticate, function($id) use ($app, $db) {
  if ($id != $_SESSION['user_id']) { $app->notFound(); }

  $flash = $app->view()->getData('flash');
  if (!isset($flash['data'])) {
    $user = \Data\UserRepository::get_user_by_id($db, $id);
    $_SESSION['slim.flash']['data'] = $user;
  }
  $errors = (isset($flash['errors'])) ? $flash['errors'] : array();

  $app->view()->set_template('layouts/basic.php');
  $app->render('users/profile.php', array(
    'page_title' => $app->view()->tr('pages.changepassword'),
    'errors' => $errors
  ));
});

$app->post('/users/:id/account', $require_ssl, $authenticate, function($id) use ($app, $db) {
  if ($id != $_SESSION['user_id']) { $app->notFound(); }

  include BASE_URI . DS . 'routes' . DS . 'validators' . DS . 'profile.php';

  $data = $app->request()->post();
  $errors = validate($data);
  if ($errors) {
    $app->flash('errors', $errors);
    $app->redirect($app->view()->url_secure('/users/' . $id. '/account'));
  }

  $data['use_same_address'] = isset($data['use_same_address']) ? 1 : 0;
  $stmt = \Data\UserRepository::update_user($db, $data, $id);
  if ($stmt) {
    $app->flash('info', 'User Updated.');
    $app->redirect($app->view()->url('/users/' . $id));
  } else {
    $app->error(new \Exception('Error updating user. Please, try again later.'));
  }
});

$app->get('/users/:id/orders', $authenticate, function($id) use ($app, $db) {
  if ($id != $_SESSION['user_id']) { $app->notFound(); }

  $orders = \Data\OrderRepository::get_orders_by_user_id($db, $id);

  $app->view()->set_template('layouts/basic.php');
  $app->render('users/orders.php', array(
    'page_title' => 'Your Orders',
    'orders' => $orders
  ));
});

$app->get('/users/:uid/orders/:oid', $authenticate, function($uid, $oid) use ($app, $db) {
  if ($uid != $_SESSION['user_id']) { $app->notFound(); }

  $order_contents = \Data\OrderRepository::get_order_contents($db, $oid);

  if ($order_contents) {
    $app->view()->set_template('layouts/basic.php');
    $app->render('users/order_contents.php', array(
      'page_title' => 'Your Order',
      'order_contents' => $order_contents,
      'order_id' => $oid
    ));
  } else {
    $app->notFound();
  }
});

