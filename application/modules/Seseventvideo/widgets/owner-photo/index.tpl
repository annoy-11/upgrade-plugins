<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sesbasic_sidebar_block seseventvideo_profile_photo sesbasic_clearfix sesbasic_bxs">
  <?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile')) ?>
<?php if($this->title): ?>
  <span>
    <?php echo $this->translate('%s', $this->item->getTitle()); ?>
  </span>
<?php endif; ?>
</div>
