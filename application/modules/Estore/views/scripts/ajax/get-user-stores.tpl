<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-user-stores.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div>
  <ul class="_list">
    <li data-rel="<?php echo $this->viewer()->getGuid(); ?>" class="estore_switcher_li _listitem sesbasic_clearfix _self">
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
    <?php foreach($this->stores as $store){?>
      <li data-rel="<?php echo $store->getGuid(); ?>" class="estore_switcher_li _listitem sesbasic_clearfix">
        <div class="_thumb">
          <img src="<?php echo $store->getPhotoUrl('thumb.icon'); ?>" />
        </div>
        <div class="_cont sesbasic_text_light">
          <span><?php echo $store->getTitle(); ?></span>
        </div>
    	</li>
    <?php } ?>
  </ul>
</div>
