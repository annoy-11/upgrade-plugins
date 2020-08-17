<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmaterial/externals/styles/landing-page.css'); ?>

<div class="sesmaterial_landing sesbasic_bxs">
<div class="sesmaterial_landing_box_bg" <?php if($this->backgroundimage) { ?> style="background-image:url(<?php echo $this->backgroundimage ?>);"<?php } ?>>
  </div>
  <div class="sesmaterial_landing_box">
  <div class="sesmaterial_box_main">
  <div class="sesmaterial_landing_bnr" <?php if($this->mainimage) { ?> style="background-image:url(<?php echo $this->mainimage ?>);" <?php } ?>>
  </div>
  <div class="sesmaterial_landing_loginsignup">
  <div class="sesmaterial_landing_login">
  <h2>Login</h2>
   <?php echo $this->content()->renderWidget("sesmaterial.login-or-signup")?>
   <p class="form_btm_text"><?php echo $this->translate("Need an account? "); ?><a href="#" id="landing_signup"><?php echo $this->translate("Sign Up"); ?></a></p>
      <div class="sesmaterial_quick_popup_social_btns">
            <?php if ('none' != Engine_Api::_()->getApi('settings', 'core')->getSetting('core_facebook_enable', 'none') && Engine_Api::_()->getApi('settings', 'core')->core_facebook_secret):?>
            <?php if (!$this->facebook):?>
              <?php return; ?>
            <?php endif;?>
            <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
            <a href="<?php echo $href;?>" id="fbLogin" class="sesmaterial_quick_popup_social_btn_facebook">
              <span><i class="fa fa-facebook"></i><?php echo $this->translate("Sign in with Facebook")?></span></a>
          <?php endif;?>
        </div>
  </div>
  <div class="sesmaterial_landing_signup">
  <h2><?php echo $this->translate("Sign up"); ?></h2>
  <?php echo $this->action("index", "signup", defined('sesquicksignup') ? "quicksignup" : "sesmaterial", array('disableContent'=>true)) ?>
  <p class="form_btm_text"><?php echo $this->translate("Already a member, "); ?><a href="#" id="landing_signin"><?php echo $this->translate("Sign In"); ?></a></p>
<div class="sesmaterial_quick_popup_social_btns">
            <?php if ('none' != Engine_Api::_()->getApi('settings', 'core')->getSetting('core_facebook_enable', 'none') && Engine_Api::_()->getApi('settings', 'core')->core_facebook_secret):?>
            <?php if (!$this->facebook):?>
              <?php return; ?>
            <?php endif;?>
            <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
            <a href="<?php echo $href;?>" id="fbLogin" class="sesmaterial_quick_popup_social_btn_facebook">
              <span><i class="fa fa-facebook"></i><?php echo $this->translate("Sign up with Facebook")?></span></a>
          <?php endif;?>
        </div>
  </div>
  </div>
  </div>
  </div>
</div>
<script>
sesJqueryObject(document).ready(function(){
    sesJqueryObject("#landing_signup").click(function(){
        sesJqueryObject(".sesmaterial_landing_signup").show();
				sesJqueryObject(".sesmaterial_landing_login").hide();
    });
    sesJqueryObject("#landing_signin").click(function(){
        sesJqueryObject(".sesmaterial_landing_signup").hide();
				sesJqueryObject(".sesmaterial_landing_login").show();
    });
});
</script>
