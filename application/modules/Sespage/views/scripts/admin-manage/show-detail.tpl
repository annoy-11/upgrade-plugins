<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: show-details.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sespage_view_stats_popup">
  <div class="sespage_view_popup_con">
    <?php $pageItem = Engine_Api::_()->getItem('sespage_page', $this->claimItem->page_id);?>
    <?php $userItem = Engine_Api::_()->getItem('user', $this->claimItem->user_id);?>
    <div class="sespage_popup_img_page">
      <p class="popup_img"><?php echo $this->itemPhoto($pageItem, 'thumb.profile') ?></p>
      <p class="popup_title"><?php echo $pageItem->getTitle();?></p>
    	<p class="owner_title"><b>Page Owner :</b><span class="owner_des"><?php echo $pageItem->getOwner()->getTitle();?></span></p>
			 <p class="owner_title"><b>Claimed by &nbsp;:</b><span class="owner_des"><?php echo $userItem->getTitle();?></span></p>
    </div>
    <div class="sespage_popup_owner_page">
      <p class="owner_title"><b>Reason for Claim:</b></p>
      <p class="owner_des"><?php echo $this->claimItem->description;?></p>
    </div>
  </div>
</div>
