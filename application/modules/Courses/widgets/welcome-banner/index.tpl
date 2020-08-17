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
<?php   $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/scripts/lity.js');
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/lity.css'); 
?> 
<div class="courses_welcome_banner sesbasic_bxs_ sesbasic_clearfix">
  <div class="courses_welcome_banner_inner">
     <div class="_left">
        <h2><?php echo $this->heading; ?></h2>
        <p class="sesbasic_text_light"><?php echo $this->description; ?></p>
        <a href="<?php echo $this->button1Link; ?>"><?php echo $this->button1Title; ?></a>
        <a href="<?php echo $this->button2Link; ?>"><?php echo $this->button2Title; ?></a>
       <div class="play-btn-main">
        <div class="play-btn">
          <?php if($this->video_type == "uploaded"): ?> 
           <a href="<?php echo $this->video; ?>" class="btn" data-lity ><i class="fa fa-play"></i></a>
          <?php else: ?>
            <a href="<?php echo $this->embedCode; ?>" class="btn" data-lity><i class="fa fa-play"></i></a>
          <?php endif; ?>
        </div>
      </div>
     </div>
     <div class="_right">
         <img src="<?php echo $this->image; ?>" />
     </div>
  </div>
</div>

