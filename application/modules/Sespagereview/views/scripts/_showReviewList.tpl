<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showReviewList.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
<?php foreach($this->paginator as $review):?>
  <?php $reviewer = Engine_Api::_()->getItem('user', $review->owner_id);?>
  <?php $page = Engine_Api::_()->getItem('sespage_page', $review->page_id);?>
  <li class="sesbasic_clearfix">
    <div class="sespagereview_review_listing_left">
      <div class="sespagereview_review_listing_left_photo" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height;?>; width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width;?>;">
        <?php echo $this->htmlLink($page->getHref(), $this->itemPhoto($page, 'thumb.profile')) ?>
      </div>
      <?php if(in_array('pageName', $this->stats)):?>
        <p class="sespagereview_review_listing_left_title"><?php echo $this->htmlLink($page->getHref(), $page->getTitle(),array('data-src' => $page->getGuid())) ?></p>
      <?php endif;?>
      <?php if(isset($this->featuredLabelActive) && $review->featured):?>
        <div class="sespagereview_review_featured_block"><p><?php echo $this->translate('Featured');?></p></div>
      <?php endif;?>
      <?php if(isset($this->verifiedLabelActive) && $review->verified):?>
        <div class="sespagereview_review_verified_block"><p><?php echo $this->translate('Verified');?></p></div>
      <?php endif;?>
    </div>
    <div class="sespagereview_review_listing_right sesbasic_clearfix">
      <div class="sespagereview_review_listing_top sesbasic_clearfix">
        <?php if(in_array('title', $this->stats)): ?>
          <div class='sespagereview_review_listing_title sesbasic_clearfix'>
            <?php if(strlen($review->getTitle()) > $this->title_truncation):?>
              <?php $title = mb_substr($review->getTitle(),0,$this->title_truncation).'...';?>
            <?php else:?>
              <?php $title = $review->getTitle();?>
            <?php endif; ?>
            <?php echo $this->htmlLink($review->getHref(), $title) ?>
          </div>
        <?php endif; ?>
      <div class="sespagereview_review_listing_top_info sesbasic_clearfix">
        <?php if(in_array('reviewOwnerPhoto', $this->stats)): ?>
          <div class='sespagereview_review_listing_top_info_img'>
            <?php echo $this->htmlLink($reviewer->getOwner()->getHref(), $this->itemPhoto($reviewer->getOwner(), 'thumb.icon')) ?>
          </div>
        <?php endif; ?>
        <div class='sespagereview_review_listing_top_info_cont'>
          <?php if(in_array('reviewOwnerName', $this->stats) || in_array('creationDate', $this->stats)): ?>
            <p class="sespagereview_review_listing_stats sesbasic_text_light">
              <?php if(in_array('reviewOwnerName', $this->stats)): ?>
                <?php echo $this->translate('SESPAGEby ');?><?php echo $this->htmlLink($reviewer->getOwner()->getHref(), $reviewer->getOwner()->getTitle(), array('data-src' => $reviewer->getOwner()->getGuid())) ?>
              <?php endif; ?>
              <?php echo $this->translate('SESPAGEFor ');?><?php echo $this->htmlLink($page->getHref(), $page->getTitle()) ?>
              <?php if(in_array('reviewOwnerName', $this->stats) && in_array('creationDate', $this->stats)): ?> | <?php endif; ?>
              <?php if(in_array('creationDate', $this->stats)): ?>
                <?php echo $this->translate('SESPAGEabout ').$this->timestamp(strtotime($review->creation_date));?>
              <?php endif; ?>
            </p>
          <?php endif; ?>
          <p class="sespagereview_review_listing_stats sesbasic_text_light">
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
      <div class="sespagereview_review_show_rating review_ratings_listing">
        <?php if(in_array('rating', $this->stats)): ?>
          <div class="sesbasic_rating_star">
            <?php $ratingCount = $review->rating;?>
            <?php for($i=0; $i<5; $i++){?>
              <?php if($i < $ratingCount):?>
                <span id="" class="sespagereview_rating_star"></span>
              <?php else:?>
                <span id="" class="sespagereview_rating_star sespagereview_rating_star_disable"></span>
              <?php endif;?>
            <?php }?>
          </div>
        <?php endif ?>
        <?php if(in_array('parameter', $this->stats)){ ?>
          <?php $reviewParameters = Engine_Api::_()->getDbtable('parametervalues', 'sespagereview')->getParameters(array('content_id'=>$review->getIdentity(),'page_id'=>$review->page_id)); ?>
          <?php if(count($reviewParameters)>0){ ?>
            <div class="sespagereview_review_show_rating_box sesbasic_clearfix">
              <?php foreach($reviewParameters as $reviewP){ ?>
                <div class="sesbasic_clearfix">
                  <div class="sespagereview_review_show_rating_label"><?php echo $reviewP['title']; ?></div>
                  <div class="sespagereview_review_show_rating_parameters sesbasic_rating_parameter sesbasic_rating_parameter_small">
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
      <div class="sespagereview_review_listing_desc sesbasic_clearfix">
        <?php if(in_array('pros', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.show.pros', 1)): ?>
          <p class="sespagereview_review_listing_body">
            <b><?php echo $this->translate("SESPAGEPros"); ?></b>
            <?php echo $this->string()->truncate($this->string()->stripTags($review->pros), 300) ?>
          </p>
        <?php endif; ?>
        <?php if(in_array('cons', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.show.cons', 1)): ?>
          <p class="sespagereview_review_listing_body">
            <b><?php echo $this->translate("Cons"); ?></b>
            <?php echo $this->string()->truncate($this->string()->stripTags($review->cons), 300) ?>
          </p>
        <?php endif; ?>
        <?php if(in_array('description', $this->stats) && $review->description): ?>
          <p class='sespagereview_review_listing_body'>
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
          <p class="sespagereview_review_listing_recommended"> <b><?php echo $this->translate('Recommended');?><i class="<?php if($review->recommended):?>fa fa-check<?php else:?>fa fa-times<?php endif;?>"></i></b></p>
        <?php endif;?>
        <p class="sespagereview_review_listing_more">
          <a href="<?php echo $review->getHref()?>" class=""><?php echo $this->translate('Continue Reading »');?></a>
        </p>
      </div>
      <?php  echo $this->partial('_reviewOptions.tpl','sespagereview',array('subject'=>$review,'viewer'=>$this->viewer(),'stats'=>$this->stats)); ?>
    </div>
  </li>
<?php endforeach;?>