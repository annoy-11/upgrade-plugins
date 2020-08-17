<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _dataLabel.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(isset($this->featuredLabelActive) && $course->featured):?>
 <p class="courses_label_featured" title="<?php echo $this->translate('Featured');?>"><?php echo $this->translate('Featured');?></p>
<?php endif; ?>
<?php if(isset($this->sponsoredLabelActive) && $course->sponsored):?>
 <p class="courses_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><?php echo $this->translate('SPONSORED');?></p>
<?php endif; ?>
<?php if(isset($this->verifiedLabelActive) && $course->verified): ?>
  <p class="courses_label_verified" title="<?php echo $this->translate('verified');?>"><?php echo $this->translate('Verified');?></p>
<?php endif; ?>
