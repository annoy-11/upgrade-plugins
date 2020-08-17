<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: corresponding-image.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(count($this->paginator) && !empty($this->paginator)) { ?>
  <?php foreach($this->paginator as $item){ ?>
    <a data-url="<?php echo $item->photo_id; ?>" class="sespage_corresponding_image_album" href="<?php echo $item->getHref(); ?>">
      <img src="<?php echo $item->getPhotoUrl('thumb.icon'); ?>"/>
    </a>
  <?php } ?>
<?php } ?>