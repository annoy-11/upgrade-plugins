<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: sales-stats.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(!$this->is_ajax){ 
  echo $this->partial('dashboard/left-bar.tpl', 'eclassroom', array(
 	 'classroom' => $this->classroom,
  ));	
?>
	<div class="classroom_dashboard_content sesbm sesbasic_clearfix">
<?php }
?>
<?php $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency(); ?>
  <div class="classroom_dashboard_content_header sesbasic_clearfix">
    <h3><?php echo $this->translate("Sales Stats"); ?></h3>
  </div>
  <div class="classroom_sale_stats_container sesbasic_bxs sesbasic_clearfix">
  	<div class="classroom_sale_stats">
    	<span><?php echo $this->translate("Today"); ?></span>
      <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->todaySale,$defaultCurrency); ?></span>
    </div>
  	<div class="classroom_sale_stats">
    	<span><?php echo $this->translate("This Week"); ?></span>
      <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->weekSale,$defaultCurrency); ?></span>
    </div>
  	<div class="classroom_sale_stats">
    	<span><?php echo $this->translate("This Month"); ?></span>
      <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->monthSale,$defaultCurrency); ?></span>
    </div>
  </div>
  <div class="classroom_dashboard_ticket_statics sesbasic_bxs sesbasic_clearfix">
   <div class="classroom_dashboard_content_header sesbasic_clearfix">
      <h3><?php echo $this->translate("Order Statistics"); ?></h3>
    </div>
    <div class="classroom_sale_stats_container sesbasic_bxs sesbasic_clearfix">
      <div class="classroom_sale_stats"><span><?php echo $this->translate("Total Order"); ?></span><span><?php echo $this->classroomStatsSale['totalOrder'] ?></span></div>
        <div class="classroom_sale_stats"><span><?php echo $this->translate("Total Courses Sold"); ?></span><span><?php echo $this->classroomStatsSale['total_courses'] ?></span></div>
        <div class="classroom_sale_stats"><span><?php echo $this->translate("Total Commission Amount"); ?></span><span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->classroomStatsSale['commission_amount'],$defaultCurrency) ?> </span></div>
        <div class="classroom_sale_stats"><span><?php echo $this->translate("Total Tax Amount"); ?></span><span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->classroomStatsSale['total_billingtax_cost'],$defaultCurrency); ?></span></div>
    </div>
  </div>
<?php if(!$this->is_ajax){ ?>
</div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
