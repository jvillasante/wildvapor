<section class="content">
  <div class="list_work">
    <?php if (isset($random_products)) { ?>
      <h4>Random Products</h4>
      <ul id="mycarousel" class="jcarousel-skin-tango item da-thumbs">
        <?php foreach ($random_products as $r) { ?>
          <li>
            <img src="<?php echo $this->uploads_small($r['image']); ?>" alt="" />
            <span><a title="<?php echo $r['name']; ?>" href="<?php echo $this->url('/products/' . $r['cname'] . '/' . $r['id']); ?>"><?php echo \Helpers\Util::safe_truncate($r['name'], 30); ?></a><br>
            <?php echo \Helpers\Util::get_price_homepage($r['price'], $r['sale_price']); ?></span>
            <?php if ($r['sale_price'] != NULL) { echo '<span class="sale">Sale</span>'; } ?>
            <?php if ($r['is_new']) { echo '<span class="new">New</span>'; } ?>
            <article class="da-animate da-slideFromRight" style="display: block;">
              <h3><?php echo \Helpers\Util::safe_truncate($r['name'], 80); ?></h3>
              <p>
              <a href="<?php echo $this->url('/products/' . $r['cname']. '/' . $r['id']); ?>" class="link tip" title="View Detail"></a>&nbsp;
              <?php if ($r['cname'] == 'kits') { ?>
                <a href="<?php echo $this->url('/shop/wishlist?action=add&id=' . $r['id'] . '&attributes=1'); ?>" class="wishlist tip" title="Add to WishList"></a>&nbsp;
                <a href="<?php echo $this->url('/shop/cart?action=add&id=' . $r['id'] . '&attributes=1'); ?>" class="cart tip" title="Add to cart"></a>
              <?php } else { ?>
                <a href="<?php echo $this->url('/shop/wishlist?action=add&id=' . $r['id'] . '&attributes=' . $r['has_attributes']); ?>" class="wishlist tip" title="Add to WishList"></a>&nbsp;
                <a href="<?php echo $this->url('/shop/cart?action=add&id=' . $r['id'] . '&attributes=' . $r['has_attributes']); ?>" class="cart tip" title="Add to cart"></a>
              <?php } ?>
              </p>
            </article>
          </li>
        <?php } ?>
      </ul>
    <?php } ?>
  </div>

  <div class="list_work list_work2">
    <?php if (isset($new_arrival)) { ?>
      <h4>New Arrival</h4>
      <ul id="mycarouselnew" class="jcarousel-skin-tango item">
      <?php foreach ($new_arrival as $n) { ?>
        <li>
          <img height="150" width="150" src="<?php echo $this->uploads_small($n['image']); ?>" alt="" />
          <span><a title="<?php echo $n['name']; ?>" href="<?php echo $this->url('/products/' . $n['cname'] . '/' . $n['id']); ?>"><?php echo \Helpers\Util::safe_truncate($n['name'], 30); ?></a><br>
          <?php echo \Helpers\Util::get_price_homepage($n['price'], $n['sale_price']); ?></span>
          <span class="new">New</span>
            <ul>
              <li><a href="<?php echo $this->url('/products/' . $n['cname'] . '/' . $n['id']); ?>" class="link tip" title="View Details">View Details</a></li>
              <?php if ($n['cname'] == 'kits') { ?>
                <li><a href="<?php echo $this->url('/shop/cart?action=add&id=' . $n['id'] . '&attributes=1'); ?>" class="cart tip" title="Add to Cart">Cart</a></li>
                <li><a href="<?php echo $this->url('/shop/wishlist?action=add&id=' . $n['id'] . '&attributes=1'); ?>" class="wishlist tip" title="Add to Wishlist">Add Wishlist</a></li>
              <?php } else { ?>
                <li><a href="<?php echo $this->url('/shop/cart?action=add&id=' . $n['id'] . '&attributes=' . $n['has_attributes']); ?>" class="cart tip" title="Add to Cart">Cart</a></li>
                <li><a href="<?php echo $this->url('/shop/wishlist?action=add&id=' . $n['id'] . '&attributes=' . $n['has_attributes']); ?>" class="wishlist tip" title="Add to Wishlist">Add Wishlist</a></li>
              <?php } ?>
            </ul>
        </li>
      <?php } ?>
      </ul>
    <?php } ?>
  </div>
</section>

<?php
$js = '<script type="text/javascript" src="' . $this->path('js/jquery.jcarousel.min.js') . '"> </script>';
$js .= <<<END
  <script type="text/javascript">
  //------JCAROUSEL-------------
  function mycarousel_initCallback(carousel){
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
      carousel.startAuto(0);
    });
    carousel.buttonPrev.bind('click', function() {
      carousel.startAuto(0);
    });
    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
      carousel.stopAuto();
    }, function() {
      carousel.startAuto();
    });
  };
  jQuery(document).ready(function() {
    jQuery('#mycarousel, #mycarouselnew').jcarousel({
      auto: 0,
        wrap: 'last',
        initCallback: mycarousel_initCallback
    });
  });
  </script>
END;

  $this->appendData(array('js' => $js));
?>
