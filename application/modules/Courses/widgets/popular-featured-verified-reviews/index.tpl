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
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<?php if($this->widgetIdentity){ 
    $randonnumber = $this->widgetIdentity;
  }else{
    $randonnumber = $this->identity;
  }
?>
<ul class="sesbasic_sidebar_block courses_review_sidebar_block sesbasic_bxs sesbasic_clearfix"  id="widget_courses_<?php echo $randonnumber; ?>" style="position:relative;">
  <div class="sesbasic_loading_cont_overlay" id="courses_widget_overlay_<?php echo $randonnumber; ?>"></div>
  <?php foreach( $this->results as $review ):?>
    <?php $reviewOwner = Engine_Api::_()->getItem('user', $review->owner_id);?>
    <li class="courses_review_sidebar_list <?php if($this->image_type == 'rounded'):?>courses_sidebar_image_rounded<?php endif;?> sesbasic_clearfix">
      <?php echo $this->htmlLink($reviewOwner, $this->itemPhoto($reviewOwner, 'thumb.icon')); ?>
      <div class="courses_review_sidebar_list_info">
          <?php  if(isset($this->titleActive)){ ?>
          <div class="courses_review_sidebar_list_title">
            <?php if(strlen($review->getTitle()) > $this->title_truncation){
            $title = mb_substr($review->getTitle(),0,($this->title_truncation-3)).'...';
            echo $this->htmlLink($review->getHref(),$title);
            } else { ?>
            <?php echo $this->htmlLink($review->getHref(),$review->getTitle()) ?>
              <?php } ?>
          </div>
        <?php } ?>
          <?php $reviewCrator = Engine_Api::_()->getItem('user', $review->owner_id);?>
          <?php $reviewTaker = Engine_Api::_()->getItem('courses', $review->course_id);?> 
          <?php if(isset($this->reviewOwnerNameActive) || isset($this->courseNameActive)):?>
            <div class="courses_review_sidebar_list_stat sesbasic_text_light">
              <?php if(isset($this->reviewOwnerNameActive)):?>
                <?php echo 'by '.$this->htmlLink($reviewCrator, $reviewCrator->getTitle(), array('data-src' => $reviewCrator->getGuid()));?>
              <?php endif;?>
              <?php if(isset($this->courseNameActive)):?>
                <?php echo 'For '.$this->htmlLink($reviewTaker, $reviewTaker->getTitle(), array('data-src' => $reviewTaker->getGuid()));?>	
              <?php endif;?>
            </div>
          <?php endif;?>  
              <div class="courses_list_stats courses_review_sidebar_list_stat">
          <?php if(isset($this->likeActive) && isset($review->like_count)) { ?>
              <span title="<?php echo $this->translate(array('%s like', '%s likes', $review->like_count), $this->locale()->toNumber($review->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $review->like_count; ?></span>
          <?php } ?>
          <?php if(isset($this->viewActive) && isset($review->view_count)) { ?>
              <span title="<?php echo $this->translate(array('%s view', '%s views', $review->view_count), $this->locale()->toNumber($review->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $review->view_count; ?></span>
          <?php } ?>
          <?php if(isset($this->commentActive) && isset($review->comment_count)) { ?>
              <span title="<?php echo $this->translate(array('%s comment', '%s comments', $review->comment_count), $this->locale()->toNumber($review->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $review->comment_count; ?></span>
          <?php } ?>
          <?php if(Engine_Api::_()->getApi('core', 'courses')->allowReviewRating() && $this->ratingActive){
            echo '<span title="'.$this->translate(array('%s rating', '%s ratings', $review->rating), $this->locale()->toNumber($review->rating)).'"><i class="fa fa-star sesbasic_text_light"></i>'.round($review->rating,1).'/5'. '</span>';
          } ?>
        </div>
        <?php if(isset($this->ratingActive)): ?>
          <div class="courses_list_rating courses_review_sidebar_list_stat clear">
            <?php $ratingCount = $review->rating;?>
            <?php for($i=0; $i<5; $i++){?>
              <?php if($i < $ratingCount):?>
                <span id="" class="courses_rating_star_small"></span>
              <?php else:?>
                <span id="" class="courses_rating_star_small_half"></span>
              <?php endif;?>
            <?php }?>
                      </div>
        <?php endif ?>
          </div>
      <?php if($this->descriptionActive):?>
        <div class="courses_review_sidebar_list_body clear">
      <?php if(strlen($this->string()->stripTags($review->getDescription())) > $this->description_truncation){
        $description = mb_substr($this->string()->stripTags($review->getDescription()),0,($this->description_truncation-3)).'...';
        echo $description;
      } else { ?>
        <?php  echo $this->string()->stripTags($review->getDescription()); ?>
      <?php } ?>
        </div>
      <?php endif;?>
      <div class="courses_review_sidebar_featured_list">
        <?php if(isset($this->featuredLabelActive) && $review->featured):?>
      <p class="featured"><?php echo $this->translate('Featured');?></p>
        <?php endif;?>
        <?php if(isset($this->verifiedLabelActive) && $review->verified):?>
      <p class="verified"><?php echo $this->translate('Verified');?></p>
        <?php endif;?>
      </div>
    </li>
  <?php endforeach; ?>
</ul>
<?php if(isset($this->widgetName)){ ?>
  <div class="sidebar_privew_next_btns">
    <div class="sidebar_previous_btn">
      <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Previous'), array(
        'id' => "widget_previous_".$randonnumber,
        'onclick' => "widget_previous_$randonnumber()",
        'class' => 'buttonlink previous_icon'
      )); ?>
    </div>
    <div class="Sidebar_next_btns">
      <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Next'), array(
        'id' => "widget_next_".$randonnumber,
        'onclick' => "widget_next_$randonnumber()",
        'class' => 'buttonlink_right next_icon'
      )); ?>
    </div>
  </div>
<?php } ?>
</ul>
<?php if(isset($this->widgetName)){ ?>
<script type="application/javascript">
 		var anchor_<?php echo $randonnumber ?> = sesJqueryObject('#widget_courses_<?php echo $randonnumber; ?>').parent();
    function showHideBtn<?php echo $randonnumber ?> (){
			sesJqueryObject('#widget_previous_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->results->getCurrentPageNumber() == 1 ? 'none' : '' ) ?>');
    	sesJqueryObject('#widget_next_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->results->count() == $this->results->getCurrentPageNumber() ? 'none' : '' ) ?>');	
		}
		showHideBtn<?php echo $randonnumber ?> ();
    function widget_previous_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#courses_widget_overlay_<?php echo $randonnumber; ?>').show();
      new Request.HTML({
        url : en4.core.baseUrl + 'widget/index/mod/courses/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
        data : {
          format : 'html',
					is_ajax: 1,
					params :'<?php echo json_encode($this->params); ?>', 
          page : <?php echo sprintf('%d', $this->results->getCurrentPageNumber() - 1) ?>
        },
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					anchor_<?php echo $randonnumber ?>.html(responseHTML);
					<?php if(isset($this->view_type) && $this->view_type == 'gridOutside'){ ?>
					jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({theme:"minimal-dark"});
				<?php } ?>
					sesJqueryObject('#courses_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
      }).send()
		};

    function widget_next_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#courses_widget_overlay_<?php echo $randonnumber; ?>').show();
      new Request.HTML({
        url : en4.core.baseUrl + 'widget/index/mod/courses/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
        data : {
          format : 'html',
					is_ajax: 1,
					params :'<?php echo json_encode($this->params); ?>' , 
          page : <?php echo sprintf('%d', $this->results->getCurrentPageNumber() + 1) ?>
        },
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					anchor_<?php echo $randonnumber ?>.html(responseHTML);
					<?php if(isset($this->view_type) && $this->view_type == 'gridOutside'){ ?>
					jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({theme:"minimal-dark"});
				<?php } ?>
					sesJqueryObject('#courses_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
      }).send();
		};

</script>
<?php } ?>
