<section class="content">
<?php
  if ($type == 'search') {
    echo '<h3>There are no results for query: ' . $query;
  } else {
    echo '<h3>There are no ' . $type . ' in stock.';
  }
?>
</section>
