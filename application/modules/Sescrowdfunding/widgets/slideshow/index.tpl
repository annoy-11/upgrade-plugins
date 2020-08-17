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

<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sescrowdfunding/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sescrowdfunding/externals/scripts/owl.carousel.js'); 
?>
<div class="sescf_slideshow_wrapper sesbasic_bxs sesbasic_clearfix">
	<div class="sescf_slideshow">
    <?php foreach($this->paginator as $result): ?>
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
    	<?php if($this->view_type == 1): ?>
        <!--Design 1-->
        <div class="sesbasic_clearfix sescf_list_item">
          <div class="sesbasic_clearfix sescf_list_item_inner">
            <div class="sescf_list_item_thumb sescf_list_btns_wrapper" style="height:<?php echo $this->height ?>px;">
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
            </div> 
            <div class="sescf_list_item_cont sesbasic_clearfix">
              <?php if($this->titleActive): ?>
              <div class="sescf_list_item_title">
                <a href="<?php echo $result->getHref(); ?>" title="<?php echo $this->translate($result->getTitle()); ?>"><?php echo $result->getTitle(); ?></a>
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
                  <span>
                    <i class="fa fa-thumbs-up sesbasic_text_light"></i>
                    <span><?php echo $result->like_count; ?></span>
                  </span>
                <?php endif; ?>
                <?php if($this->commentActive): ?>
                  <span>
                    <i class="fa fa-comment sesbasic_text_light"></i>
                    <span><?php echo $result->comment_count; ?></span>
                  </span>
                <?php endif; ?>
                <?php if($this->viewActive): ?>
                  <span>
                    <i class="fa fa-eye sesbasic_text_light"></i>
                    <span><?php echo $result->view_count; ?></span>
                  </span>
                <?php endif; ?>
                <?php if($this->ratingActive): ?>
                  <span>
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
                <?php endif; ?>
              </div>
              <?php if($this->descriptionActive): ?>
                <p class="sescf_list_item_des"><?php echo $this->string()->truncate($this->string()->stripTags($result->short_description), $this->description_truncation); ?></p>
              <?php endif; ?>
              <div class="sescf_list_item_progress sesbasic_clearfix">
                <div class="sescf_list_item_fund_stats sescf_list_item_fund_stats_value sesbasic_clearfix">
                  <span><?php echo $totalGainAmountwithCu; ?></span>	
                  <span class="sescf_total_d centerT"><?php echo $getDoners; ?></span>
                  <span class="sescf_total_g rightT"><?php echo $totalAmount; ?></span>
                </div>
                <span class="sescf_list_item_progress_bar" style="background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.outercolor', 'fbfbfb') ?>"><span style="width:<?php echo $totalPerAmountGain; ?>%;background-color:<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', 'fbfbfb') ?>"></span></span>
                <div class="sescf_list_item_fund_stats sesbasic_clearfix">
                  <span class="sescf_total_g"><?php echo $this->translate("RAISED"); ?></span>
                  <span class="sescf_total_d centerT"><?php if($getDoners > 1) { echo $this->translate("Donors"); } else { echo $this->translate("Donor"); } ?></span>
                  <span class="sescf_total_g rightT"><?php echo $this->translate("Goal"); ?></span>
                </div>
              </div>
              <?php if($this->viewButtonActive): ?>
                <div class="sescf_list_item_btn">
                  <a href="<?php echo $result->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View"); ?></a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php elseif($this->view_type == 2): ?>
      <!--Design 2-->
      <div class="sesbasic_clearfix sescf_full_slide_item">
        <div class="sesbasic_clearfix sescf_full_slide_item_inner sescf_list_btns_wrapper">
          <div class="sescf_full_slide_item_image" style="height:400px;">
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
          </div> 
          <div class="sescf_full_slide_item_cont_wrap">
            <div class="sescf_full_slide_item_cont sesbasic_clearfix">
            	<div class="sescf_full_slide_item_cont_top">
                <?php if($this->titleActive): ?>
                <div class="sescf_full_slide_item_title centerT">
                  <a href="<?php echo $result->getHref(); ?>" title="<?php echo $this->translate($result->getTitle()); ?>"><?php echo $result->getTitle(); ?></a>
                </div>
                <?php endif; ?>
                <div class="sescf_full_slide_item_top_stats sesbasic_clearfix centerT">
                  <?php if($this->byActive): ?>
                  <span class="sescf_list_item_owner">
                    <i class="fa fa-user-circle sesbasic_text_light"></i>
                    <span><?php echo $this->translate("Created by "); ?><a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a></span>
                  </span>
                  <?php endif; ?>
                  <?php if($this->likeActive): ?>
                  <span>
                    <i class="fa fa-thumbs-up sesbasic_text_light"></i>
                    <span><?php echo $result->like_count; ?></span>
                  </span>
                  <?php endif; ?>
                  <?php if($this->commentActive): ?>
                  <span>
                    <i class="fa fa-comment sesbasic_text_light"></i>
                    <span><?php echo $result->comment_count; ?></span>
                  </span>
                  <?php endif; ?>
                  <?php if($this->viewActive): ?>
                  <span>
                    <i class="fa fa-eye sesbasic_text_light"></i>
                    <span><?php echo $result->view_count; ?></span>
                  </span>
                  <?php endif; ?>
                  <?php if($this->ratingActive): ?>
                  <span>
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
                  <?php endif; ?>
                </div>
              </div>

              <div class="sescf_full_slide_item_cont_btm sesbasic_clearfix">
              	<div class="sescf_full_slide_item_chart sescf_pie_chart sesbasic_clearfix">
                  <div class="pie_progress" role="progressbar" data-goal="<?php echo $totalPerAmountGain; ?>" aria-valuemin="0" aria-valuemax="100" data-barsize="8" data-barcolor="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', 'fbfbfb') ?>">
                    <span class="pie_progress__number"><?php echo round($totalPerAmountGain,2); ?>%</span>
                  </div>
                </div>
                <div class="sescf_full_slide_item_cont_btm_info">
                	<div class="sescf_full_slide_item_cont_btm_left">
                  	<p class="sesbasic_clearfix">
                    	<span><?php if($getDoners > 1) { echo $this->translate("Donors:"); } else { echo $this->translate("Donor:"); } ?></span>
                      <span><?php echo $getDoners; ?></span>
                    </p>
                    <p class="sesbasic_clearfix">
                    	<span>Location:</span>
                      <span>Africa</span>
                    </p>
                  </div>
                  <div class="sescf_full_slide_item_cont_btm_middle centerT">
                  	<p><?php echo $totalGainAmountwithCu; ?></p>
                    <p><?php echo $this->translate("Raised of "); ?><?php echo $totalAmount; ?></p>
                  </div>
                  <?php if($this->viewButtonActive): ?>
                    <div class="sescf_full_slide_item_cont_btm_right rightT">
                      <a href="<?php echo $result->getHref(); ?>" class="sesbasic_link_btn"><?php echo $this->translate("View"); ?></a>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    <?php endforeach; ?>  
	</div>
</div>

<script type="text/javascript">
	sescfJqueryObject(document).ready(function() {
		sescfJqueryObject('.sescf_slideshow').owlCarousel({
			loop:true,
			items:1,
			margin:0,
			autoHeight:true,
			autoplay:<?php echo $this->autoplay ?>,
			autoplayTimeout:'<?php echo $this->speed ?>',
			autoplayHoverPause:true
		});
		sescfJqueryObject( ".owl-prev").html('<i class="fa fa-angle-left"></i>');
		sescfJqueryObject( ".owl-next").html('<i class="fa fa-angle-right"></i>');
	});
	
	sescfJqueryObject(document).ready(function($){	
		sescfJqueryObject('.pie_progress').asPieProgress({
			namespace: 'pie_progress',
			trackcolor:'<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.outercolor', 'fbfbfb') ?>',
			trackbordercolor:'<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.fillcolor', 'fbfbfb') ?>',
		});
		sescfJqueryObject('.pie_progress').asPieProgress('start');
	});
	
</script>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sescrowdfunding/externals/scripts/jquery-asPieProgress.js'); ?>
