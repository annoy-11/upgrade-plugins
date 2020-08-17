<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: show-details.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="edocument_view_stats_popup">
  <div class="edocument_view_popup_con">
    <?php $documentItem = Engine_Api::_()->getItem('edocument', $this->claimItem->edocument_id);?>
    <?php $userItem = Engine_Api::_()->getItem('user', $this->claimItem->user_id);?>
    <div class="edocument_popup_img_document">
      <p class="popup_img"><?php echo $this->itemPhoto($documentItem, 'thumb.icon') ?></p>
      <p class="popup_title"><?php echo $documentItem->getTitle();?></p>
    	<p class="owner_title"><b>Document Owner :</b><span class="owner_des"><?php echo $documentItem->getOwner()->getTitle();?></span></p>
			 <p class="owner_title"><b>Claimed by &nbsp;:</b><span class="owner_des"><?php echo $userItem->getTitle();?></span></p>
    </div>
    <div class="edocument_popup_owner_document">
      <p class="owner_title"><b>Reason for Claim:</b></p>
      <p class="owner_des"><?php echo $this->claimItem->description;?></p>
    </div>
  </div>
</div>
