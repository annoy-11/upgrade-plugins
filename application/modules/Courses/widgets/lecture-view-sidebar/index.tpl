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
<div class="courses_lecture_view_sidebar sesbasic_clearfix sesbasic_bxs">
   <div class="courses_lecture_view_sidebar_inner">
     <div class="courses_lecture_view_sidebar_head">
         <?php echo $this->course->getTitle(); ?>
     </div>
     <div class="courses_lecture_view_owner sesbasic_text_light">
         <?php echo $this->htmlLink($this->owner->getOwner()->getParent(), $this->itemPhoto($this->owner->getOwner()->getParent(), 'thumb.icon')); ?><?php echo $this->htmlLink($this->owner->getHref(),$this->owner->getTitle() ) ?>
     </div>
     </div>
     <div class="courses_lecture_view_sidebar_lectures">
        <ul>
          <?php foreach($this->paginator as $lecture): ?>
            <li <?php echo $this->lecture_id == $lecture->lecture_id ? 'class="active"':""; ?>><a href="<?php echo ($lecture->as_preview || $this->isPurchesed) ? $lecture->getHref() : "javascript:;" ?>"><?php if($lecture->photo_id){ ?><img src="<?php echo $lecture->getPhotoUrl(); ?>" /><?php } ?><?php echo $lecture->getTitle();  ?></a></li>
          <?php endforeach; ?>
        </ul>
     </div>
   </div>
</div>
