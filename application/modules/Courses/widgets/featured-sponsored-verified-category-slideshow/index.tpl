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
<?php $descriptionLimit = $this->description_truncation;?>
<?php $identity = $this->identity;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/slideshow.css'); ?>
<div class="courses_slideshow_course_wrapper sesbasic_clearfix sesbasic_bxs <?php if($this->navigation != 'nextprev'){ echo " isbulletnav " ; } echo $this->isfullwidth ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->height ?>px;">
	<div class="courses_slideshow_course_container" style="height:<?php echo $this->height ?>px;">
  	<div class="courses_course_slideshow">
    	<div class="courses_slideshow_course" id="courses_slideshow_<?php echo $this->identity; ?>">
      <ul class="bjqs">
        <?php  foreach( $this->paginator as $course): ?>
        <li class="courses_slideshow_inner_view sesbasic_clearfix " style="height:<?php echo $this->height ?>px;">
          <div class="courses_slideshow_slides">
            <div class="courses_slideshow_inside">
              <div class="courses_slideshow_thumb courses_thumb">       
                <div class="courses_slideshow_thumb_img">
                  <a href="<?php echo $course->getHref(); ?>" class="slide_thumb" style="height:<?php echo $this->height ?>px;">
                   <?php if(isset($this->coursePhotoActive)){ ?>
                    <span style="background-image:url(<?php echo $course->getPhotoUrl('profile.icon'); ?>);"></span>
                    <?php } ?>
                  </a>        
                <div class="courses_labels">
                  <?php if(isset($this->featuredLabelActive) && $course->featured == 1):?>
                    <span class="courses_label_featured"><?php echo $this->translate('Featured'); ?></span>
                  <?php endif;?>
                  <?php if(isset($this->sponsoredLabelActive) && $course->sponsored == 1):?>
                    <span class="courses_label_sponsored"><?php echo $this->translate('Sponsored'); ?></span>
                  <?php endif;?>
                  <?php if(isset($this->verifiedLabelActive) && $course->verified == 1):?>
                        <span class="courses_label_verified"><?php echo $this->translate('Verified'); ?></span>
                  <?php endif;?>
                </div>
              </div>
              </div>
            </div>
            <div class="courses_slideshow_inside_contant">
              <div class="courses_slideshow_info sesbasic_clearfix ">
                <?php if(isset($this->titleActive) ){ ?>
                  <div class="courses_slideshow_info_title">
                    <?php if(strlen($course->getTitle()) > $this->title_truncation){ 
                      $title = mb_substr($course->getTitle(),0,$this->title_truncation).'...';
                      echo $this->htmlLink($course->getHref(),$title) ?>
                    <?php }else{ ?>
                      <?php echo $this->htmlLink($course->getHref(),$course->getTitle() ) ?>
                    <?php } ?>
                  </div>
                <?php } ?>
            <div class="courses_slideshow_mid_cont">
              <div class="courses_admin_stat">
                <?php if(isset($this->creationDateActive)){ ?>
                <div class="courses_course_stat sesbasic_text_light"> <span><i class="fa fa-calendar"></i>
                  <?php if($course->publish_date): ?>
                  <?php echo date('M d, Y',strtotime($course->publish_date));?>
                  <?php else: ?>
                  <?php echo date('M d, Y',strtotime($course->creation_date));?>
                  <?php endif; ?>
                  </span>
                </div>
                <?php } ?>
                 <?php if(isset($this->categoryActive)){ ?>
                    <?php if($course->category_id != '' && intval($course->category_id) && !is_null($course->category_id)):?>
                    <?php $categoryItem = Engine_Api::_()->getItem('courses_category', $course->category_id);?>
                        <?php if($categoryItem):?>
                            <div class="courses_course_stat sesbasic_text_light">
                            <span> <i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a> </span>
                            </div>
                        <?php endif;?>
                    <?php endif;?>
                  <?php } ?>
    			 		<?php if(isset($this->ratingActive)){ ?>
               <div class="courses_slideshow_rating">
              <?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/rating.tpl';?>   
              </div> 
               <?php } ?>
            </div>
           </div>
            <div class="_des sesbasic_text_light">
               <?php echo $this->string()->truncate($this->string()->stripTags($course->description), $descriptionLimit) ?>
            </div>
            <?php if(isset($this->likeActive) || isset($this->favouriteActive) || isset($this->commentActive) || isset($this->viewActive)){ ?>
              <div class="courses_static_list_group">
                <div class="courses_desc_stats sesbasic_text_light">
                 <?php if(isset($this->likeActive)){ ?>
                    <span title="<?php echo $this->translate(array('%s like', '%s likes', $course->like_count), $this->locale()->toNumber($course->like_count)); ?>"><i class="sesbasic_icon_like_o"></i><?php echo $course->like_count; ?></span>
                  <?php } ?>
                 <?php if(isset($this->commentActive)){ ?>
                    <span title="<?php echo $this->translate(array('%s comment', '%s comments', $course->comment_count), $this->locale()->toNumber($course->comment_count))?>"><i class="sesbasic_icon_comment_o"></i><?php echo $course->comment_count; ?></span>
                  <?php } ?>
                   <?php if(isset($this->favouriteActive)){ ?>
                    <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $course->favourite_count), $this->locale()->toNumber($course->favourite_count))?>"><i class="sesbasic_icon_favourite_o"></i><?php echo $course->favourite_count; ?></span>
                  <?php } ?>
                <?php if(isset($this->viewActive)){ ?>
                    <span title="<?php echo $this->translate(array('%s view', '%s views', $course->view_count), $this->locale()->toNumber($course->view_count))?>"><i class="sesbasic_icon_view"></i><?php echo $course->view_count; ?></span>
                  <?php } ?>
                </div>
                <div class="courses_list_grid_thumb_btns"> 
                    <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enable.sharing', 1)):?>
                    <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $course, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                    <?php endif;?>
                    <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                    <?php $canComment =  $course->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                    <?php if(isset($this->likeButtonActive)):?>                      
                      <?php $LikeStatus = Engine_Api::_()->courses()->getLikeStatus($course->course_id,$course->getType()); ?>
                      <a href="javascript:;" data-url="<?php echo $course->course_id ; ?>" data-type="courses_like_view" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn courses_like_<?php echo $course->course_id ?> courses_likefavfollow <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $course->like_count; ?></span></a>
                    <?php endif;?>
                    <?php if(isset($this->favouriteButtonActive) && isset($course->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enable.favourite', 1)): ?>
                      <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'courses')->isFavourite(array('resource_type'=>'courses','resource_id'=>$course->course_id)); ?>
                      <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count courses_favourite_<?php echo $course->course_id ;?>  sesbasic_icon_fav_btn courses_likefavfollow <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $course->course_id ; ?>" data-type="courses_favourite_view"><i class="fa fa-heart"></i><span><?php echo $course->favourite_count; ?></span></a>
                    <?php endif;?>
                  <?php endif;?>
                </div>    
              </div>   
             <?php } ?>
              <?php if(isset($this->priceActive)) { ?>
                <?php  include(APPLICATION_PATH."/application/Courses/views/scripts/_coursePrice.tpl"); ?>
               <?php } ?>
            </div>
          </div>
        </div>
      </li>
        <?php endforeach; ?>
    </ul>
  </div>
  </div>
  </div>
</div>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/scripts/slideshow/bjqs-1.3.min.js');
?>
<script type="text/javascript">
  window.addEvent('domready', function () {
		<?php if($this->isfullwidth){ ?>
			var htmlElement = document.getElementsByTagName("body")[0];
			htmlElement.addClass('courses_category_slideshow');
		<?php } ?>
		<?php if($this->autoplay){ ?>
			var autoplay_<?php echo $this->identity; ?> = true;
		<?php }else{ ?>
			var autoplay_<?php echo $this->identity; ?> = false;
		<?php } ?>
		<?php if($this->navigation == 'nextprev'){ ?>
			var navigation_<?php echo $this->identity; ?> = true;
			var markers_<?php echo $this->identity; ?> = false;
		<?php }else{ ?>
			var navigation_<?php echo $this->identity; ?> = false;
			markers_<?php echo $this->identity; ?> = true;
		<?php } ?>
		
			var	width = sesJqueryObject('#courses_slideshow_<?php echo $this->identity; ?>').outerWidth();
			var	heigth = '<?php echo $this->height ?>';
			sesJqueryObject('#courses_slideshow_<?php echo $this->identity; ?>').bjqs({
				responsive  : true,// enable responsive capabilities (beta)
				automatic: autoplay_<?php echo $this->identity; ?>,// automatic
				animspeed:<?php echo $this->speed; ?>,// the delay between each slide
				animtype:"<?php echo $this->type; ?>", // accepts 'fade' or 'slide'
				showmarkers:markers_<?php echo $this->identity; ?>,
				showcontrols: navigation_<?php echo $this->identity; ?>,/// center controls verically
				// if responsive is set to true, these values act as maximum dimensions
				width : width,
				height : heigth,
				slidecount: <?php echo count($this->paginator) ?>
			});
  });
// On before slide change
sesBasicAutoScroll('.courseslide_<?php echo $this->identity; ?>').on('init', function(event, slick, currentSlide, nextSlide){
  sesBasicAutoScroll('#courses_slideshow_<?php echo $this->identity; ?>').show();
});
</script>
