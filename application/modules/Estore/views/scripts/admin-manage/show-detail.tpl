<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: show-details.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="estore_view_stats_popup">
  <div class="estore_view_popup_con">
    <?php $storeItem = Engine_Api::_()->getItem('stores', $this->claimItem->store_id);?>
    <?php $userItem = Engine_Api::_()->getItem('user', $this->claimItem->user_id);?>
    <div class="estore_popup_img_store">
      <p class="popup_img"><?php echo $this->itemPhoto($storeItem, 'thumb.profile') ?></p>
      <p class="popup_title"><?php echo $storeItem->getTitle();?></p>
    	<p class="owner_title"><b>Store Owner :</b><span class="owner_des"><?php echo $storeItem->getOwner()->getTitle();?></span></p>
			 <p class="owner_title"><b>Claimed by &nbsp;:</b><span class="owner_des"><?php echo $userItem->getTitle();?></span></p>
    </div>
    <div class="estore_popup_owner_store">
      <p class="owner_title"><b>Reason for Claim:</b></p>
      <p class="owner_des"><?php echo $this->claimItem->description;?></p>
    </div>
  </div>
</div>
