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
<div class="courses_gutter_labels">
  <div class="courses_list_labels ">
    <?php if($this->subject->featured): ?>
      <span class="courses_label_featured"><?php echo $this->translate('Featured');?></span>
    <?php endif; ?>
    <?php if($this->subject->sponsored): ?>
      <span class="courses_label_sponsored"><?php echo $this->translate('Sponsored');?></span>
    <?php endif; ?>
    <?php if($this->subject->verified): ?>
      <span class="courses_label_verified"><?php echo $this->translate('Verified');?></span>
    <?php endif; ?>
  </div>
</div>
