<?php

function validate(&$data) {
  $v = new \Valitron\Validator($data);
  if (!empty($data['first_name'])) {
    $v->rule('regex', 'first_name', '/^[A-Z \'.-]{2,30}$/i');
  }
  if (!empty($data['last_name'])) {
    $v->rule('regex', 'last_name', '/^[A-Z \'.-]{2,40}$/i');
  }
  if (!empty($data['address1'])) {
    $v->rule('regex', 'address1', '/^[A-Z0-9 \',.#-]{2,80}$/i');
  }
  if (!empty($data['address2'])) {
    $v->rule('regex', 'address2', '/^[A-Z0-9 \',.#-]{2,80}$/i');
  }
  if (!empty($data['city'])) {
    $v->rule('regex', 'city', '/^[A-Z \'.-]{2,60}$/i');
  }
  if (!empty($data['zip_code'])) {
    $v->rule('regex', 'zip_code', '/^(\d{5}$)|(^\d{5}-\d{4})$/');
  }
  if (!empty($data['phone'])) {
    $v->rule('regex', 'phone', '/\(?\d{3}\)?[-\s.]?\d{3}[-\s.]\d{4}/x');
  }
  if (!empty($data['state'])) {
    $v->rule('regex', 'state', '/^[A-Z]{2}$/');
    $v->rule('max', 'state', 2);
  }

  if($v->validate()) {
    return null;
  } else {
    return $v->errors();
  }
}
