<?php

function no_products($app, $type, $query = NULL) {
  $app->render('products/list/no_products.php', array(
    'page_title' => $type,
    'type' => $type,
    'query' => $query
  ));
  $app->stop();
}

$app->get('/products/search', function() use ($app, $db, $config) {
  $params = $app->request()->get();
  $records_per_page = $config['records_per_page'];
  $pagination = new \Zebra\Pagination();
  $pagination->selectable_pages(5);
  $results = \Helpers\Search::search($db, $params['q'], $pagination, $records_per_page);
  if ($results) {
    $rows = \Data\ProductsRepository::get_total_records($db);
    $pagination->records($rows['rows']);
    $pagination->records_per_page($records_per_page);

    $app->render('products/list/list.php', array(
      'type' => 'search',
      'page_title' => 'Search',
      'search_result' => $results,
      'pagination' => $pagination
    ));
  } else {
    no_products($app, 'search', $params['q']);
  }
});

$app->get('/products/:category', function($category) use ($app, $db, $config) {
  if (!in_array($category, $config['products'], true)) {
    $app->notFound();
  }

  $records_per_page = $config['records_per_page'];
  $pagination = new \Zebra\Pagination();
  $pagination->selectable_pages(5);
  $products = \Data\ProductsRepository::get_products_by_category($db, $category, $pagination, $records_per_page);
  if ($products) {
    $rows = \Data\ProductsRepository::get_total_records($db);
    $pagination->records($rows['rows']);
    $pagination->records_per_page($records_per_page);
    $app->render('products/list/list.php', array(
      'page_title' => $category,
      'products' => $products,
      'pagination' => $pagination,
      'current' => $category,
    ));
  } else {
    no_products($app, $category);
  }
});

$app->get('/products/:category/:id', function($category, $id) use ($app, $db, $config) {
  if (!in_array($category, $config['products'], true)) {
    $app->notFound();
  }

  $flash = $app->view()->getData('flash');
  $review_errors = (isset($flash['review_errors'])) ? $flash['review_errors'] : array();

  $product = \Data\ProductsRepository::get_product($db, $category, $id);
  if ($product) {
    $reviews = \Data\ProductsRepository::get_review($db, $id);
    $reviews_rows = \Data\ProductsRepository::get_total_records($db);
    $rating_avg = \Data\ProductsRepository::get_rating($db, $id);
    $recommended_products = \Data\ProductsRepository::get_recommended_products($db, $id);
    if ($category == 'kits') {
      $products = \Data\ProductsRepository::get_kit_products($db, $id);
      $app->view()->set_template('layouts/basic.php');
      $app->render('products/detail/kit.php', array(
        'page_title' => 'Kit',
        'kit' => $product,
        'products' => $products,
        'category' => $category,
        'recommended_products' => $recommended_products,
        'review_errors' => $review_errors,
        'reviews' => $reviews,
        'reviews_count' => $reviews_rows['rows'],
        'rating_avg' => $rating_avg
      ));
    } else {
      if ($product['has_attributes'] == 1) {
        $attributes = \Data\ProductsRepository::get_product_attributes($db, $id);
      } else {
        $attributes = NULL;
      }
      $app->view()->set_template('layouts/basic.php');
      $app->render('products/detail/product.php', array(
        'page_title' => ucfirst($category) . ' - ' . $id,
        'row' => $product,
        'attributes' => $attributes,
        'category' => $category,
        'recommended_products' => $recommended_products,
        'review_errors' => $review_errors,
        'reviews' => $reviews,
        'reviews_count' => $reviews_rows['rows'],
        'rating_avg' => $rating_avg
      ));
    }
  } else {
    $app->notFound();
  }
});

$app->post('/products/review', function() use($app, $db) {
  $data = $app->request()->post();

  include BASE_URI . DS . 'routes' . DS . 'validators' . DS . 'review.php';
  $errors = validate($data);
  if ($errors) {
    $app->flash('review_errors', $errors);
    $app->flash('data', $data);
    $app->redirect($app->view()->url('/products/' . $data['category'] . '/' . $data['product_id'] . '#review-form'));
  }

  if (isset($data['product_id']) && filter_var($data['product_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
    $message = strip_tags($data['message']);
    $result = \Data\ProductsRepository::review_product($db, $data['product_id'], $data['rating'], $message, $data['name'], $data['email']);
    if ($result) {
      $app->flash('info', 'Your review has been added. Thank you for reviewing our products.');
      $app->redirect($app->view()->url('/products/' . $data['category'] . '/' . $data['product_id'] . '#review-form'));
    } else {
      $app->error(new \Exception('Your review could not be processed due to a system error. We apologize for the inconvenience.'));
    }
  }
});

$app->post('/products/load_more', function() use ($app, $db) {
  $data = $app->request()->post();
  if (isset($data['page'], $data['id'])) {
    $page = $data['page'];
    $id = $data['id'];
    $reviews = \Data\ProductsRepository::get_review($db, $id, $page);
    if ($reviews) {
      foreach ($reviews as $review) {
        echo '<div class="feedback">';
        echo '<div>';
        echo '<h4>' . $review['reviewer_name'] . '</h4>';
        echo '<span>' . $review['review_date'] . '</span>';
        echo '<p>' . $review['review'] . '</p>';
        echo '</div>';
        echo '</div>';
      }
    }
  }
});

