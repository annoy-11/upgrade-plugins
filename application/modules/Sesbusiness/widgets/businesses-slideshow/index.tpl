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

<?php $identity = $this->identity;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/styles.css'); ?>
<?php if($this->params['enableSlideshow']){ ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesbusiness/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesbusiness/externals/scripts/owl.carousel.js'); 
?>
 <?php } ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<div class="sesbusiness_businesses_slideshow_wrapper sesbasic_clearfix sesbasic_bxs">
  <div class="sesbusiness_businesses_slideshow_container sesbasic_clearfix sesbusiness_fg_color">

    <div class="_right_col <?php if(empty($this->params['leftBusiness'])) {?>_noleftblock<?php } ?>" <?php if(empty($this->params['enableSlideshow'])) { ?> style="display:none;" <?php } ?>>
      <div class="sesbusiness_businesses_slideshow sesbusiness_businesses_slideshow_<?php echo $this->identity;?>" style="height:<?php echo $this->params['height'] ?>px;">
        <?php $leftData = array();?>
        <?php foreach($this->businesses as $data):?>
          <?php if($data['type'] == 'left'):?>
             <?php $leftData[] = $data['business_id']; ?>
             <?php continue;?>
          <?php endif;?>
          <?php $business = Engine_Api::_()->getItem('businesses', $data['business_id']);?>
          <div class="sesbusiness_businesses_slideshow_item sesbasic_clearfix">
            <div class="_thumb sesbusiness_thumb" style="height:<?php echo $this->params['height'] ?>px;"> 
              <a href="<?php echo $business->getHref(); ?>" class="sesbusiness_thumb_img">
                <span style="background-image:url(<?php echo $business->getPhotoUrl('thumb.profile'); ?>);"></span>
              </a>
              <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabel)):?>
                <div class="sesbusiness_list_labels sesbasic_animation">
                  <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataLabel.tpl';?>
                </div>
              <?php endif;?>
              <div class="_btns sesbasic_animation"> 
                <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataButtons.tpl';?>
              </div>
            </div>
            <div class="sesbusiness_businesses_slideshow_cont_wrap">   
              <?php if(isset($this->titleActive)):?>
                <?php if(strlen($business->getTitle()) > $this->params['title_truncation']):?>
                  <?php $title = mb_substr($business->getTitle(),0,$this->params['title_truncation']).'...';?>
                <?php else: ?>
                  <?php $title = $business->getTitle();?>
                <?php endif; ?>
                <div class="_title">
                  <a href="<?php echo $business->getHref();?>"><?php echo $title;?></a><?php if(isset($this->verifiedLabelActive)&& $business->verified):?><i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
                </div>
              <?php endif;?>
              <div class="sesbusiness_businesses_slideshow_cont">
              	<div class="_left">  
                	<div class="_stats">
                    <?php if(SESBUSINESSSHOWUSERDETAIL == 1 && isset($this->byActive)):?>
                      <?php $owner = $business->getOwner();?>
                      <span>
                        <i class="fa fa-user"></i>	
                        <span><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
                      </span>
                    <?php endif;?>
                  </div>
                  <div class="_stats">
                    <span>
                    	<i class="fa fa-bar-chart"></i>	
                      <span><?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataStatics.tpl';?></span>
                  	</span>
                  </div>  
                  <div class="_stats">
                  	<?php if(isset($this->categoryActive)):?>
                      <?php if (!empty($business->category_id)):?>
                      <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sesbusiness')->find($business->category_id)->current();?>
                      <?php endif;?>
                      <span>
                        <i class="fa fa-folder-open"></i>
                        <span><a href="<?php echo $business->getHref();?>"><?php echo $category->category_name;?></a></span>
                      </span>
                  	<?php endif;?>
                    <?php if(isset($this->locationActive) && $business->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness_enable_location', 1)):?>
                      <span class="_location">
                        <i class="fa fa-map-marker" title="<?php echo $this->translate('Location');?>"></i>
                        <span title="<?php echo $business->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesbusiness.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $business->business_id,'resource_type'=>'businesses','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $business->location;?></a><?php else:?><?php echo $business->location;?><?php endif;?></span>
                      </span>
                    <?php endif;?>
                  </div>
                  <?php if(isset($this->descriptionActive)):?>
                    <div class="_des">
                      <p><?php echo $this->string()->truncate($this->string()->stripTags($business->description), $this->params['description_truncation']) ?></p>
                    </div>
                  <?php endif;?>
                  <?php if(isset($this->contactDetailActive) && (isset($business->business_contact_phone) || isset($business->business_contact_email) || isset($business->business_contact_website))):?>
                    <div class="_contactlinks sesbasic_clearfix sesbasic_animation">
                      <?php if($business->business_contact_phone):?>
                        <span>
                          <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                            <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $business->business_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                          <?php else:?>
                            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
                          <?php endif;?>
                        </span>
                      <?php endif;?>
                      <?php if($business->business_contact_email):?>
                        <span>
                          <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                            <a href='mailto:<?php echo $business->business_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
                          <?php else:?>
                            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
                          <?php endif;?>
                        </span>
                      <?php endif;?>
                      <?php if($business->business_contact_website):?>
                        <span>
                          <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                            <a href="<?php echo parse_url($business->business_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $business->business_contact_website : $business->business_contact_website; ?>" target="_blank" ><?php echo $this->translate("Visit Website")?></a>
                          <?php else:?>
                            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
                          <?php endif;?>
                        </span>
                      <?php endif;?>
                    </div>
                  <?php endif;?>
                </div>
                <div class="_buttons">
                	<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataSharing.tpl';?>
              	</div>
              </div>
            </div>
          </div>	
        <?php endforeach;?>
      </div>
    </div>
    <?php if($this->params['leftBusiness']) { 
      $height = ($this->params['height'] -20) / 3;
    ?>
      <div class="_left_col <?php if(empty($this->params['enableSlideshow'])) {?>_norightblock<?php } ?>">
        <?php for($i=0;$i<count($leftData);$i++):?>
          <?php $business = Engine_Api::_()->getItem('businesses', $leftData[$i]);?>
          <div class="sesbusiness_businesses_slideshow_left_item">
            <div class="_thumb" style="height:<?php echo $height ?>px;">
              <a href="<?php echo $business->getHref(); ?>" class="_thumbimg">
                <span style="background-image:url(<?php echo $business->getPhotoUrl('thumb.profile'); ?>);"></span>
              </a>
            </div>
            <div class="_cont">    
              <?php if(isset($this->titleActive)):?>
                <div class="_title">
                  <a href="<?php echo $business->getHref();?>"><?php echo $business->getTitle();?></a><?php if(isset($this->verifiedLabelActive)&& $business->verified):?><i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
                </div>
              <?php endif;?>
              <?php if(isset($this->categoryActive)):?>
                <div class="_stats sesbasic_clearfix">
                  <?php if (!empty($business->category_id)):?>
                  <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sesbusiness')->find($business->category_id)->current();?>
                  <?php endif;?>
                  <i class="fa fa-folder-open"></i>
                  <span><a href="<?php echo $business->getHref();?>"><?php echo $category->category_name;?></a></span>
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
  .sesbusiness_businesses_slideshow .owl-prev,
	.sesbusiness_businesses_slideshow .owl-next {
    display:block !important;
  }
  </style>
<?php endif; ?>
<script type="text/javascript">
//Slideshow widget
sesbusinessJqueryObject(document).ready(function() {
  var sesbusinessElement = sesJqueryObject('.sesbusiness_businesses_slideshow_<?php echo $this->identity;?>');
	if(sesbusinessElement.length > 0) {
    var sesbusinessElements = sesbusinessJqueryObject('.sesbusiness_businesses_slideshow_<?php echo $this->identity;?>');
    sesbusinessElements.each(function(){
      sesbusinessJqueryObject(this).owlCarousel({
        loop:true,
        items:1,
        margin:0,
        autoHeight:true,
        autoplay:<?php echo $this->params['autoplay'] ?>,
        autoplayTimeout:<?php echo $this->params['speed'] ?>,
        autoplayHoverPause:true
      });
      sesbusinessJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
      sesbusinessJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
    });
	}
});
</script>
<style type="text/css">
  <?php if($this->params['navigation'] == 2){?>
    .sesbusiness_businesses_slideshow_<?php echo $this->identity;?> .owl-dots{
      display:none;
    }
    .sesbusiness_businesses_slideshow_<?php echo $this->identity;?> .owl-nav > div{
      display:block !important;
    }
  <?php } else{ ?>
    .sesbusiness_businesses_slideshow_<?php echo $this->identity;?> .owl-nav{
       display:none;
    }
  <?php } ?>
	.sespage_businesses_slideshow_<?php echo $this->identity;?> .owl-stage-outer{
		height:<?php echo $this->params['height'] ?>px !important;
	}
</style>
