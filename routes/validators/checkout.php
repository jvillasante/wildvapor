<?php

function validate(&$data) {
  $v = new \Valitron\Validator($data);

  // required
  $v->rule('required', 'first_name')->message('First Name is required.');
  $v->rule('required', 'last_name')->message('Last Name is required.');
  $v->rule('required', 'email')->message('Email Addres is required.');
  $v->rule('required', 'phone')->message('Phone Number is required.');
  $v->rule('required', 'shipping_address1')->message('Shipping Address1 is required.');
  $v->rule('required', 'shipping_city')->message('Shipping City is required.');
  $v->rule('required', 'shipping_state')->message('Shipping State is required.');
  $v->rule('required', 'shipping_zip_code')->message('Shipping Zip Code is required.');
  $v->rule('required', 'cc_number')->message('Credit Card Number is required.');
  $v->rule('required', 'cc_exp_month')->message('Credit Card Expiration Month is required.');
  $v->rule('required', 'cc_exp_year')->message('Credit Card Expiration Year is required.');
  $v->rule('required', 'cc_cvv')->message('Credit Card CVV is required.');

  // personal
  $v->rule('regex', 'first_name', '/^[A-Z \'.-]{2,30}$/i')->message('First Name contains invalid characters.');
  $v->rule('regex', 'last_name', '/^[A-Z \'.-]{2,40}$/i')->message('Last Name contains invalid characters.');
  $v->rule('email', 'email')->message('Email Address is not a valid email address.');
  $v->rule('max', 'email', 80)->message('Email Address must be less than 80 characters.');
  $v->rule('regex', 'phone', '/\(?\d{3}\)?[-\s.]?\d{3}[-\s.]\d{4}/x')->message('Phone Number contains invalid characters.');
  // $v->rule('regex', 'phone', '/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/')->message('Phone Number contains invalid characters.');

  // shipping
  $v->rule('regex', 'shipping_address1', '/^[A-Z0-9 \',.#-]{2,80}$/i')->message('Shipping Address1 contains invalid characters.');
  if (!empty($data['shipping_address2'])) {
    $v->rule('regex', 'shipping_address2', '/^[A-Z0-9 \',.#-]{2,80}$/i')->message('Shipping Address2 contains invalid characters.');
  }
  $v->rule('regex', 'shipping_city', '/^[A-Z \'.-]{2,60}$/i')->message('Shipping City contains invalid characters.');
  $v->rule('regex', 'shipping_state', '/^[A-Z]{2}$/')->message('Shipping State contains invalid characters.');
  $v->rule('regex', 'shipping_zip_code', '/^(\d{5}$)|(^\d{5}-\d{4})$/')->message('Shipping Zip Code contains invalid characters.');

  // billing
  $data['cc_number'] = str_replace(array(' ', '-'), '', $data['cc_number']);

  \Valitron\Validator::addRule('creditCard', function($field, $value, array $params) {
    if (!preg_match ('/^4[0-9]{12}(?:[0-9]{3})?$/', $value) // Visa
      && !preg_match ('/^5[1-5][0-9]{14}$/', $value) // MasterCard
      && !preg_match ('/^3[47][0-9]{13}$/', $value) // American Express
      && !preg_match ('/^6(?:011|5[0-9]{2})[0-9]{12}$/', $value) // Discover
    ) {
      return false;
    } else {
      return true;
    }
  }, 'Credit Card Number contains invalid characters.');

  \Valitron\Validator::addRule('expirationYear', function($field, $value, array $params) {
    if ($value < date('Y')) {
      return false;
    } else {
      return true;
    }
  }, 'Credit Card Expiration Year must be a date after ' . date('Y') . '.');

  $v->rule('creditCard', 'cc_number')->message('Credit Card Number contains invalid characters.');
  $v->rule('min', 'cc_exp_month', 1)->message('Credit Card Expiration Month must be greater than 1.');
  $v->rule('max', 'cc_exp_month', 12)->message('Credit Card Expiration Month must be less than 12.');
  $v->rule('expirationYear', 'cc_exp_year')->message('Credit Card Expiration Year must be a date after ' . date('Y'));
  $v->rule('regex', 'cc_cvv', '/^[0-9]{3,4}$/')->message('Credit Card CVV contains invalid characters.');
  if (empty($data['use_same_address'])) {
    $v->rule('required', 'billing_address1')->message('Billing Address1 is required.');
    $v->rule('required', 'billing_city')->message('Billing City is required.');
    $v->rule('required', 'billing_state')->message('Billing State is required.');
    $v->rule('required', 'billing_zip_code')->message('Billing Zip Code is required.');
    $v->rule('regex', 'billing_address1', '/^[A-Z0-9 \',.#-]{2,80}$/i')->message('Billing Address1 contains invalid characters.');
    if (!empty($data['billing_address2'])) {
      $v->rule('regex', 'billing_address2', '/^[A-Z0-9 \',.#-]{2,80}$/i')->message('Billing Address2 contains invalid characters.');
    }
    $v->rule('regex', 'billing_city', '/^[A-Z \'.-]{2,60}$/i')->message('Billing City contains invalid characters.');
    $v->rule('regex', 'billing_state', '/^[A-Z]{2}$/')->message('Billing State contains invalid characters.');
    $v->rule('regex', 'billing_zip_code', '/^(\d{5}$)|(^\d{5}-\d{4})$/')->message('Billing Zip Code contains invalid characters.');
  }

  if($v->validate()) {
    return null;
  } else {
    return $v->errors();
  }
}

