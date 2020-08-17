<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _horrizontallistView.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $owner = $store->getOwner();?>
<!-- <li class="estore_hlist_item sesbasic_clearfix">
	<article class="sesbasic_animation">
    <div class="_thumb estore_thumb" style="height:<?php echo is_numeric($height)?$height.'px':$height ?>;width:<?php echo is_numeric($width)?$width.'px':$width ?>;">
      <a href="<?php echo $store->getHref();?>" class="floatL estore_thumb_img"><span class="bg_item_photo" style="background-image:url(<?php echo $store->getPhotoUrl('thumb.profile'); ?>);"></span></a>
      <div class="estore_list_labels sesbasic_animation">
        <?php if(isset($this->featuredLabelActive) && $store->featured):?>
        <span class="estore_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
        <?php endif;?>
        <?php if(isset($this->sponsoredLabelActive) && $store->sponsored):?>
        <span class="estore_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
        <?php endif;?>
        <?php if(isset($this->hotLabelActive) && $store->hot):?>
        <span class="estore_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
        <?php endif;?>
      </div>
       <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        <div class="_btns sesbasic_animation">
					<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
        </div>
      <?php endif;?>
    </div>
    <div class="_cont">
      <?php if(isset($category) && $this->categoryActive):?>
        <div class="_category">
          <a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a>
        </div>
      <?php endif;?>
      <?php if(isset($this->titleActive)):?>
        <div class="_title">
          <a href="<?php echo $store->getHref();?>"><?php echo $title;?></a><?php if(isset($this->verifiedLabelActive)&& $store->verified):?><i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
        </div>
      <?php endif;?>
      <?php if(ESTORESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
        <div class="_stats sesbasic_clearfix sesbasic_text_light">
          <i class="fa fa-user"></i>
          <span><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
        </div>
      <?php endif;?>
      <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($store->follow_count)) || (isset($this->memberActive) && isset($store->member_count))):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
          <i class="fa fa-chart-bar"></i>
          <span><?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataStatics.tpl';?></span>
        </div>
      <?php endif;?> -->
      <!--<?php if(isset($this->priceActive) && $store->price):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<i class="fa fa-dollar-sign"></i> <span><?php echo $store->price;?></span>
        </div>
      <?php endif;?>!-->
     <!--  <?php if($store->location):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix _location">
          <i class="fa fa-map-marker" title="<?php echo $this->translate('Location');?>"></i>
          <span title="<?php echo $store->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a><?php else:?><?php echo $store->location;?><?php endif;?></span>
        </div>
      <?php endif;?>
      <?php if(isset($this->contactDetailActive) && (isset($store->store_contact_phone) || isset($store->store_contact_email) || isset($store->store_contact_website))):?>
        <div class="_contactlinks sesbasic_clearfix sesbasic_animation">
          <?php if($store->store_contact_phone):?>
            <span>
              <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $store->store_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
              <?php endif;?>
            </span>
          <?php endif;?>
          <?php if($store->store_contact_email):?>
            <span>
              <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                <a href='mailto:<?php echo $store->store_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
              <?php endif;?>
            </span>
          <?php endif;?>
          <?php if($store->store_contact_website):?>
            <span>
              <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                <a href="<?php echo parse_url($store->store_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $store->store_contact_website : $store->store_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
              <?php endif;?>
            </span>
          <?php endif;?>
        </div>
      <?php endif;?>
      <?php if(isset($this->socialSharingActive)):?>
        <div class="_footer">
          <div class="_sharebuttons"><?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataSharing.tpl';?></div>
        </div>
      <?php endif;?>
    </div>
  </article>  
  <script>
  function showSocialIconsS(id) {
    if(sesJqueryObject('#sidebarsocialicons_' + id)) {
        if (sesJqueryObject('#sidebarsocialicons_' + id).css('display') == 'block') {
            sesJqueryObject('#sidebarsocialicons_' + id).css('display','none');
        } else {
            sesJqueryObject('#sidebarsocialicons_' + id).css('display','block');
        }
    }
  }
  window.addEvent('domready', function() {
    $(document.body).addEvent('click', function(event){
      if(event.target.className != 'estore_sidebar_list_option_btns' && event.target.id != 'testcl') {
      	sesJqueryObject('.estore_sidebar_list_option_btns').css('display', 'none');
      }
    });
  });
</script>
</li>
  
 -->
