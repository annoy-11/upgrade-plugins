<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: show-details.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesgroup_view_stats_popup">
  <div class="sesgroup_view_popup_con">
    <?php $groupItem = Engine_Api::_()->getItem('sesgroup_group', $this->claimItem->group_id);?>
    <?php $userItem = Engine_Api::_()->getItem('user', $this->claimItem->user_id);?>
    <div class="sesgroup_popup_img_group">
      <p class="popup_img"><?php echo $this->itemPhoto($groupItem, 'thumb.profile') ?></p>
      <p class="popup_title"><?php echo $groupItem->getTitle();?></p>
    	<p class="owner_title"><b>Group Owner :</b><span class="owner_des"><?php echo $groupItem->getOwner()->getTitle();?></span></p>
			 <p class="owner_title"><b>Claimed by &nbsp;:</b><span class="owner_des"><?php echo $userItem->getTitle();?></span></p>
    </div>
    <div class="sesgroup_popup_owner_group">
      <p class="owner_title"><b>Reason for Claim:</b></p>
      <p class="owner_des"><?php echo $this->claimItem->description;?></p>
    </div>
  </div>
</div>
