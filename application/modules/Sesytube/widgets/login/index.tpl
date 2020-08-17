<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesytube/externals/styles/style_login.css'); ?>

<div class="sesytube_login_main sesbasic_bxs">
  <div class="sesytube_login_form">
    <div class="sesytube_login_title">
      <h3>Sign In</h3>
    </div>
    <?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
    <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
    <div class="sesytube_social_login_btns">
      <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
    </div>
    <?php else: ?>
    <div class="sesytube_ligin_with_social">
      <?php
          if( 'none' != $settings->getSetting('core_facebook_enable', 'none')
              && $settings->core_facebook_secret ) {
    ?>
      <div id="facebook_login_btn_href" style="display:none;"><?php echo User_Model_DbTable_Facebook::loginButton(); ?></div>
      <div class="facebook_btn"> <a href="" id="fb_href_lnk">
        <p class="facebook_icon"><i class="fa fa-facebook"></i></p>
        <p class="facebook"><?php echo $this->translate("LOG IN WITH FACEBOOK");?></p>
        </a> </div>
      <?php } ?>
      <?php
          if( 'none' != $settings->getSetting('core_twitter_enable', 'none')
              && $settings->core_twitter_secret ) {
    ?>
      <div id="twitter_login_btn_href" style="display:none;"><?php echo User_Model_DbTable_Twitter::loginButton(); ?></div>
      <div class="twitter_btn"> <a href="" id="twitter_href_lnk">
        <p class="twitter_icon"><i class="fa fa-twitter"></i></p>
        <p class="twitter"><?php echo $this->translate("LOG IN WITH TWITTER");?></p>
        </a> </div>
      <?php } ?>
    </div>
    <?php endif;?>
    <div class="sesytube_info_text">
      <p><?php echo $this->translate("Log in with your credentials");?></p>
    </div>
    <?php echo $this->form->render($this) ?> </div>
</div>
<script type="application/javascript">
sesJqueryObject('#fb_href_lnk').attr('href',sesJqueryObject('#facebook_login_btn_href').find('a').attr('href'));
sesJqueryObject('#facebook_login_btn_href').remove();
sesJqueryObject('#twitter_href_lnk').attr('href',sesJqueryObject('#twitter_login_btn_href').find('a').attr('href'));
sesJqueryObject('#twitter_login_btn_href').remove();
if(!sesJqueryObject('#twitter_href_lnk').length && !sesJqueryObject('#fb_href_lnk').length)
  sesJqueryObject('.sesytube_ligin_with_social').remove();
sesJqueryObject('#user_form_login').find('input[type="email"]').attr('placeholder','<?php echo $this->translate("Email Address"); ?>');
sesJqueryObject('#user_form_login').find('input[type="password"]').attr('placeholder','<?php echo $this->translate("Password"); ?>');
</script> 
