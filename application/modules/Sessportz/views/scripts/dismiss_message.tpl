<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if (APPLICATION_ENV == 'production'): ?>
	<div id="" class="ses_tip_red tip">
	  <span>
	    <?php echo 'Please make sure that you change the mode of your website from "Production Mode" to "Development Mode" whenever you make any changes in the settings in this theme to refect those changes on user side.'; ?>
	  </span>
	</div>
	<style>
	.ses_tip_red > span {
	background-color:red;
	color: white;
	}
	</style>
<?php endif; ?>
<h2><?php echo $this->translate("Responsive Sportz Theme") ?></h2>
<?php if(!Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbasic')) { ?>
  	<div class="tip"><span><?php echo $this->translate("This plugin requires \"<a href='https://socialnetworking.solutions/social-engine/socialenginesolutions-basic-required-plugin/' target='_blank'>SocialNetworking.Solutions (SNS) Basic Required Plugin </a>\" to be installed and enabled on your website for Location and various other featrures to work. Please get the plugin from <a href='https://socialnetworking.solutions/social-engine/socialenginesolutions-basic-required-plugin/' target='_blank'>here</a> to install and enable on your site."); ?></span></div>
  <?php } ?>
<?php 
$sessportz_adminmenu = Zend_Registry::isRegistered('sessportz_adminmenu') ? Zend_Registry::get('sessportz_adminmenu') : null;
if(!empty($sessportz_adminmenu)) { ?>
<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
<?php } ?>
