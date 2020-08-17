<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-service.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/scripts/core.js'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesbusiness', array(
	'business' => $this->business,
      ));	
?>
<div class="sesbusiness_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs sesbusiness_dashboard_manage_services">
<?php } ?>
  <div class="sesbusiness_dashboard_content_top sesbasic_clearfix">
  	<div class="_left"> 
      <h3><?php echo $this->translate("Services")?></h3>
      <p><?php echo $this->translate("You can add your business service by click on Add New Service link."); ?></p> 
  	</div>
    <div class="_img centerT">
    
    </div>
  </div>
  <section class="sesbusiness_dashboard_services">
    <div class="sesbusiness_dashboard_content_btns">
      <a href="<?php echo $this->url(array('business_id' => $this->business->business_id, 'action'=>'addservice'),'sesbusiness_dashboard',true);?>" class="sessmoothbox sesbasic_button"><i class="fa fa-plus"></i><span><?php echo $this->translate("Add Service");?></span></a>
    </div>
    <div class="sesbusiness_dashboard_services_listing" id="sesbusinesseservice_services">
      <?php include APPLICATION_PATH . '/application/modules/Sesbusiness/views/scripts/_services.tpl'; ?>
    </div>
  </section>  
  <?php if(!$this->is_ajax){ ?>
    </div>
  </section>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
