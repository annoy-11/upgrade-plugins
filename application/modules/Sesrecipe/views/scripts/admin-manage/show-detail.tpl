<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: show-details.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesrecipe_view_stats_popup">
  <div class="sesrecipe_view_popup_con">
    <?php $recipeItem = Engine_Api::_()->getItem('sesrecipe_recipe', $this->claimItem->recipe_id);?>
    <?php $userItem = Engine_Api::_()->getItem('user', $this->claimItem->user_id);?>
    <div class="sesrecipe_popup_img_recipe">
      <p class="popup_img"><?php echo $this->itemPhoto($recipeItem, 'thumb.icon') ?></p>
      <p class="popup_title"><?php echo $recipeItem->getTitle();?></p>
    	<p class="owner_title"><b>Recipe Owner :</b><span class="owner_des"><?php echo $recipeItem->getOwner()->getTitle();?></span></p>
			 <p class="owner_title"><b>Claimed by &nbsp;:</b><span class="owner_des"><?php echo $userItem->getTitle();?></span></p>
    </div>
    <div class="sesrecipe_popup_owner_recipe">
      <p class="owner_title"><b>Reason for Claim:</b></p>
      <p class="owner_des"><?php echo $this->claimItem->description;?></p>
    </div>
  </div>
</div>
