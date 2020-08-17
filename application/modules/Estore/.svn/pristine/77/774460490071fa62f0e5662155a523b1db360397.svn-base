<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-service.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/scripts/core.js'); ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'estore', array(
	'store' => $this->store,
      ));	
?>
<div class="estore_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs estore_dashboard_manage_services">
<?php } ?>
  <div class="estore_dashboard_content_header sesbasic_clearfix">
  	<div class="_left"> 
      <h3><?php echo $this->translate("Services")?></h3>
      <p><?php echo $this->translate("You can add your store service by click on Add New Service link."); ?></p> 
  	</div>
    <div class="_img centerT">
    
    </div>
  </div>
  <section class="estore_dashboard_services">
    <div class="estore_dashboard_content_btns">
      <a href="<?php echo $this->url(array('store_id' => $this->store->store_id, 'action'=>'addservice'),'estore_dashboard',true);?>" class="sessmoothbox estore_link_btn"><i class="fa fa-plus"></i> <span><?php echo $this->translate("Add Service");?></span></a>
    </div>
    <div class="estore_dashboard_services_listing" id="estoreservice_services">
      <?php include APPLICATION_PATH . '/application/modules/Estore/views/scripts/_services.tpl'; ?>
    </div>
  </section>  
  <?php if(!$this->is_ajax){ ?>
    </div>
  </section>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
