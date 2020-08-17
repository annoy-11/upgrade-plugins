<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: mainphoto.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(!$this->is_ajax) {
  echo $this->partial('dashboard/left-bar.tpl', 'eclassroom', array('classroom' => $this->classroom));	
?>
	<div class="classroom_dashboard_content sesbm sesbasic_clearfix">
<?php }  ?>
	<div class="classroom_dashboard_form">
    <div class="classroom_edit_photo_blog">
      <?php echo $this->form->render() ?> 
    </div> 
	</div>
<?php if(!$this->is_ajax) { ?>
	</div>
</div>
<?php } ?>
