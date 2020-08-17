<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sesbasic_ext_breadcrumb sesbasic_bxs sesbasic_clearfix">
  <div class="_mainhumb"><a href="<?php echo $this->page->getHref(); ?>"><img src="<?php echo $this->page->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>
  <div class="_maincont">
    <a href="<?php echo $this->page->getHref(); ?>"><?php echo $this->page->getTitle(); ?></a>
    <span class="sesbasic_text_light">&raquo;</span>
    <a href="<?php echo $this->album->getHref(); ?>"><?php echo $this->translate("Photo Albums"); ?></a>
    <span class="sesbasic_text_light">&raquo;</span>
    <?php echo $this->album->getTitle(); ?>
  </div>
</div>