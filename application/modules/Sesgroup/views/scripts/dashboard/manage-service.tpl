<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-service.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/scripts/core.js'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array(
	'group' => $this->group,
      ));	
?>
<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs sesgroup_dashboard_manage_services">
<?php } ?>
  <div class="sesgroup_dashboard_content_top sesbasic_clearfix">
  	<div class="_left"> 
      <h3><?php echo $this->translate("Services")?></h3>
      <p><?php echo $this->translate("You can add your group service by click on Add New Service link."); ?></p> 
  	</div>
    <div class="_img centerT">
    
    </div>
  </div>
  <section class="sesgroup_dashboard_services">
    <div class="sesgroup_dashboard_content_btns">
      <a href="<?php echo $this->url(array('group_id' => $this->group->group_id, 'action'=>'addservice'),'sesgroup_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Service");?></span></a>
    </div>
    <div class="sesgroup_dashboard_services_listing" id="sesgroupservice_services">
      <?php include APPLICATION_PATH . '/application/modules/Sesgroup/views/scripts/_services.tpl'; ?>
    </div>
  </section>  
  <?php if(!$this->is_ajax){ ?>
    </div>
  </section>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>