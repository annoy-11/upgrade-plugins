<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-membership-business.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php foreach($this->result as $business){ ?>
<li class="sesbasic_clearfix">
  <input type="checkbox" name="multibusiness[]" value="<?php echo $business->getGuid(); ?>" />
  <div class="sesbasic_clearfix">
    <div class="_thumb">
      <img src="<?php echo $business->getPhotoUrl('thumb.normal'); ?>" class="thumb_icon" />
    </div>
    <div class="_cont">
      <p><?php echo $business->getTitle(); ?></p>
    </div>
  </div>  
</li>
<?php } ?>
<?php die; ?>
