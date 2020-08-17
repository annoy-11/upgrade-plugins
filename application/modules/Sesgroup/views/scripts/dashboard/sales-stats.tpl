
<?php if(!$this->is_ajax){ 
  echo $this->partial('dashboard/left-bar.tpl', 'sesgroup', array(
 	 'group' => $this->group,
  ));	
?>
	<div class="sesgroup_dashboard_content sesbm sesbasic_clearfix">
<?php } 
?>
<?php $defaultCurrency = Engine_Api::_()->egroupjoinfees()->defaultCurrency(); ?>
  <div class="sesbasic_dashboard_content_header sesbasic_clearfix">
    <h3><?php echo $this->translate("Sales Stats"); ?></h3>
  </div>
  <div class="sesgroup_db_sale_stats_container sesbasic_bxs sesbasic_clearfix">
  	<div class="sesgroup_db_sale_stats">
    	<section>
        <span><?php echo $this->translate("Today"); ?></span>
        <span><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($this->todaySale,$defaultCurrency); ?></span>
    	</section>
    </div>
  	<div class="sesgroup_db_sale_stats">
			<section>
        <span><?php echo $this->translate("This Week"); ?></span>
        <span><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($this->weekSale,$defaultCurrency); ?></span>
    	</section>
    </div>
  	<div class="sesgroup_db_sale_stats">
			<section>
        <span><?php echo $this->translate("This Month"); ?></span>
        <span><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($this->monthSale,$defaultCurrency); ?></span>
    	</section>
    </div>
  </div>
  
  <div class="sesgroup_db_dashboard_ticket_statics sesbasic_bxs sesbasic_clearfix">
   <div class="sesbasic_dashboard_content_header sesbasic_clearfix">
      <h3><?php echo $this->translate("Statistics"); ?></h3>
    </div>
    <div class="sesgroup_db_sale_stats_container sesbasic_bxs sesbasic_clearfix">
      <div class="sesgroup_db_sale_stats">
      	<section>
      		<span><?php echo $this->translate("Total Order"); ?></span>
          <span><?php echo $this->eventStatsSale['totalOrder'] ?></span>
      	</section>
      </div>
      <div class="sesgroup_db_sale_stats">
      	<section>
          <span><?php echo $this->translate("Total Commission Amount"); ?></span>
          <span><?php echo Engine_Api::_()->egroupjoinfees()->getCurrencyPrice($this->eventStatsSale['commission_amount'],$defaultCurrency) ?> </span>
				</section>
      </div>
    </div>
  </div>
<?php if(!$this->is_ajax){ ?>
</div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
