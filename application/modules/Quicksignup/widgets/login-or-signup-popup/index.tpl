<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php
  $this->headScript()
    ->appendFile($this->layout()->staticBaseUrl . 'externals/mdetect/mdetect' . ( APPLICATION_ENV != 'development' ? '.min' : '' ) . '.js');
?>
<?php if ($this->pageIdentity !== 'user-signup-index') : ?>
  <div id='user_signup_popup'>
    <div class="close_icon_container" onclick="parent.Smoothbox.close();">
      <i class="fa fa-times" aria-hidden="true" ></i>
    </div>
    <?php echo $this->action('index','signup', 'quicksignup', array('disableContent' => true)); ?>
  </div>
<?php endif; ?>
<?php if ($this->pageIdentity !== 'user-auth-login') : ?>
  <div id='user_auth_popup'>
    <div class="close_icon_container" onclick="parent.Smoothbox.close();">
      <i class="fa fa-times" aria-hidden="true" ></i>
    </div>
    <?php echo $this->action('login','auth', 'user', array(
      'disableContent' => true,
      'return_url' => '64-' . base64_encode($this->url())
    )); ?>
  </div>
<?php endif; ?>

<script type='text/javascript'>
  if( !DetectMobileQuick() && !DetectIpad() ) {
    en4.core.runonce.add(function() {
      var setPopupContent = function (event, contentId) {
        event.stop();
        Smoothbox.open($(contentId).get('html'));
        en4.core.reCaptcha.render();
        $('TB_window').addClass('signup_login_popup_wrapper');
        Smoothbox.instance.doAutoResize();
      };
      <?php if ($this->pageIdentity !== 'user-signup-index') : ?>
        $$('.user_signup_link').addEvent('click', function(event) {
          setPopupContent(event, 'user_signup_popup');
        });
      <?php endif; ?>
      <?php if ($this->pageIdentity !== 'user-auth-login') : ?>
        $$('.user_auth_link').addEvent('click', function(event) {
          setPopupContent(event, 'user_auth_popup');
        });
      <?php endif; ?>
    });
  }
</script>
