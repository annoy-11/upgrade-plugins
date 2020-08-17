<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: course-policy.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="courses_policy">
    <div class="courses_term_condition">			  
        <h3><?php echo $this->translate('Terms and Conditions'); ?></h3>
        <p><?php echo $this->course->term_and_condition; ?></p>
    </div>
    <div class="courses_return_policy">		
        <h3><?php echo $this->translate('Return Policy'); ?></h3>
        <p><?php echo $this->course->return_policy; ?></p>
    </div>
</div>
