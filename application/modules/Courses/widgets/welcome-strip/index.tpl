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
<div class="courses_welcome_strip sesbasic_bxs_ sesbasic_clearfix" style="background-image:url(application/modules/Courses/externals/images/strip-bg.jpg);">
  <div class="courses_welcome_strip_inner">
    <div class="_left">
     <span class="_top"><?php echo $this->heading1; ?></span>
     <span class="_quote"><?php echo $this->heading2; ?></span>
   </div>
   <div class="_right">
     <span class="_btn"><a href="<?php echo $this->buttonLink; ?>"><?php echo $this->buttonTitle; ?></a></span>
   </div>
  </div>
</div>

