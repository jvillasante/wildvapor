<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>
  <h2>Checkout: &nbsp;<small>Checkout Steps</small></h2>
  <div id="tab" class="tab2">
    <ul class="nav nav2">
      <li class="nav-one"><a href="#checkout" class="current">Checkout Info</a></li>
      <li class="nav-two"><a href="#billing">1. Shipping Details</a></li>
      <li class="nav-three"><a href="#delivery">2. Billing Details</a></li>
      <li class="nav-four"><a href="#confirm">3. Confirm Order</a></li>
    </ul>
    <div class="list-wrap checkoutbox">
      <form id="checkout_form" method="post" class="form-register" action="<?php echo $this->url_secure('/shop/cccheckout'); ?>">
        <div id="checkout">
          <p><?php
            if (isset($checkout_errors) && count($checkout_errors)) {
              echo '<div class="checkout_errors">';
              echo '<h4>You have the following errors. Please, check your data and try again.</h4>';
              $i = 0;
              foreach ($checkout_errors as $k => $v) {
                $i = $i + 1;
                $str = (is_array($v)) ? implode('|', $v) : $v;
                echo '<span class="dropcap">'.$i.'</span>';
                echo '<p>'.$str.'</p>';
                if ($i == 5) {
                  echo '<span class="dropcap">'.($i + 1).'</span>';
                  echo '<p>... and '.(count($checkout_errors) - $i).' more!</p>';
                  break;
                }
              }
              echo '</div>';
            }
          ?></p>
          <div class="one-half first">
            <h4>Checkout process</h4>
            <p>Please follow this steps in order to buy the contents of your shopping cart.</p>
            <h4>To start the process continue on to your Shipping Details.</h4>

            <div class="billing">
              <img src="<?php echo $this->path('images/service-4.png'); ?>" alt="">
              <h3>Secure Credit Card Payment</h3>
              <span>This is a secure 128-bit SSL encrypted payment.</span>

              <ul class="payment-options">
                <li><a href="#" class="tip" title="Paypal"><img src="<?php echo $this->path('/images/payment-icon-paypal.png'); ?>" alt="Paypal"></a></li>
                <li><a href="#" class="tip" title="American Express"><img src="<?php echo $this->path('/images/payment-icon-ae.png'); ?>" alt="American Express"></a></li>
                <li><a href="#" class="tip" title="Discover"><img src="<?php echo $this->path('/images/payment-icon-discover.png'); ?>" alt="Discover"></a></li>
                <li><a href="#" class="tip" title="Master Card"><img src="<?php echo $this->path('/images/payment-icon-mastercard.png'); ?>" alt="Master Card"></a></li>
                <li><a href="#" class="tip" title="Visa"><img src="<?php echo $this->path('/images/payment-icon-visa.png'); ?>" alt="Visa"></a></li>
              </ul>
            </div>

          </div>
          <div class="one-half">
            <h4>These are the steps we'll follow when you click the Place Order Button.</h4>
            <ul class="ounlist bullet">
              <li>Take and validate all your shipping information.</li>
              <li>Take and validate all your billing information.</li>
              <li>Process the payment with PayPal.</li>
              <li>Wrap it up. We'll contact you by email confirming your order.</li>
            </ul>
          </div>
        </div>
        <div id="billing" class="hide"><?php include BASE_URI . DS . 'views' . DS . 'shop' . DS . 'cccheckout_shipping.php'; ?></div>
        <div id="delivery" class="hide"><?php include BASE_URI . DS . 'views' . DS . 'shop' . DS . 'cccheckout_billing.php'; ?></div>
        <div id="confirm" class="hide"><?php include BASE_URI . DS . 'views' . DS . 'shop' . DS . 'cccheckout_confirm.php'; ?></div>
      </form>
    </div>
  </div>
  <div style="clear:both; display:block; height:40px"></div>
</div><!--end:container-2-->

<?php
  $js = '<script type="text/javascript" src="' . $this->path('js/organictabs.jquery.js') . '"></script>';
  $js .= <<<END
    <script type="text/javascript" charset="utf-8">
      $(function() {
        $("#tab").organicTabs({
            "speed": 200
        });
      });

      $("#use_same_address").change(function() {
        if(this.checked) {
          $('#billing_address1').val($('#shipping_address1').val());
          $('#billing_address2').val($('#shipping_address2').val());
          $('#billing_city').val($('#shipping_city').val());
          var state = $('select[name=shipping_state] option:selected').val();
          $('select[name=billing_state] option[value=' + state + ']').attr('selected','selected');
          $('#billing_zip_code').val($('#shipping_zip_code').val());
        } else {
          $('#billing_address1').val('');
          $('#billing_address2').val('');
          $('#billing_city').val('');
          $('select[name=billing_state]').val('');
          $('#billing_zip_code').val('');
        }
      });

      $('#checkout_form').submit(function (){
        $('input[type=submit]', this).attr('disabled', 'disabled');
        $('input[type=submit]', this).attr('value', 'Processing...');
      });
    </script>
END;

  $this->appendData(array('js' => $js));
?>

