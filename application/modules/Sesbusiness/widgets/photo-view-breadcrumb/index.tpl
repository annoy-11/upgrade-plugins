<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sesbasic_ext_breadcrumb sesbasic_bxs sesbasic_clearfix">
  <div class="_mainhumb"><a href="<?php echo $this->business->getHref(); ?>"><img src="<?php echo $this->business->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>
  <div class="_maincont">
    <a href="<?php echo $this->business->getHref(); ?>"><?php echo $this->business->getTitle(); ?></a>
    <span class="sesbasic_text_light">&raquo;</span>
    <a href="<?php echo $this->album->getHref(); ?>"><?php echo $this->translate("Photo Albums"); ?></a>
    <span class="sesbasic_text_light">&raquo;</span>
    <a href="<?php echo $this->album->getHref(); ?>"><?php echo $this->album->getTitle(); ?></a>
    <?php if($this->photo->title) { ?>
      <span class="sesbasic_text_light">&raquo;</span>
      <a href="javascript:void(0);"><?php echo $this->photo->getTitle(); ?></a>
    <?php } ?>
  </div>
</div>
