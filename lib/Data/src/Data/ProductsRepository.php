<?php

namespace Data;

class ProductsRepository {
  public static function get_total_records($db) {
    $query = 'SELECT FOUND_ROWS() AS rows';
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetch();
  }

  public static function get_product_attributes($db, $product_id) {
    $query = '
      SELECT
        a.name AS name, av.id, av.value AS value
      FROM attribute_value av
      INNER JOIN attribute a
        ON av.attribute_id = a.id
      WHERE av.id IN
        (SELECT attribute_value_id
           FROM product_attribute
          WHERE product_id = :product_id)
      ORDER BY a.name;
    ';

    $stmt = $db->prepare($query);
    $stmt->execute(array('product_id' => $product_id));
    return $stmt->fetchAll();
  }

  public static function get_category($db, $pid) {
    $query = '
      SELECT c.name AS category_name
      FROM categories c
      INNER JOIN products p
       ON p.category_id = c.id AND p.id = :pid
      LIMIT 1;
    ';

    $stmt = $db->prepare($query);
    $stmt->execute(array('pid' => $pid));
    $category = $stmt->fetch();
    return $category['category_name'];
  }

  public static function get_products_by_category($db, $category, $pagination, $records_per_page) {
    if ($category == 'kits') {
      $query = '
          SELECT
            SQL_CALC_FOUND_ROWS
            c.name AS cname, c.description AS cdesc,
            p.id, p.name, p.description, p.image, p.stock,
            p.price, sales.price AS sale_price,
            IF(DATEDIFF(NOW(), p.created) < 30, true, false) as is_new,
            1 AS has_attributes
          FROM products p
          INNER JOIN categories c
            ON p.category_id = c.id AND c.name = :category
          INNER JOIN sales
            ON (sales.product_id = p.id
              AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
              OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
          WHERE p.stock>0
          ORDER BY p.name ASC
          LIMIT
            ' . (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page . '
      ';
    } else {
      $query = '
          SELECT
            SQL_CALC_FOUND_ROWS
            c.name AS cname, c.description AS cdesc,
            p.id, p.name, p.description, p.image, p.stock,
            p.price, sales.price AS sale_price,
            IF(DATEDIFF(NOW(), p.created) < 30, true, false) as is_new,
            IF(pa.product_id IS NULL, 0, 1) AS has_attributes
          FROM products p
          INNER JOIN categories c
            ON p.category_id = c.id AND c.name = :category
          INNER JOIN sales
            ON (sales.product_id = p.id
              AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
              OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
          LEFT OUTER JOIN product_attribute pa
            ON p.id = pa.product_id
          WHERE p.stock>0
          GROUP BY p.id
          ORDER BY p.name ASC
          LIMIT
            ' . (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page . '
      ';
    }

    $stmt = $db->prepare($query);
    $stmt->execute(array('category' => $category));
    return $stmt->fetchAll();
  }

  public static function get_product($db, $category, $id) {
    if ($category == 'kits') {
      $query = '
        SELECT
          p.id, p.name, p.description, p.image, p.stock,
          p.price, sales.price AS sale_price,
          IF(DATEDIFF(NOW(), p.created) < 30, true, false) as is_new,
          1 AS has_attributes
        FROM products p
        INNER JOIN sales
          ON (sales.product_id=p.id
            AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
            OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
        WHERE p.stock>0 AND p.id=:id
        LIMIT 1;
      ';
    } else {
      $query = '
        SELECT
          p.id, p.name, p.description, p.image, p.stock,
          p.price, sales.price AS sale_price,
          IF(DATEDIFF(NOW(), p.created) < 30, true, false) as is_new,
          IF(pa.product_id IS NULL, 0, 1) AS has_attributes
        FROM products p
        INNER JOIN sales
          ON (sales.product_id=p.id
            AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
            OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
        LEFT OUTER JOIN product_attribute pa
          ON p.id = pa.product_id
        WHERE p.stock>0 AND p.id=:id
        GROUP BY p.id
        LIMIT 1;
      ';
    }

    $stmt = $db->prepare($query);
    $stmt->execute(array('id' => $id));
    return $stmt->fetch();
  }

  public static function get_kit_products($db, $id) {
    $query = '
      SELECT
        p2.id, p2.name, p2.description, p2.image, p2.stock,
        p2.price, sales.price AS sale_price, ak.quantity as quantity,
        IF(DATEDIFF(NOW(), p2.created) < 30, true, false) as is_new,
        IF(pa.product_id IS NULL, 0, 1) AS has_attributes
      FROM products p1
      INNER JOIN accessories_kits AS ak
        ON p1.id=ak.kit_id
      INNER JOIN products p2
        ON ak.accessory_id = p2.id
      INNER JOIN sales
        ON (sales.product_id=p2.id
          AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
          OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
      LEFT OUTER JOIN product_attribute pa
        ON p2.id = pa.product_id
      WHERE p1.id = :id
      GROUP BY p2.id

      UNION

      SELECT
        p2.id, p2.name, p2.description, p2.image, p2.stock,
        p2.price, sales.price AS sale_price, ek.quantity as quantity,
        IF(DATEDIFF(NOW(), p2.created) < 30, true, false) as is_new,
        IF(pa.product_id IS NULL, 0, 1) AS has_attributes
      FROM products p1
      INNER JOIN eliquids_kits AS ek
        ON p1.id=ek.kit_id
      INNER JOIN products p2
        ON ek.eliquid_id = p2.id
      INNER JOIN sales
        ON (sales.product_id=p2.id
          AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
          OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
      LEFT OUTER JOIN product_attribute pa
        ON p2.id = pa.product_id
      WHERE p1.id = :id
      GROUP BY p2.id
    ';

    $stmt = $db->prepare($query);
    $stmt->execute(array('id' => $id));
    $products = $stmt->fetchAll();
    if ($products) {
      foreach ($products as &$p) {
        if ($p['has_attributes'] == 1) {
          $p['attributes'] = \Data\ProductsRepository::get_product_attributes($db, $p['id']);
        } else {
          $p['attributes'] = null;
        }
      }
    }
    return $products;
  }

  public static function get_recommended_products($db, $ids) {
    $query = '
      SELECT
        c.name AS cname,
        p.id, p.name, p.description, p.image, p.stock,
        p.price, sales.price AS sale_price,
        IF(DATEDIFF(NOW(), p.created) < 30, true, false) as is_new
      FROM order_contents AS oc1
      JOIN order_contents AS oc2
        ON oc1.order_id=oc2.order_id
      JOIN products AS p
        ON p.id=oc2.product_id
      INNER JOIN categories c
        ON p.category_id = c.id
      INNER JOIN sales
        ON (sales.product_id = p.id
          AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
          OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
      WHERE p.stock > 0 AND oc1.product_id IN (:ids) AND oc2.product_id NOT IN (:ids)
      GROUP BY oc2.product_id
      ORDER BY COUNT(oc2.product_id) DESC, RAND()
      LIMIT 4;
    ';

    $stmt = $db->prepare($query);
    $stmt->execute(array('ids' => $ids));
    return $stmt->fetchAll();
  }

  public static function get_random_products($db) {
    $query = '
      SELECT
        c.name AS cname,
        p.id, p.name, p.description, p.image, p.stock,
        p.price, sales.price AS sale_price,
        IF(DATEDIFF(NOW(), p.created) < 30, true, false) as is_new,
        IF(pa.product_id IS NULL, 0, 1) AS has_attributes
      FROM products p
      INNER JOIN categories c
        ON p.category_id = c.id
      INNER JOIN sales
        ON (sales.product_id = p.id
          AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
          OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
      LEFT OUTER JOIN product_attribute pa
        ON p.id = pa.product_id
      WHERE p.stock>0
      GROUP BY p.id
      ORDER BY RAND()
      LIMIT 6;
    ';

    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public static function get_new_arrival($db) {
    $query = '
      SELECT
        c.name AS cname,
        p.id, p.name, p.description, p.image, p.stock,
        p.price, sales.price AS sale_price,
        IF(DATEDIFF(NOW(), p.created) < 30, true, false) as is_new,
        IF(pa.product_id IS NULL, 0, 1) AS has_attributes
      FROM products p
      INNER JOIN categories c
        ON p.category_id = c.id
      INNER JOIN sales
        ON (sales.product_id = p.id
          AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
          OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
      LEFT OUTER JOIN product_attribute pa
        ON p.id = pa.product_id
      WHERE p.stock>0 AND DATEDIFF(NOW(), p.created) < 30
      GROUP BY p.id
      ORDER BY RAND()
      LIMIT 6;
    ';

    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public static function get_best_sellers($db) {
    $query = '
      SELECT
        c.name AS cname,
        p.id, p.name, p.description, p.image, p.stock,
        p.price, sales.price AS sale_price,
        IF(DATEDIFF(NOW(), p.created) < 30, true, false) as is_new
      FROM order_contents AS oc
      JOIN products AS p
        ON p.id=oc.product_id
      INNER JOIN categories c
        ON p.category_id = c.id
      INNER JOIN sales
        ON (sales.product_id = p.id
          AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
          OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
      WHERE p.stock > 0
      GROUP BY oc.product_id
      ORDER BY COUNT(oc.product_id) DESC
      LIMIT 3;
    ';

    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public static function search($db, $words, $all_words, $pagination, $records_per_page) {
    if ($all_words) {
      $query = '
        SELECT
           SQL_CALC_FOUND_ROWS
           c.name AS cname, c.description AS cdesc,
           p.id, p.name, p.description, p.image, p.stock,
           p.price, sales.price AS sale_price,
           IF(DATEDIFF(NOW(), p.created) < 30, true, false) as is_new,
           IF(pa.product_id IS NULL, 0, 1) AS has_attributes
         FROM products p
         INNER JOIN categories c
           ON p.category_id = c.id
         INNER JOIN sales
           ON (sales.product_id = p.id
             AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
             OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
         LEFT OUTER JOIN product_attribute pa
           ON p.id = pa.product_id
         WHERE p.stock>0 AND MATCH (p.name, p.description) AGAINST (:words IN BOOLEAN MODE)
         GROUP BY p.id
         ORDER BY MATCH (p.name, p.description) AGAINST (:words IN BOOLEAN MODE) DESC
         LIMIT
           ' . (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page . '
      ';
    } else {
      $query = '
        SELECT
           SQL_CALC_FOUND_ROWS
           c.name AS cname, c.description AS cdesc,
           p.id, p.name, p.description, p.image, p.stock,
           p.price, sales.price AS sale_price,
           IF(DATEDIFF(NOW(), p.created) < 30, true, false) as is_new,
           IF(pa.product_id IS NULL, 0, 1) AS has_attributes
         FROM products p
         INNER JOIN categories c
           ON p.category_id = c.id
         INNER JOIN sales
           ON (sales.product_id = p.id
             AND ((NOW() BETWEEN sales.start_date AND sales.end_date)
             OR (NOW() > sales.start_date AND sales.end_date IS NULL)))
         LEFT OUTER JOIN product_attribute pa
           ON p.id = pa.product_id
         WHERE p.stock>0 AND MATCH (p.name, p.description) AGAINST (:words)
         GROUP BY p.id
         ORDER BY MATCH (p.name, p.description) AGAINST (:words) DESC
         LIMIT
           ' . (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page . '
      ';
    }

    $stmt = $db->prepare($query);
    $stmt->execute(array('words' => $words));
    return $stmt->fetchAll();
  }

  public static function review_product($db, $pid, $rating, $review, $name, $email) {
    $query = 'INSERT INTO reviews (product_id, rating, review, reviewer_name, reviewer_email) VALUES (:pid, :rating, :review, :name, :email);';

    $stmt = $db->prepare($query);
    $stmt->execute(array('pid' => $pid, 'rating' => $rating, 'review' => $review, 'name' => $name, 'email' => $email));

    if ($stmt->rowCount() == 1) {
      return true;
    } else {
      return false;
    }
  }

  public static function get_review($db, $pid, $page_number=0) {
    $position = ($page_number * 2);
    $query = '
      SELECT
        SQL_CALC_FOUND_ROWS
        r.id, r.review, r.reviewer_name, r.review_date
      FROM reviews r
      WHERE r.product_id = :pid
      ORDER BY r.review_date DESC
      LIMIT
        ' . $position . ', ' . 2 . '
    ';

    $stmt = $db->prepare($query);
    $stmt->execute(array('pid' => $pid));
    return $stmt->fetchAll();
  }

  public static function get_rating($db, $pid) {
    $query = 'SELECT ROUND(AVG(rating)) AS rating FROM reviews WHERE product_id=:pid';

    $stmt = $db->prepare($query);
    $stmt->execute(array('pid' => $pid));
    return $stmt->fetch();
  }

  public static function update_stock($db, $cart) {
    $query = 'UPDATE products SET stock=stock-:qty WHERE id=:pid';
    $qty = $pid = 0;
    $stmt = $db->prepare($query);
    $stmt->bindParam(':qty', $qty);
    $stmt->bindParam(':pid', $pid);
    foreach ($cart['cart_items'] as $row) {
      $qty = $row['quantity'];
      $pid = $row['id'];
      $stmt->execute();
    }
  }
}
