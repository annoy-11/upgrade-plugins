<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesrecipe/externals/styles/styles.css'); ?> 

<div class="sesbasic_sidebar_block sesrecipe_review_owner_photo sesbasic_clearfix">
  <?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile')); ?>
  <?php if($this->title): ?>
    <span class="clear">
      <?php echo $this->htmlLink($this->item->getOwner(), $this->item->getOwner()) ?>
    </span>
  <?php endif; ?>
</div>
