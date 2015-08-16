<?php

function validate($data) {
  $v = new \Valitron\Validator($data);
  $v->rule('required', ['name', 'email', 'message']);
  $v->rule('email', 'email');
  $v->rule('max', 'email', 80);

  if($v->validate()) {
    return null;
  } else {
    return $v->errors();
  }
}
