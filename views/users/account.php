<section class="content">
  <?php echo $this->tr('users.view.account.header'); ?>
  <div id="tab" class="tab2">
    <ul class="nav nav2">
      <li class="nav-one"><a href="#account" class="current">My Accounts</a></li>
      <li class="nav-two"><a href="#order">My Orders</a></li>
    </ul>
    <div class="list-wrap myaccount">
      <ul id="account">
        <li><a href="<?php echo $this->url_secure('/users/' . $_SESSION['user_id'] . '/account'); ?>">Edit you account information</a></li>
        <li><a href="<?php echo $this->url_secure('/users/' . $_SESSION['user_id'] . '/changepassword'); ?>">Change your password</a></li>
        <li><a href="<?php echo $this->url('/shop/cart'); ?>">Modify your cart</a></li>
        <li><a href="<?php echo $this->url('/shop/wishlist'); ?>">Modify your Wish List</a></li>
      </ul>
      <ul id="order" class="hide">
        <li><a href="<?php echo $this->url('/users/' . $_SESSION['user_id'] . '/orders'); ?>">View your order history</a></li>
      </ul>
    </div>
  </div>
</section>

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

  $this->appendData(array('js' => $js));
?>

