<?php
define('BASE_URI', dirname(__FILE__));
define('FT_MIN_WORD_LEN', 4);
$config = include BASE_URI . DS . 'config' . DS . 'config.php';

// Autoloader
$loader = include BASE_URI . DS . 'vendor' . DS . 'Aura.Autoload' . DS . 'scripts'. DS . 'instance.php';
$loader->register();
$loader->setPaths([
  'Slim\\'        => BASE_URI . DS . 'vendor' . DS . 'Slim' . DS . 'src' . DS,
  'SlimHelpers\\' => BASE_URI . DS . 'lib' . DS . 'SlimHelpers' . DS . 'src' . DS,
  'Helpers\\'     => BASE_URI . DS . 'lib' . DS . 'Helpers' . DS . 'src' . DS,
  'Valitron\\'    => BASE_URI . DS . 'vendor' . DS . 'valitron' . DS . 'src' . DS,
  'Data\\'        => BASE_URI . DS . 'lib' . DS . 'Data' . DS . 'src' . DS,
  'Zebra\\'       => BASE_URI . DS . 'vendor' . DS . 'Zebra' . DS . 'src' . DS,
]);

$loader->setClasses([
  'PHPMailer' => BASE_URI . DS . 'vendor' . DS . 'phpmailer' . DS . 'class.phpmailer.php',
  'POP3'      => BASE_URI . DS . 'vendor' . DS . 'phpmailer' . DS . 'class.php3.php',
  'SMTP'      => BASE_URI . DS . 'vendor' . DS . 'phpmailer' . DS . 'class.smtp.php',
]);

// Database
$db = NULL;
try {
  $db = new PDO('mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], $config['db_username'], $config['db_password'], array(
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ));
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}

$availableLangs = $config['languages'];

$app = new \SlimHelpers\MultilingualSlim(array(
  'templates.path' =>  BASE_URI . DS . 'views',
));

$translator = new \SlimHelpers\Translator($app->getLog(), BASE_URI . DS . 'lang' . DS);
$app->view(new \SlimHelpers\MultilingualView($app, $translator, 'layouts/main.php'));

$app->add(new \Slim\Middleware\SessionCookie(array(
  'expires' => '30 days',
  'name' => 'wildvapor_session',
  'secret' => 'lmSrM77Le0EcCTCgv7yfRmoe0A1GAVTv'
)));

if (!$config['live']) {
  $loader->add('Whoops\\', BASE_URI . DS . 'vendor' . DS . 'whoops' . DS . 'src' . DS);
  $loader->add('Zeuxisoo\\', BASE_URI . DS . 'vendor' . DS . 'php-slim-whoops' . DS . 'src' . DS);

  $app->config('debug', true);
  // $app->config('whoops.editor', 'sublime');
  $app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);
}

$app->notFound(function () use ($app) {
  $app->view()->set_template('layouts/basic.php');
  $app->render('404.php');
});

$app->error(function (\Exception $e) use ($app) {
  $app->view()->set_template('layouts/basic.php');
  $app->render('error.php', array('message' => $e->getMessage()));
});

// Hooks
require BASE_URI . DS . 'routes' . DS . 'hooks' . DS . 'slim.before.php';

// Middlewares
$require_ssl = require BASE_URI . DS . 'routes' . DS . 'middlewares' . DS . 'require_ssl.php';
$authenticate = require BASE_URI . DS . 'routes' . DS . 'middlewares' . DS . 'authenticate.php';

// Routes
require BASE_URI . DS . 'routes' . DS . 'index.php';
require BASE_URI . DS . 'routes' . DS . 'products.php';
require BASE_URI . DS . 'routes' . DS . 'shop.php';
require BASE_URI . DS . 'routes' . DS . 'session.php';
require BASE_URI . DS . 'routes' . DS . 'users.php';

$app->run();


