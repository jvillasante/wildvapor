<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>
    <div class="fourpage">
    <h2><strong><span>!</span>404</strong><span> !</span></h2>
    <h3>Looks like the file you are looking for is no longer available.</h3>
    <p>You could have gotten wrong the url or the page no longer exists. Try another url in your browser.</p>
    <h4>You might wanna browse our site intead:</h4>
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
