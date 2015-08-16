<?php

$app->get('/', function () use ($app, $db) {
  $random_products = \Data\ProductsRepository::get_random_products($db);
  $new_arrival = \Data\ProductsRepository::get_new_arrival($db);

  $app->render('home.php', array(
    'page_title' => 'Home',
    'random_products' => $random_products,
    'new_arrival' => $new_arrival,
    'current' => 'home',
  ));
});

$app->get('/home/about', function() use ($app) {
  $app->render('home/about.php', array(
    'page_title' => 'About Us',
    'current' => 'about',
  ));
});

$app->get('/home/return', function() use ($app) {
  $app->render('home/return.php', array(
    'page_title' => 'Return Policy',
    'current' => 'policies',
  ));
});

$app->get('/home/payment', function() use ($app) {
  $app->render('home/payment.php', array(
    'page_title' => 'Payment Policy',
    'current' => 'policies',
  ));
});

$app->get('/home/shipping', function() use ($app) {
  $app->render('home/shipping.php', array(
    'page_title' => 'Shipping Policy',
    'current' => 'policies',
  ));
});

$app->get('/home/privacy', function() use ($app) {
  $app->render('home/privacy.php', array(
    'page_title' => 'Privacy Policy',
    'current' => 'policies',
  ));
});

$app->get('/home/contact', function() use ($app) {
  $flash = $app->view()->getData('flash');
  $errors = (isset($flash['errors'])) ? $flash['errors'] : array();

  $app->render('home/contact.php', array(
    'page_title' => 'Contact',
    'errors' => $errors,
    'current' => 'contact',
  ));
});

$app->post('/home/contact', function() use ($app, $config) {
  include BASE_URI . DS . 'routes' . DS . 'validators' . DS . 'contact.php';

  $data = $app->request()->post();
  $errors = validate($data);
  if ($errors) {
    $app->flash('errors', $errors);
    $app->flash('data', $data);
    $app->redirect($app->view()->url('/home/contact'));
  }

  $result = sendContactMail($data['name'], $data['email'], $data['website'], $data['message'], $config);
  if (!is_array($result)) {
    $app->flash('info', $result);
    $app->redirect($app->view()->url('/'));
  } else {
    $app->error(new \Exception($result['error']));
  }
});

$app->get('/home/faq', function() use ($app) {
  $app->render('home/faq.php', array(
    'page_title' => 'FAQ',
    'current' => 'faq',
  ));
});

function sendContactMail($name, $email, $website, $message, $config) {
  $_body = $message;
  if ($website) {
    $_body .= "<br /><br />$website";
  }

  if ($config['live']) {
    $body = file_get_contents(BASE_URI . DS . 'views' . DS . 'mail_template.html');
    $body = str_replace('{{title}}', 'Message from ' . $name . ' to WildVapor Inc', $body);
    $body = str_replace('{{message}}', $_body, $body);
    $data = array(
      'live' => $config['live'],
      'mail_server' => $config['mail_server'],
      'mail_port' => $config['mail_port'],
      'mail_username' => $config['mail_username'],
      'mail_password' => $config['mail_password'],
      'mail_to_address' => $config['mail_from'],
      'mail_to_name' => 'Wildvapor',
      'subject' => "Mail from $name",
      'body' => $body,
      'mail_from' => $email
    );

    $mailer = new \Helpers\Mailer($data);
    if ($mailer->sendMail()) {
      return 'Your message has been sent. Thank you.';
    } else {
      return array('error' => $mailer->getError());
    }
  } else {
    return $body;
  }
};

