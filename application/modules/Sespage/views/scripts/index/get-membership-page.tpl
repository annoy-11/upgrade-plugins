<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: get-membership-page.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php foreach($this->result as $page){ ?>
<li class="sesbasic_clearfix">
  <input type="checkbox" name="multipage[]" value="<?php echo $page->getGuid(); ?>" />
  <div class="sesbasic_clearfix">
    <div class="_thumb">
      <img src="<?php echo $page->getPhotoUrl('thumb.normal'); ?>" class="thumb_icon" />
    </div>
    <div class="_cont">
      <p><?php echo $page->getTitle(); ?></p>
    </div>
  </div>  
</li>
<?php } ?>
<?php die; ?>