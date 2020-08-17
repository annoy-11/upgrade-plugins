<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<div class="courses_review_view courses_profile_review sesbasic_bxs sesbasic_clearfix">
  <div class="courses_review_listing_top sesbasic_clearfix">
    <?php if(in_array('title', $this->stats)): ?>
    	<div class="courses_review_listing_title"><?php echo $this->review->getTitle() ?></div>
    <?php endif; ?>
    <div class="courses_review_listing_top_info sesbasic_clearfix">
      <div class="courses_review_listing_top_info_img">
        <?php if(in_array('postedin', $this->stats)): ?>
        <?php echo $this->htmlLink($this->item->getHref(), $this->itemPhoto($this->item, 'thumb.icon')); ?>
        <?php endif; ?>
      </div>
      <div class="courses_review_listing_top_info_cont sesbasic_clearfix">
        <p class='courses_review_listing_stats sesbasic_text_light sesbasic_clearfix'>
          <?php if(in_array('postedin', $this->stats)): ?>
          	<?php echo $this->translate('For');?> <?php echo $this->htmlLink($this->item, $this->item) ?>
          <?php endif; ?>
          <?php if(in_array('postedin', $this->stats) && in_array('creationDate', $this->stats)) : ?> | <?php endif; ?>
          <?php if(in_array('creationDate', $this->stats)): ?>
            <?php echo $this->translate('about').' '.$this->timestamp($this->review->creation_date) ?></p>
          <?php endif; ?>
        </p>
        <p class="courses_review_listing_stats sesbasic_text_light">
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
    <div class="courses_review_show_rating review_ratings_listing">
      <?php if(in_array('rating', $this->stats)){ ?>
        <div class="sesbasic_rating_star courses_review_listing_star">
          <?php $ratingCount = $this->review->rating;?>
          <?php for($i=0; $i<5; $i++){?>
          <?php if($i < $ratingCount):?>
          <span id="" class="courses_rating_star"></span>
          <?php else:?>
          <span id="" class="courses_rating_star courses_rating_star_disable"></span>
          <?php endif;?>
          <?php }?>
        </div>
      <?php } ?>
      <?php if(in_array('parameter', $this->stats)){ ?>
      <?php $reviewParameters = Engine_Api::_()->getDbtable('parametervalues', 'courses')->getParameters(array('content_id'=>$this->review->getIdentity(),'user_id'=>$this->review->owner_id)); ?>
      <?php if(count($reviewParameters)>0){ ?>
      <div class="courses_review_show_rating_box sesbasic_clearfix">
        <?php foreach($reviewParameters as $reviewP){ ?>
          <div class="sesbasic_clearfix">
            <div class="courses_review_show_rating_label"><?php echo $reviewP['title']; ?></div>
            <div class="courses_review_show_rating_parameters sesbasic_rating_parameter sesbasic_rating_parameter_small">
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
  
  <div class="courses_review_listing_desc">
    <?php if(in_array('pros', $this->stats) && $this->review->pros): ?>
    	<div class="courses_review_listing_body"> <b class="label"><?php echo $this->translate("Pros"); ?></b> <?php echo $this->review->pros;  ?> </div>
    <?php endif; ?>
    <?php if(in_array('cons', $this->stats) && $this->review->cons): ?>
    	<div class="courses_review_listing_body"> <b class="label"><?php echo $this->translate("Cons"); ?></b> <?php echo $this->review->cons;  ?> </div>
    <?php endif; ?>
    <?php if(in_array('description', $this->stats)): ?>
    	<div class='courses_review_listing_body'> <b class="label"><?php echo $this->translate("Summary"); ?></b>
      	<div class="sesbasic_html_block"><?php echo $this->review->description;  ?></div>
      </div>
    <?php endif; ?>
    <?php if(in_array('recommended', $this->stats)): ?>
      <div class="courses_review_listing_recommended"> <b><?php echo $this->translate("Recommended"); ?>
        <?php if($this->review->recommended): ?>
      <i class="fa fa-check"></i></b>
        <?php else: ?>
      <i class="fa fa-times"></i></b>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
  <?php  echo $this->partial('_reviewOptions.tpl','courses',array('subject'=>$this->review,'viewer'=> Engine_Api::_()->user()->getViewer(),'stats'=>$this->stats,'profileWidgets'=>true)); ?>  
</div>
