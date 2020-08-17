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
<?php  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<?php if($this->viewer()->getIdentity()):?>
 <?php $showFollowButton = 1;?>
<?php endif;?>
<div class="courses_category_carousel_wrapper courses_carousel_h_wrapper ">
  <div class="slide sesbasic_clearfix sesbasic_bxs courses_slick_slider_container <?php echo $this->params['isfullwidth'] ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->params['height'] ?>px;display:none;">
    <div class="pageslide_<?php echo $this->identity; ?> courses_category_carousel">
      <?php foreach( $this->paginator as $item): ?>
      <?php if($showFollowButton):?>
        <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'courses')->isFollow(array('resource_id' => $item->category_id,'resource_type' => 'courses_category')); ?>
        <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
        <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
      <?php endif;?>
      <div class="courses_category_carousel_item sesbasic_clearfix courses_grid_btns_wrap" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">
        <div class="courses_category_carousel_item_thumb" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">       
          <?php $href = $item->getHref(); $imageURL = $item->getPhotoUrl();?>
          <a href="<?php echo $href; ?>" class="courses_list_thumb_img">
            <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
          </a>
          <?php if(isset($this->socialshareActive)) {
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
            <div class="courses_grid_btns"> 
              <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sessocialshare')){ ?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->params['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->params['socialshare_icon_limit'])); ?>
              <?php } ?>
            </div>
           <?php } ?>
          </div>
          <div class="courses_category_carousel_item_info sesbasic_clearfix centerT">
            <?php if(isset($this->titleActive) ){ ?>
              <span class="courses_category_carousel_item_info_title">
                <?php if(strlen($item->getTitle()) > $this->params['title_truncation']){ 
                  $title = mb_substr($item->getTitle(),0,($this->params['title_truncation'])).'...';
                  echo $this->htmlLink($item->getHref(),$this->translate($title)) ?>
                <?php }else{ ?>
                  <?php 
                  echo $this->htmlLink($item->getHref(),$this->translate($item->getTitle()) )?>
                <?php } ?>
              </span>
            <?php } ?>
             <?php if(isset($this->descriptionActive) ){ ?>
             <span class="courses_category_carousel_item_info_des">
                <?php if(strlen($item->description) > $this->params['description_truncation']){ 
                        $description = mb_substr($item->description,0,($this->params['description_truncation'])).'...';
                        echo $description; ?>
                <?php }else{ ?>
                  <?php echo $item->description ?>
                <?php } ?>
              </span>
            <?php } ?>
            <?php if(isset($this->countCourseActive) ){ ?>
              <span class="courses_category_carousel_item_info_stat">
                <?php echo $this->translate(array('%s Course', '%s Courses',$item->total_courses_categories), $this->locale()->toNumber($item->total_courses_categories)); ?>
              </span>
            <?php } ?>
            <?php if($showFollowButton && isset($this->followButtonActive)):?>
              <span class="courses_category_carousel_item_info_button">
                <a href='javascript:;'  data-url='<?php echo $item->category_id; ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation courses_link_btn courses_category_follow courses_category_follow_<?php echo $item->category_id; ?>"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>
              </span>
            <?php endif;?>
          </div>
        </div>
      <?php  endforeach; ?> 
    </div>
  </div>
</div>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/scripts/slick/slick.js') ?>
<script type="text/javascript">
  window.addEvent('domready', function () {
		<?php if($this->params['isfullwidth']){ ?>
			var htmlElement = document.getElementsByTagName("body")[0];
			htmlElement.addClass('courses_category_carousel');
		<?php } ?>
		<?php if($this->params['autoplay']){ ?> var playAu = true; <?php }else{ ?> var playAu  = false; <?php } ?>
		sesBasicAutoScroll('.pageslide_<?php echo $this->identity; ?>').slick({
			dots: false,
			infinite: true,
			speed: <?php echo $this->params['speed'] ?>,
			slidesToShow: 1,
			centerMode: true,
			variableWidth: true,
			autoplay:playAu,
		});
  });
	sesBasicAutoScroll('.pageslide_<?php echo $this->identity; ?>').on('init', function(page, slick, currentSlide, nextSlide){
		sesBasicAutoScroll('.pageslide_<?php echo $this->identity; ?>').parent().show();
		console.log('done');
	});
</script>
