<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _reviewsidebarWidgetDate.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
<?php foreach( $this->results as $review ): ?>
<?php $reviewOwner = Engine_Api::_()->getItem('user', $review->owner_id);?>
<?php if($this->view_type == 'list'){ ?>
  <li class="sesmember_review_sidebar_list <?php if($this->image_type == 'rounded'):?>sesmember_sidebar_image_rounded<?php endif;?> sesbasic_clearfix">
    <?php echo $this->htmlLink($reviewOwner, $this->itemPhoto($reviewOwner, 'thumb.icon')); ?>
    <div class="sesmember_review_sidebar_list_info">
    	<?php  if(isset($this->titleActive)){ ?>
      	<div class="sesmember_review_sidebar_list_title">
          <?php if(strlen($review->getTitle()) > $this->title_truncation_list){
          $title = mb_substr($review->getTitle(),0,($this->title_truncation_list-3)).'...';
          echo $this->htmlLink($review->getHref(),$title);
          } else { ?>
          <?php echo $this->htmlLink($review->getHref(),$review->getTitle()) ?>
        	<?php } ?>
      	</div>
      <?php } ?>
        <?php $reviewCrator = Engine_Api::_()->getItem('user', $review->owner_id);?>
        <?php $reviewTaker = Engine_Api::_()->getItem('user', $review->user_id);?> 
        <?php if(isset($this->byActive)):?>
        <div class="sesmember_review_sidebar_list_stat sesbasic_text_light">
	  <?php echo 'by '.$this->htmlLink($reviewCrator, $reviewCrator->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $reviewCrator->getGuid()));?>
	  <?php echo 'For '.$this->htmlLink($reviewTaker, $reviewTaker->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $reviewTaker->getGuid()));?>	
        </div>
      <?php endif;?>  
			<div class="sesmember_list_stats sesmember_review_sidebar_list_stat">
        <?php if(isset($this->likeActive) && isset($review->like_count)) { ?>
        	<span title="<?php echo $this->translate(array('%s like', '%s likes', $review->like_count), $this->locale()->toNumber($review->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $review->like_count; ?></span>
        <?php } ?>
        <span title='<?php echo $this->translate("10 Followers");?>'><i class="fa fa-check sesbasic_text_light"></i><?php echo $this->translate("10 Followers");?></span>
        <?php if(isset($this->viewActive) && isset($review->view_count)) { ?>
        	<span title="<?php echo $this->translate(array('%s view', '%s views', $review->view_count), $this->locale()->toNumber($review->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $review->view_count; ?></span>
         <?php } ?>
        <?php if(Engine_Api::_()->getApi('core', 'sesmember')->allowReviewRating() && $this->ratingActive){
          echo '<span title="'.$this->translate(array('%s rating', '%s ratings', $review->rating), $this->locale()->toNumber($review->rating)).'"><i class="fa fa-star sesbasic_text_light"></i>'.round($review->rating,1).'/5'. '</span>';
        } ?>
      </div>
      <?php if(isset($this->ratingActive)): ?>
        <div class="sesmember_list_rating sesmember_review_sidebar_list_stat clear">
          <?php $ratingCount = $review->rating;?>
          <?php for($i=0; $i<5; $i++){?>
            <?php if($i < $ratingCount):?>
              <span id="" class="sesmember_rating_star_small"></span>
            <?php else:?>
              <span id="" class="sesmember_rating_star_small_half"></span>
            <?php endif;?>
          <?php }?>
					</div>
      <?php endif ?>
		</div>
    <?php if($this->descriptionActive):?>
      <div class="sesmember_review_sidebar_list_body clear">
	<?php if(strlen($this->string()->stripTags($review->getDescription())) > $this->description_truncation){
	  $description = mb_substr($this->string()->stripTags($review->getDescription()),0,($this->description_truncation-3)).'...';
	  echo $description;
	} else { ?>
	  <?php  echo $this->string()->stripTags($review->getDescription()); ?>
	<?php } ?>
      </div>
    <?php endif;?>
    <div class="sesmember_review_sidebar_featured_list">
      <?php if(isset($this->featuredLabelActive) && $review->featured):?>
	<p class="featured"><?php echo $this->translate('Featured');?></p>
      <?php endif;?>
      <?php if(isset($this->verifiedLabelActive) && $review->verified):?>
	<p class="verified"><?php echo $this->translate('Verified');?></p>
      <?php endif;?>
    </div>
  </li>
<?php }else{ ?>
  <li class="sesmember_review_grid sesbasic_clearfix sesbasic_bxs sesmember_grid_btns_wrap" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
    <div class="sesmember_review_grid_thumb floatL" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
      <?php $href = $reviewOwner->getHref();$imageURL = $reviewOwner->getPhotoUrl('thumb.profile');?>
      <a href="<?php echo $href; ?>" class="sesmember_review_grid_thumb_img floatL">
        <span class="floatL" style="background-image:url(<?php echo $imageURL; ?>);"></span>
      </a>
      <?php if(isset($this->featuredLabelActive)){ ?>
      <div class="sesmember_labels">
        <?php if(isset($this->featuredLabelActive) && $review->featured){ ?>
          <p class="sesmember_label_featured">FEATURED</p>
        <?php } ?>
      </div>
      <?php } ?>
      <?php if(isset($this->verifiedLabelActive) && $review->verified == 1){ ?>
        <div class="sesmember_verified_label" title="<?php echo $this->translate("VERIFIED"); ?>" style="display:none;"><i class="fa fa-check"></i></div>
      <?php } ?>
      <div class="sesmember_review_grid_thumb_cont">
      	<?php if(isset($this->titleActive) ){ ?>
          <div class="sesmember_review_grid_title">
            <?php if(strlen($review->getTitle()) > $this->title_truncation_grid){ 
            $title = mb_substr($review->getTitle(),0,($this->title_truncation_grid - 3)).'...';
            echo $this->htmlLink($review->getHref(),$title, array('class' => '', 'data-src' => $review->getGuid()) ) ?>
            <?php }else{ ?>
            <?php echo $this->htmlLink($review->getHref(),$review->getTitle(), array('class' => '', 'data-src' => $review->getGuid())) ?>
            <?php } ?>
            <?php if(isset($this->verifiedLabelActive) && $review->verified == 1){ ?>
            <i class="sesmember_verified_sign fa fa-check-circle" title="Verified"></i>
            <?php } ?>
          </div>
      	<?php } ?>
      </div>
        <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive)) {
      $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $review->getHref()); ?>
        <div class="sesmember_grid_btns"> 
          <?php if(isset($this->socialSharingActive)){ ?>
          
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $review, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

          <?php }  ?>			
        </div>
      <?php } ?>
    </div>
		<div class="sesmember_review_grid_info sesbasic_clearfix clear">
			<?php $reviewCrator = Engine_Api::_()->getItem('user', $review->owner_id);?> 
			<?php $reviewTaker = Engine_Api::_()->getItem('user', $review->user_id);?> 
			<div class="sesmember_review_grid_stat sesmember_sidebar_image_rounded floatL sesbasic_text_light">
				<?php echo $this->htmlLink($reviewTaker, $this->itemPhoto($reviewTaker, 'thumb.icon'), array('class' => 'sesmember_reviw_prof_img floatL')); ?>
				<div class="sesmember_review_tittle_block">
					<p><?php echo 'by '.$this->htmlLink($reviewCrator, $reviewCrator->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $reviewCrator->getGuid()));?></p>
					<p><?php echo 'For '.$this->htmlLink($reviewTaker, $reviewTaker->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $reviewTaker->getGuid()));?></p>
					<div class="sesmember_list_stats sesmember_review_grid_stat clear">
						<?php if(isset($this->likeActive) && isset($review->like_count)) { ?>
						<span title="<?php echo $this->translate(array('%s like', '%s likes', $review->like_count), $this->locale()->toNumber($review->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $review->like_count; ?></span>
						<?php } ?>
						<?php if(isset($this->viewActive) && isset($review->view_count)) { ?>
						<span title="<?php echo $this->translate(array('%s view', '%s views', $review->view_count), $this->locale()->toNumber($review->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $review->view_count; ?></span>
						<?php } ?>
						<?php if(Engine_Api::_()->getApi('core', 'sesmember')->allowReviewRating() && $this->ratingActive){
						echo '<span title="'.$this->translate(array('%s rating', '%s ratings', $review->rating), $this->locale()->toNumber($review->rating)).'"><i class="fa fa-star sesbasic_text_light"></i>'.round($review->rating,1).'/5'. '</span>';
						} ?>
					</div>
				</div>
				<?php if(isset($this->ratingActive)): ?>
					<div class="sesmember_list_rating sesmember_review_sidebar_list_stat floatR">
						<?php $ratingCount = $review->rating;?>
						<?php for($i=0; $i<5; $i++){?>
							<?php if($i < $ratingCount):?>
								<span id="" class="sesmember_rating_star_small"></span>
							<?php else:?>
								<span id="" class="sesmember_rating_star_small_half"></span>
							<?php endif;?>
						<?php }?>
					</div>
				<?php endif ?> 
		  </div>
			<?php if($this->descriptionActive):?>
				<div class="sesmember_review_sidebar_list_body clear">
					<?php if(strlen($this->string()->stripTags($review->getDescription())) > $this->description_truncation):?>
						<?php $description = mb_substr($this->string()->stripTags($review->getDescription()),0,($this->description_truncation-3)).'...';?>
						<?php echo $description;?>
					<?php else: ?>
						<?php  echo $this->string()->stripTags($review->getDescription()); ?>
					<?php endif; ?>
				</div>
			<?php endif;?>
    </div>
  </li>
<?php } ?>
<?php endforeach; ?>