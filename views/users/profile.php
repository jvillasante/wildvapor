<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>
    <h2>Modify your account information</h2>
    <p>
      You can change your account information on this page. The information you submit here
      will be available later on the checkout proccess.
      <br/><strong>Note: </strong>* Indicates a required field.
    </p>
    <form action="<?php $this->url_secure('/session/register'); ?>" method="post" class="form-register">
      <div class="registerbox">
        <div class="one-half first">
          <h3>Your Personal Details</h3>
          <div class="registerbox">
            <fieldset>
              <div class="control-group">
                <label class="control-label"><?php echo $this->tr('session.view.register.firstname'); ?>:</label>
                <?php \Helpers\Form::create_input('first_name', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
              <div class="control-group">
                <label class="control-label"><?php echo $this->tr('session.view.register.lastname'); ?>:</label>
                <?php \Helpers\Form::create_input('last_name', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
              <div class="control-group">
                <label class="control-label">Username:</label>
                <?php \Helpers\Form::create_input('username', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge', 'others' => 'disabled')); ?>
                <span><small>You can't modify your username. This value is unique.</small></span>
              </div>
              <div class="control-group">
                <label class="control-label"><?php echo $this->tr('session.view.register.email'); ?>:</label>
                <?php \Helpers\Form::create_input('email', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge', 'others' => 'disabled')); ?>
                <span><small>You can't modify your email address. This value is used for loggin in.</small></span>
              </div>
              <div class="control-group">
                <label class="control-label">Phone Number:</label>
                <?php \Helpers\Form::create_input('phone', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
            </fieldset>
          </div>
        </div>

        <div class="one-half">
          <h3>Your Address <small>(This will be your shipping address)</small></h3>
          <div class="registerbox">
            <fieldset>
              <div class="control-group">
                <label class="control-label">Address1:</label>
                <?php \Helpers\Form::create_input('address1', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
              <div class="control-group">
                <label class="control-label"> Address2:</label>
                <?php \Helpers\Form::create_input('address2', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
              <div class="control-group">
                <label class="control-label">City:</label>
                <?php \Helpers\Form::create_input('city', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
              <div class="control-group">
                <label class="control-label">State:</label>
                <?php \Helpers\Form::create_input('state', 'select', $errors, $values='SESSION'); ?>
              </div>
              <div class="control-group">
                <label class="control-label"> Zip Code:</label>
                <?php \Helpers\Form::create_input('zip_code', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
              <?php \Helpers\Form::create_input('use_same_address', 'checkbox', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              <small>Use Same Address for Billing?</small>
            </fieldset>
          </div>
          <div class="pull-right">
            <a href="<?php echo $this->url('/'); ?>"><input type="button" class="submit" value="Continue Shopping"></a>
            <input type="submit" class="submit" value="Change Account &rarr;">
          </div>
        </div>
      </div>
    </form>
  <div style="clear:both; display:block; height:40px"></div>
</div>

