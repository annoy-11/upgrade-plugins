<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sesbasic_ext_breadcrumb sesbasic_bxs sesbasic_clearfix">
  <div class="_mainhumb"><a href="<?php echo $this->group->getHref(); ?>"><img src="<?php echo $this->group->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>
  <div class="_maincont">
    <a href="<?php echo $this->group->getHref(); ?>"><?php echo $this->group->getTitle(); ?></a>
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