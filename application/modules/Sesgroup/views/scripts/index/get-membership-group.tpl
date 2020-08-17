<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-membership-group.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php foreach($this->result as $group){ ?>
<li class="sesbasic_clearfix">
  <input type="checkbox" name="multigroup[]" value="<?php echo $group->getGuid(); ?>" />
  <div class="sesbasic_clearfix">
    <div class="_thumb">
      <img src="<?php echo $group->getPhotoUrl('thumb.normal'); ?>" class="thumb_icon" />
    </div>
    <div class="_cont">
      <p><?php echo $group->getTitle(); ?></p>
    </div>
  </div>  
</li>
<?php } ?>
<?php die; ?>