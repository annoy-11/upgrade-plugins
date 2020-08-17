<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl 2018-07-28 00:00:00 SocialEngineSolutions $
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
<h2><?php echo $this->translate("Responsive Material Theme") ?></h2>
<?php 
$sesmaterial_adminmenu = Zend_Registry::isRegistered('sesmaterial_adminmenu') ? Zend_Registry::get('sesmaterial_adminmenu') : null;
if(!empty($sesmaterial_adminmenu)) { ?>
<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
<?php } ?>
