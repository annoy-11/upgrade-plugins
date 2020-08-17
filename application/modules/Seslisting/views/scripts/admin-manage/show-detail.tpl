<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: show-detail.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="seslisting_view_stats_popup">
  <div class="seslisting_view_popup_con">
    <?php $listingItem = Engine_Api::_()->getItem('seslisting', $this->claimItem->listing_id);?>
    <?php $userItem = Engine_Api::_()->getItem('user', $this->claimItem->user_id);?>
    <div class="seslisting_popup_img_listing">
      <p class="popup_img"><?php echo $this->itemPhoto($listingItem, 'thumb.icon') ?></p>
      <p class="popup_title"><?php echo $listingItem->getTitle();?></p>
    	<p class="owner_title"><b>Listing Owner :</b><span class="owner_des"><?php echo $listingItem->getOwner()->getTitle();?></span></p>
			 <p class="owner_title"><b>Claimed by &nbsp;:</b><span class="owner_des"><?php echo $userItem->getTitle();?></span></p>
    </div>
    <div class="seslisting_popup_owner_listing">
      <p class="owner_title"><b>Reason for Claim:</b></p>
      <p class="owner_des"><?php echo $this->claimItem->description;?></p>
    </div>
  </div>
</div>
