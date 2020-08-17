<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _cources.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer_id = $this->viewer_id; ?>
<?php foreach($this->courseEntries as $courseEntrie) { ?>
  <li id="sesprofilefield_course_<?php echo $courseEntrie->course_id; ?>">
    <div class="courses_details_main">
      <div class="courses_details">
        <p class="courses_name"><?php echo $courseEntrie->title; ?></p>
        <?php if($courseEntrie->number) { ?>
          <p class="date sesbasic_text_light">
            <span><?php echo $courseEntrie->number; ?></span>
          </p>
        <?php } ?>
        
        <?php if($courseEntrie->associate_with) { ?>
          <p class="courses_des"><?php echo $courseEntrie->associate_with; ?></p>
        <?php } ?>
      </div>
      <div class="field_option">
        <?php if($viewer_id == $courseEntrie->owner_id) { ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'edit-course', 'course_id' => $courseEntrie->course_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-pencil')); ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'delete-course', 'course_id' => $courseEntrie->course_id), $this->translate('	'), array('class' => 'sessmoothbox fa fa-trash')); ?>
        <?php } ?>
      </div>
    </div>
  </li>
<?php } ?>
