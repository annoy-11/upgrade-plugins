<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: policy.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'courses', array('course' => $this->course));	
?>
  <div class="courses_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
<?php if(isset($this->form)): ?>
  <div class="courses_dashboard_form courses_db_overview_form"><?php echo $this->form->render() ?></div>
<?php endif; ?>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
