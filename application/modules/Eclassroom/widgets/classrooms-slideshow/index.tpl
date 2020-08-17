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

<?php 

 $identity = $this->identity;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/styles.css'); ?>
<?php if($this->params['enableSlideshow']){ ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Courses/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Courses/externals/scripts/owl.carousel.js'); 
?>
 <?php } ?>
 <?php $descriptionLimit = 0;?>
<?php if(isset($this->descriptionActive)):?>
<?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<div class="eclassroom_classrooms_slideshow_wrapper sesbasic_clearfix sesbasic_bxs">
 <?php if(isset($this->newLabelActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('classroom.new', 1)):?>
    <div class="eclassroom_list_newlabel">
        <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_newLabel.tpl';?>
    </div>
 <?php endif;?>
  <div class="eclassroom_classrooms_slideshow_container sesbasic_clearfix eclassroom_fg_color">
    <div class="_right_col <?php if(empty($this->params['leftClassroom'])) {?>_noleftblock<?php } ?>" <?php if(empty($this->params['enableSlideshow'])) { ?> style="display:none;" <?php } ?>>
      <div class="eclassroom_classrooms_slideshow eclassroom_classrooms_slideshow_<?php echo $this->identity;?>" style="height:<?php echo $this->params['height'] ?>px;">
        <?php $leftData = array();?>
        <?php foreach($this->classrooms as $data):?>
          <?php if($data['type'] == 'left'):?>
             <?php $leftData[] = $data['classroom_id']; ?>
             <?php continue;?>
          <?php endif;?>
          <?php $classroom = Engine_Api::_()->getItem('classroom', $data['classroom_id']);?>
          	<div class="eclassroom_classrooms_slideshow_item sesbasic_clearfix">
            	<div class="_thumb eclassroom_thumb" style="height:<?php echo $this->params['height'] ?>px;"> 
                <a href="<?php echo $classroom->getHref(); ?>" class="eclassroom_thumb_img">
                  <span style="background-image:url(<?php echo $classroom->getCoverPhotoUrl() ?>);"></span>
                </a>
                <div class="thumb_logo_slide">
                  <a href="<?php echo $classroom->getHref(); ?>" class="logo_is rounded">
                    <span class="bg_item_photo" style="background-image:url(<?php echo $classroom->getPhotoUrl('thumb.icon'); ?>);">
                    </span>
                  </a>
                </div>
              	<div class="eclassroom_list_labels sesbasic_animation">
                  <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataLabel.tpl';?>
                </div>
                 <div class="_btns sesbasic_animation">
                    <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataButtons.tpl';?>
                </div>
            	</div>
              <div class="eclassroom_classrooms_slideshow_cont_wrap">   
                <?php if(isset($this->titleActive)):?>
                  <?php if(strlen($classroom->getTitle()) > $this->params['title_truncation']):?>
                    <?php $title = mb_substr($classroom->getTitle(),0,$this->params['title_truncation']).'...';?>
                  <?php else: ?>
                    <?php $title = $classroom->getTitle();?>
                  <?php endif; ?>
                  <div class="_title">
                    <a href="<?php echo $classroom->getHref();?>"><?php echo $title;?></a>
                    <?php  if(isset($this->verifiedLabelActive)&& $classroom->verified):?>
                      <i class="eclassroom_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
                    <?php  endif;?>
                  </div>
                  <?php endif;?>
                  <div class="eclassroom_classrooms_slideshow_cont">
                    <?php if(isset($this->ratingActive)):?>
                        <div class="eclassroom_slideshow_rating sesbasic_clearfix sesbasic_bxs">
                            <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/rating.tpl';?>
                        </div>
                     <?php endif;?>
                    <div class="_stats sesbasic_text_light sesbasic_clearfix sesbasic_bxs">
                     <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataStatics.tpl';?>
                    </div>  
                    <div class="_stats sesbasic_text_light">
                    <?php if(ECLASSROOMSHOWUSERDETAIL == 1 && isset($this->byActive)): ?>
                      <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($classroom->getOwner()->getHref(), $classroom->getOwner()->getTitle());?></span>
                    <?php endif;?>
                    <?php if(isset($this->creationDateActive)):?>
                    -&nbsp;
                      <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_date.tpl';?>
                    <?php endif;?>
										<?php if (!empty($classroom->category_id)): ?>
                            <?php $category = Engine_Api::_ ()->getDbtable('categories', 'eclassroom')->find($classroom->category_id)->current();?>
                     <?php endif;?> 
                    <?php if(isset($category) && isset($this->categoryActive)):?>
                    <span class="_stats sesbasic_text_light"> 
                      -&nbsp;<span><i class="fa fa-folder-open"></i><span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
                      </span> 
                    </span>
                    <?php endif;?>
										<?php  if(isset($this->locationActive) && $classroom->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.location', 1)):?>
                    -&nbsp;<span class="_stats sesbasic_text_light _location"> <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i> 
                      <span title="<?php echo $classroom->location;?>">
                        <?php if(Engine_Api::_()->getApi('settings','core')->getSetting('eclassroom.enable.map.integration', 1)):?>
                          <a href="<?php echo $this->url(array('resource_id' => $classroom->classroom_id,'resource_type'=>'classroom','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $classroom->location;?></a>
                        <?php else:?>
                          <?php echo $classroom->location;?>
                        <?php  endif;?>
                      </span>
                    </span>
                    <?php endif;?>
                    </div>
                    <?php if($descriptionLimit):?>
                    <div class="_des sesbasic_clearfix"> <?php echo $this->string()->truncate($this->string()->stripTags($classroom->description), $descriptionLimit) ?></div>
                    <?php endif;?>
										<?php if(isset($this->socialSharingActive)):?>
                        <div class="eclassroom_slide_sharebtn sesbasic_clearfix sesbasic_bxs">
                            <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataSharing.tpl';?>
                        </div>
                  	<?php endif;?>
                  </div>
                </div>
              </div>
        <?php endforeach;?>
        </div>  
      </div>
    <?php if($this->params['leftClassroom']) {  
      $height = ($this->params['height'] -20) / 3; 
    ?>
       <div class="_left_col <?php if(empty($this->params['enableSlideshow'])) {?>_norightblock<?php } ?>">
        <?php for($i=0;$i<count($leftData);$i++):?>
          <?php $classroom = Engine_Api::_()->getItem('classroom', $leftData[$i]);?>
          <div class="eclassroom_classrooms_slideshow_left_item">
            <div class="_thumb" style="height:<?php echo $height ?>px;">
              <a href="<?php echo $classroom->getHref(); ?>" class="_thumbimg">
                <span style="background-image:url(<?php echo $classroom->getPhotoUrl('thumb.profile'); ?>);"></span>
              </a>
            </div>
            <div class="_cont">    
              <?php if(isset($this->titleActive)):?>
                <div class="_title">
                  <a href="<?php echo $classroom->getHref();?>"><?php echo $classroom->getTitle();?></a>
                  <?php if(isset($this->verifiedLabelActive) && $classroom->verified):?>
                    <i class="eclassroom_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <?php if(isset($this->categoryActive)):?>
                <div class="_stats sesbasic_clearfix">
                  <?php if (!empty($classroom->category_id)):?>
                  <?php $category = Engine_Api::_ ()->getDbtable('categories', 'eclassroom')->find($classroom->category_id)->current();?>
                  <?php endif;?>
                  <i class="fa fa-folder-open"></i>
                  <span><a href="<?php echo $classroom->getHref();?>"><?php echo $category->category_name;?></a></span>
                </div>
              <?php endif;?>
            </div>  
          </div>
        <?php endfor;?>
      </div>
    <?php } ?>
 </div>
</div> 
<?php if($this->enableSlideshow): ?>
  <style>
  .eclassroom_classrooms_slideshow .owl-prev,
	.eclassroom_classrooms_slideshow .owl-next {
    display:block !important;
  }
  </style>
<?php endif; ?>
<script type="text/javascript">
//Slideshow widget
coursesJqueryObject(document).ready(function() {
  var eclassroomElement = sesJqueryObject('.eclassroom_classrooms_slideshow_<?php echo $this->identity;?>');
	if(eclassroomElement.length > 0) {
    var eclassroomElements = coursesJqueryObject('.eclassroom_classrooms_slideshow_<?php echo $this->identity;?>');
    eclassroomElements.each(function(){
      coursesJqueryObject(this).owlCarousel({
        loop:true,
        items:1,
        margin:0,
        autoHeight:true,
        autoplay:<?php echo $this->params['autoplay'] ?>,
        autoplayTimeout:<?php echo $this->params['speed'] ?>,
        autoplayHoverPause:true
      });
      coursesJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
      coursesJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
    });
	}
});
</script>
<style type="text/css">
  <?php if($this->params['navigation'] == 2){ ?>
    .eclassroom_classrooms_slideshow_<?php echo $this->identity;?> .owl-dots{
      display:none;
    }
    .eclassroom_classrooms_slideshow_<?php echo $this->identity;?> .owl-nav > div{
      display:block !important;
    }
  <?php } else{ ?>
    .eclassroom_classrooms_slideshow_<?php echo $this->identity;?> .owl-dots{
      display:block !important;
    }
    .eclassroom_classrooms_slideshow_<?php echo $this->identity;?> .owl-nav > div{
      display:none !important;
    }
  <?php } ?>
	.sespage_classrooms_slideshow_<?php echo $this->identity;?> .owl-stage-outer{
		height:<?php echo $this->params['height'] ?>px !important;
	}
</style>
