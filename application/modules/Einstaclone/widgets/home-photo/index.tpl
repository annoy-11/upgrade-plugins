<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Einstaclone/externals/styles/styles.css'); ?>
<div class="einstaclone_member_info">
  <div class="einstaclone_member_photo">
    <a href="<?php echo $this->viewer()->getHref(); ?>"><?php echo $this->itemPhoto($this->viewer, 'thumb.profile', true); ?></a>
  </div>
  <h3><a href="<?php echo $this->viewer->getHref(); ?>"><?php echo $this->translate('%1$s', $this->viewer()->getTitle()); ?></a></h3>
  <h4><a href="<?php echo $this->viewer()->getHref(); ?>"><?php echo $this->viewer->username; ?></a></h4>
</div>
