<?php

namespace Data;

class TransactionRepository {
  public static function add_transaction($db, $oid, $trans_type, $amt, $rc, $rrc, $tid, $r) {
    $query = 'INSERT INTO transactions
      VALUES (NULL, :oid, :trans_type, :amt, :rc, :rrc, :tid, :r, NOW());';
    $stmt = $db->query($query, array(
      'oid' => $oid, 'trans_type' => $trans_type, 'amt' => $amt,
      'rc' => $rc, 'rrc' => $rrc, 'tid' => $tid, 'r' => $r
    ));
    return $stmt;
  }
}
