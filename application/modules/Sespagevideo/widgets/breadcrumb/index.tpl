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
<div class="sesbasic_ext_breadcrumb sesbasic_bxs sesbasic_clearfix">
  <div class="_mainhumb"><a href="<?php echo $this->page->getHref(); ?>"><img src="<?php echo $this->page->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>
  <div class="_maincont">
    <a href="<?php echo $this->url(array('action' => 'home'), "sespagevideo_general"); ?>"><?php echo $this->translate("Videos Home"); ?></a>
    <span class="sesbasic_text_light">&raquo;</span>
    <a href="<?php echo $this->page->getHref(); ?>"><?php echo $this->page->getTitle(); ?></a><span class="sesbasic_text_light">&raquo;</span>
    <?php echo $this->video->getTitle(); ?>

  </div>
</div>
