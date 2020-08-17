<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php  $baseURL = Zend_Registry::get('StaticBaseUrl');?>
<?php 
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');
  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/scripts/slick/slick.js');
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/styles.css');
?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<div class="sesbusiness_welcome_block_container">
<div class="sesbusiness_business_carousel_wrapper sesbasic_clearfix sesbasic_bxs <?php if($this->params['viewType'] == 'horizontal'): ?>sesbusiness_carousel_h_wrapper<?php else: ?>sesbusiness_carousel_v_wrapper <?php endif; ?>" style="min-height:<?php echo $this->params['imageheight'] ?>px;">
  <div id="businesseslide_<?php echo $this->identity; ?>" class="sesbasic_clearfix sesbusiness_business_carousel_<?php echo $this->identity; ?> slider">
    <?php foreach( $this->paginator as $business): ?>
    	<div class="sesbusiness_grid_item sesbasic_clearfix <?php if(isset($this->contactButtonActive) || isset($this->socialSharingActive)):?> _isbtns<?php endif;?>" style="width:<?php echo is_numeric($this->params['width']) ? $this->params['width'].'px':$this->params['width'];?>;">
        <article>
          <div class="_thumb sesbusiness_thumb" style="height:<?php echo $this->params['imageheight'] ?>px;">
            <a href="<?php echo $business->getHref(); ?>" class="sesbusiness_thumb_img">
              <span class="sesbasic_animation" style="background-image:url(<?php echo $business->getPhotoUrl('thumb.profile'); ?>);"></span>
            </a>
            <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabelActive) || isset($this->verifiedLabelActive)){ ?>
              <div class="sesbusiness_list_labels sesbasic_animation">
                <?php if(isset($this->featuredLabelActive) && $business->featured){ ?>
                  <span class="sesbusiness_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
                <?php } ?>
                <?php if(isset($this->sponsoredLabelActive) && $business->sponsored){ ?>
                  <span class="sesbusiness_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
                <?php } ?>
                <?php if(isset($this->hotLabelActive) && $business->hot){ ?>
                  <span class="sesbusiness_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
                <?php } ?>
              </div>
            <?php } ?>
            <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
              <div class="_btns sesbasic_animation">
                <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataButtons.tpl';?>
              </div>
            <?php endif;?>
            <?php if(isset($this->titleActive) ){ ?>
              <div class="_thumbinfo">
                <div>
                  <div class="_title">
                    <?php if(strlen($business->getTitle()) > $this->params['title_truncation']){ 
                      $title = mb_substr($business->getTitle(),0,($this->params['title_truncation'])).'...';
                      echo $this->htmlLink($business->getHref(),$title, array() ) ?>
                      <?php if(isset($this->verifiedLabelActive) && $business->verified):?>
                        <i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
                      <?php endif;?>
                    <?php }else{ ?>
                      <?php echo $this->htmlLink($business->getHref(),$business->getTitle(), array() ) ?>
                      <?php if(isset($this->verifiedLabelActive) && $business->verified):?>
                        <i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
                      <?php endif;?>
                    <?php } ?>
                  </div>
                </div>  
              </div>
            <?php } ?>
          </div>
					<div class="_cont sesbasic_clearfix">
            <?php $owner = $business->getOwner(); ?>
           	<?php if(SESBUSINESSSHOWUSERDETAIL == 1 && isset($this->byActive)){ ?>
              <div class="_owner sesbasic_text_light">
                <?php if(isset($this->byActive)):?>
                  <span class="_owner_img">
                    <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
                  </span>
                  <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?></span>
                <?php endif;?>
                -&nbsp;<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_date.tpl';?>
              </div>
           	<?php } ?>
            <?php if(isset($this->categoryActive)){ ?>
              <div class="_stats sesbasic_text_light">
              	<?php if($business->category_id != '' && intval($business->category_id) && !is_null($business->category_id)){ 
                    $categoryItem = Engine_Api::_()->getItem('sesbusiness_category', $business->category_id);?>
                    <?php if($categoryItem):?>
                	<i class="fa fa-folder-open"></i> <span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></span>
                    <?php endif;?>
                <?php } ?>
              </div>
            <?php } ?>
            <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($business->follow_count)) || (isset($this->memberActive) && isset($business->member_count))):?>
            <div class="_stats sesbasic_text_light">
            	<i class="fa fa-bar-chart"></i>
              <span><?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataStatics.tpl';?></span>
            </div>
            <?php endif;?>
            <?php if(isset($this->locationActive) && $business->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness_enable_location', 1)):?>				<div class="_stats sesbasic_text_light _location">
              	<i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
                <span title="<?php echo $business->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesbusiness.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $business->business_id,'resource_type'=>'businesses','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $business->location;?></a><?php else:?><?php echo $business->location;?><?php endif;?></span>
              </div>
            <?php endif;?>
            <?php if(isset($this->descriptionActive)):?>
            	<div class="_des"><?php echo $this->string()->truncate($this->string()->stripTags($business->description), $this->params['description_truncation']) ?></div>
            <?php endif;?>
					</div>
          <?php if(isset($this->socialSharingActive)) {
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $business->getHref()); ?>
            <div class="_sharebuttons sesbasic_clearfix">
              <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataSharing.tpl';?>
            </div>
          <?php } ?>
        </article>
      </div>
    <?php endforeach; ?>
  </div>
	<div class="sesbasic_loading_cont_overlay" style="display:block;"></div>
</div>
</div>
<style type="text/css">
.sesbusiness_business_carousel_<?php echo $this->identity; ?>{display:none;}
.sesbusiness_business_carousel_<?php echo $this->identity; ?>.slick-initialized{display:block;}
.sesbusiness_business_carousel_<?php echo $this->identity; ?>.slick-initialized + .sesbasic_loading_cont_overlay{display:none !important;}
</style>
<script type="text/javascript">
	<?php if($this->params['viewType'] == 'horizontal'): ?>
	sesBasicAutoScroll(document).on('ready', function() {
		sesBasicAutoScroll(".sesbusiness_business_carousel_<?php echo $this->identity; ?>").slick({
			infinite: true,
			dots: false,
			slidesToShow: 1,
			variableWidth: true,
			slidesToScroll: 1,
			dots:false,
			centerMode: true,
	})});
<?php else: ?>
	sesBasicAutoScroll(document).on('ready', function() {
		sesBasicAutoScroll(".sesbusiness_business_carousel_<?php echo $this->identity; ?>").slick({
			infinite: true,
			dots: false,
			slidesToShow: 1,
			slidesToScroll: 1,
			dots:false,
	})});
<?php endif; ?>
</script>
