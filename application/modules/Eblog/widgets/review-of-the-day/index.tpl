<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $reviewOwner = Engine_Api::_()->getItem('user', $review->owner_id);?>
<ul class="eblog_blog_listing sesbasic_bxs sesbasic_clearfix">
<?php foreach( $this->results as $review ): ?>
   <li class="eblog_grid eblog_review_of_the_day sesbasic_clearfix sesbasic_bxs eblog_grid_btns_wrap">
    <div class="eblog_grid_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
      <?php $href = $reviewOwner->getHref();$imageURL = $reviewOwner->getPhotoUrl('thumb.profile');?>
      <a href="<?php echo $href; ?>" class="eblog_thumb_img">
        <span class="floatL" style="background-image:url(<?php echo $imageURL; ?>);"></span>
      </a>
      <?php if(isset($this->featuredLabelActive)){ ?>
      <div class="eblog_list_labels">
        <?php if(isset($this->featuredLabelActive) && $review->featured){ ?>
          <p class="eblog_label_featured"><?php echo $this->translate('Featured');?></p>
        <?php } ?>
         <?php if(isset($this->verifiedLabelActive) && $review->verified == 1){ ?>
           <p class="eblog_label_verified"><?php echo $this->translate('Verified');?></p>
            <?php } ?>
      </div>
      <?php } ?>
         </div>
      <div class="eblog_review_grid_thumb_cont">
      	<?php if(isset($this->titleActive) ){ ?>
          <div class="eblog_grid_info_title">
            <?php if(strlen($review->getTitle()) > $this->title_truncation){ 
            $title = mb_substr($review->getTitle(),0,($this->title_truncation - 3)).'...';
            echo $this->htmlLink($review->getHref(),$title, array('class' => '', 'data-src' => $review->getGuid()) ) ?>
            <?php }else{ ?>
            <?php echo $this->htmlLink($review->getHref(),$review->getTitle(), array('class' => '', 'data-src' => $review->getGuid())) ?>
            <?php } ?>
          </div>
      	<?php } ?>
      </div>
		<div class="eblog_review_grid_info sesbasic_clearfix clear">
			<?php $reviewCrator = Engine_Api::_()->getItem('user', $review->owner_id);?> 
			<?php $reviewTaker = Engine_Api::_()->getItem('eblog_blog', $review->blog_id);?> 
			<div class="eblog_review_grid_stat eblog_sidebar_image_rounded sesbasic_text_light">
				<div class="eblog_review_title_block">
				  <?php if(isset($this->byActive)):?>
						<p><?php echo 'Posted by '.$this->htmlLink($reviewCrator, $reviewCrator->getTitle());?></p>
					<?php endif;?>
					<p><?php echo $this->htmlLink($reviewTaker, $this->itemPhoto($reviewTaker, 'thumb.icon'), array('class' => 'eblog_reviw_prof_img')); ?><?php echo 'For '.$this->htmlLink($reviewTaker, $reviewTaker->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $reviewTaker->getGuid()));?></p>
					<div class="eblog_list_stats eblog_review_grid_stat clear">
						<?php if(isset($this->likeActive) && isset($review->like_count)) { ?>
						<span title="<?php echo $this->translate(array('%s like', '%s likes', $review->like_count), $this->locale()->toNumber($review->like_count)); ?>"><i class="sesbasic_icon_like_o sesbasic_text_light"></i><?php echo $review->like_count; ?></span>
						<?php } ?>
						<?php if(isset($this->viewActive) && isset($review->view_count)) { ?>
						<span title="<?php echo $this->translate(array('%s view', '%s views', $review->view_count), $this->locale()->toNumber($review->view_count))?>"><i class="sesbasic_icon_view sesbasic_text_light"></i><?php echo $review->view_count; ?></span>
						<?php } ?>
						<?php if(Engine_Api::_()->getApi('core', 'eblog')->allowReviewRating() && $this->ratingActive){
						echo '<span title="'.$this->translate(array('%s rating', '%s ratings', $review->rating), $this->locale()->toNumber($review->rating)).'"><i class="fa fa-star-o sesbasic_text_light"></i>'.round($review->rating,1).'/5'. '</span>';
						} ?>
					</div>
				</div>
				<?php if(isset($this->ratingActive)): ?>
					<div class="eblog_list_rating eblog_review_sidebar_list_stat">
						<?php $ratingCount = $review->rating; $x=0; ?>
						<?php if( $ratingCount > 0 ): ?>
							<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
								<span id="" class="eblog_rating_star_small"></span>
							<?php endfor; ?>
							<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
								<span class="eblog_rating_star_small eblog_rating_star_small_half"></span>
							<?php }else{ $x = $x - 1;} ?>
							<?php if($x < 5){ 
								for($j = $x ; $j < 5;$j++){ ?>
								<span class="eblog_rating_star_small eblog_rating_star_disable"></span>
								<?php }   	
							} ?>
						<?php endif; ?>
					</div>
				<?php endif ?> 
		  </div>
      <?php if($this->descriptionActive && $review->getDescription()):?>
				<div class="eblog_review_sidebar_list_body clear">
					<?php if(strlen($this->string()->stripTags($review->getDescription())) > $this->description_truncation):?>
						<?php $description = mb_substr($this->string()->stripTags($review->getDescription()),0,($this->description_truncation-3)).'...';?>
						<?php echo $description;?>
					<?php else: ?>
						<?php  echo $this->string()->stripTags($review->getDescription()); ?>
					<?php endif; ?>
				</div>
			<?php endif;?>
    </div>
     <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)) || isset($this->likeButtonActive)) {
      $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $review->getHref()); ?>
        <div class="eblog_list_share_btns"> 
          <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)){ ?>
            
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $review, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

          <?php }  ?>			
        </div>
      <?php } ?>
  </li>
  <?php endforeach; ?>
</ul>