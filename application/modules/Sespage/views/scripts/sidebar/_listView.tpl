<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $owner = $page->getOwner();?>
<li class="sespage_sidebar_list_item sesbasic_clearfix">
  <div class="_thumb" style="width:<?php echo is_numeric($width)?$width.'px':$width ?>;">
    <span style="height:<?php echo is_numeric($height)?$height.'px':$height ?>;width:<?php echo is_numeric($width)?$width.'px':$width ?>;"><a href="<?php echo $page->getHref();?>" class="floatL sespage_thumb_img"><span class="bg_item_photo" style="background-image:url(<?php echo $page->getPhotoUrl('thumb.profile'); ?>);"></span></a></span>
    <div class="_labels">
      <?php if(isset($this->featuredLabelActive) && $page->featured):?>
      <span class="sespage_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
      <?php if(isset($this->sponsoredLabelActive) && $page->sponsored):?>
      <span class="sespage_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
      <?php if(isset($this->hotLabelActive) && $page->hot):?>
      <span class="sespage_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
    </div>
  </div>
  <div class="_cont">
    <?php if(isset($this->titleActive)):?>
      <div class="_title">
        <a href="<?php echo $page->getHref();?>"><?php echo $title;?></a><?php if(isset($this->verifiedLabelActive)&& $page->verified):?><i class="sespage_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
      </div>
    <?php endif;?>
    <?php if(SESPAGESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
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
    <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagereview') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.pluginactivated')):?>
      <?php echo $this->partial('_pageRating.tpl', 'sespagereview', array('showRating' =>(isset($this->ratingActive) ? 1 : 0), 'rating' => $page->rating,'review' => $page->review_count,'page_id' => $page->page_id));?>
    <?php endif;?>
    <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($page->follow_count)) || (isset($this->memberActive) && isset($page->member_count))):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix">
          <i class="fa fa-bar-chart"></i>
          <span><?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataStatics.tpl';?></span>
      </div>
    <?php endif;?>
    <?php if(isset($this->priceActive) && $page->price):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix">
        <i class="fa fa-usd"></i> <span><?php echo $page->price;?></span>
      </div>
    <?php endif;?>
    <?php if($page->location):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix _location">
        <i class="fa fa-map-marker" title="<?php echo $this->translate('Location');?>"></i>
        <span title="<?php echo $page->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sespage.enable.map.integration', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)):?><a href="<?php echo $this->url(array('resource_id' => $page->page_id,'resource_type'=>'sespage_page','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $page->location;?></a><?php else:?><?php echo $page->location;?><?php endif;?></span>
      </div>
    <?php endif;?>
    <?php if(isset($this->contactDetailActive) && (isset($page->page_contact_phone) || isset($page->page_contact_email) || isset($page->page_contact_website))):?>
      <?php if($page->page_contact_phone):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<i class="fa fa-mobile"></i>
          <span>
            <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
              <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $page->page_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
            <?php else:?>
              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
            <?php endif;?>
          </span>
      	</div>  
      <?php endif;?>
      <?php if($page->page_contact_email):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<i class="fa fa-envelope"></i>
          <span>
            <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
              <a href='mailto:<?php echo $page->page_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
            <?php else:?>
              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
            <?php endif;?>
          </span>
        </div>  
      <?php endif;?>
      <?php if($page->page_contact_website):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<i class="fa fa-globe"></i>
          <span>
            <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
              <a href="<?php echo parse_url($page->page_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $page->page_contact_website : $page->page_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
            <?php else:?>
              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
            <?php endif;?>
          </span>
        </div>
      <?php endif;?>
    <?php endif;?>
    <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
    	<div class="_footer">
        <div class="_btns"><?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataButtons.tpl';?></div>
        <div class="_sharebuttons"><?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataSharing.tpl';?></div>
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
      if(event.target.className != 'sespage_sidebar_list_option_btns' && event.target.id != 'testcl') {
      	sesJqueryObject('.sespage_sidebar_list_option_btns').css('display', 'none');
      }
    });
  });
</script>
</li>
  
