<?php $current = isset($current) ? $current : null; ?>
<nav>
  <ul id="mega-menu-3" class="mega-menu">
    <li class="first"><a href="<?php echo $this->url('/'); ?>" <?php if ($current == 'home') { echo 'class="current"'; } ?>><?php echo $this->tr('navbar.home'); ?></a></li>
    <li><a href="<?php echo $this->url('/products/kits'); ?>" <?php if ($current == 'kits') { echo 'class="current"'; } ?>><?php echo $this->tr('navbar.kits'); ?></a></li>
    <li><a href="<?php echo $this->url('/products/accessories'); ?>" <?php if ($current == 'accessories') { echo 'class="current"'; } ?>><?php echo $this->tr('navbar.accesories'); ?></a></li>
    <li><a href="<?php echo $this->url('/products/eliquids'); ?>" <?php if ($current == 'eliquids') { echo 'class="current"'; } ?>><?php echo $this->tr('navbar.eliquid'); ?></a></li>
    <li><a href="#" <?php if ($current == 'policies') { echo 'class="current"'; } ?>>Our Policies</a>
      <ul>
        <li><a href="<?php echo $this->url('/home/return'); ?>">Return Policy</a></li>
        <li><a href="<?php echo $this->url('/home/payment'); ?>">Payment Policy</a></li>
        <li><a href="<?php echo $this->url('/home/shipping'); ?>">Shipping Policy</a></li>
        <li><a href="<?php echo $this->url('/home/privacy'); ?>">Privacy Policy</a></li>
      </ul>
    </li>
    <li><a href="<?php echo $this->url('/home/contact'); ?>" <?php if ($current == 'contact') { echo 'class="current"'; } ?>><?php echo $this->tr('navbar.contact'); ?></a></li>
    <li><a href="<?php echo $this->url('/home/about'); ?>" <?php if ($current == 'about') { echo 'class="current"'; } ?>><?php echo $this->tr('navbar.about'); ?></a></li>
    <li><a href="<?php echo $this->url('/home/faq'); ?>" <?php if ($current == 'faq') { echo 'class="current"'; } ?>><?php echo $this->tr('navbar.faq'); ?></a></li>
  </ul>
</nav><!--end:grey-->
