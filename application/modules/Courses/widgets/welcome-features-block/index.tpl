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
<div class="courses_welcome_features sesbasic_bxs_ sesbasic_clearfix">
  <div class="courses_welcome_features_inner">
     <div class="_right">
        <ul>
          <li>
           <img src="<?php echo $this->image1; ?>" />
            <div class="_cont">
            <h4><?php echo $this->block1title; ?></h4> 
            <p><?php echo $this->block1Text; ?></p></div>
          </li>
          <li> 
          <img src="<?php echo $this->image2; ?>" />
            <div class="_cont">
            <h4><?php echo $this->block2title; ?></h4>
            <p><?php echo $this->block2Text; ?></p>
            </div>
          </li>
          <li>
          <img src="<?php echo $this->image3; ?>" />
            <div class="_cont">
            <h4><?php echo $this->block3title; ?></h4>
            <p><?php echo $this->block3Text; ?></p>
            </div>
          </li>
          <li>
          <img src="<?php echo $this->image4; ?>" />
            <div class="_cont">
              <h4><?php echo $this->block4title; ?></h4>
              <p><?php echo $this->block4Text; ?></p>
            </div>
          </li>
        </ul>
     </div>
     <div class="_left">
        <h2><?php echo $this->heading; ?></h2>
        <h3><?php echo $this->headingText; ?></h3>
        <p class="sesbasic_text_light"><?php echo $this->description; ?></p>
        <a href="<?php echo $this->buttonLink; ?>"><?php echo $this->buttonTitle; ?></a>
     </div>
  </div>
</div>

