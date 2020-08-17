<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: show-details.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesarticle_view_stats_popup">
  <div class="sesarticle_view_popup_con">
    <?php $articleItem = Engine_Api::_()->getItem('sesarticle', $this->claimItem->article_id);?>
    <?php $userItem = Engine_Api::_()->getItem('user', $this->claimItem->user_id);?>
    <div class="sesarticle_popup_img_article">
      <p class="popup_img"><?php echo $this->itemPhoto($articleItem, 'thumb.icon') ?></p>
      <p class="popup_title"><?php echo $articleItem->getTitle();?></p>
    	<p class="owner_title"><b>Article Owner :</b><span class="owner_des"><?php echo $articleItem->getOwner()->getTitle();?></span></p>
			 <p class="owner_title"><b>Claimed by &nbsp;:</b><span class="owner_des"><?php echo $userItem->getTitle();?></span></p>
    </div>
    <div class="sesarticle_popup_owner_article">
      <p class="owner_title"><b>Reason for Claim:</b></p>
      <p class="owner_des"><?php echo $this->claimItem->description;?></p>
    </div>
  </div>
</div>
