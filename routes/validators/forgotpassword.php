<?php

function validate($data) {
  $v = new \Valitron\Validator($data);
  $v->rule('required', 'email')->message('Email is required');
  $v->rule('email', 'email')->message('Email Address is not a valid email address.');

  if($v->validate()) {
    return null;
  } else {
    return $v->errors();
  }
}
