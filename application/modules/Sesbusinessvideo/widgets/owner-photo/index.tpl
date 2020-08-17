<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbasic_sidebar_block sesbusinessvideo_profile_photo sesbasic_clearfix sesbasic_bxs">
  <?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile')) ?>
<?php if($this->title): ?>
  <span>
    <?php echo $this->translate('%s', $this->item->getTitle()); ?>
  </span>
<?php endif; ?>
</div>
