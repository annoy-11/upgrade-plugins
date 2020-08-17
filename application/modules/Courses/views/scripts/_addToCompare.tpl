<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _addToCompare.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>

<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enablecomparision',1)) { ?>
<div class="_right">
    <?php $existsCompare = Engine_Api::_()->courses()->checkAddToCompare($course);
    $compareData = Engine_Api::_()->courses()->compareData($course); ?>
    <input type="checkbox" class="courses_compare_change courses_compare_course_<?php echo $course->getIdentity(); ?>" name="compare" <?php echo $existsCompare ? 'checked' : ''; ?> value="1" data-attr='<?php echo $compareData; ?>' />
    <span><?php echo $this->translate("Add To Compare"); ?></span>
    <span class="checkmark"></span>
</div>
<?php } ?>
