<?php
  if (isset($type) && ($type == 'search')) {
    $cname = 'Search Results';
    $cdesc = ($search_result['all_words']) ? '<strong>All Words Search.</strong> ' : '<strong>Any Words Search.</strong> ';
    $cdesc .= ' Query: ' . $search_result['query'];
    // if (!empty($search_result['accepted_words'])) {
      // $cdesc .= 'Accepted Words: ' . implode(', ', $search_result['accepted_words']) . '. ';
    // }
    // if (!empty($search_result['ignored_words'])) {
      // $cdesc .= 'Ignored Words: ' . implode(', ', $search_result['ignored_words']) . '.';
    // }
    $products = !empty($search_result['products']) ? $search_result['products'] : array();
  } else {
    $cname = $products[0]['cname'];
    $cdesc = $products[0]['cdesc'];
  }
?>
<section class="content">
    <h2><?php echo ucfirst($cname); ?></h2>
    <p><?php echo $cdesc; ?></p>
    <ul id="products" class="list clearfix">
    <?php foreach ($products as $row) { ?>
      <li class="da-thumbs">
        <div class="product-thumb-hover">
          <section class="left">
            <img src="<?php echo $this->uploads_small($row['image']); ?>" alt="">
            <?php if ($row['sale_price'] != NULL) { echo '<p class="sale">Sale</p>'; } ?>
            <?php if ($row['is_new']) { echo '<p class="new">New</p>'; } ?>

            <article class="da-animate da-slideFromRight" style="display: block;">
              <h3><?php echo $row['name']; ?></h3>
              <p>
                <a href="<?php echo $this->url('/products/' . $row['cname'] . '/' . $row['id']); ?>" class="link tip" title="View Detail"></a>&nbsp;
                <?php if ($row['cname'] == 'kits') { ?>
                  <a href="<?php echo $this->url('/shop/cart?action=add&id=' . $row['id'] . '&attributes=1'); ?>" class="cart tip" title="Add to cart"></a>&nbsp;&nbsp;
                <?php } else { ?>
                  <a href="<?php echo $this->url('/shop/cart?action=add&id=' . $row['id'] . '&attributes=' . $row['has_attributes']); ?>" class="cart tip" title="Add to cart"></a>&nbsp;&nbsp;
                <?php } ?>
              </p>
            </article>
          </section>
        </div>
        <section class="center">
          <h3><?php echo $row['name']; ?></h3>
          <em>Category: <a href="#"><?php echo ucfirst($row['cname']); ?></a></em><br />
          <span><?php echo \Helpers\Util::get_stock_status($row['stock']); ?></span><br />
          <span><?php echo \Helpers\Util::safe_truncate($row['description'], 200); ?></span>
        </section>
        <section class="right">
          <?php echo \Helpers\Util::get_price($row['price'], $row['sale_price']); ?>
          <ul class="menu-button">
            <?php if ($row['cname'] == 'kits') { ?>
              <li><a href="<?php echo $this->url('/shop/cart?action=add&id=' . $row['id'] . '&attributes=1'); ?>" class="cart tip" title="Add to Cart"></a></li>
              <li><a href="<?php echo $this->url('/shop/wishlist?action=add&id=' . $row['id'] . '&attributes=1'); ?>" class="wishlist tip" title="Add to Wishlist"></a></li>
            <?php } else { ?>
              <li><a href="<?php echo $this->url('/shop/cart?action=add&id=' . $row['id'] . '&attributes=' . $row['has_attributes']); ?>" class="cart tip" title="Add to Cart"></a></li>
              <li><a href="<?php echo $this->url('/shop/wishlist?action=add&id=' . $row['id'] . '&attributes=' . $row['has_attributes']); ?>" class="wishlist tip" title="Add to Wishlist"></a></li>
            <?php } ?>
            <li><a href="<?php echo $this->url('/products/' . $row['cname'] . '/' . $row['id']); ?>" class="link tip" title="View Detail"></a></li>
          </ul>
        </section>
      </li>
    <?php } ?>
    </ul><!--end:products-->
    <?php $pagination->render(); ?>
</section>

