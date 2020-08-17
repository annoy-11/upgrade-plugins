<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbasic_breadcrumb sesbasic_bxs sesbasic_clearfix">
 <!-- <div class="_mainhumb"><a href="<?php echo $this->parentItem->getHref(); ?>"><img src="<?php echo $this->parentItem->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>-->
  <div class="_maincont">
    <a href="<?php echo $this->url(array('action' => 'home'), "sesbusinessoffer_general"); ?>"><?php echo $this->translate("Offers Home"); ?></a>
    <span class="sesbasic_text_light">&raquo;</span>
    <a href="<?php echo $this->parentItem->getHref(); ?>"><?php echo $this->parentItem->getTitle(); ?></a><span class="sesbasic_text_light">&nbsp;&raquo;</span>
    <?php echo $this->offer->getTitle(); ?>
  </div>
</div>
