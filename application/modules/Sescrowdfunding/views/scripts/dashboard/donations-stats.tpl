<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: donations-stats.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(!$this->is_ajax){ 
  echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array(
 	 'crowdfunding' => $this->crowdfunding,
  ));	
?>
	<div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix sesbasic_bxs">
<?php } ?>
<?php $defaultCurrency = Engine_Api::_()->sescrowdfunding()->defaultCurrency(); ?>
  <div class="sescrowdfunding_dashboard_content_header sesbasic_clearfix">
    <h3><?php echo $this->translate("Donations Stats"); ?></h3>
  </div>
  <div class="sescf_donations_stats_container sesbasic_bxs sesbasic_clearfix">
  	<div class="sescf_donations_stats">
    	<div>
        <span><?php echo $this->translate("Today"); ?></span>
        <span><?php echo Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($this->todaySale,$defaultCurrency); ?></span>
      </div>
    </div>
  	<div class="sescf_donations_stats">
			<div>
        <span><?php echo $this->translate("This Week"); ?></span>
        <span><?php echo Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($this->weekSale,$defaultCurrency); ?></span>
			</div>
    </div>
  	<div class="sescf_donations_stats">
    	<div>
        <span><?php echo $this->translate("This Month"); ?></span>
        <span><?php echo Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($this->monthSale,$defaultCurrency); ?></span>
			</div>
    </div>
    <div class="sescf_donations_stats">
      	<div>
      		<span><?php echo $this->translate("Total Donors"); ?></span>
          <span><?php echo $this->crowdfundingStatsSale['totalOrder']; ?></span>
        </div>
      </div>
  </div>
<?php if(!$this->is_ajax){ ?>
</div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
