<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: show-detail.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesproduct_view_stats_popup">
  <div class="sesproduct_view_popup_con">
    <?php $productItem = Engine_Api::_()->getItem('sesproduct', $this->claimItem->product_id);?>
    <?php $userItem = Engine_Api::_()->getItem('user', $this->claimItem->user_id);?>
    <div class="sesproduct_popup_img_product">
      <p class="popup_img"><?php echo $this->itemPhoto($productItem, 'thumb.icon') ?></p>
      <p class="popup_title"><?php echo $productItem->getTitle();?></p>
    	<p class="owner_title"><b>Product Owner :</b><span class="owner_des"><?php echo $productItem->getOwner()->getTitle();?></span></p>
			 <p class="owner_title"><b>Claimed by &nbsp;:</b><span class="owner_des"><?php echo $userItem->getTitle();?></span></p>
    </div>
    <div class="sesproduct_popup_owner_product">
      <p class="owner_title"><b>Reason for Claim:</b></p>
      <p class="owner_des"><?php echo $this->claimItem->description;?></p>
    </div>
  </div>
</div>
