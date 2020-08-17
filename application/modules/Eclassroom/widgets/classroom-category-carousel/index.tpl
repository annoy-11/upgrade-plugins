<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/styles.css'); ?>
<?php if($this->viewer()->getIdentity()):?>
 <?php $showFollowButton = 1;?>
<?php endif;?>
<div class="eclassroom_category_carousel_wrapper eclassroom_carousel_h_wrapper ">
  <div class="slide sesbasic_clearfix sesbasic_bxs eclassroom_slick_slider_container <?php echo $this->params['isfullwidth'] ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->params['height'] ?>px;display:none;">
    <div class="classroomslide_<?php echo $this->identity; ?> eclassroom_category_carousel">
      <?php foreach( $this->paginator as $item):?>
      <?php if($showFollowButton):?>
        <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'eclassroom')->isFollow(array('resource_id' => $item->category_id,'resource_type' => 'eclassroom_category')); ?>
        <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
        <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
      <?php endif;?>
      <div class="eclassroom_category_carousel_item sesbasic_clearfix eclassroom_grid_btns_wrap" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">
        <div class="eclassroom_category_carousel_item_thumb" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">       
          <?php $href = $item->getHref(); $imageURL = $item->getPhotoUrl();?>
          <a href="<?php echo $href; ?>" class="eclassroom_list_thumb_img">
            <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
          </a>
          <?php if(isset($this->socialshareActive)) {
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
            <div class="eclassroom_grid_btns"> 
              <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sessocialshare')){ ?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->params['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->params['socialshare_icon_limit'])); ?>
              <?php } ?>
            </div>
           <?php } ?>
          </div>
          <div class="eclassroom_category_carousel_item_info sesbasic_clearfix centerT">
            <?php if(isset($this->titleActive) ){ ?>
              <span class="eclassroom_category_carousel_item_info_title">
                <?php if(strlen($item->getTitle()) > $this->params['title_truncation']){ 
                  $title = mb_substr($item->getTitle(),0,($this->params['title_truncation'] - 3 )).'...';
                  echo $this->htmlLink($item->getHref(),$this->translate($title)) ?>
                <?php }else{ ?>
                  <?php 
                  echo $this->htmlLink($item->getHref(),$this->translate($item->getTitle()) )?>
                <?php } ?>
              </span>
            <?php } ?>
             <?php if(isset($this->descriptionActive) ){ ?>
             <span class="eclassroom_category_carousel_item_info_des">
                <?php if(strlen($item->description) > $this->params['description_truncation']){ 
                        $description = mb_substr($item->description,0,($this->params['description_truncation'] - 3)).'...';
                        echo $description; ?>
                <?php }else{ ?>
                  <?php echo $item->description ?>
                <?php } ?>
              </span>
            <?php } ?>
            <?php if(isset($this->countClassroomActive) ){ ?>
              <span class="eclassroom_category_carousel_item_info_stat">
                <?php echo $this->translate(array('%s Classroom', '%s Classrooms',$item->total_classroom_categories), $this->locale()->toNumber($item->total_classroom_categories)); ?>
              </span>
            <?php } ?>
            <?php if($showFollowButton && isset($this->followButtonActive)):?>
              <span class="eclassroom_category_carousel_item_info_button">
                <a href='javascript:;' data-type='eclassroom_category_follow' data-url='<?php echo $item->category_id; ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation eclassroom_link_btn eclassroom_likefavfollow eclassroom_category_follow_<?php echo $item->category_id; ?>"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>
              </span>
            <?php endif;?>
          </div>
        </div>
      <?php endforeach; ?> 
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
			htmlElement.addClass('eclassroom_category_carousel');
		<?php } ?>
		<?php if($this->params['autoplay']){ ?> var playAu = true; <?php }else{ ?> var playAu  = false; <?php } ?>
		sesBasicAutoScroll('.classroomslide_<?php echo $this->identity; ?>').slick({
			dots: false,
			infinite: true,
			speed: <?php echo $this->params['speed'] ?>,
			slidesToShow: 1,
			centerMode: true,
			variableWidth: true,
			autoplay:playAu,
		});
  });
	sesBasicAutoScroll('.classroomslide_<?php echo $this->identity; ?>').on('init', function(page, slick, currentSlide, nextSlide){
		sesBasicAutoScroll('.classroomslide_<?php echo $this->identity; ?>').parent().show();
		console.log('done');
	});
</script>
