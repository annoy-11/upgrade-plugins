<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursesalbum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: corresponding-image.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(count($this->paginator) && !empty($this->paginator)) { ?>
  <?php foreach($this->paginator as $item){ ?>
    <a data-url="<?php echo $item->photo_id; ?>" class="coursesalbum_corresponding_image_album" href="<?php echo $item->getHref(); ?>">
      <img src="<?php echo $item->getPhotoUrl('thumb.icon'); ?>"/>
    </a>
  <?php } ?>
<?php } ?>
