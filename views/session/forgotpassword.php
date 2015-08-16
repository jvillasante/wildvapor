<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>
  <h2><?php echo $this->tr('session.view.forgot.header'); ?> &nbsp;
    <small><?php echo $this->tr('session.view.forgot.header.explanation'); ?></small>
  </h2>
    <form action="<?php $this->url('/session/forgotpassword'); ?>" method="post" class="form-register">
    <div class="registerbox">
      <fieldset>
        <div class="control-group">
          <?php \Helpers\Form::create_input('email', 'text', $errors, $values='SESSION', array('class' => 'input-xlarge', 'others' => 'placeholder="' . $this->tr('session.view.forgot.email.placeholder') . '"')); ?> </div>
      </fieldset>
    </div>
    <div class="pull-right">
      <input type="submit" class="submit" value="<?php echo $this->tr('session.view.forgot.button.label'); ?> &rarr;">
    </div>
  </form>
  <div style="clear:both; display:block; height:40px"></div>
</div>

