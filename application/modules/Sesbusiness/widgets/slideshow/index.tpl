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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesbusiness/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesbusiness/externals/scripts/owl.carousel.js'); 
?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<div class="sesbusiness_list_slideshow_container sesbasic_bxs">
  <div class="sesbusiness_list_slideshow sesbusiness_list_slideshow_<?php echo $this->identity;?>">
    <?php foreach($this->paginator as $business):?>
      <?php if(strlen($business->getTitle()) > $this->params['title_truncation']):?>
        <?php $title = mb_substr($business->getTitle(),0,$this->params['title_truncation']).'...';?>
      <?php else: ?>
        <?php $title = $business->getTitle();?>
      <?php endif; ?>
      <?php $owner = $business->getOwner();?>
      <div class="sesbusiness_list_item item">
        <article class="sesbasic_clearfix">
          <div class="_thumb sesbusiness_thumb" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">
            <a href="<?php echo $business->getHref();?>" class="sesbusiness_thumb_img sesbusiness_browse_location_<?php echo $business->getIdentity(); ?>">
              <span style="background-image:url(<?php echo $business->getPhotoUrl('thumb.profile'); ?>);"></span>
            </a>
            <div class="sesbusiness_list_labels sesbasic_animation">
              <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataLabel.tpl';?>
            </div>
            <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
              <div class="_btns sesbasic_animation">
                <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataButtons.tpl';?>
              </div>
            <?php endif;?>
          </div>
          <div class="_cont">
            <?php if(isset($this->titleActive)):?>
              <div class="_title">
                <a href="<?php echo $business->getHref();?>" class='sesbusiness_browse_location_<?php echo $business->getIdentity(); ?>'><?php echo $title;?></a> <?php if(isset($this->verifiedLabelActive)&& $business->verified):?><i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
              </div>
            <?php endif;?>
            <div class="_continner">
              <div class="_continnerleft">
                <div class="_owner sesbasic_text_light
                  <?php if(SESBUSINESSSHOWUSERDETAIL == 1):?>
                    <?php if(isset($this->ownerPhotoActive)):?>
                      <span class="_owner_img">
                        <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
                      </span>
                    <?php endif;?>
                    <?php if(isset($this->byActive)):?>
                      <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
                    <?php endif;?>
                  <?php endif;?>
                  <?php if(isset($this->creationDateActive)):?>
                    -&nbsp;<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_date.tpl';?>
                  <?php endif;?>
                </div>
                 <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || isset($this->followActive) || isset($this->memberActive)):?>
                  <div class="_stats sesbasic_text_light">
                    <i class="fa fa-bar-chart"></i>
                    <span><?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataStatics.tpl';?></span>
                  </div>
                <?php endif;?>
                <?php if($business->location):?>
                  <div class="_stats sesbasic_text_light">
                    <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
                    <span title="<?php echo $business->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesbusiness.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $business->business_id,'resource_type'=>'businesses','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $business->location;?></a><?php else:?><?php echo $business->location;?><?php endif;?></span>
                  </div>
                <?php endif;?>
                <div class="sesbasic_clearfix _middleinfo">
                  <?php if(isset($category) && isset($this->categoryActive)):?>
                    <div><i class="fa fa-folder-open sesbasic_text_light"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></div>
                  <?php endif;?>
                  <!--<?php if(isset($this->priceActive) && $business->price):?>
                    <div class="sesbusiness_ht"><i class="fa fa-usd sesbasic_text_light"></i>&nbsp;<span><?php echo $business->price;?></span></div>
                  <?php endif;?>!-->
                </div>
                <?php if(isset($this->descriptionActive)):?>
                  <div class="_des">
                    <?php echo $this->string()->truncate($this->string()->stripTags($business->description), $this->params['description_truncation']) ?>
                  </div>
                <?php endif;?>
              </div>
              <?php if(isset($this->contactDetailActive) && (isset($business->business_contact_phone) || isset($business->business_contact_email) || isset($business->business_contact_website))):?>
                <div class="_continnerright">
                  <div class="sesbusiness_list_contact_btns sesbasic_clearfix">
                    <?php  if($business->business_contact_phone):?>
                      <div class="sesbasic_clearfix">
                        <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                          <a href="javascript:void(0);" class="sesbasic_link_btn" onclick="sessmoothboxDialoge('<?php echo $business->business_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("View Phone No")?></a>
                        <?php endif;?>
                      </div>
                    <?php  endif;?>
                    <?php if($business->business_contact_email):?>
                      <div class="sesbasic_clearfix">
                        <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                          <a href='mailto:<?php echo $business->business_contact_email ?>' class="sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                        <?php endif;?>
                      </div>
                    <?php endif;?>
                    <?php if($business->business_contact_website):?>
                      <div class="sesbasic_clearfix">
                        <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                          <a href="<?php echo parse_url($business->business_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $business->business_contact_website : $business->business_contact_website; ?>" target="_blank" class="sesbasic_link_btn"><?php echo $this->translate("Visit Website")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                        <?php endif;?>
                      </div>
                    <?php endif;?>
                  </div>
                </div>
              <?php endif;?> 
            </div>  
            <div class="_footer">
              <div class="_socialbtns">
                <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataSharing.tpl';?>
              </div>
            </div>
          </div>
        </article>
      </div>
    <?php endforeach;?>
  </div>
</div>
<script type="text/javascript">
  sesbusinessJqueryObject('.sesbusiness_list_slideshow_<?php echo $this->identity;?>').owlCarousel({
    nav : true,
    loop:true,
    items:1,
    //autoplay:<?php echo $this->params['autoplay'] ?>,
    //autoplayTimeout:<?php echo $this->params['speed'] ?>,
  })
  sesbusinessJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
  sesbusinessJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
</script>
