<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Elivestreaming
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: dismiss_message.tpl 2019-10-01 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<h2><?php echo $this->translate("Live Streaming Plugin") ?></h2>
<?php $elivestreaming_adminmenu = Zend_Registry::isRegistered('elivestreaming_adminmenu') ? Zend_Registry::get('elivestreaming_adminmenu') : null; ?>
<?php if($elivestreaming_adminmenu) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
