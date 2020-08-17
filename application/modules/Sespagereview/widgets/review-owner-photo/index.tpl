<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagereview/externals/styles/styles.css'); ?> 

<div class="sesbasic_sidebar_block sespagereview_photo_block sespagereview_review_owner_photo sesbasic_clearfix">
  <?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile')); ?>
  <?php if($this->title): ?>
    <span class="clear">
      <?php echo $this->htmlLink($this->item->getOwner(), $this->item->getOwner()) ?>
    </span>
  <?php endif; ?>
</div>
