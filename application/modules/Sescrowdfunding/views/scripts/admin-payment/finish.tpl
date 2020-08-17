<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: finish.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(empty($this->error)){ ?>
		The payment has been successfully sent to the crowdfunding owner. <?php echo $this->htmlLink($this->url(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'payment','action'=>'index')), $this->translate("Back to Payment Requests")); ?>
<?php }else{ ?>
	The payment has been failed or cancelled. <?php echo $this->htmlLink($this->url(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'payment','action'=>'index')), $this->translate("Back to Payment Requests")); ?>
<?php } ?>
 