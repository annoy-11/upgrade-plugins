<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $owner = $group->getOwner();?>
<li class="sesgroup_sidebar_list_item sesbasic_clearfix">
  <div class="_thumb" style="width:<?php echo is_numeric($width)?$width.'px':$width ?>;">
    <span style="height:<?php echo is_numeric($height)?$height.'px':$height ?>;width:<?php echo is_numeric($width)?$width.'px':$width ?>;"><a href="<?php echo $group->getHref();?>" class="floatL sesgroup_thumb_img"><span class="bg_item_photo" style="background-image:url(<?php echo $group->getPhotoUrl('thumb.profile'); ?>);"></span></a></span>
    <div class="_labels">
      <?php if(isset($this->featuredLabelActive) && $group->featured):?>
      <span class="sesgroup_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
      <?php if(isset($this->sponsoredLabelActive) && $group->sponsored):?>
      <span class="sesgroup_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
      <?php if(isset($this->hotLabelActive) && $group->hot):?>
      <span class="sesgroup_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
    </div>
  </div>
  <div class="_cont">
    <?php if(isset($this->titleActive)):?>
      <div class="_title">
        <a href="<?php echo $group->getHref();?>"><?php echo $title;?></a><?php if(isset($this->verifiedLabelActive)&& $group->verified):?><i class="sesgroup_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
      </div>
    <?php endif;?>
    <?php if(SESGROUPSHOWUSERDETAIL == 1 && isset($this->byActive)):?>
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
    <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($group->follow_count)) || (isset($this->memberActive) && isset($group->member_count))):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix">
          <i class="fa fa-bar-chart"></i>
          <span><?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataStatics.tpl';?></span>
      </div>
    <?php endif;?>
    <!--<?php if(isset($this->priceActive) && $group->price):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix">
        <i class="fa fa-usd"></i> <span><?php echo $group->price;?></span>
      </div>
    <?php endif;?>!-->
    <?php if($group->location):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix _location">
        <i class="fa fa-map-marker" title="<?php echo $this->translate('Location');?>"></i>
        <span title="<?php echo $group->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesgroup.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $group->group_id,'resource_type'=>'sesgroup_group','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $group->location;?></a><?php else:?><?php echo $group->location;?><?php endif;?></span>
      </div>
    <?php endif;?>
    <?php if(isset($this->contactDetailActive) && (isset($group->group_contact_phone) || isset($group->group_contact_email) || isset($group->group_contact_website))):?>
      <?php if($group->group_contact_phone):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<i class="fa fa-mobile"></i>
          <span>
            <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
              <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $group->group_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
            <?php else:?>
              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
            <?php endif;?>
          </span>
      	</div>  
      <?php endif;?>
      <?php if($group->group_contact_email):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<i class="fa fa-envelope"></i>
          <span>
            <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
              <a href='mailto:<?php echo $group->group_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
            <?php else:?>
              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
            <?php endif;?>
          </span>
        </div>  
      <?php endif;?>
      <?php if($group->group_contact_website):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<i class="fa fa-globe"></i>
          <span>
            <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
              <a href="<?php echo parse_url($group->group_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $group->group_contact_website : $group->group_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
            <?php else:?>
              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
            <?php endif;?>
          </span>
        </div>
      <?php endif;?>
    <?php endif;?>
    <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
    	<div class="_footer">
        <div class="_btns"><?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataButtons.tpl';?></div>
        <div class="_sharebuttons"><?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataSharing.tpl';?></div>
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
      if(event.target.className != 'sesgroup_sidebar_list_option_btns' && event.target.id != 'testcl') {
      	sesJqueryObject('.sesgroup_sidebar_list_option_btns').css('display', 'none');
      }
    });
  });
</script>
</li>
  