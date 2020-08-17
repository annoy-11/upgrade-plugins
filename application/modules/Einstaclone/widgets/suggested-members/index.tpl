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
<div class="einstaclone_suggested_members">
   <div class="einstaclone_suggested_members_inner">
     <a href="members" class="view_all" title="<?php echo $this->translate('View All'); ?>"><i class="fa fa-angle-right"></i></a>
      <?php foreach($this->results as $item) { ?>
        <div class="einstaclone_member_item">
          <div class="_img">
            <a href="<?php echo $item->getHref(); ?>"><?php echo $this->itemPhoto($item, 'thumb.icon'); ?></a>
          </div> 
          <div class="_cont">
              <span class="_username"><a href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a></span>
              <span class="_name einstaclone_text_light"><?php echo $item->username; ?></span>
          </div>
          <div class="_btn">
            <?php echo $this->partial('_addfriend.tpl', 'einstaclone', array('subject' => $item)); ?>
          </div>
        </div>
      <?php } ?>
   </div>
</div>
