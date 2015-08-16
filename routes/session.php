<?php

$app->get('/session/register', $require_ssl, function() use ($app) {
  $flash = $app->view()->getData('flash');
  $errors = (isset($flash['errors'])) ? $flash['errors'] : array();

  $app->view()->set_template('layouts/basic.php');
  $app->render('session/register.php', array(
    'page_title' => 'pages.register',
    'errors' => $errors
  ));
});

$app->post('/session/register', $require_ssl, function() use ($app, $db) {
  include BASE_URI . DS . 'routes' . DS . 'validators' . DS . 'register.php';

  $data = $app->request()->post();
  $errors = validate($data);
  if ($errors) {
    $app->flash('errors', $errors);
    $app->flash('data', $data);
    $app->redirect($app->view()->url_secure('/session/register'));
  }

  $user = \Data\UserRepository::get_user_by_email_or_username($db, $data['email'], $data['username']);
  if (!$user) {
    $data['id'] = \Helpers\User::uid();
    $stmt = \Data\UserRepository::insert($db, $data);
    if ($stmt->rowCount() > 0) {
      $app->flash('info', $app->view()->tr('session.registered'));
      $app->redirect($app->view()->url('/'));
    } else {
      $app->error(new \Exception($app->view()->tr('session.system.error')));
    }
  } else {
    if (($user['email'] == $data['email']) && ($user['username'] == $data['username'])) {
      $app->flash('error', $app->view()->tr('session.user.exists'));
    } elseif ($user['email'] == $data['email']) {
      $app->flash('error', $app->view()->tr('session.email.taken'));
    } elseif ($user['username'] == $data['username']) {
      $app->flash('error', $app->view()->tr('session.username.taken'));
    }
    unset($data['password']);
    unset($data['password_confirmation']);
    $app->flash('data', $data);
    $app->redirect($app->view()->url_secure('/session/register'));
  }
});

$app->get('/session/login', $require_ssl, function() use ($app, $db) {
  $flash = $app->view()->getData('flash');
  $errors = (isset($flash['errors'])) ? $flash['errors'] : array();

  $app->view()->set_template('layouts/basic.php');
  $app->render('session/login.php', array(
    'page_title' => $app->view()->tr('pages.login'),
    'errors' => $errors
  ));
});

$app->post('/session/login', $require_ssl, function() use ($app, $db) {
  include BASE_URI . DS . 'routes' . DS . 'validators' . DS . 'login.php';

  $data = $app->request()->post();
  $errors = validate($data);
  if ($errors) {
    $app->flash('error', $app->view()->tr('session.login.errors'));
    $app->redirect($app->view()->url_secure('/session/login'));
  }

  $user = \Data\UserRepository::get_user_by_email_and_password($db, $data['email'], $data['password']);
  if ($user) {
    \Data\CartRepository::clear_cart($db, $_SESSION['user_id']); // remove past items
    \Data\WishListRepository::clear_wish_list($db, $_SESSION['user_id']); // remove past items

    if ($user['type'] == 'admin') {
      session_regenerate_id(true);
      $_SESSION['admin'] = true;
    }
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['logged_in'] = true;

    $app->flash('info', 'Welcome to our store ' . $user['username'] . '. Enjoy!');
    $app->redirect($app->view()->url('/'));
  } else {
    $app->flash('error', $app->view()->tr('session.login.match.error'));
    $app->redirect($app->view()->url_secure('/session/login'));
  }
});

$app->get('/session/logout', $authenticate, function() use ($app) {
  $_SESSION = array();
  session_destroy();
  setcookie(session_name(), '', time() - 300);
  $app->flash('info', $app->view()->tr('session.logout'));
  $app->redirect($app->view()->url('/'));
});

$app->get('/session/forgotpassword', function() use ($app) {
  $flash = $app->view()->getData('flash');
  $errors = (isset($flash['errors'])) ? $flash['errors'] : array();

  $app->view()->set_template('layouts/basic.php');
  $app->render('session/forgotpassword.php', array(
    'page_title' => $app->view()->tr('pages.forgotpassword'),
    'errors' => $errors
  ));
});

$app->post('/session/forgotpassword', function() use ($app, $db, $config) {
  include BASE_URI . DS . 'routes' . DS . 'validators' . DS . 'forgotpassword.php';

  $data = $app->request()->post();
  $errors = validate($data);
  if ($errors) {
    $app->flash('errors', $errors);
    $app->redirect($app->view()->url('/session/forgotpassword'));
  }

  $user = \Data\UserRepository::get_user_by_email($db, $data['email']);
  if ($user) {
    $password = substr(md5(uniqid(rand(), true)), 10, 15);
    if (\Data\UserRepository::update_password($db, $password, $user['id'])) {
      $result = sendForgotPasswordMail($user, $password, $config);
      if (!is_array($result)) {
        $app->flash('info', $result);
        $app->redirect($app->view()->url_secure('/session/login'));
      } else {
        $app->error(new \Exception($result['error']));
      }
    } else {
      $app->error(new \Exception($app->view()->tr('session.forgot.system.error')));
    }
  } else {
    $app->flash('error', $app->view()->tr('session.forgot.email.error'));
    $app->redirect($app->view()->url('/session/forgotpassword'));
  }
});

function sendForgotPasswordMail($user, $password, $config) {
  $message = "Your password to log into WildVapor has been
    temporarily changed to '$password'. Please log in using that password and this
    email address. Then you may change your password to something more familiar.";

  if ($config['live']) {
    $body = file_get_contents(BASE_URI . DS . 'views' . DS . 'mail_template.html');
    $body = str_replace('{{title}}', 'Your temporary password at WildVapor Inc', $body);
    $body = str_replace('{{message}}', $message, $body);
    $data = array(
      'live' => $config['live'],
      'mail_username' => $config['mail_username'],
      'mail_password' => $config['mail_password'],
      'mail_to_address' => $user['email'],
      'mail_to_name' => \Helpers\User::get_name($user),
      'subject' => 'Your temporary password at WildVapor.',
      'body' => $body,
      'mail_from' => $config['mail_from'],
    );

    $mailer = new \Helpers\Mailer($data);
    if ($mailer->sendMail()) {
      return 'Your password has been changed. You will receive
        the new, temporary password via email. Once you have logged in
        with this new password, you may change it by clicking on the "Change
        Password" link.';
    } else {
      return array('error' => $mailer->getError());
    }
  } else {
    return $message;
  }
};

