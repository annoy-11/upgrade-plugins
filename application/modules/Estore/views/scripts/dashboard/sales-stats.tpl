
<?php if(!$this->is_ajax){ 
  echo $this->partial('dashboard/left-bar.tpl', 'estore', array(
 	 'store' => $this->store,
  ));	
?>
	<div class="estore_dashboard_content sesbm sesbasic_clearfix">
<?php }
?>
<?php $defaultCurrency = Engine_Api::_()->estore()->defaultCurrency(); ?>
  <div class="estore_dashboard_content_header sesbasic_clearfix">
    <h3><?php echo $this->translate("Sales Stats"); ?></h3>
  </div>
  <div class="estore_sale_stats_container sesbasic_bxs sesbasic_clearfix">
  	<div class="estore_sale_stats">
    	<span><?php echo $this->translate("Today"); ?></span>
      <span><?php echo Engine_Api::_()->estore()->getCurrencyPrice($this->todaySale,$defaultCurrency); ?></span>
    </div>
  	<div class="estore_sale_stats">
    	<span><?php echo $this->translate("This Week"); ?></span>
      <span><?php echo Engine_Api::_()->estore()->getCurrencyPrice($this->weekSale,$defaultCurrency); ?></span>
    </div>
  	<div class="estore_sale_stats">
    	<span><?php echo $this->translate("This Month"); ?></span>
      <span><?php echo Engine_Api::_()->estore()->getCurrencyPrice($this->monthSale,$defaultCurrency); ?></span>
    </div>
  </div>
  
  <div class="estore_dashboard_ticket_statics sesbasic_bxs sesbasic_clearfix">
   <div class="estore_dashboard_content_header sesbasic_clearfix">
      <h3><?php echo $this->translate("Order Statistics"); ?></h3>
    </div>
    <div class="estore_sale_stats_container sesbasic_bxs sesbasic_clearfix">
      <div class="estore_sale_stats"><span><?php echo $this->translate("Total Order"); ?></span><span><?php echo $this->storeStatsSale['totalOrder'] ?></span></div>
        <div class="estore_sale_stats"><span><?php echo $this->translate("Total Products Sold"); ?></span><span><?php echo $this->storeStatsSale['total_products'] ?></span></div>
        <div class="estore_sale_stats"><span><?php echo $this->translate("Total Commission Amount"); ?></span><span><?php echo Engine_Api::_()->estore()->getCurrencyPrice($this->storeStatsSale['commission_amount'],$defaultCurrency) ?> </span></div>
        <div class="estore_sale_stats"><span><?php echo $this->translate("Total Shipping Amount"); ?></span><span><?php echo Engine_Api::_()->estore()->getCurrencyPrice($this->storeStatsSale['total_shippingtax_cost']); ?></span></div>
        <div class="estore_sale_stats"><span><?php echo $this->translate("Total Tax Amount"); ?></span><span><?php echo Engine_Api::_()->estore()->getCurrencyPrice($this->storeStatsSale['total_billingtax_cost'],$defaultCurrency); ?></span></div>
        <div class="estore_sale_stats"><span><?php echo $this->translate("Total Admin Tax Amount"); ?></span><span><?php echo Engine_Api::_()->estore()->getCurrencyPrice($this->storeStatsSale['total_admintax_cost'],$defaultCurrency); ?></span></div>
    </div>
  </div>
<?php if(!$this->is_ajax){ ?>
</div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>