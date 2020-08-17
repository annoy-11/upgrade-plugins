<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epaytm
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: dismiss_message.tpl 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<h2><?php echo $this->translate("Paytm Payment Gateway") ?></h2>

<?php $epaytm_adminmenu = Zend_Registry::isRegistered('epaytm_adminmenu') ? Zend_Registry::get('epaytm_adminmenu') : null; ?>
<?php if(!empty($epaytm_adminmenu)) { ?>
<?php if(count($this->navigation) ): ?>
  <div class='sesbasic-admin-navgation'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
<?php } ?>
