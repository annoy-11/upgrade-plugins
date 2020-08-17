<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbasic_breadcrumb sesbasic_bxs sesbasic_clearfix">
 <!-- <div class="_mainhumb"><a href="<?php echo $this->parentItem->getHref(); ?>"><img src="<?php echo $this->parentItem->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>-->
  <div class="_maincont">
    <a href="<?php echo $this->url(array('action' => 'home'), "sespagenote_general"); ?>"><?php echo $this->translate("Notes Home"); ?></a>
    <span class="sesbasic_text_light">&raquo;</span>
    <a href="<?php echo $this->parentItem->getHref(); ?>"><?php echo $this->parentItem->getTitle(); ?></a><span class="sesbasic_text_light">&nbsp;&raquo;</span>
    <?php echo $this->note->getTitle(); ?>
  </div>
</div>
