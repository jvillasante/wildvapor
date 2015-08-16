<?php

namespace Data;

class OrderRepository {
  public static function add_order($db, $uid, $total, $tax) {
    $oid = NULL;

    $db->beginTransaction();
    try {
      $query = 'INSERT INTO orders (user_id, total, tax, order_date)
        VALUES (:uid, :total, :tax, NOW());';

      $stmt = $db->prepare($query);
      $stmt->execute(array('uid' => $uid, 'total' => $total, 'tax' => $tax));
      $oid = $db->lastInsertId();

      $query = '
        INSERT INTO order_contents (order_id, product_id, quantity, price_per, attributes)
        SELECT
          :oid, c.product_id, c.quantity, IFNULL(sales.price, p.price), c.attributes
        FROM carts AS c
        INNER JOIN products p
            ON c.product_id=p.id
        INNER JOIN sales
            ON (sales.product_id=p.id
            AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
            OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
        WHERE c.user_id=:uid
      ';
      $stmt = $db->prepare($query);
      $stmt->execute(array('oid' => $oid, 'uid' => $uid));

      $db->commit();
      return $oid;
    } catch (\Exception $e) {
      $db->rollBack();
      return NULL;
    }
  }

  public static function get_order_contents($db, $oid) {
    $query = '
      SELECT
        cat.name AS cname,
        p.id, oc.quantity, oc.price_per, (oc.quantity*oc.price_per) AS subtotal,
        IF (oc.attributes IS NULL, p.name, CONCAT(p.name, " (", oc.attributes, ")")) AS name,
        o.total, o.tax, p.image as image, oc.ship_date as ship_date
      FROM order_contents AS oc
      INNER JOIN products AS p
        ON oc.product_id=p.id
      INNER JOIN categories cat
          ON cat.id = p.category_id
      INNER JOIN orders AS o
        ON oc.order_id=o.id
      WHERE oc.order_id=:oid
    ';

    $stmt = $db->prepare($query);
    $stmt->execute(array('oid' => $oid));
    return $stmt->fetchAll();
  }

  public static function get_orders_by_user_id($db, $uid) {
    $query = '
      SELECT id, total, tax, order_date as date
      FROM orders WHERE user_id = :user_id
      ORDER BY date;
    ';

    $stmt = $db->prepare($query);
    $stmt->execute(array('user_id' => $uid));
    return $stmt->fetchAll();
  }
}
