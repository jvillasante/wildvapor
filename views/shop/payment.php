<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>
    <div class="fourpage">
    <h2><strong><span>!</span><?php echo $title; ?></strong><span>!</span></h2>
    <h3><?php echo $subtitle; ?></h3>
    <p><?php echo $message; ?></p>

    <h4>You might wanna continue browsing our site:</h4>
    <ul class="site-menu">
      <li><a href="<?php echo $this->url('/'); ?>">Home</a></li>
      <li><a href="<?php echo $this->url('/products/kits'); ?>"><?php echo $this->tr('navbar.kits'); ?></a></li>
      <li><a href="<?php echo $this->url('/products/accessories'); ?>"><?php echo $this->tr('navbar.accesories'); ?></a></li>
      <li><a href="<?php echo $this->url('/products/eliquids'); ?>"><?php echo $this->tr('navbar.eliquid'); ?></a></li>
      <li><a href="<?php echo $this->url('/home/contact'); ?>">Contact Us</a></li>
    </ul>
    </div>
    <div style="clear:both; display:block; height:40px"></div>
</div><!--end:container-2-->
