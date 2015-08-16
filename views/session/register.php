<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>
  <h2><?php echo $this->tr('session.view.register.header'); ?> &nbsp;
    <small>
      You don't need to register in order to buy from our store, you can always add our products to your cart and checkout with Paypal.
      Registrations is optional and give you the option to view your order history and other user related functionality. Registration is free and will give you access to all the
      features we provide. Use the form below to begin the registration process. Note: All fields marked * are required.
    </small>
  </h2>
    <form action="<?php $this->url_secure('/session/register'); ?>" method="post" class="form-register">
      <p><?php
        if (isset($errors) && count($errors)) {
          echo '<div class="checkout_errors">';
          echo '<h4>You have the following errors. Please, check your data and try again.</h4>';
          $i = 0;
          foreach ($errors as $k => $v) {
            $i = $i + 1;
            $str = (is_array($v)) ? implode('|', $v) : $v;
            echo '<span class="dropcap">'.$i.'</span>';
            echo '<p>'.$str.'</p>';
            if ($i == 5) {
              echo '<span class="dropcap">'.($i + 1).'</span>';
              echo '<p>... and '.(count($errors) - $i).' more!</p>';
              break;
            }
          }
          $errors = array();
          echo '</div>';
        }
      ?></p>
      <div class="registerbox">
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
                <label class="control-label"><span class="red">*</span> <?php echo $this->tr('session.view.register.username'); ?>:</label>
                <div class="input-group">
                  <?php \Helpers\Form::create_input('username', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
                  <span class="info"><small><?php echo $this->tr('session.view.register.username.explanation'); ?></small></span>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label"> <?php echo $this->tr('session.view.register.phone'); ?>:</label>
                <?php \Helpers\Form::create_input('phone', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>

              <h3><?php echo $this->tr('session.view.register.password.header'); ?></h3>
              <div class="control-group">
                <label  class="control-label"><span class="red">*</span> <?php echo $this->tr('session.view.register.password'); ?>:</label>
                <div class="input-group">
                  <?php \Helpers\Form::create_input('password', 'password', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
                  <span class="info"><small><?php echo $this->tr('session.view.register.password.explanation'); ?></small></span>
                </div>
              </div>
              <div class="control-group">
                <label  class="control-label"><span class="red">*</span> <?php echo $this->tr('session.view.register.password.confirmation'); ?>:</label>
                <?php \Helpers\Form::create_input('password_confirmation', 'password', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
            </fieldset>
          </div>
        </div>

        <div class="one-half">
          <h3>Your Address <small>(This will be your shipping address)</small></h3>
          <div class="registerbox">
            <fieldset>
              <div class="control-group">
                <label class="control-label"> <?php echo $this->tr('session.view.register.address1'); ?>:</label>
                <?php \Helpers\Form::create_input('address1', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
              <div class="control-group">
                <label class="control-label"> <?php echo $this->tr('session.view.register.address2'); ?>:</label>
                <?php \Helpers\Form::create_input('address2', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
              <div class="control-group">
                <label class="control-label"> <?php echo $this->tr('session.view.register.city'); ?>:</label>
                <?php \Helpers\Form::create_input('city', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
              <div class="control-group">
                <label class="control-label"> <?php echo $this->tr('session.view.register.zip'); ?>:</label>
                <?php \Helpers\Form::create_input('zip_code', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge')); ?>
              </div>
              <div class="control-group">
                <label for="select01" class="control-label"> <?php echo $this->tr('session.view.register.country'); ?>:</label>
                <?php \Helpers\Form::create_input('country', 'select', $errors, $values='SESSION'); ?>
              </div>
              <div class="control-group">
                <label class="control-label"> <?php echo $this->tr('session.view.register.state'); ?>:</label>
                <?php \Helpers\Form::create_input('state', 'select', $errors, $values='SESSION'); ?>
              </div>
            </fieldset>
          </div>
          <div class="pull-right">
            <label class="checkbox inline">
              <input type="checkbox" name="terms" />
            </label>
            <?php echo $this->tr('session.view.register.policy.label'); ?> <a href="<?php echo $this->url('/home/privacy'); ?>" ><?php echo $this->tr('session.view.register.policy'); ?></a>
            &nbsp;
            <input type="Submit" class="submit" value="<?php echo $this->tr('session.view.register.button.label'); ?> &rarr;">
          </div>
        </div>
      </div>
    </form>
  <div style="clear:both; display:block; height:40px"></div>
</div>

