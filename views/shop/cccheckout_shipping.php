<?php if (!isset($errors)) { $errors = array(); } ?>

<p>
  This is step 1 of your Checkout Process. Please enter your shipping information. On the next step, you'll be able to
  enter your billing information and complete the order. Check the last box if your
  shipping and billing addresses are the same. When you are ready, follow to the next step.
  <br/><strong>Note: </strong>* Indicates a required field.
</p>

<div class="one-half first">
  <h3>Your Personal Details</h3>
  <div class="registerbox">
    <fieldset>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> <?php echo $this->tr('session.view.register.firstname'); ?>:</label>
        <?php \Helpers\Form::create_input('first_name', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> <?php echo $this->tr('session.view.register.lastname'); ?>:</label>
        <?php \Helpers\Form::create_input('last_name', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> <?php echo $this->tr('session.view.register.email'); ?>:</label>
        <?php \Helpers\Form::create_input('email', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> Phone Number:</label>
        <?php \Helpers\Form::create_input('phone', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
    </fieldset>
  </div>
</div>

<div class="one-half">
  <h3>Shipping Address</h3>
  <div class="registerbox">
    <fieldset>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> Address1:</label>
        <?php \Helpers\Form::create_input('shipping_address1', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
      <div class="control-group">
        <label class="control-label"> Address2:</label>
        <?php \Helpers\Form::create_input('shipping_address2', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> City:</label>
        <?php \Helpers\Form::create_input('shipping_city', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="red">*</span> State:</label>
        <?php \Helpers\Form::create_input('shipping_state', 'select', $errors, $values='SESSION'); ?>
      </div>
      <div class="control-group">
        <label class="control-label"><span class="zip_code">*</span> Zip Code:</label>
        <?php \Helpers\Form::create_input('shipping_zip_code', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      </div>
      <?php \Helpers\Form::create_input('use_same_address', 'checkbox', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
      <small>Use Same Address for Billing?</small>
    </fieldset>
  </div>
</div>
