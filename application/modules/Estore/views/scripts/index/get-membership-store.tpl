<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-membership-store.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php foreach($this->result as $store){ ?>
<li class="sesbasic_clearfix">
  <input type="checkbox" name="multistore[]" value="<?php echo $store->getGuid(); ?>" />
  <div class="sesbasic_clearfix">
    <div class="_thumb">
      <img src="<?php echo $store->getPhotoUrl('thumb.normal'); ?>" class="thumb_icon" />
    </div>
    <div class="_cont">
      <p><?php echo $store->getTitle(); ?></p>
    </div>
  </div>  
</li>
<?php } ?>
<?php die; ?>
