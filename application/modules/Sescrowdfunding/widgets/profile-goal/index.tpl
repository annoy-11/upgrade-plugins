<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency(); ?>
<div class="sescf_profile_goal sesbasic_clearfix sesbasic_bxs">
	<div class="sescf_profile_goal_total centerT">
    <?php $totalGainAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($this->totalGainAmount,$currency); ?>
  	<?php echo $totalGainAmount; ?>
  </div>
  <div class="sescf_profile_goal_target centerT">
    <?php $goal = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($this->crowdfunding->price,$currency); ?>
  	<?php echo $this->translate("Raised of %s Goal", $goal); ?>
  </div>
  <?php //$totalPerAmountGain = (($this->totalGainAmount * 100) / $this->crowdfunding->price); ?>
  
  <?php 
  $currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency();
  $totalGainAmount = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getCrowdfundingTotalAmount(array('crowdfunding_id' => $this->crowdfunding->crowdfunding_id));
  $getDoners = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getDoners(array('crowdfunding_id' => $this->crowdfunding->crowdfunding_id));
  $totalGainAmountwithCu = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($totalGainAmount,$currency);
  $totalAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($this->crowdfunding->price,$currency);
  $totalPerAmountGain = (($totalGainAmount * 100) / $this->crowdfunding->price);
  if($totalPerAmountGain > 100) {
    $totalPerAmountGain = 100;
  } else if(empty($totalPerAmountGain)) {
    $totalPerAmountGain = 0;
  }
  ?>
  <div class="sescf_profile_goal_chart sescf_pie_chart sesbasic_clearfix">
    <div class="pie_progress" role="progressbar" data-goal="<?php echo $totalPerAmountGain; ?>" aria-valuemin="0" aria-valuemax="100" data-barsize="8" data-barcolor="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', 'fbfbfb') ?>">
      <span class="pie_progress__number"><?php echo round($totalPerAmountGain,2).'%'; ?></span>
    </div>
  </div>
  <?php
    $daysLeft = 0;
    $fromDate = date('Y-m-d',strtotime($this->crowdfunding->publish_date));
    $curDate = date('Y-m-d');
    $daysLeft = abs(strtotime($curDate) - strtotime($fromDate));
    $days = $daysLeft/(60 * 60 * 24);
  ?>
  
  	<?php if(empty($this->crowdfunding->show_start_time) && $this->crowdfunding->publish_date != '' && strtotime($this->crowdfunding->publish_date) > time()) { ?>
  	  <div class="sescf_profile_goal_stat">
      <span><?php echo $this->translate("Days Left"); ?></span>
      <span class="sescf_profile_goal_stat_value"><?php echo $days; ?></span>
      </div>
    <?php } elseif(strtotime($this->crowdfunding->publish_date) < time() && empty($this->crowdfunding->show_start_time)) { ?>
      <div class="sescf_profile_goal_stat">
      <span class="sescf_profile_goal_stat_value sescf_expired"><?php echo $this->translate("Expired"); ?></span>
      </div>
    <?php } elseif($this->crowdfunding->show_start_time && 0) { ?>
      <div class="sescf_profile_goal_stat">
      <span class="sescf_profile_goal_stat_value"><?php echo $this->translate(""); ?></span>
      </div>
    <?php } ?>
  
  <?php if($this->crowdfunding->location): ?>
    <div class="sescf_profile_goal_stat">
      <span><?php echo $this->translate("Location"); ?></span>
      <span class="sescf_profile_goal_stat_value"><a href="<?php echo $this->url(array('resource_id' => $this->crowdfunding->crowdfunding_id, 'resource_type'=>'crowdfunding', 'action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="openSmoothbox"><?php echo $this->crowdfunding->location; ?></a></span>
    </div>
  <?php endif; ?>
  
  <?php if($this->totalGainAmount < $this->crowdfunding->price) { ?>
    <?php if($this->viewer_id && $this->viewer_id != $this->crowdfunding->owner_id && !empty($this->crowdfunding->show_start_time)) { ?>
      <div class="sescf_profile_goal_btn">
        <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'order', 'action' => 'donate', 'crowdfunding_id' => $this->crowdfunding->crowdfunding_id, 'gateway_id' => 2), $this->translate("DONATE"), array('class' => 'sesbasic_link_btn')); ?>
      </div>
    <?php } elseif($this->viewer_id && strtotime($this->crowdfunding->publish_date) > time() && $this->viewer_id != $this->crowdfunding->owner_id) { ?>
      <div class="sescf_profile_goal_btn">
        <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sescrowdfunding', 'controller' => 'order', 'action' => 'donate', 'crowdfunding_id' => $this->crowdfunding->crowdfunding_id, 'gateway_id' => 2), $this->translate("DONATE"), array('class' => 'sesbasic_link_btn')); ?>
      </div>
    <?php } ?>
  <?php } else { ?>
    <div class="sescf_profile_goal_success">
    	<i class="fa fa-check"></i>
      <span><?php echo $this->translate("Successfully Completed"); ?></span>
    </div>
  <?php } ?>
</div>
<script type="text/javascript">
	sescfJqueryObject(document).ready(function($){	
		sescfJqueryObject('.pie_progress').asPieProgress({
			namespace: 'pie_progress',
			trackcolor:'<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.outercolor', 'fbfbfb') ?>',
		});
		sescfJqueryObject('.pie_progress').asPieProgress('start');
	});
</script>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfunding/externals/scripts/jquery.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfunding/externals/scripts/jquery-asPieProgress.js'); ?> 
