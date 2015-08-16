<?php $best_sellers = \Data\ProductsRepository::get_best_sellers($db); ?>

<aside class="sidebar">
  <div class="side">
    <h4>Bestsellers</h4>
    <?php if (isset($best_sellers) && count($best_sellers)) { ?>
      <?php foreach ($best_sellers as $b) { ?>
        <div class="entry">
          <div class="da-thumbs">
            <div class="div-bestsellers">
              <img src="<?php echo $this->uploads_thumb($b['image']); ?>" alt="">
              <article class="da-animate da-slideFromRight" style="display: block;">
                <p><a href="<?php echo $this->url('/products/' . $b['cname']. '/' . $b['id']); ?>" class="link"></a></p>
              </article>
            </div>
          </div>
          <h3><a href="<?php echo $this->url('/products/' . $b['cname']. '/' . $b['id']); ?>" title="<?php echo $b['name']; ?>"><?php echo \Helpers\Util::safe_truncate($b['name'], 30); ?></a></h3>
          <small>$<?php echo \Helpers\Util::get_just_price($b['price'], $b['sale_price']); ?></small><br />
          <small><?php echo \Helpers\Util::get_stock_status($b['stock']); ?></small>
        </div>
      <?php } ?>
  <?php } else { ?>
    ...
  <?php } ?>
  </div><!--end:side-->

  <div class="side">
    <h4>Our Customer Love Us!</h4>
    <ul class="fade">
      <li class="feed">Easy shopping experience! Pricing is attractive! Lots of styles to choose from and great pics!<br>
        <small><a href="#">&mdash; Louie Jie Mahusay</a></small>
      </li>
      <li class="feed">Easy shopping experience! Pricing is attractive! Lots of styles to choose from and great pics!<br>
        <small><a href="#">&mdash; Louie Jie Mahusay</a></small>
      </li>
      <li class="feed">Easy shopping experience! Pricing is attractive! Lots of styles to choose from and great pics!<br>
        <small><a href="#">&mdash; Louie Jie Mahusay</a></small>
      </li>
      <li class="feed">Easy shopping experience! Pricing is attractive! Lots of styles to choose from and great pics!<br>
        <small><a href="#">&mdash; Louie Jie Mahusay</a></small>
      </li>
    </ul>
  </div>
</aside>
