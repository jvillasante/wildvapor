<?php

function validate($data) {
  $v = new \Valitron\Validator($data);
  $v->rule('required', 'password')->message('Password is required.');
  $v->rule('required', 'new_password')->message('New Password is required.');
  $v->rule('required', 'new_password_confirmation')->message('New Password Confirmation is required.');
  $v->rule('regex', 'new_password', '/^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W]*)\S*$/')->message('New Password contains invalid characters.');
  $v->rule('equals', 'new_password_confirmation', 'new_password')->message('New Password Confirmation must match with New Password');

  if($v->validate()) {
    return null;
  } else {
    return $v->errors();
  }
}
