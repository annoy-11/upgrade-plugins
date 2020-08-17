<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: finish.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(empty($this->error)){ ?>
		The payment has been successfully sent to the store owner. <?php echo $this->htmlLink($this->url(array('route' => 'default', 'module' => 'sesproduct', 'controller' => 'payment','action'=>'index')), $this->translate("Back to Payment Requests")); ?>
<?php }else{ ?>
	The payment has been failed or cancelled. <?php echo $this->htmlLink($this->url(array('route' => 'default', 'module' => 'sesproduct', 'controller' => 'payment','action'=>'index')), $this->translate("Back to Payment Requests")); ?>
<?php } ?>
 