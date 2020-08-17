<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sesbasic_sidebar_block sespagevideo_profile_photo sesbasic_clearfix sesbasic_bxs">
  <?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile')) ?>
<?php if($this->title): ?>
  <span>
    <?php echo $this->translate('%s', $this->item->getTitle()); ?>
  </span>
<?php endif; ?>
</div>
