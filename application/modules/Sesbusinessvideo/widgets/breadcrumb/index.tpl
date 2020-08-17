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
<div class="sesbasic_ext_breadcrumb sesbasic_bxs sesbasic_clearfix">
  <div class="_mainhumb"><a href="<?php echo $this->business->getHref(); ?>"><img src="<?php echo $this->business->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>
  <div class="_maincont">
    <a href="<?php echo $this->url(array('action' => 'home'), "sesbusinessvideo_general"); ?>"><?php echo $this->translate("Videos Home"); ?></a>
    <span class="sesbasic_text_light">&raquo;</span>
    <a href="<?php echo $this->business->getHref(); ?>"><?php echo $this->business->getTitle(); ?></a><span class="sesbasic_text_light">&raquo;</span>
    <?php echo $this->video->getTitle(); ?>

  </div>
</div>
