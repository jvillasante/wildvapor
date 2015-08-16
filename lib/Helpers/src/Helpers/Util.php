<?php

namespace Helpers;

class Util {
  public static function get_price($regular, $sales) {
    if ((0 < $sales) && ($sales < $regular)) {
      return '<span class="price"><small>$'.$regular.'</small>&nbsp;&nbsp; $'.$sales.'</span>';
    } else {
      return '<span class="price">$'.$regular.'</span>';
    }
  }

  public static function get_price_homepage($regular, $sales) {
    if ((0 < $sales) && ($sales < $regular)) {
      return '<small class="sale">$'.$regular.'</small>'. '  ' . '<small>$'.$sales.'</small>';
    } else {
      return '<small>$'.$regular.'</small>';
    }
  }

  public static function get_stock_status($stock) {
    if ($stock > 5) { // Plenty!
      return 'In Stock';
    } elseif ($stock > 0) { // Low!
      return 'Low Stock';
    } else { // Out!
      return 'Currently Out of Stock';
    }
  }

  public static function get_just_price($regular, $sales) {
    if ((0 < $sales) && ($sales < $regular)) {
      return number_format($sales, 2);
    } else {
      return number_format($regular, 2);
    }
  }

  public static function parse_cart_items($cart_items) {
    $subtotal = 0;
    $messages = array();
    $ids = array();
    foreach ($cart_items as $row) {
      $ids []= $row['id'];
      $price = \Helpers\Util::get_just_price($row['price'], $row['sale_price']);
      $subtotal += $price * $row['quantity'];

      if ($row['stock'] < $row['quantity']) {
        $message = 'There are only '.$row['stock'].' left in stock of '.$row['name'].'. Please update the quantity, remove the item entirely, or move it to your wish list.';
        array_push($messages, $message);
      }
    }

    $count = count($cart_items);
    $tax = $subtotal * 0.07;  // tax = 7%
    $total = $subtotal + $tax;

    return array(
      'messages' => $messages,
      'count' => $count,
      'subtotal' => $subtotal,
      'total' => $total,
      'tax' => $tax,
      'ids' => implode(',', $ids),
      'cart_items' => $cart_items
    );
  }

  public static function parse_wish_list_items($wish_list_items) {
    $subtotal = 0;
    $ids = array();
    foreach ($wish_list_items as $row) {
      $ids []= $row['id'];
      $price = \Helpers\Util::get_just_price($row['price'], $row['sale_price']);
      $subtotal += $price * $row['quantity'];
    }

    $count = count($wish_list_items);
    $tax = $subtotal * 0.07;  // tax = 7%
    $total = $subtotal + $tax;

    return array(
      'count' => $count,
      'subtotal' => $subtotal,
      'total' => $total,
      'tax' => $tax,
      'ids' => implode(',', $ids),
      'wish_list_items' => $wish_list_items
    );
  }

  public static function safe_truncate($string, $length, $append = '...') {
    $ret = substr($string, 0, $length);
    $last_space = strrpos($ret, ' ');

    if ($last_space !== FALSE && $string != $ret) {
      $ret = substr($ret, 0, $last_space);
    }

    if ($ret != $string) {
      $ret .= $append;
    }

    return $ret;
  }

  public static function dd($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit;
  }

}
