<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecometchatapi
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: dismiss_message.tpl 2019-12-18 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
  
<h2><?php echo $this->translate("Comet Chat APIs Integration") ?></h2>

<?php $ecometchatapi_adminmenu = Zend_Registry::isRegistered('ecometchatapi_adminmenu') ? Zend_Registry::get('ecometchatapi_adminmenu') : null; ?>
<?php if(!empty($ecometchatapi_adminmenu)) { ?>
<?php if(count($this->navigation) ): ?>
  <div class='sesbasic-admin-navgation'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
<?php } ?>
