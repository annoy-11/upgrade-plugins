<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: finish.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(empty($this->error)){ ?>
		The payment has been successfully sent to the course owner. <?php echo $this->htmlLink($this->url(array('route' => 'default', 'module' => 'courses', 'controller' => 'payment','action'=>'index')), $this->translate("Back to Payment Requests")); ?>
<?php }else{ ?>
	The payment has been failed or cancelled. <?php echo $this->htmlLink($this->url(array('route' => 'default', 'module' => 'courses', 'controller' => 'payment','action'=>'index')), $this->translate("Back to Payment Requests")); ?>
<?php } ?>
 
