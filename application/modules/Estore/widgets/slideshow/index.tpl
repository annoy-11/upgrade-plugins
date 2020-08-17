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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Estore/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Estore/externals/scripts/owl.carousel.js'); 
?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<div class="estore_list_slideshow_container sesbasic_bxs">
  <div class="estore_list_slideshow estore_list_slideshow_<?php echo $this->identity;?>">
    <?php foreach($this->paginator as $store):?>
      <?php if(strlen($store->getTitle()) > $this->params['title_truncation']):?>
        <?php $title = mb_substr($store->getTitle(),0,$this->params['title_truncation']).'...';?>
      <?php else: ?>
        <?php $title = $store->getTitle();?>
      <?php endif; ?>
      <?php $owner = $store->getOwner();?>
      <div class="estore_list_item item">
        <article class="sesbasic_clearfix">
          <div class="estore_list_newlabel">
            <?php
						$dayIncludeTime = strtotime(date("Y-m-d H:i:s", strtotime('+'.(Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer(), 'stores', 'newBsduration')*24).' hours', strtotime($store->creation_date))));
						$currentTime = strtotime(date("Y-m-d H:i:s"));
						//echo '<pre>';print_r($this->newLabelActive);die;
						if($dayIncludeTime > $currentTime && Engine_Api::_()->getApi('settings', 'core')->getSetting('store.new', 1))
						include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_newLabel.tpl';?>
          </div>
          <div class="_thumb estore_thumb" style="height:<?php echo $this->params['height'] ?>px;">
            <a href="<?php echo $store->getHref();?>" class="estore_thumb_img estore_browse_location_<?php echo $store->getIdentity(); ?>">
              <span style="background-image:url(<?php echo $store->getPhotoUrl('thumb.profile'); ?>);"></span>
            </a>
            <div class="estore_list_labels sesbasic_animation">
              <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabel.tpl';?>
            </div>
            <div class="_btns sesbasic_animation">
              <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
            </div>
            <div class="_thumbinfo">
              <div>
            <?php if(isset($this->contactDetailActive) && (isset($store->store_contact_phone) || isset($store->store_contact_email) || isset($store->store_contact_website))): ?>
                <div class="estore_list_contact_btns sesbasic_clearfix">
                  <?php  if($store->store_contact_phone):?>
                    <div class="sesbasic_clearfix">
                      <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                        <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $store->store_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                      <?php else:?>
                        <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox estore_link_btn"><?php echo $this->translate("View Phone No")?></a>
                      <?php endif;?>
                    </div>
                  <?php  endif;?>
                  <?php if($store->store_contact_email):?>
                    <div class="sesbasic_clearfix">
                      <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                        <a href='mailto:<?php echo $store->store_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
                      <?php else:?>
                        <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox estore_link_btn"><?php echo $this->translate("Send Email")?></a>
                      <?php endif;?>
                    </div>
                  <?php endif;?>
                  <?php if($store->store_contact_website):?>
                    <div class="sesbasic_clearfix">
                      <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                        <a href="<?php echo parse_url($store->store_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $store->store_contact_website : $store->store_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
                      <?php else:?>
                        <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox estore_link_btn"><?php echo $this->translate("Send Email")?></a>
                      <?php endif;?>
                    </div>
                  <?php endif;?>
                </div>
              <?php endif;?> 
              </div>
              <div class="estore_profile_isrounded"> <a href="<?php echo $store->getHref();?>" class="estore_thumb_img"><span class="bg_item_photo" style="background-image:url(<?php echo $store->getPhotoUrl('thumb.icon'); ?>);"></span></a></div>
                <div class="_title"> <a href="<?php echo $store->getHref();?>"><?php echo $title; ?><?php if(isset($this->verifiedLabelActive) && $store->verified):?>
          <i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
          <?php endif;?></a>
                  <div class="_date">
                    <?php if(ESTORESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
                    <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
                    <?php endif;?>
                    <?php if(isset($this->creationDateActive)):?>
                    -&nbsp;
                    <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
                    <?php endif; ?>
                  </div>
                </div>
            </div>
          </div>
          <div class="_cont">
            <div class="_continner">
             <?php if(isset($this->ratingActive)): $item = $store; ?>
                <div class="estore_sgrid_rating">
                    <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_rating.tpl';?>
                </div>
            <?php unset($item); endif;?>
            <?php if (!empty($store->category_id)): ?>
                <?php $category = Engine_Api::_ ()->getDbtable('categories', 'estore')->find($store->category_id)->current();?>
            <?php endif;?> 
            <?php if(isset($category) && isset($this->categoryActive)):?>
                <div class="_stats _category sesbasic_text_light sesbasic_clearfix">
                    <div><i class="far fa-folder-open"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></div>
                </div>
            <?php endif;?>
            <?php if(!empty($store->location) && isset($this->locationActive)):?>
              <div class="_stats sesbasic_text_light _location">
                <i class="fa fa-map-marker-alt sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
                <span title="<?php echo $store->location;?>"><?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1) && Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a><?php else:?><?php echo $store->location;?><?php endif;?></span>
              </div>
            <?php endif;?>
            <?php if(isset($this->descriptionActive)):?>
              <div class="_des">
                <?php echo $this->string()->truncate($this->string()->stripTags($store->description), $this->params['description_truncation']) ?>
              </div>
            <?php endif;?>
             <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || isset($this->followActive) || isset($this->memberActive)):?>
              <div class="_stats estore_slideshow_data_stats sesbasic_text_light">
                <span><?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataStatics.tpl';?></span>
              </div>
            <?php endif;?>
          </div>
        </div>
        </article>
      </div>
    <?php endforeach;?>
  </div>
</div>
<script type="text/javascript">
  estoreJqueryObject('.estore_list_slideshow_<?php echo $this->identity;?>').owlCarousel({
    nav : true,
    loop:true,
    items:3,
		responsive:{
			0:{
					items:1
			},
			600:{
					items:2
			},
			1000:{
					items:3,
			}
		}
    //autoplay:<?php echo $this->params['autoplay'] ?>,
    //autoplayTimeout:<?php echo $this->params['speed'] ?>,
  })
  estoreJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
  estoreJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
</script>
