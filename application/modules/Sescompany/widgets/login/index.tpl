<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescompany
 * @package    Sescompany
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sescompany/externals/styles/style_login.css'); ?>
<div class="sescompany_login_main sesbasic_bxs">
 <!-- <?php if($this->showlogo): ?>
	<div class="sescompany_site_logo">    
    	<?php echo $this->content()->renderWidget('sescompany.menu-logo'); ?>
    </div>
    <?php endif; ?> -->
    <div class="sescompany_login_form">
	<div class="sescompany_login_tittle">
    	<h3><?php echo $this->translate("Sign In"); ?></h3>
    </div>
  <?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
	<?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
        <div class="sescompany_social_login_btns">
        <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
      </div>
      <?php else: ?>
  <div class="sescompany_ligin_with_social">
    <?php
          if( 'none' != $settings->getSetting('core_facebook_enable', 'none')
              && $settings->core_facebook_secret ) {
    ?>
      <div id="facebook_login_btn_href" style="display:none;"><?php echo User_Model_DbTable_Facebook::loginButton(); ?></div>
    	<div class="facebook_btn">
        <a href="" id="fb_href_lnk">
        	<p class="facebook_icon"><i class="fa fa-facebook"></i></p>
        	<p class="facebook"><?php echo $this->translate("LOG IN WITH FACEBOOK");?></p>
            </a>
        </div>
        
   <?php } ?>
    <?php
          if( 'none' != $settings->getSetting('core_twitter_enable', 'none')
              && $settings->core_twitter_secret ) {
    ?>
        <div id="twitter_login_btn_href" style="display:none;"><?php echo User_Model_DbTable_Twitter::loginButton(); ?></div>
        <div class="twitter_btn">
        <a href="" id="twitter_href_lnk">
        	<p class="twitter_icon"><i class="fa fa-twitter"></i></p>
        	<p class="twitter"><?php echo $this->translate("LOG IN WITH TWITTER");?></p>
            </a>
        </div>
    <?php } ?>
    </div>
      <?php endif;?>
     
     <!-- <div class="sescompany_info_text">
    	<p><?php echo $this->translate("Log in with your credentials");?></p>
    </div> -->
<?php echo $this->form->render($this) ?>
</div>
</div>
<?php $loginbackgroundimage = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescompany.loginbackgroundimage', 0); ?>
<style>
#global_page_user-auth-login,#global_page_core-error-requireuser{
	background: url("<?php echo $loginbackgroundimage ?>");
}
</style>
<script type="application/javascript">
sesJqueryObject('#fb_href_lnk').attr('href',sesJqueryObject('#facebook_login_btn_href').find('a').attr('href'));
sesJqueryObject('#facebook_login_btn_href').remove();
sesJqueryObject('#twitter_href_lnk').attr('href',sesJqueryObject('#twitter_login_btn_href').find('a').attr('href'));
sesJqueryObject('#twitter_login_btn_href').remove();
if(!sesJqueryObject('#twitter_href_lnk').length && !sesJqueryObject('#fb_href_lnk').length)
  sesJqueryObject('.sescompany_ligin_with_social').remove();
sesJqueryObject('#user_form_login').find('input[type="email"]').attr('placeholder','<?php echo $this->translate("Email Address"); ?>');
sesJqueryObject('#user_form_login').find('input[type="password"]').attr('placeholder','<?php echo $this->translate("Password"); ?>');
</script>