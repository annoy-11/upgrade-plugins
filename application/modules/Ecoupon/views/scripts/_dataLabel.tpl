<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _dataLabel.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(isset($this->featuredLabelActive) && $coupon->featured):  ?>
 <p class="ecoupon_label_featured" title="<?php echo $this->translate('Featured');?>"><?php echo $this->translate('Featured');?></p>
<?php endif; ?>
<?php if(isset($this->hotLabelActive) && $coupon->hot): ?>
  <p class="ecoupon_label_verified" title="<?php echo $this->translate('Hot');?>"><?php echo $this->translate('Hot');?></p>
<?php endif; ?>
