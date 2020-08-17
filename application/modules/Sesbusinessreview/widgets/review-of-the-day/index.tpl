<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessreview/externals/styles/styles.css'); ?>
<ul class="sesbusinessreview_block sesbasic_bxs sesbasic_clearfix">
  <?php foreach( $this->results as $review ):?>
    <?php $reviewParent = Engine_Api::_()->getItem('businesses', $review->business_id);?>
    <li class="sesbusinessreview_oftheday sesbasic_clearfix sesbasic_bxs sesbusinessreview_grid_btns_wrap" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
      <div class="reviewofday_header"></div>
      <div class="reviewofday_body">
        <div class="sesbusinessreview_review_grid_thumb sesbasic_clearfix">
          <a href="<?php echo $reviewParent->getHref(); ?>" class="sesbusinessreview_review_grid_thumb_img floatL">
            <span style="background-image:url(<?php echo $reviewParent->getPhotoUrl('thumb.profile'); ?>);"></span>
          </a>
        </div>
          <?php if(isset($this->featuredLabelActive)){ ?>
          <div class="sesbusinessreview_labels sesbasic_clearfix">
            <?php if(isset($this->featuredLabelActive) && $review->featured){ ?>
              <p class="sesbusinessreview_label_featured"><?php echo $this->translate('FEATURED');?></p>
            <?php } ?>
          </div>
          <?php } ?>
          <?php if(isset($this->verifiedLabelActive) && $review->verified == 1){ ?>
            <div class="sesbusinessreview_verified_label" title="<?php echo $this->translate("VERIFIED"); ?>" style="display:none;"><i class="fa fa-check"></i></div>
          <?php } ?>
          <?php if(isset($this->titleActive) ){ ?>
              <div class="sesbusinessreview_review_grid_title">
                <?php if(strlen($review->getTitle()) > $this->title_truncation){ 
                $title = mb_substr($review->getTitle(),0,($this->title_truncation - 3)).'...';
                echo $this->htmlLink($review->getHref(),$title, array('class' => '', 'data-src' => $review->getGuid()) ) ?>
                <?php }else{ ?>
                <?php echo $this->htmlLink($review->getHref(),$review->getTitle(), array('class' => '', 'data-src' => $review->getGuid())) ?>
                <?php } ?>
                <?php if(isset($this->verifiedLabelActive) && $review->verified == 1){ ?>
                <i class="sesbusinessreview_verified_sign fa fa-check-circle" title="Verified"></i>
                <?php } ?>
              </div>
            <?php } ?>
            <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive)) {
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $review->getHref()); ?>
          <?php } ?>
          <div class="sesbasic_clearfix clear">
            <?php $reviewCrator = Engine_Api::_()->getItem('user', $review->owner_id);?> 
            <?php $reviewTaker = Engine_Api::_()->getItem('businesses', $review->business_id);?> 
            <div class="sesbusinessreview_review_grid_stat sesbusinessreview_sidebar_image_rounded floatL sesbasic_text_light">
              <div class="sesbusinessreview_review_tittle_block">
                <?php if(isset($this->reviewOwnerNameActive)):?>
                  <p><?php echo 'by '.$this->htmlLink($reviewCrator, $reviewCrator->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $reviewCrator->getGuid()));?></p>
                <?php endif;?>
                <?php if(isset($this->businessNameActive)):?>
                  <p><?php echo 'For '.$this->htmlLink($reviewTaker, $reviewTaker->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $reviewTaker->getGuid()));?></p>
                <?php endif;?>
                <div class="sesbusinessreview_list_stats sesbusinessreview_review_grid_stat clear">
                  <?php if(isset($this->likeActive) && isset($review->like_count)) { ?>
                  <span title="<?php echo $this->translate(array('%s like', '%s likes', $review->like_count), $this->locale()->toNumber($review->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $review->like_count; ?></span>
                  <?php } ?>
                  <?php if(isset($this->viewActive) && isset($review->view_count)) { ?>
                  <span title="<?php echo $this->translate(array('%s view', '%s views', $review->view_count), $this->locale()->toNumber($review->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $review->view_count; ?></span>
                  <?php } ?>
                  <?php if(Engine_Api::_()->getApi('core', 'sesbusinessreview')->allowReviewRating() && $this->ratingActive){
                  echo '<span title="'.$this->translate(array('%s rating', '%s ratings', $review->rating), $this->locale()->toNumber($review->rating)).'"><i class="fa fa-star sesbasic_text_light"></i>'.round($review->rating,1).'/5'. '</span>';
                  } ?>
                </div>
              </div>
            <?php if(isset($this->ratingActive)): ?>
              <div class="sesbusinessreview_list_rating sesbusinessreview_review_sidebar_list_stat floatR">
                <?php $ratingCount = $review->rating;?>
                <?php for($i=0; $i<5; $i++){?>
                  <?php if($i < $ratingCount):?>
                      <span id="" class="sesbusinessreview_rating_star_small"></span>
                  <?php else:?>
                      <span id="" class="sesbusinessreview_rating_star_small_half"></span>
                  <?php endif;?>
                <?php }?>
              </div>
            <?php endif ?> 
          </div>
          <?php if(isset($this->descriptionActive)):?>
            <div class="sesbusinessreview_review_sidebar_list_body clear">
              <?php if(strlen($this->string()->stripTags($review->getDescription())) > $this->description_truncation):?>
                  <?php $description = mb_substr($this->string()->stripTags($review->getDescription()),0,($this->description_truncation-3)).'...';?>
                  <?php echo $description;?>
              <?php else: ?>
                  <?php  echo $this->string()->stripTags($review->getDescription()); ?>
              <?php endif; ?>
            </div>
          <?php endif;?>
          <div class="sesbusinessreview_oftheday_btns">
            <?php if(isset($this->likeButtonActive) && $review->authorization()->isAllowed($this->viewer(), 'comment')): ?>
              <?php $likeStatus = Engine_Api::_()->sesbusinessreview()->getLikeStatus($review->review_id,$review->getType()); ?>
              <div class="">
                <a href="javascript:;" data-type="like_view" data-url="<?php echo $review->review_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesbusinessreview_like_<?php echo $review->review_id ?> sesbusinessreview_like <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $review->like_count;?></span></a>
              </div>
            <?php endif;?>
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.allow.share', 1) && $this->viewer()->getIdentity() && isset($this->socialSharingActive)): ?>
              <div class="_listbuttons_share">
                <a href="javascript:void(0);" class="sesbasic_icon_btn sesbasic_animation sesbusiness_button_toggle"><i class="fa fa-share-alt"></i></a>
                <div class="sesbusinessreview_listing_share_popup">
                 <p><?php echo $this->translate("Share This Business");?></p>
                 <?php $socialsharePlusIcon = $this->socialshare_enable_plusicon;?>
                 <?php $socialshareLimit = $this->socialshare_icon_limit;?>
                 <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $review, 'socialshare_enable_plusicon' => $socialsharePlusIcon, 'socialshare_icon_limit' => $socialshareLimit)); ?>
                 <a href="<?php echo $this->url(array('module' => 'activity','controller' => 'index','action' => 'share','type' => $review->getType(),'id' => $review->getIdentity(),'format' => 'smoothbox'),'default',true);?>" class="openSmoothbox sesbasic_icon_btn sesbasic_icon_share_btn" title='<?php echo $this->translate("Share on Site")?>'><i class="fa fa-share"></i></a>
                </div>
              </div> 
            <?php endif; ?>
          </div>
        </div>
      </div>
    </li>
  <?php endforeach; ?>
</ul>