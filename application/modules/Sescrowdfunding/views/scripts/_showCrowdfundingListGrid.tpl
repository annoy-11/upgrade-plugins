<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showCrowdfundingListGrid.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php  if(!$this->is_ajax): ?>
  <style>
    .displayFN{display:none !important;}
		.sescf_grid_item_two_progress_bar > span > p,.sescf_list_item_two_progress_bar > span > p{background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', '#fbfbfb') ?>;}
  </style>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?> 
<?php endif;?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity; ?>
<?php endif;?>
<?php  if(isset($this->defaultOptions) && count($this->defaultOptions) == 1): ?>
  <script type="application/javascript">
    sesJqueryObject('#tab-widget-sescrowdfunding-<?php echo $randonNumber; ?>').parent().css('display','none');
    sesJqueryObject('.sescrowdfunding_container_tabbed<?php echo $randonNumber; ?>').css('border','none');
  </script>
<?php endif;?>

<?php if(!$this->is_ajax) { ?>
	<div class="sesbasic_view_type sesbasic_clearfix clear" style="display:<?php echo $this->bothViewEnable ? 'block' : 'none'; ?>;height:<?php echo $this->bothViewEnable ? '' : '0px'; ?>">
		<?php if(isset($this->show_item_count) && $this->show_item_count){ ?>
			<div class="sesbasic_clearfix sesbm sescrowdfunding_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_sescrowdfunding' : 'paginator_count_ajax_sescrowdfunding' ?>"><span id="total_item_count_sescrowdfunding" style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("crowdfunding found.") : $this->translate("Crowdfunding Found."); ?></div>
		<?php } ?>
		<div class="sesbasic_view_type_options sesbasic_view_type_options_<?php echo $randonNumber; ?>">
			<?php if(is_array($this->optionsEnable) && in_array('list',$this->optionsEnable)){ ?>
				<a href="javascript:;" rel="list" id="sescrowdfunding_list_view_<?php echo $randonNumber; ?>" class="listicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'list') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('List View') : '' ; ?>"></a>
			<?php } ?>
			<?php if(is_array($this->optionsEnable) && in_array('grid',$this->optionsEnable)){ ?>
				<a href="javascript:;" rel="grid" id="sescrowdfunding_grid_view_<?php echo $randonNumber; ?>" class="a-gridicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'grid') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Grid View') : '' ; ?>"></a>
			<?php } ?>
		</div>
	</div>
<?php } ?>
<?php if(!$this->is_ajax) { ?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">
    <ul class="sescrowdfunding_listing <?php if($this->view_type == 'grid'): ?> sesbasic_clearfix sescf_grid_listing <?php else: ?> sesbasic_clearfix sescf_list_listing <?php endif; ?>" id="tabbed-widget_<?php echo $randonNumber; ?>" style="min-height:50px;position:relative;">
<?php } ?>

<?php foreach( $this->paginator as $result ):?>
  <?php if($this->view_type == 'grid') { ?>
    <li class="sesbasic_clearfix sescf_grid_item" style="width:<?php echo $this->width_grid ?>px;">
    	<div class="sesbasic_clearfix sescf_grid_item_inner">
      	<div class="sescf_grid_item_top">
          <?php if($this->titleActive): ?>
            <div class="sescf_grid_item_title">
              <a href="<?php echo $result->getHref(); ?>" title="<?php echo $this->translate($result->getTitle()); ?>"><?php echo $this->string()->truncate($this->string()->stripTags($result->getTitle()), $this->title_truncation_list) ?></a>
            </div>
          <?php endif; ?>
          <div class="sescf_grid_item_top_stats sesbasic_clearfix">
            <?php if($this->byActive): ?>
              <p class="sescf_grid_item_owner">
                <i class="fa fa-user-circle sesbasic_text_light"></i>
                <a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a>
              </p>
            <?php endif; ?>
            <?php if($this->categoryActive && $result->category_id): ?>
              <?php $category = Engine_Api::_()->getItem('sescrowdfunding_category', $result->category_id); ?>
              <p class="sescf_grid_item_category">
                <i class="fa fa-folder-open sesbasic_text_light"></i>
                <a href="<?php echo $category->getHref(); ?>"><?php echo $category->category_name; ?></a>
              </p>
            <?php endif; ?>
          </div>
        </div>
        <div class="sescf_grid_item_thumb sescf_list_btns_wrapper" style="height:<?php echo $this->height_grid ?>px;">
        	<img class="sescf_grid_item_img" src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
          <a href="<?php echo $result->getHref(); ?>" class="sescf_grid_item_thumb_overlay sesbasic_animation"></a>
          <div class="sescf_labels_main">
          <?php if($this->featuredLabelActive && $result->featured): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_featured"><?php echo $this->translate("FEATURED");?></span>
            </p>
          <?php endif; ?>
            <?php if($this->sponsoredLabelActive && $result->sponsored): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_sponsored"><?php echo $this->translate("SPONSORED");?></span>
            </p>
          <?php endif; ?>
           <?php if($this->verifiedLabelActive && $result->verified): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_verified"><?php echo $this->translate("VERIFIED");?></span>
            </p>
          <?php endif; ?>
          </div>
          <p class="sescf_list_btns sesbasic_animation">
            <?php $enableShare = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.sharing', 1); ?>
            <?php if($this->socialSharingActive && $enableShare == 2): ?>
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $result->getHref()); ?>
            <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $result->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
            <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=' . $result->getTitle().'%0a'; ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
            <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($result->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $result->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $result->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
            <?php endif; ?>
            
            <?php if($this->likeButtonActive): ?>
              <!--Like Button-->
              <?php $canComment =  $result->authorization()->isAllowed($this->viewer, 'comment');?>
              <?php if($canComment):?>
                <?php $LikeStatus = Engine_Api::_()->sescrowdfunding()->getLikeStatusCrowdfunding($result->crowdfunding_id, $result->getType()); ?>
                <a href="javascript:;" data-url="<?php echo $result->crowdfunding_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?> sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?>_<?php echo $result->crowdfunding_id ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></a>
              <?php endif; ?>
            <?php endif; ?>
          </p>
          <div class="sescf_grid_item_thumb_stats sesbasic_clearfix sesbasic_animation centerT">
            <?php if($this->likeActive): ?>
              <p title="<?php echo $this->translate(array('%s like', '%s likes', $result->like_count), $this->locale()->toNumber($result->like_count)); ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></p>
            <?php endif; ?>
            <?php if($this->commentActive): ?>
            <p title="<?php echo $this->translate(array('%s comment', '%s comments', $result->comment_count), $this->locale()->toNumber($result->comment_count)); ?>"><i class="fa fa-comment"></i><span><?php echo $result->comment_count; ?></span></p>
              <?php endif; ?>
            <?php if($this->viewActive): ?>
              <p title="<?php echo $this->translate(array('%s view', '%s views', $result->view_count), $this->locale()->toNumber($result->view_count)); ?>"><i class="fa fa-eye"></i><span><?php echo $result->view_count; ?></span></p>
            <?php endif; ?>
            <?php if($this->ratingActive): ?>
              <p title="<?php echo $this->translate(array('%s rating', '%s ratings', round($result->rating,2)), $this->locale()->toNumber(round($result->rating,2))); ?>"><i class="fa fa-star"></i><span><?php echo round($result->rating,2); ?></span></p>
            <?php endif; ?>
          </div>
        </div>
        <div class="sescf_grid_item_cont sesbasic_clearfix">
          <?php if($this->descriptiongridActive): ?>
            <p class="sescf_grid_item_des"><?php echo $this->string()->truncate($this->string()->stripTags($result->short_description), $this->description_truncation_grid) ?></p>
        	<?php endif; ?>
        	<?php 
        	$currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency();
        	$totalGainAmount = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getCrowdfundingTotalAmount(array('crowdfunding_id' => $result->crowdfunding_id));
        	$getDoners = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getDoners(array('crowdfunding_id' => $result->crowdfunding_id));
        	$totalGainAmountwithCu = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($totalGainAmount,$currency);
        	$totalAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($result->price,$currency);
        	$totalPerAmountGain = (($totalGainAmount * 100) / $result->price);
        	if($totalPerAmountGain > 100) {
            $totalPerAmountGain = 100;
        	} else if(empty($totalPerAmountGain)) {
            $totalPerAmountGain = 0;
        	}
        	?>
          <div class="sescf_grid_item_progress sesbasic_clearfix">
            <span class="sescf_grid_item_progress_overall sesbasic_text_light"><?php echo round($totalPerAmountGain,2).'%'; echo $this->translate(" Completed"); ?></span>
            <?php
              $daysLeft = 0;
              $fromDate = date('Y-m-d',strtotime($result->publish_date));
              $curDate = date('Y-m-d');
              $daysLeft = abs(strtotime($curDate) - strtotime($fromDate));
              $days = $daysLeft/(60 * 60 * 24);
            ?>
            <div class="sescf_grid_goal sescf_profile_goal_stat">
              <?php if(empty($result->show_start_time) && $result->publish_date != '' && strtotime($result->publish_date) > time()) { ?>
                <span class="sescf_profile_goal_stat_value sesbasic_text_hl"><?php echo $days; ?> Days Left</span>
              <?php } elseif(strtotime($result->publish_date) < time() && empty($result->show_start_time)) { ?>
                <span class="sescf_profile_goal_stat_value sescf_expired"><?php echo $this->translate("Expired"); ?></span>
              <?php } elseif($result->show_start_time) { ?>
                <span class="sescf_profile_goal_stat_value sesbasic_text_hl"><?php echo $this->translate(""); ?></span>
              <?php } ?>
            </div>
            <span class="sescf_grid_item_progress_bar" style="background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.outercolor', 'fbfbfb') ?>"><span style="width:<?php echo $totalPerAmountGain;?>%;background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', 'fbfbfb') ?>"></span></span>
        	</div>
          <div class="sescf_grid_item_stats sesbasic_clearfix">
          	<div class="sescf_total_g">
            	<span class="sescf_grid_item_stat_value"><?php echo $totalGainAmountwithCu; ?></span>
              <span class="sescf_grid_item_stat_label sesbasic_text_light"><?php echo $this->translate("RAISED"); ?></span>	
            </div>	
          	<div class="sescf_total_d centerT">
            	<span class="sescf_grid_item_stat_value"><?php echo $getDoners; ?></span>
              <span class="sescf_grid_item_stat_label sesbasic_text_light">
              <?php if($getDoners > 1) { echo $this->translate("Donors"); } else {  echo $this->translate("Donor"); } ?></span>
            </div>
          	<div class="sescf_total_g rightT">
            	<span class="sescf_grid_item_stat_value"><?php echo $totalAmount; ?></span>
              <span class="sescf_grid_item_stat_label sesbasic_text_light"><?php echo $this->translate("GOAL"); ?></span>	
            </div>	
          </div>
          <?php if($this->viewButtonActive) { ?>
          <div class="sescf_grid_item_btn">
            <a href="<?php echo $result->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View"); ?></a>
          </div>
          <?php } ?>
        </div>
      </div>
  	</li>
  <?php } else if($this->view_type == 'list') {  ?>
    <li class="sesbasic_clearfix sescf_list_item">
    	<div class="sesbasic_clearfix sescf_list_item_inner">
        <div class="sescf_list_item_thumb sescf_list_btns_wrapper" style="height:<?php echo $this->height_list ?>px;width:<?php echo $this->width_list ?>px;">
        	<img class="sescf_grid_item_img" src="<?php echo $result->getPhotoUrl(); ?>" alt="" />
          <a href="<?php echo $result->getHref(); ?>" class="sescf_list_item_thumb_overlay sesbasic_animation"></a>
             <div class="sescf_labels_main">
          <?php if($this->featuredLabelActive && $result->featured): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_featured"><?php echo $this->translate("FEATURED");?></span>
            </p>
          <?php endif; ?>
            <?php if($this->sponsoredLabelActive && $result->sponsored): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_sponsored"><?php echo $this->translate("SPONSORED");?></span>
            </p>
          <?php endif; ?>
           <?php if($this->verifiedLabelActive && $result->verified): ?>
            <p class="sescf_labels sesbasic_animation">
              <span class="sescf_label_verified"><?php echo $this->translate("VERIFIED");?></span>
            </p>
          <?php endif; ?>
          </div>
          <p class="sescf_list_btns sesbasic_animation">
            <?php $enableShare = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.sharing', 1); ?>
            <?php if($this->socialSharingActive && $enableShare): ?>
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $result->getHref()); ?>
            <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $result->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
            <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=' . $result->getTitle().'%0a'; ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
            <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($result->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $result->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $result->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
            <?php endif; ?>
            <?php if($this->likeButtonActive): ?>
              <!--Like Button-->
              <?php $canComment =  $result->authorization()->isAllowed($this->viewer, 'comment');?>
              <?php if($canComment):?>
                <?php $LikeStatus = Engine_Api::_()->sescrowdfunding()->getLikeStatusCrowdfunding($result->crowdfunding_id, $result->getType()); ?>
                <a href="javascript:;" data-url="<?php echo $result->crowdfunding_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?> sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?>_<?php echo $result->crowdfunding_id ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></a>
              <?php endif; ?>
            <?php endif;  ?>
          </p>
        </div> 
        <div class="sescf_list_item_cont sesbasic_clearfix">
          <?php if($this->titleActive): ?>
            <div class="sescf_list_item_title">
              <a href="<?php echo $result->getHref(); ?>" title="<?php echo $this->translate($result->getTitle()); ?>"><?php echo $this->string()->truncate($this->string()->stripTags($result->getTitle()), $this->title_truncation_grid) ?></a>
            </div>
          <?php endif; ?>
          <div class="sescf_list_item_top_stats sesbasic_clearfix">
            <?php if($this->byActive): ?>
          	<span class="sescf_list_item_owner">
            	<i class="fa fa-user-circle sesbasic_text_light"></i>
              <span><?php echo $this->translate("Created by "); ?><a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a></span>
            </span>
            <?php endif; ?>
            <?php if($this->likeActive): ?>
              <span title="<?php echo $this->translate(array('%s like', '%s likes', $result->like_count), $this->locale()->toNumber($result->like_count)); ?>">
                <i class="fa fa-thumbs-up sesbasic_text_light"></i>
                <span><?php echo $result->like_count; ?></span>
              </span>
            <?php endif; ?>
            <?php if($this->commentActive): ?>
              <span title="<?php echo $this->translate(array('%s comment', '%s comments', $result->comment_count), $this->locale()->toNumber($result->comment_count)); ?>">
                <i class="fa fa-comment sesbasic_text_light"></i>
                <span><?php echo $result->comment_count; ?></span>
              </span>
            <?php endif; ?>
            <?php if($this->viewActive): ?>
              <span title="<?php echo $this->translate(array('%s view', '%s views', $result->view_count), $this->locale()->toNumber($result->view_count)); ?>">
                <i class="fa fa-eye sesbasic_text_light"></i>
                <span><?php echo $result->view_count; ?></span>
              </span>
            <?php endif; ?>
            <?php if($this->ratingActive): ?>
            <span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($result->rating,2)), $this->locale()->toNumber(round($result->rating,2))); ?>">
            	<i class="fa fa-star sesbasic_text_light"></i>
              <span><?php echo round($result->rating,2); ?></span>
            </span>
            <?php endif; ?>
            <?php if($this->categoryActive && $result->category_id): ?>
              <?php $category = Engine_Api::_()->getItem('sescrowdfunding_category', $result->category_id); ?>
              <span class="sescf_list_item_category">
                <i class="fa fa-folder-open sesbasic_text_light"></i>
                <span><a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a></span>
              </span>
            <?php endif;  ?>
          </div>
          <?php if($this->descriptionlistActive): ?>
            <p class="sescf_list_item_des"><?php echo $this->string()->truncate($this->string()->stripTags($result->short_description), $this->description_truncation_list) ?></p>
        	<?php endif; ?>
          <?php 
        	$currency = Engine_Api::_()->sescrowdfunding()->getCurrentCurrency();
        	$totalGainAmount = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getCrowdfundingTotalAmount(array('crowdfunding_id' => $result->crowdfunding_id));
        	$getDoners = Engine_Api::_()->getDbTable('orders', 'sescrowdfunding')->getDoners(array('crowdfunding_id' => $result->crowdfunding_id));
        	$totalGainAmountwithCu = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($totalGainAmount,$currency);
        	$totalAmount = Engine_Api::_()->sescrowdfunding()->getCurrencyPrice($result->price,$currency);
        	$totalPerAmountGain = (($totalGainAmount * 100) / $result->price);
        	if($totalPerAmountGain > 100) {
            $totalPerAmountGain = 100;
        	} else if(empty($totalPerAmountGain)) {
            $totalPerAmountGain = 0;
        	}
        	?>
          <div class="sescf_list_item_progress sesbasic_clearfix">
           <span class="sescf_list_item_progress_overall sesbasic_text_light"><?php echo round($totalPerAmountGain,2).'%'; echo $this->translate(" Completed"); ?></span>
            <?php
              $daysLeft = 0;
              $fromDate = date('Y-m-d',strtotime($result->publish_date));
              $curDate = date('Y-m-d');
              $daysLeft = abs(strtotime($curDate) - strtotime($fromDate));
              $days = $daysLeft/(60 * 60 * 24);
            ?>
            <div class="sescf_list_goal sescf_profile_goal_stat">
              <?php if(empty($result->show_start_time) && $result->publish_date != '' && strtotime($result->publish_date) > time()) { ?>
                <span class="sescf_profile_goal_stat_value sesbasic_text_hl"><?php echo $days; ?> Days Left</span>
              <?php } elseif(strtotime($result->publish_date) < time() && empty($result->show_start_time)) { ?>
                <span class="sescf_profile_goal_stat_value sescf_expired"><?php echo $this->translate("Expired"); ?></span>
              <?php } elseif($result->show_start_time) { ?>
                <span class="sescf_profile_goal_stat_value sesbasic_text_hl"><?php echo $this->translate(""); ?></span>
              <?php } ?>
            </div>
          	<div class="sescf_list_item_fund_stats sescf_list_item_fund_stats_value sesbasic_clearfix">
              <span><?php echo $totalGainAmountwithCu; ?></span>	
              <span class="sescf_total_d centerT"><?php echo $getDoners; ?></span>
              <span class="sescf_total_g rightT"><?php echo $totalAmount; ?></span>
            </div>
            <span class="sescf_list_item_progress_bar" style="background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.outercolor', 'fbfbfb') ?>"><span style="width:<?php echo $totalPerAmountGain; ?>%;background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', 'fbfbfb') ?>"></span></span>
        		<div class="sescf_list_item_fund_stats sesbasic_clearfix">
              <span class="sescf_total_g"><?php echo $this->translate("RAISED"); ?></span>
              <span class="sescf_total_d centerT"><?php if($getDoners > 1) { echo $this->translate("Donors"); } else { echo $this->translate("Donor"); } ?></span>
              <span class="sescf_total_g rightT"><?php echo $this->translate("GOAL"); ?></span>
            </div>
          </div>
          <?php if($this->viewButtonActive) { ?>
          <div class="sescf_list_item_btn rightT">
             <a href="<?php echo $result->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View"); ?></a>
          </div>
          <?php } ?>
        </div>
      </div>
  	</li>
  <?php } ?>
<?php endforeach; ?>

<?php  if($this->paginator->getTotalItemCount() == 0 &&  (empty($this->widgetType))) { ?>
  <?php if( isset($this->category) || isset($this->tag) || isset($this->text) ):?>
    <div class="sesbasic_tip">
      <img src="application/modules/Sescrowdfunding/externals/images/crowdfunding-icon.png" alt="" />
      <span>
        <?php echo $this->translate('Nobody has posted a crowdfunding with that criteria.');?>
        <?php if ($this->can_create):?>
          <?php echo $this->translate('Be the first to %1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sescrowdfunding_general").'">', '</a>'); ?>
        <?php endif; ?>
      </span>
    </div>
  <?php else:?>
  	<div class="sesbasic_tip">
      <img src="application/modules/Sescrowdfunding/externals/images/crowdfunding-icon.png" alt="" />
      <span>
        <?php echo $this->translate('Nobody has created a crowdfunding yet.');?>
        <?php if ($this->can_create):?>
          <?php echo $this->translate('Be the first to %1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sescrowdfunding_general").'">', '</a>'); ?>
        <?php endif; ?>
      </span>
    </div>
  <?php endif; ?>
<?php } else if($this->paginator->getTotalItemCount() == 0 && isset($this->tabbed_widget) && $this->tabbed_widget) { ?>
  <div class="sesbasic_tip">
    <img src="application/modules/Sescrowdfunding/externals/images/crowdfunding-icon.png" alt="" />
    <span>
      <?php $errorTip = ucwords(str_replace('SP',' ',$this->defaultOpenTab)); ?>
      <?php echo $this->translate("There are currently no %s",$errorTip);?>
      <?php if (isset($this->can_create) && $this->can_create):?>
        <?php echo $this->translate('%1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sescrowdfunding_general").'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>
<?php } ?>
  
<?php if($this->loadOptionData == 'pagging' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')): ?>
  <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sescrowdfunding"),array('identityWidget'=>$randonNumber)); ?>
<?php endif;?>
  
<?php if(!$this->is_ajax) { ?>
  </ul>
    <?php if($this->loadOptionData != 'pagging' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')):?>
      <div class="sesbasic_view_more sescf_view_more" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore')); ?> </div>
      <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <span class="sesbasic_link_btn sescf_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>
    <?php endif;?>
  </div>

  <script type="text/javascript">
    var requestTab_<?php echo $randonNumber; ?>;
    var valueTabData ;
    // globally define available tab array
    var requestTab_<?php echo $randonNumber; ?>;
		<?php if($this->loadOptionData == 'auto_load' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')) { ?>
			window.addEvent('load', function() {
				sesJqueryObject(window).scroll( function() {
					var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
					var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
					if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
					}
				});
			});
    <?php } ?>
    sesJqueryObject(document).on('click','.selectView_<?php echo $randonNumber; ?>',function(){

      if(sesJqueryObject(this).hasClass('active'))
        return;
      
      if(sesJqueryObject(this).attr('class') == 'a-gridicon selectView_<?php echo $randonNumber; ?>') {
        sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').removeClass('sesbasic_clearfix sescf_list_listing');
        sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_clearfix sescf_grid_listing');
      } else if(sesJqueryObject(this).attr('class') == 'listicon selectView_<?php echo $randonNumber; ?>') {
        sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').removeClass('sesbasic_clearfix sescf_grid_listing');
        sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_clearfix sescf_list_listing');
      } else {
        sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').removeClass('sesbasic_clearfix sescf_list_listing');
        sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_clearfix sescf_grid_listing');
      }
      
      if($("view_more_<?php echo $randonNumber; ?>"))
        document.getElementById("view_more_<?php echo $randonNumber; ?>").style.display = 'none';
      document.getElementById("tabbed-widget_<?php echo $randonNumber; ?>").innerHTML = "<div class='clear sesbasic_loading_container'></div>";
      sesJqueryObject('#sescrowdfunding_grid_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sescrowdfunding_list_view_<?php echo $randonNumber; ?>').removeClass('active');
      

      
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display','none');
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').css('display','none');
      sesJqueryObject(this).addClass('active');
      if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {
				requestTab_<?php echo $randonNumber; ?>.cancel();
      }
      if (typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined') {
				requestViewMore_<?php echo $randonNumber; ?>.cancel();
      }
      requestTab_<?php echo $randonNumber; ?> = (new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/sescrowdfunding/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
				'data': {
					format: 'html',
					page: 1,
					type:sesJqueryObject(this).attr('rel'),
					params : <?php echo json_encode($this->params); ?>, 
					is_ajax : 1,
					searchParams: searchParams<?php echo $randonNumber; ?>,
					identity : '<?php echo $randonNumber; ?>',
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
					if($("loading_image_<?php echo $randonNumber; ?>"))
            document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
				}
      })).send();
    });
  </script>
<?php } ?>
  
<?php if(isset($this->optionsListGrid['paggindData']) || isset($this->loadJs)){ ?>
	<script type="text/javascript">
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var requestViewMore_<?php echo $randonNumber; ?>;
		var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
		var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
		var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
		var searchParams<?php echo $randonNumber; ?> ;
		var is_search_<?php echo $randonNumber;?> = 0;
		<?php if($this->loadOptionData != 'pagging'){ ?>
			viewMoreHide_<?php echo $randonNumber; ?>();
			
			function viewMoreHide_<?php echo $randonNumber; ?>() {
				if ($('view_more_<?php echo $randonNumber; ?>'))
				$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
			}
			
			function viewMore_<?php echo $randonNumber; ?> () {
			
				sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
				sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    
				requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/sescrowdfunding/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: page<?php echo $randonNumber; ?>,    
						params : params<?php echo $randonNumber; ?>, 
						is_ajax : 1,
						is_search:is_search_<?php echo $randonNumber;?>,
						view_more:1,
						searchParams:searchParams<?php echo $randonNumber; ?> ,
						identity : '<?php echo $randonNumber; ?>',
						identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>'
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					
						if($('loading_images_browse_<?php echo $randonNumber; ?>'))
              sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
              
						if($('loadingimgsescrowdfunding-wrapper'))
              sesJqueryObject('#loadingimgsescrowdfunding-wrapper').hide();

						//if(!isSearch) {
							document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
						//} else {
						//	document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
							//isSearch = false;
						//}

						document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';

					}
				});
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php } else { ?>
			function paggingNumber<?php echo $randonNumber; ?>(pageNum){
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
				requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/sescrowdfunding/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: pageNum,    
						params :params<?php echo $randonNumber; ?> , 
						is_ajax : 1,
						searchParams:searchParams<?php echo $randonNumber; ?>  ,
						identity : identity<?php echo $randonNumber; ?>,
						type:'<?php echo $this->view_type; ?>'
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_images_browse_<?php echo $randonNumber; ?>'))
              sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
						if($('loadingimgsescrowdfunding-wrapper'))
              sesJqueryObject('#loadingimgsescrowdfunding-wrapper').hide();
              
						sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
						
						document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
						if(isSearch){
							isSearch = false;
						}
					}
				}));
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php } ?>
	</script>
<?php } ?>
