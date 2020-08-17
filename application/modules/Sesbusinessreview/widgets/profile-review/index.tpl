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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessreview/externals/styles/styles.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
<div class="sesbusinessreview_review_view sesbusinessreview_profile_review sesbasic_bxs sesbasic_clearfix">
  <div class="sesbusinessreview_review_view_top sesbasic_clearfix">
    <?php if(in_array('title', $this->stats)): ?>
    	<div class="sesbusinessreview_review_view_title"><?php echo $this->review->getTitle() ?></div>
    <?php endif; ?>
    <div class="sesbusinessreview_review_view_item_info sesbasic_clearfix">
      <div class="sesbusinessreview_review_view_info_img">
        <?php if(in_array('postedin', $this->stats)): ?>
        <?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.icon')); ?>
        <?php endif; ?>
      </div>
      <div class="sesbusinessreview_review_view_info_cont sesbasic_clearfix">
        <p class='sesbusinessreview_review_view_stats sesbasic_text_light sesbasic_clearfix'>
          <?php if(in_array('postedin', $this->stats)): ?>
          	<?php echo $this->translate('SESBUSINESSFor');?> <?php echo $this->htmlLink($this->item, $this->item) ?>
          <?php endif; ?>
          <?php if(in_array('postedin', $this->stats) && in_array('creationDate', $this->stats)) : ?> | <?php endif; ?>
          <?php if(in_array('creationDate', $this->stats)): ?>
            <?php echo $this->translate('SESBUSINESSabout ').$this->timestamp($this->review->creation_date) ?></p>
          <?php endif; ?>
        </p>
        <p class="sesbusinessreview_review_view_stats sesbasic_text_light">
          <?php if(in_array('likeCount', $this->stats)): ?>
          <span><i class="fa fa-thumbs-up"></i><?php echo $this->translate(array('%s like', '%s likes', $this->review->like_count), $this->locale()->toNumber($this->review->like_count)); ?></span>
          <?php endif; ?>
          <?php if(in_array('commentCount', $this->stats)): ?>
          <span><i class="fa fa-comment"></i><?php echo $this->translate(array('%s comment', '%s comments', $this->review->comment_count), $this->locale()->toNumber($this->review->comment_count))?></span>
          <?php endif; ?>
          <?php if(in_array('viewCount', $this->stats)): ?>
          <span><i class="fa fa-eye"></i><?php echo $this->translate(array('%s view', '%s views', $this->review->view_count), $this->locale()->toNumber($this->review->view_count))?></span>
          <?php endif; ?>
        </p>
      </div>
    </div>
    <div class="sesbusinessreview_review_show_rating review_ratings_listing">
      <?php if(in_array('rating', $this->stats)){ ?>
        <div class="sesbasic_rating_star sesbusinessreview_review_listing_star">
          <?php $ratingCount = $this->review->rating;?>
          <?php for($i=0; $i<5; $i++){?>
          <?php if($i < $ratingCount):?>
          <span id="" class="sesbusinessreview_rating_star"></span>
          <?php else:?>
          <span id="" class="sesbusinessreview_rating_star sesbusinessreview_rating_star_disable"></span>
          <?php endif;?>
          <?php }?>
        </div>
      <?php } ?>
      <?php if(in_array('parameter', $this->stats)){ ?>
      <?php $reviewParameters = Engine_Api::_()->getDbtable('parametervalues', 'sesbusinessreview')->getParameters(array('content_id'=>$this->review->getIdentity(),'business_id'=>$this->review->business_id)); ?>
      <?php if(count($reviewParameters)>0){ ?>
      <div class="sesbusinessreview_review_show_rating_box sesbasic_clearfix">
        <?php foreach($reviewParameters as $reviewP){ ?>
          <div class="sesbasic_clearfix">
            <div class="sesbusinessreview_review_show_rating_label"><?php echo $reviewP['title']; ?></div>
            <div class="sesbusinessreview_review_show_rating_parameters sesbasic_rating_parameter sesbasic_rating_parameter_small">
              <?php $ratingCount = $reviewP['rating'];?>
              <?php for($i=0; $i<5; $i++){?>
              <?php if($i < $ratingCount):?>
              <span id="" class="sesbasic-rating-parameter-unit"></span>
              <?php else:?>
              <span id="" class="sesbasic-rating-parameter-unit sesbasic-rating-parameter-unit-disable"></span>
              <?php endif;?>
              <?php }?>
            </div>
          </div>
        <?php } ?>
      </div>
      <?php } 
    }
    ?>
    </div>
  </div>
  <div class="sesbusinessreview_review_contant_disc">
    <?php if(in_array('pros', $this->stats) && $this->review->pros): ?>
    	<div class="sesbusinessreview_review_view_cont_row"> <b class="label"><?php echo $this->translate("SESBUSINESSPros"); ?></b> <?php echo $this->review->pros;  ?> </div>
    <?php endif; ?>
    <?php if(in_array('cons', $this->stats) && $this->review->cons): ?>
    	<div class="sesbusinessreview_review_view_cont_row"> <b class="label"><?php echo $this->translate("SESBUSINESSCons"); ?></b> <?php echo $this->review->cons;  ?> </div>
    <?php endif; ?>
    <?php if(in_array('description', $this->stats)): ?>
    	<div class='sesbusinessreview_review_view_cont_row'> <b class="label"><?php echo $this->translate("SESBUSINESSESummary"); ?></b>
      	<div class="sesbasic_html_block"><?php echo $this->review->description;  ?></div>
      </div>
    <?php endif; ?>
    <?php if(in_array('recommended', $this->stats)): ?>
      <div class="sesbusinessreview_review_view_cont_row sesbusinessreview_review_view_recommended"> <b><?php echo $this->translate("SESBUSINESSRecommended"); ?>
        <?php if($this->review->recommended): ?>
	  <i class="fa fa-check"></i></b>
        <?php else: ?>
	  <i class="fa fa-times"></i></b>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
  <?php  echo $this->partial('_reviewOptions.tpl','sesbusinessreview',array('subject'=>$this->review,'viewer'=> Engine_Api::_()->user()->getViewer(),'stats'=>$this->stats,'profile'=>true,'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon,'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>  
</div>
