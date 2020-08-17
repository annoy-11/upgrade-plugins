<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesarticle/externals/styles/styles.css'); ?> 

<div class="sesbasic_sidebar_block sesarticle_review_owner_photo sesbasic_clearfix">
  <?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.profile')); ?>
  <?php if($this->title): ?>
    <span class="clear">
      <?php echo $this->htmlLink($this->item->getOwner(), $this->item->getOwner()) ?>
    </span>
  <?php endif; ?>
</div>
