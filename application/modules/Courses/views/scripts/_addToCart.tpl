<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _addCart.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $setting = Engine_Api::_()->getApi('settings', 'core'); ?>
<a href="javascript:;" data-action="<?php echo $course->course_id; ?>" class="course_addtocart" title="<?php echo $this->translate('Add to Cart'); ?>">
    <?php if($setting->getSetting('courses.cartviewtype') == 2 || !empty($this->icon)){ ?>
        <i class="fa fa-shopping-cart"></i>
    <?php } elseif($setting->getSetting('courses.cartviewtype') == 1){ ?>
        <i class="fa fa-shopping-cart"></i> <?php echo $this->translate("Add to Cart"); ?>
    <?php } else { ?>
       <i class="fa fa-shopping-cart"></i> <?php echo $this->translate("Add to Cart"); ?>
    <?php } ?>
</a>
