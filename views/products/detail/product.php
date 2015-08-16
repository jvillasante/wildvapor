<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>
  <div class="prod">
    <div class="clearfix">
      <img src="<?php echo $this->uploads_big($row['image']); ?>" style="border: 4px solid #e5e5e5;">
      <?php include BASE_URI . DS . 'views' . DS . 'includes' . DS . 'rating.php'; ?>
    </div>
    </div><!--end:prod-->
    <div class="prod-detail">
      <h2><?php echo $row['name']; ?></h2>
      <?php echo \Helpers\Util::get_price($row['price'], $row['sale_price']); ?>
      <?php if (isset($attributes)) { ?>
        <form method="post" action="<?php echo $this->url('/shop/add_product'); ?>">
          <fieldset>
            Choose: &nbsp;
            <?php \Helpers\Form::create_attributes($attributes); ?>
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <br /><br />
            <span class="buttons">
              <input type="submit" name="cart" value="Add to Cart">
              <input type="submit" name="wishlist" value="Add to Wishlist">
            </span>
          </fieldset>
        </form>
      <?php } else { ?>
        <form action="#"></form>
        <span class="cart-button"><a href="<?php echo $this->url('/shop/cart?action=add&id=' . $row['id'] . '&attributes=' . $row['has_attributes']); ?>">Add to Cart</a><a href="<?php echo $this->url('/shop/wishlist?action=add&id=' . $row['id'] . '&attributes=' . $row['has_attributes']); ?>">Add to Wishlist</a></span>
      <?php } ?>
       <div id="tab">
        <ul class="nav">
          <li class="nav-one"><a href="#details" class="current">Details</a></li>
          <li class="nav-two"><a href="#specs">Specification</a></li>
        </ul>
        <div class="list-wrap">
          <div id="details">
            <p><?php echo $row['description']; ?></p>
          </div>
          <ul id="specs" class="hide">
            <li><span>Product Code:</span> <?php echo $row['id']; ?></li>
            <li><span>Availability:</span> <?php echo \Helpers\Util::get_stock_status($row['stock']); ?></li>
            <li><span>Price:</span> $<?php echo number_format($row['price'], 2); ?></li>
            <li><span>Sale Price:</span> $<?php echo \Helpers\Util::get_just_price($row['price'], $row['sale_price']); ?></li>
            <li><span>Tax:</span> 7%</li>
          </ul>
        </div>
      </div>
    </div><!--prodetail-->

  <?php if (isset($recommended_products) && count($recommended_products)) { ?>
    <div class="relatedprod">
      <h4>Customers who bought this also bought:</h4>
      <?php foreach ($recommended_products as $rp) { ?>
        <div class="entry">
          <div class="da-thumbs">
            <div class="div-related">
              <img src="<?php echo $this->uploads_small($rp['image']); ?>" alt="">
              <article class="da-animate da-slideFromRight" style="display: block;">
                <p>
                  <a href="<?php echo $this->url('/products/' . $rp['cname'] . '/'. $rp['id']); ?>" class="link tip" title="View Detail"></a>&nbsp;
                </p>
              </article>
            </div>
          </div>
          <h3><a href="<?php echo $this->url('/products/accessories/'.$rp['id']); ?>"><?php echo $rp['name']; ?></a></h3>
          <span>$<?php echo \Helpers\Util::get_just_price($rp['price'], $rp['sale_price']); ?></span>
        </div>
      <?php } ?>
    </div>
  <?php } ?>

  <form id="review-form" action="<?php echo $this->url('/products/review'); ?>" method="post" class="reviewForm">
    <div id="note">
      <?php
        if (isset($review_errors) && count($review_errors)) {
          echo '<div class="checkout_errors">';
          echo '<h4>You have the following errors. Please, check your data and try again.</h4>';
          $i = 0;
          foreach ($review_errors as $k => $v) {
            $i = $i + 1;
            $str = (is_array($v)) ? implode('|', $v) : $v;
            echo '<span class="dropcap">'.$i.'</span>';
            echo '<p>'.$str.'</p>';
          }
          echo '</div><br />';
        }

        $name = $email = $rating = $message = null;
        if (isset($_SESSION['slim.flash']['data']['name'])) { $name = $_SESSION['slim.flash']['data']['name']; }
        if (isset($_SESSION['slim.flash']['data']['email'])) { $email = $_SESSION['slim.flash']['data']['email']; }
        if (isset($_SESSION['slim.flash']['data']['rating'])) { $rating = $_SESSION['slim.flash']['data']['rating']; }
        if (isset($_SESSION['slim.flash']['data']['message'])) { $message = $_SESSION['slim.flash']['data']['message']; }
      ?>
    </div>
    <fieldset>
      <legend>Your Review</legend>
      <p>
        <input type="text" name="name" placeholder="Your Name" <?php if (isset($name)) { echo "value=$name"; } ?>>
        &nbsp;
        <input type="text" name="email" placeholder="Your Email" <?php if (isset($email)) { echo "value=$email"; } ?>>
        &nbsp;&nbsp;
        <label for="rating">Rate this product: &nbsp;&nbsp;</label>
        <span class="rating">
          <input type="radio" class="rating-input" id="rating-input-1-5" name="rating" value="5" <?php if (isset($rating) && ($rating == '5')) { echo 'checked'; } ?>>
          <label for="rating-input-1-5" class="rating-star"></label>
          <input type="radio" class="rating-input" id="rating-input-1-4" name="rating" value="4" <?php if (isset($rating) && ($rating == '4')) { echo 'checked'; } ?>>
          <label for="rating-input-1-4" class="rating-star"></label>
          <input type="radio" class="rating-input" id="rating-input-1-3" name="rating" value="3" <?php if (isset($rating) && ($rating == '3')) { echo 'checked'; } ?>>
          <label for="rating-input-1-3" class="rating-star"></label>
          <input type="radio" class="rating-input" id="rating-input-1-2" name="rating" value="2" <?php if (isset($rating) && ($rating == '2')) { echo 'checked'; } ?>>
          <label for="rating-input-1-2" class="rating-star"></label>
          <input type="radio" class="rating-input" id="rating-input-1-1" name="rating" value="1" <?php if (isset($rating) && ($rating == '1')) { echo 'checked'; } ?>>
          <label for="rating-input-1-1" class="rating-star"></label>
        </span>
      </p>
      <p>
        <textarea name="message" rows="10" cols="20" placeholder="Your Review"><?php if (isset($message)) { echo $message; } ?></textarea>
      </p>
      <p>
        <input type="submit" name="submit" class="submit" value="Review Product &rarr;">
      </p>
      <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>" />
      <input type="hidden" name="category" value="<?php echo $category; ?>" />
    </fieldset>
  </form>

  <div class="feedback-wrap">
    <div class="dvision">
      <?php if (isset($reviews) && count($reviews)) { ?>
        <h3><?php echo $reviews_count; ?> Reviews &mdash; <span><a href="#"><?php echo $row['name']; ?></a></span></h3><br>
        <?php foreach ($reviews as $review) { ?>
          <div class="feedback">
            <div>
              <h4><?php echo $this->out($review['reviewer_name']); ?></h4>
              <span><?php echo $review['review_date']; ?></span>
              <p><?php echo $this->out($review['review']); ?></p>
            </div>
          </div>
        <?php } ?>
      <?php } else { ?>
      <h3>No Reviews yet. Be the first person to voice your opinion!</h3><br>
      <?php } ?>
    </div>
  </div><!--end:feedback-wrap-->

  <?php if (isset($reviews_count) && ($reviews_count > 2)) { ?>
    <div id="fb">
      <div style="clear:both; display:block; height:1px"></div>
        <div id="facebook_style">
          <a class="load_more" href="#" >Show Older Reviews</a>
        </div>
      <div style="clear:both; display:block; height:2px"></div>
    </div>
  <?php } ?>
</div><!--end:container-2-->

<?php
  $js = '<script type="text/javascript" src="' . $this->path('js/organictabs.jquery.js') . '"></script>';
  $js .= <<<END
    <script type="text/javascript">
    $(function() {
      $("#tab").organicTabs({
          "speed": 200
      });
    });
    </script>
END;

  $_path = $this->url('/products/load_more');
  $_id = $row['id'];
  $_total_pages = ceil($reviews_count / 2);
  $js .= <<<END
    <script type="text/javascript">
      $(function() {
        var track_click = 1;
        var total_pages = $_total_pages;

        $('.load_more').live("click",function(evt) {
          if (track_click <= total_pages) {
            $.ajax({//fetch the article via ajax
              type: "POST",
              url: "$_path",//calling this page
              data: "page=" + track_click + "&id=" + $_id,
              beforeSend: function() { // add the loadng image
                $("a.load_more").text("Loading...");
              },
              success: function(html){
                $("div.dvision").append(html); //output the server response into ol#updates
                $("a.load_more").text("Show Older Reviews");
              }
            });

            track_click++;
            if(track_click >= total_pages-1) {
              $("#fb").remove(); //remove the div with class name "facebook_style"
            }
          }

          return false;
        });
      });
    </script>
END;

  $this->appendData(array('js' => $js));
?>
