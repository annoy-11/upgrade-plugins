<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessreview/externals/styles/styles.css'); ?> 

<div class="sesbasic_sidebar_block sesbusinessreview_photo_block sesbusinessreview_review_owner_photo sesbasic_clearfix">
  <?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile')); ?>
  <?php if($this->title): ?>
    <span class="clear">
      <?php echo $this->htmlLink($this->item->getHref(), $this->item->getTitle()) ?>
    </span>
  <?php endif; ?>
</div>
