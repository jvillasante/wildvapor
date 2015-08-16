<?php

namespace Data;

class UserRepository {
  public static function get_user_by_id($db, $id) {
    $query = 'SELECT first_name, last_name, email, username, phone, address1, address2, city, zip_code, country, state FROM users WHERE id = :id';

    $stmt = $db->prepare($query);
    $stmt->execute(array('id' => $id));
    return $stmt->fetch();
  }

  public static function get_user_by_email_or_username($db, $email, $username) {
    $query = 'SELECT email, username FROM users WHERE email = :email OR username = :username';

    $stmt = $db->prepare($query);
    $stmt->execute(array('email' => $email, 'username' => $username));
    return $stmt->fetch();
  }

  public static function get_user_by_email_and_password($db, $email, $password) {
    $query = 'SELECT id, username, type FROM users WHERE email = :email AND password = :password';

    $stmt = $db->prepare($query);
    $stmt->execute(array('email' => $email, 'password' => \Helpers\User::create_password_hash($password)));
    $user = $stmt->fetch();
    return ($user) ? $user : NULL;
  }

  public static function get_user_by_email($db, $email) {
    $query = 'SELECT id, first_name, last_name, username, email FROM users WHERE email = :email';

    $stmt = $db->prepare($query);
    $stmt->execute(array('email' => $email));
    $user = $stmt->fetch();
    return ($user) ? $user : NULL;
  }

  public static function get_user_by_password($db, $password) {
    $query = 'SELECT id FROM users WHERE password = :password AND id = :id';

    $stmt = $db->prepare($query);
    $stmt->execute(array('password' => \Helpers\User::create_password_hash($password), 'id' => $_SESSION['user_id']));
    $user = $stmt->fetch();
    return ($user) ? $user : NULL;
  }

  public static function update_password($db, $password, $id) {
    $query = 'UPDATE users SET password = :password WHERE id = :id LIMIT 1';

    $stmt = $db->prepare($query);
    $stmt->execute(array('password' => \Helpers\User::create_password_hash($password), 'id' => $id));
    return ($stmt->rowCount() == 1) ? true : false;
  }

  public static function update_user($db, $data, $id) {
    $query = '
      UPDATE users
      SET first_name=:first_name, last_name=:last_name, phone=:phone,
        address1=:address1, address2=:address2, city=:city, zip_code=:zip_code,
        state=:state, modified=NOW()
      WHERE id=' . $id . ';
    ';

    $stmt = $db->prepare($query);
    $stmt->execute($data);
    return ($stmt->rowCount() == 1) ? true : false;
  }

  public static function update_user_address($db, $id, $address1, $address2, $city, $state, $zip_code) {
    $query = '
      UPDATE users
      SET address1=:address1, address2=:address2, city=:city, state=:state,
        zip_code=:zip_code, modified=NOW()
      WHERE id=:id;
    ';

    $stmt = $db->prepare($query);
    $stmt->execute(array(
      'address1' => $address1,
      'address2' => $address2,
      'city' => $city,
      'state' => $state,
      'zip_code' => $zip_code,
      'id' => $id,
    ));
    return ($stmt->rowCount() == 1) ? true : false;
  }

  public static function insert($db, $data) {
    $query = 'INSERT INTO users (id, first_name, last_name, email, username, type, password, phone, address1, address2, city,
      zip_code, country, state, created, modified) VALUES (:id, :first_name, :last_name, :email, :username, :type, :password,
      :phone, :address1, :address2, :city, :zip_code, :country, :state, NOW(), NOW())';

    $stmt = $db->prepare($query);
    $stmt->execute(array(
      'id'         => $data['id'],
      'first_name' => $data['first_name'],
      'last_name'  => $data['last_name'],
      'email'      => $data['email'],
      'username'   => $data['username'],
      'type'       => 'member',
      'password'   => \Helpers\User::create_password_hash($data['password']),
      'phone'      => $data['phone'] ? $data['phone'] : NULL,
      'address1'   => $data['address1'] ? $data['address1'] : NULL,
      'address2'   => $data['address2'] ? $data['address2'] : NULL,
      'city'       => $data['city'] ? $data['city'] : NULL,
      'zip_code'   => $data['zip_code'] ? $data['zip_code'] : NULL,
      'country'    => $data['country'] ? $data['country'] : NULL,
      'state'      => $data['state'] ? $data['state'] : NULL,
    ));

    return $stmt;
  }
}
