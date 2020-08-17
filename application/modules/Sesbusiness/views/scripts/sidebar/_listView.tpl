<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $owner = $business->getOwner();?>
<li class="sesbusiness_sidebar_list_item sesbasic_clearfix">
  <div class="_thumb" style="width:<?php echo is_numeric($width)?$width.'px':$width ?>;">
    <span style="height:<?php echo is_numeric($height)?$height.'px':$height ?>;width:<?php echo is_numeric($width)?$width.'px':$width ?>;"><a href="<?php echo $business->getHref();?>" class="floatL sesbusiness_thumb_img"><span class="bg_item_photo" style="background-image:url(<?php echo $business->getPhotoUrl('thumb.profile'); ?>);"></span></a></span>
    <div class="_labels">
      <?php if(isset($this->featuredLabelActive) && $business->featured):?>
      <span class="sesbusiness_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
      <?php if(isset($this->sponsoredLabelActive) && $business->sponsored):?>
      <span class="sesbusiness_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
      <?php if(isset($this->hotLabelActive) && $business->hot):?>
      <span class="sesbusiness_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
    </div>
  </div>
  <div class="_cont">
    <?php if(isset($this->titleActive)):?>
      <div class="_title">
        <a href="<?php echo $business->getHref();?>"><?php echo $title;?></a><?php if(isset($this->verifiedLabelActive)&& $business->verified):?><i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
      </div>
    <?php endif;?>
    <?php if(SESBUSINESSSHOWUSERDETAIL == 1 && isset($this->byActive)):?>
      <div class="_stats sesbasic_clearfix sesbasic_text_light">
        <i class="fa fa-user"></i>
        <span><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
      </div>
    <?php endif;?>
    <?php if(isset($category) && $this->categoryActive):?>
      <div class="_stats sesbasic_clearfix sesbasic_text_light _category">
        <i class="fa fa-folder-open"></i>
        <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
      </div>
    <?php endif;?>
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessreview') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.pluginactivated')):?>
      <?php echo $this->partial('_businessRating.tpl', 'sesbusinessreview', array('showRating' =>(isset($this->ratingActive) ? 1 : 0), 'rating' => $business->rating,'review' => $business->review_count,'business_id' => $business->business_id));?>
    <?php endif;?>
    <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($business->follow_count)) || (isset($this->memberActive) && isset($business->member_count))):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix">
          <i class="fa fa-bar-chart"></i>
          <span><?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataStatics.tpl';?></span>
      </div>
    <?php endif;?>
    <!--<?php if(isset($this->priceActive) && $business->price):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix">
        <i class="fa fa-usd"></i> <span><?php echo $business->price;?></span>
      </div>
    <?php endif;?>!-->
    <?php if($business->location):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix _location">
        <i class="fa fa-map-marker" title="<?php echo $this->translate('Location');?>"></i>
        <span title="<?php echo $business->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesbusiness.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $business->business_id,'resource_type'=>'businesses','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $business->location;?></a><?php else:?><?php echo $business->location;?><?php endif;?></span>
      </div>
    <?php endif;?>
    <?php if(isset($this->contactDetailActive) && (isset($business->business_contact_phone) || isset($business->business_contact_email) || isset($business->business_contact_website))):?>
      <?php if($business->business_contact_phone):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<i class="fa fa-mobile"></i>
          <span>
            <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
              <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $business->business_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
            <?php else:?>
              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
            <?php endif;?>
          </span>
      	</div>  
      <?php endif;?>
      <?php if($business->business_contact_email):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<i class="fa fa-envelope"></i>
          <span>
            <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
              <a href='mailto:<?php echo $business->business_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
            <?php else:?>
              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
            <?php endif;?>
          </span>
        </div>  
      <?php endif;?>
      <?php if($business->business_contact_website):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<i class="fa fa-globe"></i>
          <span>
            <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
              <a href="<?php echo parse_url($business->business_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $business->business_contact_website : $business->business_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
            <?php else:?>
              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
            <?php endif;?>
          </span>
        </div>
      <?php endif;?>
    <?php endif;?>
    <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
    	<div class="_footer">
        <div class="_btns"><?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataButtons.tpl';?></div>
        <div class="_sharebuttons"><?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataSharing.tpl';?></div>
    	</div>
    <?php endif;?>
  </div>
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
      if(event.target.className != 'sesbusiness_sidebar_list_option_btns' && event.target.id != 'testcl') {
      	sesJqueryObject('.sesbusiness_sidebar_list_option_btns').css('display', 'none');
      }
    });
  });
</script>
</li>
  
