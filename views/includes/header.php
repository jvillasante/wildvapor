<header>
  <div id="top">
    <span>Welcome to WildVapor Inc. Logged in as: <?php echo \Helpers\User::username(); ?></span>
    <div>
    <p><?php echo $this->tr('header.language.label'); ?>:
      <?php
        $chooser = array();
          foreach($availableLangs as $availableLang) {
            if ($lang == $availableLang) {
              $chooser[] = $this->tr($availableLang);
            }
            else {
              $chooser[] = sprintf('<a href="%s">%s</a>', $this->url($pathInfo, $availableLang), $this->tr($availableLang));
            }
          }
          echo implode(' | ', $chooser);
        ?>
    </p>
      <p><?php echo $this->tr('header.currency.label'); ?>:
        <?php echo $this->tr('header.currency'); ?>
      </p>
    </div>
  </div><!--end:top-->
  <div id="top2">
      <ul class="myaccountmenu">
      <?php if (\Helpers\User::is_logged_in()) { ?>
        <li><a href="<?php echo $this->url('/users/') . $_SESSION['user_id']; ?>" class="first"><?php echo $this->tr('header.account'); ?></a></li>
        <li><a class="last" href="<?php echo $this->url('/session/logout'); ?>"><?php echo $this->tr('header.logout'); ?></a></li>
      <?php } else { ?>
        <li class="login"><a href="#login-box" class="first login-window"><?php echo $this->tr('header.login'); ?></a></li>
        <li><a href="<?php echo $this->url_secure('/session/register'); ?>" class="last"><?php echo $this->tr('header.register'); ?></a></li>
      <?php } ?>
        <li><a href="<?php echo $this->url('/shop/wishlist'); ?>"><?php echo $this->tr('header.wishlist'); ?></a></li>
        <li><a href="<?php echo $this->url('/shop/cart'); ?>"><?php echo $this->tr('header.cart'); ?></a></li>
        <li><a href="<?php echo $this->url_secure('/shop/checkout'); ?>">Checkout</a></li>
      </ul>
      <div id="login-box" class="login-popup">
        <a href="#" class="close"><img src="<?php echo $this->path('images/process-stop.png'); ?>" class="btn_close" title="<?php echo $this->tr('login-popup.close')?>" alt="Close" /></a>
        <form method="post" class="signin" action="<?php echo $this->url_secure('/session/login'); ?>">
          <fieldset class="textbox">
          <label class="email">
            <span><?php echo $this->tr('login-popup.email.label'); ?></span>
            <input id="email" name="email" value="" type="text" autocomplete="on" placeholder="<?php echo $this->tr('login-popup.email.placeholder'); ?>">
          </label>
          <label class="password">
            <span><?php echo $this->tr('login-popup.password.label')?></span>
            <input id="password" name="password" value="" type="password" placeholder="<?php echo $this->tr('login-popup.password.placeholder'); ?>">
          </label>
          <button class="submit button" type="submit"><?php echo $this->tr('login-popup.button.label')?></button>
          <p>
          <a class="forgot" href="<?php echo $this->url('/session/forgotpassword'); ?>"><?php echo $this->tr('login-popup.forgot'); ?></a> / <a class="register" href="<?php echo $this->url_secure('/session/register'); ?>"><?php echo $this->tr('login-popup.register'); ?></a>
          </p>
          </fieldset>
        </form>
      </div>
      <div id="demo-header">
        <?php include BASE_URI . DS . 'views' . DS . 'includes' . DS . 'cart_popup.php'; ?>
        </div><!-- /login-panel -->
      </div><!-- /demoheader -->
  </div><!--end:top2-->
  <div id="top3">
    <h1 class="logo"><a href="<?php echo $this->url('/'); ?>"><?php echo $this->tr('title'); ?></a></h1>
    <form action="<?php echo $this->url('/products/search') ?>" method="get" class="search_bar">
      <fieldset>
        <input type="text" name="q" class="search" value="<?php echo $this->tr('search.text')?>" onBlur="if (this.value == ''){this.value = '<?php echo $this->tr('search.text'); ?>'; }" onFocus="if (this.value== '<?php echo $this->tr('search.text'); ?>') {this.value = ''; }" />
        <input type="submit" value="<?php echo $this->tr('search.label')?>" class="submit" />
      </fieldset>
    </form>
  </div><!--end:top3-->
</header>
