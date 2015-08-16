<?php

return array(
  // app base url, this is the document_root
  'base_url' => 'http://localhost/wildvapor/public/',

  // if the app is live or in development
  'live' => false,

  // Email Configuration for sending mails
  'mail_from' => 'wildvaporinc@gmail.com',
  'mail_username' => 'wildvaporinc@gmail.com',
  'mail_password' => 'temporal1',

  // Database Configuration
  'db_host' => 'localhost',
  'db_name' => 'wildvapor',
  'db_username' => 'root',
  'db_password' => '',

  // pagination
  'records_per_page' => 10,

  // languages
  'languages' => array('en'),

  // Products for sale
  'products' => array('accessories', 'eliquids', 'kits'),

  // PayPal
  'paypal.version' => '98.0',
  'paypal.environment' => 'sandbox', // change to live
  'paypal.username' => 'wildvaporinc-facilitator_api1.gmail.com',
  'paypal.password' => '1374513219',
  'paypal.signature' => 'AGOPJbHHU7ZITfuS-vIm3yxR4LHMARJQBnzcZ-HkFUrEFuIlBG9EHRzM',
  'paypal.payment.type' => 'Sale', // or Authorization
  'paypal.currency' => 'USD', // GBP, EUR, JPY, CAD, AUD
);
