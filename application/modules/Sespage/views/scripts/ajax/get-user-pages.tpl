<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-user-pages.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div>
  <ul class="_list">
    <li data-rel="<?php echo $this->viewer()->getGuid(); ?>" class="sespage_switcher_li _listitem sesbasic_clearfix _self">
      <div class="_thumb">
        <?php echo $this->itemPhoto($this->viewer(), 'thumb.icon', $this->viewer()->getTitle()); ?>
      </div>
      <div class="_cont sesbasic_text_light">
        <span><?php echo $this->viewer()->getTitle().' ('. $this->translate('YOU').')'; ?></span>
      </div>
    </li>
  </ul>
  <ul class="_list">
  	<li class="sesbasic_text_light _sep"><i class="fa fa-user"></i><?php echo $this->translate("PERSONAL")?></li>
    <?php foreach($this->pages as $page){?>
      <li data-rel="<?php echo $page->getGuid(); ?>" class="sespage_switcher_li _listitem sesbasic_clearfix">
        <div class="_thumb">
          <img src="<?php echo $page->getPhotoUrl('thumb.icon'); ?>" />
        </div>
        <div class="_cont sesbasic_text_light">
          <span><?php echo $page->getTitle(); ?></span>
        </div>
    	</li>
    <?php } ?>
  </ul>
</div>