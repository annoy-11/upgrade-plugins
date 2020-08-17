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
<?php if (!empty($this->viewer_id)): ?>
  <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'courses')->isFavourite(array('resource_id' => $this->subject->course_id,'resource_type' => $this->subject->getType())); ?>
  <?php $favouriteClass = (!$favouriteStatus) ? 'fa-heart-o' : 'fa-heart' ;?>
  <?php $favouriteText = ($favouriteStatus) ?  $this->translate('Favorited') : $this->translate('Add to Favourite');?>
  <div class="courses_sidebar_button">
    <a href='javascript:;' data-type='favourite_course_button_view' data-url='<?php echo $this->subject->getIdentity(); ?>' data-status='<?php echo $favouriteStatus;?>' class="sesbasic_animation courses_link_btn sesbasic_animation courses_likefavfollow courses_favourite_view_<?php echo $this->subject->course_id ?> courses_favourite_course_view"><i class='fa <?php echo $favouriteClass ; ?>'></i><span style="display:none"><?php echo $this->subject->favourite_count; ?></span><span><?php echo $favouriteText; ?></span></a>
  </div>
<?php endif; ?>
