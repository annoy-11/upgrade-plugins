<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>

<?php $identity = $this->identity;?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>
<?php if($this->params['enableSlideshow']){ ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sespage/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sespage/externals/scripts/owl.carousel.js'); 
?>
 <?php } ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<div class="sespage_pages_slideshow_wrapper sesbasic_clearfix sesbasic_bxs">
  <div class="sespage_pages_slideshow_container sesbasic_clearfix sespage_fg_color">

    <div class="_right_col <?php if(empty($this->params['leftPage'])) {?>_noleftblock<?php } ?>" <?php if(empty($this->params['enableSlideshow'])) { ?> style="display:none;" <?php } ?>>
      <div class="sespage_pages_slideshow sespage_pages_slideshow_<?php echo $this->identity;?>" style="height:<?php echo $this->params['height'] ?>px;">
        <?php $leftData = array();?>
        <?php foreach($this->pages as $data):?>
          <?php if($data['type'] == 'left'):?>
             <?php $leftData[] = $data['page_id']; ?>
             <?php continue;?>
          <?php endif;?>
          <?php $page = Engine_Api::_()->getItem('sespage_page', $data['page_id']);?>
          <div class="sespage_pages_slideshow_item sesbasic_clearfix">
            <div class="_thumb sespage_thumb" style="height:<?php echo $this->params['height'] ?>px;"> 
              <a href="<?php echo $page->getHref(); ?>" class="sespage_thumb_img">
                <span style="background-image:url(<?php echo $page->getPhotoUrl('thumb.profile'); ?>);"></span>
              </a>
              <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabel)):?>
                <div class="sespage_list_labels sesbasic_animation">
                  <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataLabel.tpl';?>
                </div>
              <?php endif;?>
              <div class="_btns sesbasic_animation"> 
                <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataButtons.tpl';?>
              </div>
            </div>
            <div class="sespage_pages_slideshow_cont_wrap">   
              <?php if(isset($this->titleActive)):?>
                <?php if(strlen($page->getTitle()) > $this->params['title_truncation']):?>
                  <?php $title = mb_substr($page->getTitle(),0,$this->params['title_truncation']).'...';?>
                <?php else: ?>
                  <?php $title = $page->getTitle();?>
                <?php endif; ?>
                <div class="_title">
                  <a href="<?php echo $page->getHref();?>"><?php echo $title;?></a><?php if(isset($this->verifiedLabelActive)&& $page->verified):?><i class="sespage_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
                </div>
              <?php endif;?>
              <div class="sespage_pages_slideshow_cont">
              	<div class="_left">
                	<div class="_stats">
                    <?php if(SESPAGESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
                      <?php $owner = $page->getOwner();?>
                      <span>
                      	<i class="fa fa-user"></i>	
                      	<span><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
                      </span>
                    <?php endif;?>
                  </div>  
                  <div class="_stats">
                    <span>
                      <i class="fa fa-bar-chart"></i>	
                      <span><?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataStatics.tpl';?></span>
                  	</span>
                  </div>  
                	<div class="_stats">
                  	<?php if(isset($this->categoryActive)):?>
                      <?php if (!empty($page->category_id)):?>
                      <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sespage')->find($page->category_id)->current();?>
                      <?php endif;?>
                      <span>
                        <i class="fa fa-folder-open"></i>
                        <span><a href="<?php echo $page->getHref();?>"><?php echo $category->category_name;?></a></span>
                      </span>
                    <?php endif;?>
                    <?php if(isset($this->locationActive) && $page->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage_enable_location', 1)):?>
                      <span class="_location">
                        <i class="fa fa-map-marker" title="<?php echo $this->translate('Location');?>"></i>
                        <span title="<?php echo $page->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sespage.enable.map.integration', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)):?><a href="<?php echo $this->url(array('resource_id' => $page->page_id,'resource_type'=>'sespage_page','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $page->location;?></a><?php else:?><?php echo $page->location;?><?php endif;?></span>
                      </span>
                    <?php endif;?>
                  </div>
                  <?php if(isset($this->descriptionActive)):?>
                    <div class="_des">
                      <p><?php echo $this->string()->truncate($this->string()->stripTags($page->description), $this->params['description_truncation']) ?></p>
                    </div>
                  <?php endif;?>

                  <?php if(isset($this->contactDetailActive) && (isset($page->page_contact_phone) || isset($page->page_contact_email) || isset($page->page_contact_website))):?>
                    <div class="_contactlinks sesbasic_clearfix sesbasic_animation">
                      <?php if($page->page_contact_phone):?>
                        <span>
                          <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                            <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $page->page_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                          <?php else:?>
                            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
                          <?php endif;?>
                        </span>
                      <?php endif;?>
                      <?php if($page->page_contact_email):?>
                        <span>
                          <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                            <a href='mailto:<?php echo $page->page_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
                          <?php else:?>
                            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
                          <?php endif;?>
                        </span>
                      <?php endif;?>
                      <?php if($page->page_contact_website):?>
                        <span>
                          <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                            <a href="<?php echo parse_url($page->page_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $page->page_contact_website : $page->page_contact_website; ?>" target="_blank" ><?php echo $this->translate("Visit Website")?></a>
                          <?php else:?>
                            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
                          <?php endif;?>
                        </span>
                      <?php endif;?>
                    </div>
                  <?php endif;?>
                </div>
                <div class="_buttons">
                	<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataSharing.tpl';?>
              	</div>
              </div>
            </div>
          </div>	
        <?php endforeach;?>
      </div>
    </div>
    <?php if($this->params['leftPage']) { 
      $height = ($this->params['height'] -20) / 3;
    ?>
      <div class="_left_col <?php if(empty($this->params['enableSlideshow'])) {?>_norightblock<?php } ?>">
        <?php for($i=0;$i<count($leftData);$i++):?>
          <?php $page = Engine_Api::_()->getItem('sespage_page', $leftData[$i]);?>
          <div class="sespage_pages_slideshow_left_item">
            <div class="_thumb" style="height:<?php echo $height ?>px;">
              <a href="<?php echo $page->getHref(); ?>" class="_thumbimg">
                <span style="background-image:url(<?php echo $page->getPhotoUrl('thumb.profile'); ?>);"></span>
              </a>
            </div>
            <div class="_cont">    
              <?php if(isset($this->titleActive)):?>
                <div class="_title">
                  <a href="<?php echo $page->getHref();?>"><?php echo $page->getTitle();?></a><?php if(isset($this->verifiedLabelActive)&& $page->verified):?><i class="sespage_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
                </div>
              <?php endif;?>
              <?php if(isset($this->categoryActive)):?>
                <div class="_stats sesbasic_clearfix">
                  <?php if (!empty($page->category_id)):?>
                  <?php $category = Engine_Api::_ ()->getDbtable('categories', 'sespage')->find($page->category_id)->current();?>
                  <?php endif;?>
                  <i class="fa fa-folder-open"></i>
                  <span><a href="<?php echo $page->getHref();?>"><?php echo $category->category_name;?></a></span>
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
  .sespage_pages_slideshow .owl-prev,
	.sespage_pages_slideshow .owl-next {
    display:block !important;
  }
  </style>
<?php endif; ?>
<script type="text/javascript">
//Slideshow widget
sespageJqueryObject(document).ready(function() {
  var sespageElement = sesJqueryObject('.sespage_pages_slideshow_<?php echo $this->identity;?>');
	if(sespageElement.length > 0) {
    var sespageElements = sespageJqueryObject('.sespage_pages_slideshow_<?php echo $this->identity;?>');
    sespageElements.each(function(){
      sespageJqueryObject(this).owlCarousel({
        loop:true,
        items:1,
        margin:0,
        autoHeight:true,
        autoplay:<?php echo $this->params['autoplay'] ?>,
        autoplayTimeout:<?php echo $this->params['speed'] ?>,
        autoplayHoverPause:true
      });
      sespageJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
      sespageJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
    });
	}
});
</script>
<style type="text/css">
  <?php if($this->params['navigation'] == 2){?>
    .sespage_pages_slideshow_<?php echo $this->identity;?> .owl-dots{
      display:none;
    }
    .sespage_pages_slideshow_<?php echo $this->identity;?> .owl-nav > div{
      display:block !important;
    }
  <?php } else{ ?>
    .sespage_pages_slideshow_<?php echo $this->identity;?> .owl-nav{
       display:none;
    }
  <?php } ?>
	.sespage_pages_slideshow_<?php echo $this->identity;?> .owl-stage-outer{
		height:<?php echo $this->params['height'] ?>px !important;
	}
</style>
