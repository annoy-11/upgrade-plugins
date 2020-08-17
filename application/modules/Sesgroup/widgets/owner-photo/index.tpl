<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sesbasic_sidebar_block sesgroup_owner_photo sesbasic_clearfix">
	<div class="sesgroup_owner_photo_img">
  	<?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile')) ?>
	</div>
<?php if($this->title): ?>
  <div class="sesgroup_owner_photo_name">
    <?php echo $this->translate('%s', $this->item->getTitle()); ?>
  </div>
<?php endif; ?>
</div>
