<p>
  This is step 2 of your Checkout Process. Please enter your billing information below. Then go to the next step to review and complete your
  order. For your security, we will not store your billing information in any
  way. We accept Visa, MasterCard, American Express, and Discover.
  <br/><strong>Note: </strong>* Indicates a required field.
</p>

<div class="one-half first">
  <h3>Your Credit Card Details</h3>
  <div class="registerbox">
    <fieldset>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> Card Number:</label>
        <div class="input-group">
          <?php \Helpers\Form::create_input('cc_number', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
          <span class="info"><small>The digits on the front of your credit card.</small></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> Expiration Month:</label>
        <div class="input-group">
          <?php \Helpers\Form::create_input('cc_exp_month', 'select', $errors, $values='SESSION'); ?>
          <span class="info"><small>The month your credit card expires. Find this on the front of your credit card.</small></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> Expiration Year:</label>
        <div class="input-group">
          <?php \Helpers\Form::create_input('cc_exp_year', 'select', $errors, $values='SESSION'); ?>
          <span class="info"><small>The year your credit card expires. Find this on the front of your credit card.</small></span>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> CVV: </label>
        <div class="input-group">
          <?php \Helpers\Form::create_input('cc_cvv', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
          <span class="info"><small>Security code (or "CVC" or "CVV"). The last 3 digits displayed on the back of your credit card.</small></span>
        </div>
      </div>
    </fieldset>
  </div>
</div>

<div class="one-half">
  <h3>Billing Address</h3>
  <div class="registerbox">
    <fieldset>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> Address1:</label>
        <?php \Helpers\Form::create_input('billing_address1', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
      <div class="control-group">
        <label class="control-label"> Address2:</label>
        <?php \Helpers\Form::create_input('billing_address2', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> City:</label>
        <?php \Helpers\Form::create_input('billing_city', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> State:</label>
        <?php \Helpers\Form::create_input('billing_state', 'select', $errors, $values='SESSION'); ?>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="zip_code">*</span> Zip Code:</label>
        <?php \Helpers\Form::create_input('billing_zip_code', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
    </fieldset>
  </div>
</div>
