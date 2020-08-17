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
<div class="courses_lecture_view sesbasic_clearfix sesbasic_bxs">
   <div class="courses_lecture_view_inner">
    <div class="courses_lecture_view_strip">
     <div class="courses_lecture_view_head">
         <?php echo $this->lecture->title; ?>
     </div>
    <!-- <div class="courses_lecture_view_time sesbasic_text_light">
          <i class="fa fa-clock-o"></i>25:00
     </div>-->
     </div>
     <div class="courses_lecture_view_cont sesbasic_text_light">
      <?php if($this->lecture->type == "html"){ ?>
         <?php echo $this->lecture->code; ?>
      <?php }elseif($this->lecture->type == "external"){ ?>
        <div class="courses_lecture_video">
          <?php echo $this->lecture->code; ?>
        </div>
      <?php }else{ ?>
        <div class="courses_lecture_video">
          <iframe src="<?php echo $this->lecture_location; ?>"></iframe>
          <?php if($this->lecture->status == 0): ?>
              <div class="tip">
                <span>
                  <?php echo $this->translate('Your video is in queue to be processed - you will be notified when it is ready to be viewed.')?>
                </span>
              </div>
            <?php elseif($this->lecture->status == 2):?>
              <div class="tip">
                <span>
                  <?php echo $this->translate('Your video is currently being processed - you will be notified when it is ready to be viewed.')?>
                </span>
              </div>
            <?php elseif($this->lecture->status == 3):?>
              <div class="tip">
                <span>
                <?php echo $this->translate('Video conversion failed. Please try %1$suploading again%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'courses','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>
                </span>
              </div>
            <?php elseif($this->lecture->status == 4):?>
              <div class="tip">
                <span>
                <?php echo $this->translate('Video conversion failed. Video format is not supported by FFMPEG. Please try %1$sagain%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'courses','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>
                </span>
              </div>
            <?php elseif($this->lecture->status == 5):?>
              <div class="tip">
                <span>
                <?php echo $this->translate('Video conversion failed. Audio files are not supported. Please try %1$sagain%2$s.', '<a href="'.$this->url(array('action' => 'create','module'=>'courses','controller'=>'index'),'default',true).'/type/3'.'">', '</a>'); ?>
                </span>
              </div>
            <?php endif; ?>
        </div>
      <?php } ?>
     </div>
   </div>
</div>
