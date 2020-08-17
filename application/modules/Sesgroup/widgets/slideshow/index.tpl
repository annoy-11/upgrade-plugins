<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/styles/styles.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesgroup/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesgroup/externals/scripts/owl.carousel.js'); 
?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<div class="sesgroup_list_slideshow_container sesbasic_bxs">
  <div class="sesgroup_list_slideshow sesgroup_list_slideshow_<?php echo $this->identity;?>">
    <?php foreach($this->paginator as $group):?>
      <?php if(strlen($group->getTitle()) > $this->params['title_truncation']):?>
        <?php $title = mb_substr($group->getTitle(),0,$this->params['title_truncation']).'...';?>
      <?php else: ?>
        <?php $title = $group->getTitle();?>
      <?php endif; ?>
      <?php $owner = $group->getOwner();?>
      <div class="sesgroup_list_item item">
        <article class="sesbasic_clearfix">
          <div class="_thumb sesgroup_thumb" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">
            <a href="<?php echo $group->getHref();?>" class="sesgroup_thumb_img sesgroup_browse_location_<?php echo $group->getIdentity(); ?>">
              <span style="background-image:url(<?php echo $group->getPhotoUrl('thumb.profile'); ?>);"></span>
            </a>
            <div class="sesgroup_list_labels sesbasic_animation">
              <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataLabel.tpl';?>
            </div>
            <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
              <div class="_btns sesbasic_animation">
                <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataButtons.tpl';?>
              </div>
            <?php endif;?>
          </div>
          <div class="_cont">
            <?php if(isset($this->titleActive)):?>
              <div class="_title">
                <a href="<?php echo $group->getHref();?>" class='sesgroup_browse_location_<?php echo $group->getIdentity(); ?>'><?php echo $title;?></a> <?php if(isset($this->verifiedLabelActive)&& $group->verified):?><i class="sesgroup_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
              </div>
            <?php endif;?>
            <div class="_continner">
              <div class="_continnerleft">
                <div class="_owner sesbasic_text_light
                  <?php if(SESGROUPSHOWUSERDETAIL == 1):?>
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
                    -&nbsp;<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_date.tpl';?>
                  <?php endif;?>
                </div>
                 <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || isset($this->followActive) || isset($this->memberActive)):?>
                  <div class="_stats sesbasic_text_light">
                    <i class="fa fa-bar-chart"></i>
                    <span><?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataStatics.tpl';?></span>
                  </div>
                <?php endif;?>
                <?php if($group->location):?>
                  <div class="_stats sesbasic_text_light">
                    <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
                    <span title="<?php echo $group->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesgroup.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $group->group_id,'resource_type'=>'sesgroup_group','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $group->location;?></a><?php else:?><?php echo $group->location;?><?php endif;?></span>
                  </div>
                <?php endif;?>
                <div class="sesbasic_clearfix _middleinfo">
                  <?php if(isset($category) && isset($this->categoryActive)):?>
                    <div><i class="fa fa-folder-open sesbasic_text_light"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></div>
                  <?php endif;?>
                  <!--<?php if(isset($this->priceActive) && $group->price):?>
                    <div class="sesgroup_ht"><i class="fa fa-usd sesbasic_text_light"></i>&nbsp;<span><?php echo $group->price;?></span></div>
                  <?php endif;?>!-->
                </div>
                <?php if(isset($this->descriptionActive)):?>
                  <div class="_des">
                    <?php echo $this->string()->truncate($this->string()->stripTags($group->description), $this->params['description_truncation']) ?>
                  </div>
                <?php endif;?>
              </div>
              <?php if(isset($this->contactDetailActive) && (isset($group->group_contact_phone) || isset($group->group_contact_email) || isset($group->group_contact_website))):?>
                <div class="_continnerright">
                  <div class="sesgroup_list_contact_btns sesbasic_clearfix">
                    <?php  if($group->group_contact_phone):?>
                      <div class="sesbasic_clearfix">
                        <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                          <a href="javascript:void(0);" class="sesbasic_link_btn" onclick="sessmoothboxDialoge('<?php echo $group->group_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("View Phone No")?></a>
                        <?php endif;?>
                      </div>
                    <?php  endif;?>
                    <?php if($group->group_contact_email):?>
                      <div class="sesbasic_clearfix">
                        <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                          <a href='mailto:<?php echo $group->group_contact_email ?>' class="sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                        <?php endif;?>
                      </div>
                    <?php endif;?>
                    <?php if($group->group_contact_website):?>
                      <div class="sesbasic_clearfix">
                        <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                          <a href="<?php echo parse_url($group->group_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $group->group_contact_website : $group->group_contact_website; ?>" target="_blank" class="sesbasic_link_btn"><?php echo $this->translate("Visit Website")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                        <?php endif;?>
                      </div>
                    <?php endif;?>
                  </div>
                </div>
              <?php endif;?> 
            </div>  
            <div class="_footer">
              <div class="_socialbtns">
                <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataSharing.tpl';?>
              </div>
            </div>
          </div>
        </article>
      </div>
    <?php endforeach;?>
  </div>
</div>
<script type="text/javascript">
  sesgroupJqueryObject('.sesgroup_list_slideshow_<?php echo $this->identity;?>').owlCarousel({
    nav : true,
    loop:true,
    items:1,
    //autoplay:<?php echo $this->params['autoplay'] ?>,
    //autoplayTimeout:<?php echo $this->params['speed'] ?>,
  })
  sesgroupJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
  sesgroupJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
</script>