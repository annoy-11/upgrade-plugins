<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<h3><?php echo $this->translate($this->title);?></h3>
<div class="sesbasic_sidebar_block sescf_owner_photo_block sesbasic_clearfix sesbasic_bxs">
  <?php if($this->photoviewtype == 'square'): ?>
    <div class="sescf_owner_photo_block_photo"><?php echo $this->htmlLink($this->crowdfunding->getOwner()->getHref(), $this->itemPhoto($this->crowdfunding->getOwner())); ?></div>
  <?php else: ?>
  	<div class="sescf_owner_photo_block_photo isrounded" style="height:<?php echo $this->height?>px;width:<?php echo $this->width?>px;"><?php echo $this->htmlLink($this->crowdfunding->getOwner()->getHref(), $this->itemPhoto($this->crowdfunding->getOwner())) ?></div>
	<?php endif; ?>
  <div class="sescf_owner_photo_block_name">
  	<a href="<?php echo $this->crowdfunding->getOwner()->getHref(); ?>"><?php echo $this->crowdfunding->getOwner()->getTitle(); ?></a>
  </div>
</div>
