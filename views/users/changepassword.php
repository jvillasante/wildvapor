<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>
  <h2><?php echo $this->tr('session.view.change.header'); ?> &nbsp;
    <small><?php echo $this->tr('session.view.change.header.explanation'); ?></small>
  </h2>
    <form action="<?php $this->url_secure('/users/' . $_SESSION['user_id'] . '/changepassword'); ?>" method="post" class="form-register">
    <div class="registerbox">
      <fieldset>
        <div class="control-group">
          <?php \Helpers\Form::create_input('password', 'password', $errors, $values='SESSION', array('class' => 'input-xlarge', 'others' => 'placeholder="' . $this->tr('session.view.change.current') . '"')); ?>
        </div>
        <div class="control-group">
          <?php \Helpers\Form::create_input('new_password', 'password', $errors, $values='SESSION', array('class' => 'input-xlarge', 'others' => 'placeholder="' . $this->tr('session.view.change.new') . '"')); ?>
          <span class="info"><small><?php echo $this->tr('session.view.register.password.explanation'); ?></small></span>
        </div>
        <div class="control-group">
          <?php \Helpers\Form::create_input('new_password_confirmation', 'password', $errors, $values='SESSION', array('class' => 'input-xlarge', 'others' => 'placeholder="' . $this->tr('session.view.change.confirmation') . '"')); ?>
        </div>
      </fieldset>
    </div>
    <div class="pull-right">
      <input type="submit" class="submit" value="<?php echo $this->tr('session.view.change.button.label'); ?> &rarr;">
    </div>
  </form>
  <div style="clear:both; display:block; height:40px"></div>
</div>

