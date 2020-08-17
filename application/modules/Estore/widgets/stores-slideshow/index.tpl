<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php 

 $identity = $this->identity;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/styles.css'); ?>
<?php if($this->params['enableSlideshow']){ ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Estore/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Estore/externals/scripts/owl.carousel.js'); 
?>
<?php } ?>
<?php $descriptionLimit = 0;?>
<?php if(isset($this->descriptionActive)):?>
<?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>

<div class="estore_stores_slideshow_wrapper sesbasic_clearfix sesbasic_bxs">
  <div class="estore_stores_slideshow_container sesbasic_clearfix estore_fg_color">
    <div class="_right_col <?php if(empty($this->params['leftStore'])) {?>_noleftblock<?php } ?>" <?php if(empty($this->params['enableSlideshow'])) { ?> style="display:none;" <?php } ?>>
      <div class="estore_stores_slideshow estore_stores_slideshow_<?php echo $this->identity;?>" style="height:<?php echo $this->params['height'] ?>px;">
        <?php $leftData = array();?>
        <?php foreach($this->stores as $data):?>
        <?php if($data['type'] == 'left'):?>
        <?php $leftData[] = $data['store_id']; ?>
        <?php continue;?>
        <?php endif;?>
        <?php $store = Engine_Api::_()->getItem('stores', $data['store_id']);?>
        <div class="estore_stores_slideshow_item sesbasic_clearfix">
          <div class="_thumb estore_thumb" style="height:<?php echo $this->params['height'] ?>px;"> <a href="<?php echo $store->getHref(); ?>" class="estore_thumb_img"> <span style="background-image:url(<?php echo $store->getPhotoUrl() ?>);"></span> </a>
            <div class="estore_list_labels sesbasic_animation">
              <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabel.tpl';?>
            </div>
            <div class="_btns sesbasic_animation">
              <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
            </div>
            <?php
	 
		$dayIncludeTime = strtotime(date("Y-m-d H:i:s", strtotime('+'.(Engine_Api::_()->authorization()->getPermission((Engine_Api::_()->user()->getViewer()->getIdentity() ? Engine_Api::_()->user()->getViewer() : 0), 'stores', 'newBsduration')*24).' hours', strtotime($store->creation_date))));
		$currentTime = strtotime(date("Y-m-d H:i:s"));

	 if(isset($this->newlabelActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('store.new', 1) && $dayIncludeTime > $currentTime):?>
		<div class="estore_list_newlabel">
    	<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_newLabel.tpl';?>
		</div>
   <?php endif;?>
          </div>
          <div class="estore_stores_slideshow_cont_wrap">
            <?php if(isset($this->titleActive)):?>
            <?php if(strlen($store->getTitle()) > $this->params['title_truncation']):?>
            <?php $title = mb_substr($store->getTitle(),0,$this->params['title_truncation']).'...';?>
            <?php else: ?>
            <?php $title = $store->getTitle();?>
            <?php endif; ?>
            <div class="_title"> <a href="<?php echo $store->getHref();?>"><?php echo $title;?></a>
              <?php  if(isset($this->verifiedLabelActive)&& $store->verified):?>
              <i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
              <?php  endif;?>
            </div>
            <?php endif;?>
            <div class="estore_stores_slideshow_cont">
              <?php if(isset($this->ratingActive)): ?>
                <div class="estore_slideshow_rating sesbasic_clearfix sesbasic_bxs">
                  <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_rating.tpl';?>
                </div>
              <?php endif;?>
              <div class="_stats sesbasic_text_light sesbasic_clearfix sesbasic_bxs">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataStatics.tpl';?>
              </div>
              <div class="estore_slide_seller_info sesbasic_clearfix sesbasic_bxs">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/seller_info.tpl';?>
              </div>
              <div class="_stats sesbasic_text_light">
                <?php if(ESTORESHOWUSERDETAIL == 1 && isset($this->byActive)): ?>
                <span class="_owner_name"><i class="far fa-user"></i><?php echo $this->translate('By');?>&nbsp;<?php echo $this->htmlLink($store->getOwner()->getHref(), $store->getOwner()->getTitle());?></span>
                <?php endif;?>
                <?php if(isset($this->creationDateActive)):?>
                -&nbsp;
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
                <?php endif;?>
                <?php if (!empty($store->category_id)): ?>
                <?php $category = Engine_Api::_ ()->getDbtable('categories', 'estore')->find($store->category_id)->current();?>
                <?php endif;?>
                <?php if(isset($category) && isset($this->categoryActive)):?>
                -&nbsp; <span class="sesbasic_text_light"> <span><i class="far fa-folder-open"></i><span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span> </span> </span>
                <?php endif;?>
              </div>
              <?php  if(isset($this->locationActive) && $store->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.location', 1)):?>
              <span class="_stats sesbasic_text_light _location"> <i class="fa fa-map-marker-alt sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i> <span title="<?php echo $store->location;?>">
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1) && Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1)):?>
              <a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a>
              <?php else:?>
              <?php echo $store->location;?>
              <?php  endif;?>
              </span> </span>
              <?php endif;?>
              <?php if($descriptionLimit):?>
              <div class="_des sesbasic_clearfix"> <?php echo $this->string()->truncate($this->string()->stripTags($store->description), $descriptionLimit) ?></div>
              <?php endif;?>
            </div>
          </div>
        </div>
        <?php endforeach;?>
      </div>
    </div>
    <?php if($this->params['leftStore']) {  
      $height = ($this->params['height'] -20) / 3; 
    ?>
    <div class="_left_col <?php if(empty($this->params['enableSlideshow'])) {?>_norightblock<?php } ?>">
      <?php for($i=0;$i<count($leftData);$i++):?>
      <?php $store = Engine_Api::_()->getItem('stores', $leftData[$i]);?>
      <div class="estore_stores_slideshow_left_item">
        <div class="_thumb" style="height:<?php echo $height ?>px;"> <a href="<?php echo $store->getHref(); ?>" class="_thumbimg"> <span style="background-image:url(<?php echo $store->getPhotoUrl('thumb.profile'); ?>);"></span> </a> </div>
        <div class="_cont">
          <?php if(isset($this->titleActive)):?>
          <div class="_title"> <a href="<?php echo $store->getHref();?>"><?php echo $store->getTitle();?></a>
            <?php if(isset($this->verifiedLabelActive) && $store->verified):?>
            <i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
            <?php endif;?>
          </div>
          <?php endif;?>
          <?php if(isset($this->categoryActive)):?>
          <div class="_stats sesbasic_clearfix">
            <?php if (!empty($store->category_id)):?>
            <?php $category = Engine_Api::_ ()->getDbtable('categories', 'estore')->find($store->category_id)->current();?>
            <?php endif;?>
            <i class="fa fa-folder-open"></i> <span><a href="<?php echo $store->getHref();?>"><?php echo $category->category_name;?></a></span> </div>
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
  .estore_stores_slideshow .owl-prev,
	.estore_stores_slideshow .owl-next {
    display:block !important;
  }
  </style>
<?php endif; ?>
<script type="text/javascript">
//Slideshow widget
estoreJqueryObject(document).ready(function() {
  var estoreElement = sesJqueryObject('.estore_stores_slideshow_<?php echo $this->identity;?>');
	if(estoreElement.length > 0) {
    var estoreElements = estoreJqueryObject('.estore_stores_slideshow_<?php echo $this->identity;?>');
    estoreElements.each(function(){
      estoreJqueryObject(this).owlCarousel({
        loop:true,
        items:1,
        margin:0,
        autoHeight:true,
        autoplay:<?php echo $this->params['autoplay'] ?>,
        autoplayTimeout:<?php echo $this->params['speed'] ?>,
        autoplayHoverPause:true
      });
      estoreJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
      estoreJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
    });
	}
});
</script>
<style type="text/css">
  <?php if($this->params['navigation'] == 2){ ?>
    .estore_stores_slideshow_<?php echo $this->identity;?> .owl-dots{
      display:none;
    }
    .estore_stores_slideshow_<?php echo $this->identity;?> .owl-nav > div{
      display:block !important;
    }
  <?php } else{ ?>
    .estore_stores_slideshow_<?php echo $this->identity;?> .owl-dots{
      display:block !important;
    }
    .estore_stores_slideshow_<?php echo $this->identity;?> .owl-nav > div{
      display:none !important;
    }
  <?php } ?>
	.sespage_stores_slideshow_<?php echo $this->identity;?> .owl-stage-outer{
		height:<?php echo $this->params['height'] ?>px !important;
	}
</style>
