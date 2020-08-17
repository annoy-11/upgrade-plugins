<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?> 
<div class="courses_welcome_members sesbasic_bxs sesbasic_clearfix">
  <h2><?php echo $this->heading; ?></h2>
  <p><?php echo $this->description; ?></p>
  <div class="courses_welcome_members_inner">
     <ul class="_teachers">
      <?php foreach($this->leftpaginator as $user): ?>
        <?php $owner = $user->getOwner();?>
        <li>
           <div class="_img">
              <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
           </div>
           <span class="_name"><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></span>
           <span class="_post sesbasic_text_light"><?php echo $this->leftMemberType->getTitle(); ?></span>
        </li>
      <?php endforeach; ?>
     </ul>
     <ul class="_coach">
      <?php foreach($this->rightpaginator as $user): ?>
        <?php $owner = $user->getOwner();?>
        <li>
           <div class="_img">
              <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
           </div>
           <span class="_name"><?php echo $this->htmlLink($owner->getHref(), $owner->getTitle()) ?></span>
           <span class="_post sesbasic_text_light"><?php echo $this->rightMemberType->getTitle(); ?></span>
        </li>
      <?php endforeach; ?>
     </ul>
  </div>
</div>

