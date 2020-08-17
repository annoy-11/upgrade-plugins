<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h2><?php echo $this->translate("Web & Mobile Browser Push Notifications Plugin") ?></h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesbrowserpush', 'controller' => 'settings', 'action' => 'support'),'admin_default',true); ?>" class="help-btn">Help & Support</a>
</div>
<?php if(!Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbasic')) { ?>
  	<div class="tip"><span><?php echo $this->translate("This plugin requires \"<a href='https://socialnetworking.solutions/social-engine/socialenginesolutions-basic-required-plugin/' target='_blank'>SocialNetworking.Solutions (SNS) Basic Required Plugin </a>\" to be installed and enabled on your website for Location and various other featrures to work. Please get the plugin from <a href='https://socialnetworking.solutions/social-engine/socialenginesolutions-basic-required-plugin/' target='_blank'>here</a> to install and enable on your site."); ?></span></div>
  <?php } ?>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.serverkey', '') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.snippet', '')) { ?>
  <div class="sesbasic_info_tip"><i class="fa fa-flag"></i><span><?php echo "To start using this plugin and enable push notification, please configure and enter the Firebase API keys from <a href='admin/sesbrowserpush/settings/fb-settings'>here</a>."; ?></span></div>
<?php } ?>
<?php $sesbrowserpush_adminmenu = Zend_Registry::isRegistered('sesbrowserpush_adminmenu') ? Zend_Registry::get('sesbrowserpush_adminmenu') : null; ?>
<?php if(!empty($sesbrowserpush_adminmenu)) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render() ?>
    </div>
  <?php endif; ?>
<?php } ?>
