<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-user-businesses.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div>
  <ul class="_list">
    <li data-rel="<?php echo $this->viewer()->getGuid(); ?>" class="sesbusiness_switcher_li _listitem sesbasic_clearfix _self">
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
    <?php foreach($this->businesses as $business){?>
      <li data-rel="<?php echo $business->getGuid(); ?>" class="sesbusiness_switcher_li _listitem sesbasic_clearfix">
        <div class="_thumb">
          <img src="<?php echo $business->getPhotoUrl('thumb.icon'); ?>" />
        </div>
        <div class="_cont sesbasic_text_light">
          <span><?php echo $business->getTitle(); ?></span>
        </div>
    	</li>
    <?php } ?>
  </ul>
</div>
