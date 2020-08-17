<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="layout_middle">
  <div class="sesbasic_ext_breadcrumb sesbasic_bxs sesbasic_clearfix">
    <div class="_mainhumb"><a href="<?php echo $this->parentItem->getHref(); ?>"><img src="<?php echo $this->parentItem->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon" /></a></div>
    <div class="_maincont">
      <a href="<?php echo $this->parentItem->getHref(); ?>"><?php echo $this->parentItem->getTitle(); ?></a>
      <span class="sesbasic_text_light">&raquo;</span>
      <span><?php echo $this->translate("Create Offer"); ?></span>
    </div>
  </div>
  <div class="sespageoffer_create">
		<?php echo $this->form->render($this) ?>
  </div>
</div>
<script type="text/javascript">
  $$('.core_main_sespage').getParent().addClass('active');
</script>
