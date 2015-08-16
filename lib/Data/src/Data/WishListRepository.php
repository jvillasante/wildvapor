<?php

namespace Data;

class WishListRepository {
  public static function add_to_wish_list($db, $uid, $pid, $qty, $attributes) {
    if ($attributes == NULL) {
      $query = 'UPDATE wishlists SET quantity=quantity+:qty, date_modified=NOW()
        WHERE user_id=:uid AND product_id=:pid AND attributes IS NULL;';
    } else {
      $query = 'UPDATE wishlists SET quantity=quantity+:qty, date_modified=NOW()
        WHERE user_id=:uid AND product_id=:pid AND attributes=:attributes;';
    }

    $stmt = $db->prepare($query);
    if ($attributes == NULL) {
      $stmt->execute(array('uid' => $uid, 'pid' => $pid, 'qty' => $qty));
    } else {
      $stmt->execute(array('uid' => $uid, 'pid' => $pid, 'qty' => $qty, 'attributes' => $attributes));
    }

    if ($stmt->rowCount() == 0) {
      $query = 'INSERT INTO wishlists (user_id, product_id, quantity, attributes, date_created)
        VALUES (:uid, :pid, :qty, :attributes, NOW());';

      $stmt = $db->prepare($query);
      $stmt->execute(array('uid' => $uid, 'pid' => $pid, 'qty' => $qty, 'attributes' => $attributes));
    }

    return $stmt;
  }

  public static function update_wish_list($db, $uid, $pid, $qty, $attributes) {
    if ($qty > 0) {
      if ($attributes == NULL) {
        $query  = 'UPDATE wishlists SET quantity=:qty, date_modified=NOW()
          WHERE user_id=:uid AND product_id=:pid AND attributes IS NULL;';
      } else {
        $query  = 'UPDATE wishlists SET quantity=:qty, date_modified=NOW()
          WHERE user_id=:uid AND product_id=:pid AND attributes=:attributes;';
      }

      $stmt = $db->prepare($query);
      if ($attributes == NULL) {
        $stmt->execute(array('uid' => $uid, 'pid' => $pid, 'qty' => $qty));
      } else {
        $stmt->execute(array('uid' => $uid, 'pid' => $pid, 'qty' => $qty, 'attributes' => $attributes));
      }
      return $stmt;
    } elseif ($qty == 0) {
      return \Data\WishListRepository::remove_from_wish_list($db, $uid, $pid, $attributes);
    }
  }

  public static function remove_from_wish_list($db, $uid, $pid, $attributes) {
    if ($attributes == NULL) {
      $query = 'DELETE FROM wishlists WHERE user_id=:uid AND product_id=:pid AND attributes IS NULL;';
    } else {
      $query = 'DELETE FROM wishlists WHERE user_id=:uid AND product_id=:pid AND attributes=:attributes;';
    }

    $stmt = $db->prepare($query);
    if ($attributes == NULL) {
      $stmt->execute(array('uid' => $uid, 'pid' => $pid));
    } else {
      $stmt->execute(array('uid' => $uid, 'pid' => $pid, 'attributes' => $attributes));
    }
    return $stmt;
  }

  public static function clear_wish_list($db, $uid) {
    $query = 'DELETE FROM wishlists WHERE user_id=:uid';

    $stmt = $db->prepare($query);
    $stmt->execute(array('uid' => $uid));
    return $stmt;
  }

  public static function get_wish_list_contents($db, $uid) {
    $query = '
      SELECT
        cat.name AS cname,
        p.id, c.quantity, c.attributes, p.image,
        IF (c.attributes IS NULL, p.name, CONCAT(p.name, " (", c.attributes, ")")) AS name,
        p.price, p.stock, sales.price as sale_price

      FROM wishlists c
      INNER JOIN products p
          ON c.product_id = p.id
      INNER JOIN categories cat
          ON cat.id = p.category_id
      INNER JOIN sales
          ON (sales.product_id=p.id
          AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
          OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
      WHERE c.user_id=:uid

    ';

    $stmt = $db->prepare($query);
    $stmt->execute(array('uid' => $uid));
    return $stmt->fetchAll();
  }
}
