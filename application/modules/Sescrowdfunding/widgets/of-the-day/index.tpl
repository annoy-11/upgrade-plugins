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
<?php $result = Engine_Api::_()->getItem('crowdfunding', $this->crowdfunding_id); ?>
<div class="sesbasic_clearfix sesbasic_bxs sesbasic_sidebar_block">
	<!--Grid View Start Here-->
	<ul class="sesbasic_clearfix">
  	<li class="sesbasic_clearfix sescf_grid_item" style="width:<?php echo $this->width ?>px;">
    	<div class="sesbasic_clearfix sescf_grid_item_inner">
      	<div class="sescf_grid_item_top">
          <?php if($this->titleActive): ?>
            <div class="sescf_grid_item_title">
              <a href="<?php echo $result->getHref(); ?>" title="<?php echo $this->translate($result->getTitle()); ?>"><?php echo $this->string()->truncate($this->string()->stripTags($result->getTitle()), $this->title_truncation) ?></a>
            </div>
          <?php endif; ?>
          <div class="sescf_grid_item_top_stats sesbasic_clearfix">
            <?php if($this->byActive): ?>
          	<p class="sescf_grid_item_owner">
            	<i class="fa fa-user-circle sesbasic_text_light"></i>
              <a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a>
            </p>
            <?php endif; ?>
            <?php if($result->category_id && $this->categoryActive): ?>
              <?php $category = Engine_Api::_()->getItem('sescrowdfunding_category', $result->category_id); ?>
              <p class="sescf_grid_item_category">
                <i class="fa fa-folder-open sesbasic_text_light"></i>
                <a href="<?php echo $category->getHref(); ?>"><?php echo $category->category_name; ?></a>
              </p>
            <?php endif; ?>
          </div>
        </div>
        <div class="sescf_grid_item_thumb sescf_list_btns_wrapper" style="height:<?php echo $this->height ?>px;">
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
            <?php if(isset($this->socialSharingActive) && $enableShare): ?>
              <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $result->getHref()); ?>
              <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $result->getTitle(); ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
              <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&text=' . $result->getTitle().'%0a'; ?>" onclick="return socialSharingPopUp(this.href, '<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
              <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($result->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $result->getPhotoUrl('thumb.main'))); ?>&description=<?php echo $result->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
            <?php endif; ?>
            <?php if(isset($this->likeButtonActive)): ?>
              <!--Like Button-->
              <?php $canComment =  $result->authorization()->isAllowed($this->viewer, 'comment');?>
              <?php if($canComment):?>
                <?php $LikeStatus = Engine_Api::_()->sescrowdfunding()->getLikeStatusCrowdfunding($result->crowdfunding_id, $result->getType()); ?>
                <a href="javascript:;" data-url="<?php echo $result->crowdfunding_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?> sescrowdfunding_like_<?php echo 'sescrowdfunding'; ?>_<?php echo $result->crowdfunding_id ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></a>
              <?php endif; ?>
            <?php endif; ?>
          </p>
          <div class="sescf_grid_item_thumb_stats sesbasic_clearfix sesbasic_animation centerT">
            <?php if(isset($this->likeActive)): ?>
              <p title="<?php echo $this->translate(array('%s like', '%s likes', $result->like_count), $this->locale()->toNumber($result->like_count)); ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $result->like_count; ?></span></p>
            <?php endif; ?>
            <?php if(isset($this->commentActive)): ?>
              <p title="<?php echo $this->translate(array('%s comment', '%s comments', $result->comment_count), $this->locale()->toNumber($result->comment_count)); ?>"><i class="fa fa-comment"></i><span><?php echo $result->comment_count; ?></span></p>
            <?php endif; ?>
            <?php if(isset($this->viewActive)): ?>
              <p title="<?php echo $this->translate(array('%s view', '%s views', $result->view_count), $this->locale()->toNumber($result->view_count)); ?>"><i class="fa fa-eye"></i><span><?php echo $result->view_count; ?></span></p>
            <?php endif; ?>
            <?php if(isset($this->ratingActive)): ?>
              <p title="<?php echo $this->translate(array('%s rating', '%s ratings', round($result->rating,2)), $this->locale()->toNumber(round($result->rating,2))); ?>"><i class="fa fa-star"></i><span><?php echo round($result->rating,2); ?></span></p>
            <?php endif; ?>
          </div>
        </div>
        <div class="sescf_grid_item_cont sesbasic_clearfix">
          <?php if($this->descriptionActive): ?>
            <p class="sescf_grid_item_des"><?php echo $this->string()->truncate($this->string()->stripTags($result->short_description), $this->description_truncation) ?></p>
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
          <?php if($this->viewButtonActive): ?>
            <div class="sescf_grid_item_btn">
              <a href="<?php echo $result->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View"); ?></a>
            </div>
          <?php endif; ?>
        </div>
      </div>
  	</li>
	</ul>
  <!--Grid View End Here-->
</div>
