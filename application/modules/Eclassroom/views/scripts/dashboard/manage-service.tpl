<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: manage-serice.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/scripts/core.js'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'eclassroom', array(
	'classroom' => $this->classroom,
      ));	
?>
<div class="classroom_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs classroom_dashboard_manage_services">
<?php } ?>
  <div class="classroom_dashboard_content_header sesbasic_clearfix">
  	<div class="_left"> 
      <h3><?php echo $this->translate("Services")?></h3>
      <p><?php echo $this->translate("You can add your store service by click on Add New Service link."); ?></p> 
  	</div>
    <div class="_img centerT">
    
    </div>
  </div>
  <section class="classroom_dashboard_services">
    <div class="classroom_dashboard_content_btns">
      <a href="<?php echo $this->url(array('classroom_id' => $this->classroom->classroom_id, 'action'=>'addservice'),'eclassroom_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i> <span><?php echo $this->translate("Add Service");?></span></a>
    </div>
    <div class="classroom_dashboard_services_listing" id="classroomservice_services">
      <?php include APPLICATION_PATH . '/application/modules/Eclassroom/views/scripts/_services.tpl'; ?>
    </div>
  </section>  
  <?php if(!$this->is_ajax){ ?>
    </div>
  </section>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
