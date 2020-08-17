<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showReviewList.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
<?php foreach($this->paginator as $review):?>
  <?php $reviewer = Engine_Api::_()->getItem('user', $review->owner_id);?>
  <?php $business = Engine_Api::_()->getItem('businesses', $review->business_id);?>
  <li class="sesbasic_clearfix">
    <div class="sesbusinessreview_review_listing_left">
      <div class="sesbusinessreview_review_listing_left_photo" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height;?>; width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width;?>;">
        <?php echo $this->htmlLink($business->getHref(), $this->itemPhoto($business, 'thumb.profile')) ?>
      </div>
      <?php if(in_array('businessName', $this->stats)):?>
        <p class="sesbusinessreview_review_listing_left_title"><?php echo $this->htmlLink($business->getHref(), $business->getTitle(),array('data-src' => $business->getGuid())) ?></p>
      <?php endif;?>
      <?php if(isset($this->featuredLabelActive) && $review->featured):?>
        <div class="sesbusinessreview_review_featured_block"><p><?php echo $this->translate('Featured');?></p></div>
      <?php endif;?>
      <?php if(isset($this->verifiedLabelActive) && $review->verified):?>
        <div class="sesbusinessreview_review_verified_block"><p><?php echo $this->translate('Verified');?></p></div>
      <?php endif;?>
    </div>
    <div class="sesbusinessreview_review_listing_right sesbasic_clearfix">
      <div class="sesbusinessreview_review_listing_top sesbasic_clearfix">
        <?php if(in_array('title', $this->stats)): ?>
          <div class='sesbusinessreview_review_listing_title sesbasic_clearfix'>
            <?php if(strlen($review->getTitle()) > $this->title_truncation):?>
              <?php $title = mb_substr($review->getTitle(),0,$this->title_truncation).'...';?>
            <?php else:?>
              <?php $title = $review->getTitle();?>
            <?php endif; ?>
            <?php echo $this->htmlLink($review->getHref(), $title) ?>
          </div>
        <?php endif; ?>
      <div class="sesbusinessreview_review_listing_top_info sesbasic_clearfix">
        <?php if(in_array('reviewOwnerPhoto', $this->stats)): ?>
          <div class='sesbusinessreview_review_listing_top_info_img'>
            <?php echo $this->htmlLink($reviewer->getOwner()->getHref(), $this->itemPhoto($reviewer->getOwner(), 'thumb.icon')) ?>
          </div>
        <?php endif; ?>
        <div class='sesbusinessreview_review_listing_top_info_cont'>
          <?php if(in_array('reviewOwnerName', $this->stats) || in_array('creationDate', $this->stats)): ?>
            <p class="sesbusinessreview_review_listing_stats sesbasic_text_light">
              <?php if(in_array('reviewOwnerName', $this->stats)): ?>
                <?php echo $this->translate('SESBUSINESSby ');?><?php echo $this->htmlLink($reviewer->getOwner()->getHref(), $reviewer->getOwner()->getTitle(), array('data-src' => $reviewer->getOwner()->getGuid())) ?>
              <?php endif; ?>
              <?php echo $this->translate('SESBUSINESSFor ');?><?php echo $this->htmlLink($business->getHref(), $business->getTitle()) ?>
              <?php if(in_array('reviewOwnerName', $this->stats) && in_array('creationDate', $this->stats)): ?> | <?php endif; ?>
              <?php if(in_array('creationDate', $this->stats)): ?>
                <?php echo $this->translate('SESBUSINESSabout ').$this->timestamp(strtotime($review->creation_date));?>
              <?php endif; ?>
            </p>
          <?php endif; ?>
          <p class="sesbusinessreview_review_listing_stats sesbasic_text_light">
            <?php if(in_array('likeCount', $this->stats)): ?>
              <span title="<?php echo $this->translate(array('%s like', '%s likes', $review->like_count), $this->locale()->toNumber($review->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $review->like_count; ?></span>
            <?php endif; ?>
            <?php if(in_array('commentCount', $this->stats)): ?>
              <span title="<?php echo $this->translate(array('%s comment', '%s comments', $review->comment_count), $this->locale()->toNumber($review->comment_count))?>"><i class="fa fa-comment"></i><?php echo $review->comment_count;?></span>
            <?php endif; ?>
            <?php if(in_array('viewCount', $this->stats)): ?>
              <span title="<?php echo $this->translate(array('%s view', '%s views', $review->view_count), $this->locale()->toNumber($review->view_count))?>"><i class="fa fa-eye"></i><?php echo $review->view_count; ?></span>
            <?php endif; ?>
          </p>
        </div>	
      </div>
      <div class="sesbusinessreview_review_show_rating review_ratings_listing">
        <?php if(in_array('rating', $this->stats)): ?>
          <div class="sesbasic_rating_star">
            <?php $ratingCount = $review->rating;?>
            <?php for($i=0; $i<5; $i++){?>
              <?php if($i < $ratingCount):?>
                <span id="" class="sesbusinessreview_rating_star"></span>
              <?php else:?>
                <span id="" class="sesbusinessreview_rating_star sesbusinessreview_rating_star_disable"></span>
              <?php endif;?>
            <?php }?>
          </div>
        <?php endif ?>
        <?php if(in_array('parameter', $this->stats)){ ?>
          <?php $reviewParameters = Engine_Api::_()->getDbtable('parametervalues', 'sesbusinessreview')->getParameters(array('content_id'=>$review->getIdentity(),'business_id'=>$review->business_id)); ?>
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
        }?>
      </div>
      </div>
      <div class="sesbusinessreview_review_listing_desc sesbasic_clearfix">
        <?php if(in_array('pros', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.show.pros', 1)): ?>
          <p class="sesbusinessreview_review_listing_body">
            <b><?php echo $this->translate("SESBUSINESSPros"); ?></b>
            <?php echo $this->string()->truncate($this->string()->stripTags($review->pros), 300) ?>
          </p>
        <?php endif; ?>
        <?php if(in_array('cons', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.show.cons', 1)): ?>
          <p class="sesbusinessreview_review_listing_body">
            <b><?php echo $this->translate("Cons"); ?></b>
            <?php echo $this->string()->truncate($this->string()->stripTags($review->cons), 300) ?>
          </p>
        <?php endif; ?>
        <?php if(in_array('description', $this->stats) && $review->description): ?>
          <p class='sesbusinessreview_review_listing_body'>
            <b><?php echo $this->translate("Description"); ?></b>
            <?php if(strlen($review->description) > $this->description_truncation):?>
              <?php $description = mb_substr($review->description,0,$this->description_truncation).'...';?>
            <?php else:?>
              <?php $description = $review->description;?>
            <?php endif; ?>
            <?php echo $description; ?>
          </p>
        <?php endif; ?>
        <?php if(in_array('recommended', $this->stats)):?>
          <p class="sesbusinessreview_review_listing_recommended"> <b><?php echo $this->translate('Recommended');?><i class="<?php if($review->recommended):?>fa fa-check<?php else:?>fa fa-times<?php endif;?>"></i></b></p>
        <?php endif;?>
        <p class="sesbusinessreview_review_listing_more">
          <a href="<?php echo $review->getHref()?>" class=""><?php echo $this->translate('Continue Reading »');?></a>
        </p>
      </div>
      <?php  echo $this->partial('_reviewOptions.tpl','sesbusinessreview',array('subject'=>$review,'viewer'=>$this->viewer(),'stats'=>$this->stats)); ?>
    </div>
  </li>
<?php endforeach;?>