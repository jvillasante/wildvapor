<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>

    <div class="one-half first">
        <h4>Checkout Options</h4>
        <p>Please choose your preferred payment type</p>
        <div>
          <ul class="payment-options">
            <li><a href="<?php echo $this->url_secure('/shop/expresscheckout'); ?>" class="tip" title="Paypal"><img src="<?php echo $this->path('/images/payment-icon-paypal.png'); ?>" alt="Paypal"></a></li>
            <li><a href="<?php echo $this->url_secure('/shop/cccheckout?cctype=' . urlencode('american express')); ?>" class="tip" title="American Express"><img src="<?php echo $this->path('/images/payment-icon-ae.png'); ?>" alt="American Express"></a></li>
            <li><a href="<?php echo $this->url_secure('/shop/cccheckout?cctype=' . urlencode('discover')); ?>" class="tip" title="Discover"><img src="<?php echo $this->path('/images/payment-icon-discover.png'); ?>" alt="Discover"></a></li>
            <li><a href="<?php echo $this->url_secure('/shop/cccheckout?cctype=' . urlencode('master card')); ?>" class="tip" title="Master Card"><img src="<?php echo $this->path('/images/payment-icon-mastercard.png'); ?>" alt="Master Card"></a></li>
            <li><a href="<?php echo $this->url_secure('/shop/cccheckout?cctype=' . urlencode('visa')); ?>" class="tip" title="Visa"><img src="<?php echo $this->path('/images/payment-icon-visa.png'); ?>" alt="Visa"></a></li>
          </ul>
        </div>
      </div>
      <div class="one-half">
        <img src="<?php echo $this->path('images/service-4.png'); ?>" alt="">
        <h3>Secure Credit Card Payment</h3>
        <span>This is a secure 128-bit SSL encrypted payment.</span>

        <br /><br />

        <h4>Pay with PayPal</h4>
        <p>
          If you choose paypal as your payment method, then you are redirected to paypal website to fulfill your payment
          there in a secure environment, when you are finished you will be redirected back to our site.
        </p>

        <h4>These are the steps we'll follow if you select to pay by Credit Card.</h4>
        <ul class="ounlist bullet">
          <li>Take and validate all your shipping information.</li>
          <li>Take and validate all your billing information.</li>
          <li>Process the payment with PayPal.</li>
          <li>Wrap it up. We'll contact you by email confirming your order.</li>
        </ul>
      </div>

  <div style="clear:both; display:block; height:40px"></div>
</div>


