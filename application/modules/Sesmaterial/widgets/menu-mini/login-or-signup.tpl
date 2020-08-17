<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: login-or-signup.tpl 2015-10-28 00:00:00 SocialEngineSolutions
 * @author     SocialEngineSolutions
 */
?>
<?php
$popUpDesign = Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_popup_design');
?>

<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<script src="<?php echo $baseUrl; ?>application/modules/Sesbasic/externals/scripts/jquery.min.js"></script>
<?php if($this->viewer->getIdentity() == 0) : ?>
	<link href="<?php echo $baseUrl; ?>application/modules/Sesmaterial/externals/styles/magnific-popup.css" rel="stylesheet" />
  <script src="<?php echo $baseUrl; ?>application/modules/Sesmaterial/externals/scripts/jquery.magnific-popup.js"></script>
<?php endif;?>
  
<?php $showSeparator = 0;?> 
<?php $settings = Engine_Api::_()->getApi('settings', 'core');?>
<?php $facebook = Engine_Api::_()->getDbtable('facebook', 'user')->getApi();?>
<?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret && $facebook):?>
  <?php $showSeparator = 1;?>
<?php elseif ('none' != $settings->getSetting('core_twitter_enable', 'none') && $settings->core_twitter_secret):?>
  <?php $showSeparator = 1;?>
<?php endif;?>
  
<?php $siteTitle = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.title','1');?>
<?php $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user'); ?>
<?php if($popUpDesign == '1'): ?>
<?php if($this->viewer->getIdentity() == 0):?>
  <div id="small-dialog" class="mfp-zoom-in mfp-hide sesmaterial_quick_popup sesmaterial_quick_login_popup sesbasic_bxs">
    <div class="sesmaterial_popup_header clearfix">
      <ul class="sesmaterial_popup_header_tabs clearfix">
        <li class="tab-active">
        	<span><?php echo $this->translate("Sign In");?></span>
        </li>
        <li>
          <?php if($controllerName != 'signup'){ ?>
            <a class="popup-with-move-anim tab-link" href="#user_signup_form">
              <?php echo $this->translate("Sign Up");?>
            </a>
          <?php } ?>
        </li>
      </ul>
    </div>
    
    <div class="sesmaterial_quick_popup_content clearfix">
      <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
        <?php $numberOfLogin = Engine_Api::_()->sessociallogin()->iconStyle();?>
        <div class="sesmaterial_social_login_btns ">
          <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
        </div>
      <?php else: ?>
        <div class="sesmaterial_quick_popup_social_btns">
            <?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret):?>
            <?php if (!$facebook):?>
              <?php return; ?>
            <?php endif;?>
            <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
            <a href="<?php echo $href;?>" id="fbLogin" class="sesmaterial_quick_popup_social_btn_facebook">
              <span><i class="fa fa-facebook"></i><?php echo $this->translate("Sign in with Facebook")?></span></a>
          <?php endif;?>
          <?php if ('none' != $settings->getSetting('core_twitter_enable', 'none')
          && $settings->core_twitter_secret):?>
            <?php $href = Zend_Controller_Front::getInstance()->getRouter()
            ->assemble(array('module' => 'user', 'controller' => 'auth',
            'action' => 'twitter'), 'default', true);?>
            <a href="<?php echo $href;?>" id="googleLogin" class="sesmaterial_quick_popup_social_btn_twitter"><span><i class="fa fa-twitter"></i><?php echo $this->translate("Sign in with Twitter")?></span></a>
          <?php endif;?>
        </div>
      <?php endif;?>
      <?php if(!empty($showSeparator)):?>
        <div class="or-sep"><span>or</span></div>
      <?php endif;?>
      <div class="sesmaterial_quick_popup_form">
        <?php echo $this->content()->renderWidget("sesmaterial.login-or-signup")?>
      </div>
    </div>
  </div>
  
  <?php if($controllerName != 'signup') { ?>
    <div id="user_signup_form" class="zoom-anim-dialog mfp-hide sesmaterial_quick_popup sesmaterial_quick_signup_popup sesbasic_bxs">
      <div class="sesmaterial_popup_header clearfix">
        <ul class="sesmaterial_popup_header_tabs clearfix">
          <li>
          <?php if($controllerName != 'auth') { ?>
            <a class="popup-with-move-anim tab-link" href="#small-dialog">
							<?php echo $this->translate("Sign In");?>
            </a>
            <?php } ?>
          </li>
          <li class="tab-active">
            <span>
              <?php echo $this->translate("Sign Up");?>
            </span>
            <i></i>
          </li>
        </ul>
      </div>
      <div class="sesmaterial_quick_popup_content clearfix"> 
        <?php if(!Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')): ?>
          <div class="sesmaterial_quick_popup_social_btns">
            <?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret):?>
              <?php if (!$facebook):?>
                <?php return; ?>
              <?php endif;?>
              <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
              <a href="<?php echo $href;?>" id="fbLogin" class="sesmaterial_quick_popup_social_btn_facebook"><span><i class="fa fa-facebook"></i><?php echo $this->translate("Sign up with Facebook")?></span></a>
            <?php endif;?>

            <?php if ('none' != $settings->getSetting('core_twitter_enable', 'none')
            && $settings->core_twitter_secret):?>
              <?php $href = Zend_Controller_Front::getInstance()->getRouter()
              ->assemble(array('module' => 'user', 'controller' => 'auth',
              'action' => 'twitter'), 'default', true);?>
              <a href="<?php echo $href;?>" id="googleLogin" class="sesmaterial_quick_popup_social_btn_twitter"><span><i class="fa fa-twitter"></i><?php echo $this->translate("Sign up with Twitter")?></span></a>
            <?php endif;?>
          </div> 
        <?php endif; ?>
        <?php if(!empty($showSeparator)):?>
          <div class="or-sep"><span>or</span></div>
        <?php endif;?>
        <div class="sesmaterial_quick_popup_form">
         <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
        <?php $numberOfLogin = Engine_Api::_()->sessociallogin()->iconStyle();?>
        <div class="sesmaterial_social_login_btns ">
          <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
        </div>
      <?php endif; ?>
          <?php echo $this->action("index", "signup",defined('sesquicksignup') ? "quicksignup" : "sesmaterial", array('disableContent'=>true)) ?>
        </div>
      </div>
    </div>
  <?php } ?>
<?php endif;?>

<?php elseif($popUpDesign == '2'): ?>
<?php if($this->viewer->getIdentity() == 0):?>
  <div id="small-dialog" class="mfp-zoom-in mfp-hide sesmaterial_quick_popup sesmaterial_quick_login_popup sesbasic_bxs">
    <div class="sesmaterial_popup_header clearfix">
      <h3><?php echo $this->translate("Login"); ?></h3>
    </div>
    <div class="sesmaterial_quick_popup_content clearfix">
    	<?php if(!Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')): ?>
        <div class="sesmaterial_quick_popup_social_btns">
            <?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret):?>
            <?php if (!$facebook):?>
              <?php return; ?>
            <?php endif;?>
            <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
            <a href="<?php echo $href;?>" id="fbLogin" class="sesmaterial_quick_popup_social_btn_facebook">
              <span><i class="fa fa-facebook"></i><?php echo $this->translate("Sign in with Facebook")?></span></a>
          <?php endif;?>
          <?php if ('none' != $settings->getSetting('core_twitter_enable', 'none')
          && $settings->core_twitter_secret):?>
            <?php $href = Zend_Controller_Front::getInstance()->getRouter()
            ->assemble(array('module' => 'user', 'controller' => 'auth',
            'action' => 'twitter'), 'default', true);?>
            <a href="<?php echo $href;?>" id="googleLogin" class="sesmaterial_quick_popup_social_btn_twitter"><span><i class="fa fa-twitter"></i><?php echo $this->translate("Sign in with Twitter")?></span></a>
          <?php endif;?>
        </div>
      <?php endif;?>
      <div class="sesmaterial_quick_popup_form">
       <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
        <?php $numberOfLogin = Engine_Api::_()->sessociallogin()->iconStyle();?>
        <div class="sesmaterial_social_login_btns ">
          <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
        </div>
      <?php endif; ?>
        <?php echo $this->content()->renderWidget("sesmaterial.login-or-signup")?>
      </div>
    </div>
    
    <div class="sesmaterial_quick_popup_footer sesbasic_clearfix">
    <?php if($controllerName != 'signup') { ?>
      <a class="popup-with-move-anim tab-link" href="#user_signup_form">
        <?php echo $this->translate("Sign Up");?>
      </a>
        <?php }?>
    </div>
  
  </div>
  <?php if($controllerName != 'signup') { ?>
    <div id="user_signup_form" class="zoom-anim-dialog mfp-hide sesmaterial_quick_popup sesmaterial_quick_signup_popup sesbasic_bxs">
      <div class="sesmaterial_popup_header clearfix">
      	<h3><?php echo $this->translate("Sign Up"); ?></h3>
      </div>
      <div class="sesmaterial_quick_popup_content clearfix"> 
        <?php if(!Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')): ?>
          <div class="sesmaterial_quick_popup_social_btns">
            <?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret):?>
              <?php if (!$facebook):?>
                <?php return; ?>
              <?php endif;?>
              <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
              <a href="<?php echo $href;?>" id="fbLogin" class="sesmaterial_quick_popup_social_btn_facebook"><span><i class="fa fa-facebook" ></i><?php echo $this->translate("Sign up with Facebook")?></span></a>
            <?php endif;?>

            <?php if ('none' != $settings->getSetting('core_twitter_enable', 'none')
            && $settings->core_twitter_secret):?>
              <?php $href = Zend_Controller_Front::getInstance()->getRouter()
              ->assemble(array('module' => 'user', 'controller' => 'auth',
              'action' => 'twitter'), 'default', true);?>
              <a href="<?php echo $href;?>" id="googleLogin" class="sesmaterial_quick_popup_social_btn_twitter"><span><i class="fa fa-twitter" ></i><?php echo $this->translate("Sign up with Twitter")?></span></a>
            <?php endif;?>
          </div>
        <?php endif; ?>
        <div class="sesmaterial_quick_popup_form">
        <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
        <?php $numberOfLogin = Engine_Api::_()->sessociallogin()->iconStyle();?>
        <div class="sesmaterial_social_login_btns ">
          <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
        </div>
      <?php endif; ?>
          <?php echo $this->action("index", "signup",defined('sesquicksignup') ? "quicksignup" : "sesmaterial", array('disableContent'=>true)) ?>
        </div>
      </div>
      <div class="sesmaterial_quick_popup_footer sesbasic_clearfix">
        <?php if($controllerName != 'auth') { ?>
        <a class="popup-with-move-anim tab-link" href="#small-dialog">
          <?php echo $this->translate("Login");?>
        </a>
        <?php } ?>
      </div>
    </div>
  <?php } ?>
<?php endif;?>
<?php endif; ?>