<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
  <li class="sesbasic_clearfix sesmember_reviews">
    <div class="sesmember_review_listing_top sesbasic_clearfix">
    	<?php if(in_array('title', $this->stats)): ?>
        <div class='sesmember_review_listing_title sesbasic_clearfix'>
          <?php echo $this->htmlLink($this->review->getHref(), $this->review->title) ?>
        </div>
      <?php endif; ?>  
      <div class="sesmember_review_listing_top_info sesbasic_clearfix">
        <?php if(in_array('postedBy', $this->stats)): ?>
          <div class='sesmember_review_listing_top_info_img'>
            <?php echo $this->htmlLink($this->review->getOwner()->getHref(), $this->itemPhoto($this->review->getOwner(), 'thumb.icon')) ?>
          </div>
        <?php endif; ?>
        <div class='sesmember_review_listing_top_info_cont'>
        	<?php if(in_array('postedBy', $this->stats) || in_array('creationDate', $this->stats)): ?>
            <p class="sesmember_review_listing_stats sesbasic_text_light">
              <?php if(in_array('postedBy', $this->stats)): ?>
               by <?php echo $this->htmlLink($this->review->getOwner()->getHref(), $this->review->getOwner()->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $this->review->getOwner()->getGuid())) ?>
              <?php endif; ?>
              <?php if(in_array('postedBy', $this->stats) && in_array('creationDate', $this->stats)): ?> | <?php endif; ?>
              <?php if(in_array('creationDate', $this->stats)): ?>
                <?php echo $this->translate('about');?>
                <?php echo $this->timestamp(strtotime($this->review->creation_date)) ?>
              <?php endif; ?>
            </p>
          <?php endif; ?>
          <p class="sesmember_review_listing_stats sesbasic_text_light">
            <?php if(in_array('likeCount', $this->stats)): ?>
              <span title="<?php echo $this->translate(array('%s like', '%s likes', $this->review->like_count), $this->locale()->toNumber($this->review->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $this->review->like_count; ?></span>
            <?php endif; ?>
            <?php if(in_array('commentCount', $this->stats)): ?>
              <span title="<?php echo $this->translate(array('%s comment', '%s comments', $this->review->comment_count), $this->locale()->toNumber($this->review->comment_count))?>"><i class="fa fa-comment"></i><?php echo $this->review->comment_count;?></span>
            <?php endif; ?>
            <?php if(in_array('viewCount', $this->stats)): ?>
              <span title="<?php echo $this->translate(array('%s view', '%s views', $this->review->view_count), $this->locale()->toNumber($this->review->view_count))?>"><i class="fa fa-eye"></i><?php echo $this->review->view_count; ?></span>
            <?php endif; ?>
          </p>
        </div>
    </div>
    <div class="sesmember_review_show_rating review_ratings_listing">
        <?php if(in_array('rating', $this->stats)): ?>
          <div class="sesbasic_rating_star">
            <?php $ratingCount = $this->review->rating;?>
            <?php for($i=0; $i<5; $i++){?>
              <?php if($i < $ratingCount):?>
          <span id="" class="sesmember_rating_star"></span>
              <?php else:?>
          <span id="" class="sesmember_rating_star sesmember_rating_star_disable"></span>
              <?php endif;?>
            <?php }?>
          </div>
        <?php endif ?>
        <?php if(in_array('parameter', $this->stats)){ ?>
          <?php $reviewParameters = Engine_Api::_()->getDbtable('parametervalues', 'sesmember')->getParameters(array('content_id'=>$this->review->getIdentity(),'user_id'=>$this->review->owner_id)); ?>
          <?php if(count($reviewParameters)>0){ ?>
            <div class="sesmember_review_show_rating_box sesbasic_clearfix">
              <?php foreach($reviewParameters as $reviewP){ ?>
              <div class="sesbasic_clearfix">
                <div class="sesmember_review_show_rating_label"><?php echo $reviewP['title']; ?></div>
                <div class="sesmember_review_show_rating_parameters sesbasic_rating_parameter sesbasic_rating_parameter_small">
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
    <div class="sesmember_review_listing_desc sesbasic_clearfix">
      <?php if(in_array('pros', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.show.pros', 1)): ?>
        <p class="sesmember_review_listing_body">
          <b><?php echo $this->translate("Pros: "); ?></b>
          <?php echo $this->string()->truncate($this->string()->stripTags($this->review->pros), 300) ?>
        </p>
      <?php endif; ?>
      <?php if(in_array('cons', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.show.cons', 1)): ?>
        <p class="sesmember_review_listing_body">
          <b><?php echo $this->translate("Cons: "); ?></b>
          <?php echo $this->string()->truncate($this->string()->stripTags($this->review->cons), 300) ?>
        </p>
      <?php endif; ?>
      <?php if(in_array('description', $this->stats) && $this->review->description): ?>
        <p class='sesmember_review_listing_body'>
          <b><?php echo $this->translate("Description: "); ?></b>
          <?php echo $this->string()->truncate($this->string()->stripTags($this->review->description), 300) ?>
        </p>
      <?php endif; ?>
      <p class="sesmember_review_listing_recommended"> <b><?php echo $this->translate('Recommended');?><i class="<?php if($this->review->recommended):?>fa fa-check<?php else:?>fa fa-times<?php endif;?>"></i></b></p>
      <p class="sesmember_review_listing_more">
      	<a href="<?php echo $this->review->getHref(); ?>" class=""><?php echo $this->translate("Continue Reading"); ?> &raquo;</a>
			</p>
      
      </div>
      <?php  echo $this->partial('_reviewOptions.tpl','sesmember',array('subject'=>$this->review,'viewer'=> Engine_Api::_()->user()->getViewer(),'stats'=>$this->stats)); ?> 
  </li>
<div class="rating_params">
    <input type="hidden" id="rating_text" value="<?php echo $this->translate(array('%s rating', '%s ratings', $this->rating_count),$this->locale()->toNumber($this->rating_count)) ?>" />
    <input type="hidden" id="total_rating_average" value="<?php echo $this->total_rating_average; ?>" />
  </div>
  <div id="sesmember_review_create_form" class="" style="display:none;position:relative;"> 
    <?php echo $this->form->render($this);?>
  </div>
<?php die;?>