<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sesbasic_sidebar_block sesbusiness_owner_photo sesbasic_clearfix">
	<div class="sesbusiness_owner_photo_img">
  	<?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile')) ?>
	</div>
<?php if($this->title): ?>
  <div class="sesbusiness_owner_photo_name">
    <?php echo $this->translate('%s', $this->item->getTitle()); ?>
  </div>
<?php endif; ?>
</div>
