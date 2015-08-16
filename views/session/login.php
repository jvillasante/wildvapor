<div class="container-2">
  <div style="clear:both; display:block; height:40px"></div>
    <div class="one-half first log">
        <h4><?php echo $this->tr('session.view.login.header'); ?></h4>
        <form method="post" class="signin" action="<?php echo $this->url_secure('/session/login'); ?>">
          <fieldset class="textbox">
          <label class="email">
          <span><?php echo $this->tr('session.view.login.email'); ?></span>
          <input id="email" name="email" value="" type="text" autocomplete="on" placeholder="<?php echo $this->tr('session.view.login.email'); ?>">
          </label>
          <label class="password">
          <span><?php echo $this->tr('session.view.login.password'); ?></span>
          <input id="password" name="password" value="" type="password" placeholder="<?php echo $this->tr('session.view.login.password'); ?>">
          </label>
          <button class="submit button" type="submit"><?php echo $this->tr('session.view.login.login'); ?></button>
          <p>
          <a class="forgot" href="<?php echo $this->url('/session/forgotpassword'); ?>"><?php echo $this->tr('session.view.login.forgot.password'); ?></a> / <a class="register" href="<?php echo $this->url_secure('/session/register'); ?>"><?php echo $this->tr('session.view.login.create.account'); ?></a>
          </p>
          </fieldset>
      </form>
    </div>
    <div class="one-half log">
      <h4><?php echo $this->tr('session.view.login.not.registered'); ?></h4>
      <p><?php echo $this->tr('session.view.login.register.header'); ?></p>
      <span><a href="<?php echo $this->url_secure('/session/register'); ?>" class="reg"><?php echo $this->tr('header.register'); ?></a></span>
    </div>
  <div style="clear:both; display:block; height:40px"></div>
</div>
