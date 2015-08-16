<?php
namespace Helpers;
class Search {
  public static function search($db, $search_string, $pagination, $records_per_page) {
    $all_words = (preg_match('#^(\'|").+\1$#', $search_string) == 1) ? true : false;
    $search_result = array(
      'accepted_words' => array(),
      'ignored_words' => array(),
      'all_words' => $all_words,
      'query' => $search_string,
      'products' => array()
    );

    if (empty($search_string)) {
      return $search_result;
    }

    $delimiters = ',.; ';
    $word = strtok($search_string, $delimiters);

    while ($word) {
      if (strlen($word) < FT_MIN_WORD_LEN) {
        $search_result['ignored_words'][] = $word;
      } else {
        $search_result['accepted_words'][] = $word;
      }

      $word = strtok($delimiters);
    }

    if (count($search_result['accepted_words']) == 0) {
      return $search_result;
    }

    $words = '';
    if ($all_words) {
      $words = implode(' +', $search_result['accepted_words']);
    } else {
      $words = implode(' ', $search_result['accepted_words']);
    }

    $search_result['products'] = \Data\ProductsRepository::search($db, $words, $all_words, $pagination, $records_per_page);
    return $search_result;
  }
}

