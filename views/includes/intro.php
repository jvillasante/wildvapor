<div style="clear:both; display:block; height:20px"></div>
<div id="intro">
  <div class="one-fourth serv first">
    <img src="<?php echo $this->path('images/service-1.png'); ?>" alt="">
    <h3><a href="<?php echo $this->url('/home/shipping'); ?>">Free Shipping</a></h3>
    <span>Available</span>
  </div>
  <div class="one-fourth serv">
    <img src="<?php echo $this->path('images/service-2.png'); ?>" alt="">
    <h3><a href="<?php echo $this->url('/home/return'); ?>">30 Days Return</a></h3>
    <span>Easy Return</span>
  </div>
  <div class="one-fourth serv">
    <img src="<?php echo $this->path('images/service-3.png'); ?>" alt="">
    <h3><a href="<?php echo $this->url('/home/contact'); ?>">Call Us</a></h3>
    <span>786-398-9358</span>
  </div>
  <div class="one-fourth serv">
    <img src="<?php echo $this->path('images/service-4.png'); ?>" alt="">
    <h3><a href="<?php echo $this->url('home/faq'); ?>">Secured</a></h3>
    <span>Checkout</span>
  </div>
</div>

<?php
  $flash = $this->getData('flash');
  if (isset($flash['error'])) {
    echo '<div class="alert red_alert"><p>';
    echo $flash['error'];
    echo '</p></div>';
  } elseif (isset($flash['info'])) {
    echo '<div class="alert green_alert"><p>';
    echo $flash['info'];
    echo '</p></div>';
  }
?>


