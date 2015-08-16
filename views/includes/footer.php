<footer>
  <div class="content-wrap">
    <div class="one-fourth first">
      <h4>Our Policies</h4>
      <ul>
        <li><a href="<?php echo $this->url('/home/return'); ?>">Return Policy</a></li>
        <li><a href="<?php echo $this->url('/home/payment'); ?>">Payment Policy</a></li>
        <li><a href="<?php echo $this->url('/home/shipping'); ?>">Shipping Policy</a></li>
        <li><a href="<?php echo $this->url('/home/privacy'); ?>">Privacy Policy</a></li>
      </ul>
    </div>
    <div class="one-fourth">
      <h4>Information</h4>
      <ul>
        <li><a href="<?php echo $this->url('/home/about'); ?>">About Us</a></li>
        <li><a href="<?php echo $this->url('/home/contact'); ?>">Contact Us</a></li>
        <li><a href="<?php echo $this->url('/home/faq'); ?>">FAQ</a></li>
      </ul>
    </div>
    <div class="one-fourth">
      <h4>Extras</h4>
      <ul>
        <li><a href="#">Brands</a></li>
        <li><a href="#">Gift Vouchers</a></li>
        <li><a href="#">Affiliates</a></li>
        <li><a href="#">Special</a></li>
      </ul>
    </div>
<?php if (isset($_SESSION['user_id'])) { ?>
    <div class="one-fourth">
      <h4>My Account</h4>
      <ul>
        <li><a href="<?php echo $this->url('/users/'.$_SESSION['user_id']); ?>">My Account</a></li>
        <li><a href="<?php echo $this->url('/shop/wishlist'); ?>">My Wishlist</a></li>
        <li><a href="<?php echo $this->url('/shop/cart'); ?>">My Cart</a></li>
      </ul>
    </div>
<?php } ?>
  </div>
  <div class="content-wrap">
    <div style="clear:both; display:block;" class="social-wrap"></div>
    <ul class="social">
      <li><a href="#" class="tip" title="Facebook"><img src="<?php echo $this->path('/images/social-icon-facebook.png'); ?>" alt="Facebook"></a></li>
      <li><a href="#" class="tip" title="Dribbble"><img src="<?php echo $this->path('/images/social-icon-dribbble.png'); ?>" alt="Dribbble"></a></li>
      <li><a href="#" class="tip" title="Flickr"><img src="<?php echo $this->path('/images/social-icon-flickr.png'); ?>" alt="Flickr"></a></li>
      <li><a href="#" class="tip" title="Pinterest"><img src="<?php echo $this->path('/images/social-icon-Pinterest.png'); ?>" alt="Pinterest"></a></li>
      <li><a href="#" class="tip" title="Twitter"><img src="<?php echo $this->path('/images/social-icon-Twitter.png'); ?>" alt="Twitter"></a></li>
      <li><a href="#" class="tip" title="RSS"><img src="<?php echo $this->path('/images/social-icon-rss.png'); ?>" alt="RSS"></a></li>
    </ul>
    <ul class="payment">
      <li><a href="#" class="tip" title="Paypal"><img src="<?php echo $this->path('/images/payment-icon-paypal.png'); ?>" alt="Paypal"></a></li>
      <li><a href="#" class="tip" title="American Express"><img src="<?php echo $this->path('/images/payment-icon-ae.png'); ?>" alt="American Express"></a></li>
      <li><a href="#" class="tip" title="Discover"><img src="<?php echo $this->path('/images/payment-icon-discover.png'); ?>" alt="Discover"></a></li>
      <li><a href="#" class="tip" title="Master Card"><img src="<?php echo $this->path('/images/payment-icon-mastercard.png'); ?>" alt="Master Card"></a></li>
      <li><a href="#" class="tip" title="Visa"><img src="<?php echo $this->path('/images/payment-icon-visa.png'); ?>" alt="Visa"></a></li>
    </ul>
    <p style="clear:both; display:block;">&copy; <?php date('Y'); ?> <a href="<?php echo $this->url('/'); ?>">WildVapor</a>, All Rights Reserved. Designed by: <a href="#">louiejiemahusay</a> | Developed by: <a href="mailto:jvillasantegomez@gmail.com">jvillasantegomez</a></p> </div>
</footer>
