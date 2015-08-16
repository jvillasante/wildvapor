<?php

namespace Helpers;

class User {
  public static function create_password_hash($password) {
    return hash_hmac('sha256', $password, 'c#haRI891', false);
  }

  public static function is_logged_in() {
    return (isset($_SESSION['user_id'], $_SESSION['logged_in'])) ? true : false;
  }

  public static function is_admin() {
    return (isset($_SESSION['admin'])) ? true : false;
  }

  public static function username() {
    $username = 'guest';
    if (\Helpers\User::is_logged_in() && isset($_SESSION['username'])) {
      $username = $_SESSION['username'];
    }
    return $username;
  }

  public static function uid() {
    return md5(uniqid('biped', true));
  }

  public static function user_id() {
    if (\Helpers\User::is_logged_in()) {
      return $_SESSION['user_id'];
    } else {
      $uid = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
      if (!$uid) {
        $uid = \Helpers\User::uid();
        $_SESSION['user_id'] = $uid;
      }
      return $uid;
    }
  }

  public static function get_name($user) {
    if (!empty($user['first_name']) && !empty($user['last_name'])) {
      $name = $user['first_name'] . ' ' . $user['last_name'];
    } else {
      $name = $user['username'];
    }

    return $name;
  }

  public static function copy_user_to_flash($user) {
    $data = array();
    $data['first_name'] = $user['first_name'];
    $data['last_name'] = $user['last_name'];
    $data['email'] = $user['email'];
    $data['phone'] = $user['phone'];
    $data['shipping_address1'] = $user['address1'];
    $data['shipping_address2'] = $user['address2'];
    $data['shipping_city'] = $user['city'];
    $data['shipping_state'] = $user['state'];
    $data['shipping_zip_code'] = $user['zip_code'];
    $_SESSION['slim.flash']['data'] = $data;
  }
}
