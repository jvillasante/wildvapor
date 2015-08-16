<?php

function validate($data) {
  $v = new \Valitron\Validator($data);
  $v->rule('required', 'name')->message('Your Name is required.');
  $v->rule('required', 'email')->message('Your Email is required.');
  $v->rule('required', 'rating')->message('Your Rating is required.');
  $v->rule('required', 'message')->message('Your Review is required.');
  $v->rule('email', 'email')->message('Email Address is not a valid email address.');
  $v->rule('max', 'email', 80)->message('Email Address must be less than 80 characters.');
  $v->rule('integer', 'rating')->message('Your rating must be a number');
  $v->rule('min', 'rating', 1)->message('Your rating min value must be 1');
  $v->rule('max', 'rating', 5)->message('Your rating max value must be 5');

  if($v->validate()) {
    return null;
  } else {
    return $v->errors();
  }
}
