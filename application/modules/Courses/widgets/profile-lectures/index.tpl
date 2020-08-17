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
<div class="courses_profile_lectures sesbasic_clearfix sesbasic_bxs">
	  <div class="courses_profile_lectures_inner">
         <div class="profile_lectures_head">
             <h3><?php echo $this->translate('Course Content'); ?></h3>
             <p><?php echo $this->translate(array('%s Lecture', '%s Lectures', $this->course->lecture_count), $this->locale()->toNumber($this->course->lecture_count))?></p>
             <p><?php echo date('H:i:s',$this->course->getDuration()->duration); ?></p>
         </div>
         <div class="courses_lecture_main_box">
          <div class="courses_lecture_accordion">
            <span class="_name"><?php echo $this->course->getTitle(); ?></span>
            <span class="_time"><?php echo date('H:i:s',$this->course->getDuration()->duration); ?></span>
          </div>
          <div class="panel"> 
              <?php foreach($this->paginator as $lecture): ?>
                <div class="lecture_box <?php echo ($lecture->as_preview || $this->isPurchesed) ? "can_view_lecture" : "not_view_lecture"; ?>">
                    <span class="topic_name">
                      <a href="<?php echo ($lecture->as_preview || $this->isPurchesed) ? $lecture->getHref() : "javascript:;" ?>" class="sessmoothbox">
                      <?php if(empty($lecture->getPhotoUrl())){ ?>
                        <i class="fa fa-play-circle"></i>
                      <?php } else { ?>
                        <img src="<?php echo $lecture->getPhotoUrl(); ?>" />
                      <?php } ?>
                      <span style="background-image:url(<?php echo $lecture->getPhotoUrl(); ?>);display:none;"></span><?php echo $lecture->getTitle();  ?></a>
                    </span>
                    <span class="preview_btn">
                      <a href="<?php echo ($lecture->as_preview || $this->isPurchesed) ? $lecture->getHref() : "javascript:;" ?>" class="sessmoothbox"><?php echo ($lecture->as_preview) ? $this->translate('Preview') : ""; ?><span style="background-image:url(<?php echo $lecture->getPhotoUrl(); ?>);display:none;"></span></a>
                    </span>
                    <?php if(($lecture->duration != 0) && !empty($lecture->duration)): ?>
                      <span class="lec_time">
                        <?php echo date('H:i:s',$lecture->duration); ?>
                      </span>
                    <?php endif; ?>
                </div>
              <?php endforeach; ?>
          </div>
       </div>
    </div>
</div>
<script>
var acc = document.getElementsByClassName("courses_lecture_accordion");
var i;
for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>
