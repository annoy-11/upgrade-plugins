<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesloginpopup
 * @package    Sesloginpopup
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: page3.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesloginpopup/externals/styles/magnific-page3.css'); ?>

   <div class="sesloginpopup_loginpage">
      <div class="sesloginpopup_loginbox">
          <div class="loginbox_head" style="background:url(<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpoup.page.photo', ''); ?>);"><h2><?php echo $this->translate("SIGN IN");?></h2></div>
          <div class="loginbox_form">
            <div class="sesloginpopup_loginpage_content clearfix">
            <div class="sesloginpopup_popup_content_left sesloginpopup_popup_signup">
              <?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?>
              <?php echo $this->action("index", "signup", defined('sesquicksignup') ? "quicksignup" : "sesloginpopup", array('disableContent'=>true)) ?>
              <?php } ?>
              <?php echo $this->content()->renderWidget("sesloginpopup.login-or-signup")?>
              <p class="frome_signup"><?php if($controllerName != 'auth' && $actionName != 'login') { ?>
               <a href="signup"><?php echo $this->translate("New User? Sign Up");?></a>
              <?php } ?></p>
            </div>
            <?php if(!empty($showSeparator)):?>
              <div class="sesloginpopup_popup_content_sep">
                <span><?php echo $this->translate("OR");?></span>
              </div>
              <div class="sesloginpopup_popup_content_right">
                <span class="sesbasic_text_light"><?php echo $this->translate("Sign in with your social profile");?></span>
                <div class="sesloginpopup_quick_popup_social">
                  <?php  if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret):?>
                    <?php if (!$facebook):?>
                      <?php  return; ?>
                    <?php  endif;?>
                    <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
                    <a href="<?php echo $href;?>" id="fbLogin"><i class="fa fa-facebook"></i> <span><?php echo $this->translate("Sign up with ");?><b><?php echo $this->translate("Facebook");?></b></a>
                  <?php endif;?>
                  <?php if ('none' != $settings->getSetting('core_twitter_enable', 'none')
                   && $settings->core_twitter_secret):?>
                    <?php $href = Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble(array('module' => 'user', 'controller' => 'auth',
                    'action' => 'twitter'), 'default', true);?>
                    <a href="<?php echo $href;?>" id="googleLogin"><i class="fa fa-twitter"></i> <span><?php echo $this->translate("Sign up with ");?><b><?php echo $this->translate("Twitter");?></b></a>
                  <?php endif;?>
                </div>
              </div>  
            <?php endif;?>
           </div>
         </div>
      </div>
</div>
