<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _gridView.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $title = '';?>
<?php if(isset($this->titleActive)):?>
  <?php if(isset($this->params['grid_title_truncation'])):?>
    <?php $titleLimit = $this->params['grid_title_truncation'];?>
  <?php else:?>
    <?php $titleLimit = $this->params['title_truncation'];?>
  <?php endif;?>
  <?php if(strlen($page->getTitle()) > $titleLimit):?>
    <?php $title = mb_substr($page->getTitle(),0,$titleLimit).'...';?>
  <?php else:?>
    <?php $title = $page->getTitle();?>
  <?php endif; ?>
<?php endif;?>
<?php $descriptionLimit = 0;?>
<?php if(isset($this->griddescriptionActive)):?>
  <?php $descriptionLimit = $this->params['grid_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)):?>
  <?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $owner = $page->getOwner();?>
<li class="sespage_grid_cover_item" style="width:<?php echo $width ?>px;">
  <article>
    <div class="_cover sespage_thumb" style="height:<?php echo $height ?>px;">
      <a href="<?php echo $page->getHref();?>" class="sespage_thumb_img"><span style="background-image:url(<?php echo $page->getCoverPhotoUrl() ?>);"></span></a>
      <a href="<?php echo $page->getHref();?>" class="_cover_link"></a>
      <div class="sespage_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataLabel.tpl';?>
      </div>
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        <div class="_btns sesbasic_animation">
          <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataButtons.tpl';?>
        </div>
      <?php endif;?>
      <div class="_pageinfo sesbasic_animation">
      	<div>
          <div class="_thumb _isrounded">
            <a href="<?php echo $page->getHref();?>" class="sespage_thumb_img"><span class="bg_item_photo" style="background-image:url(<?php echo $page->getPhotoUrl('thumb.icon'); ?>);"></span></a>
          </div>
          <div class="_cont">
            <?php if(!empty($title)):?>
              <div class="_title">
                <a href="<?php echo $page->getHref();?>"><?php echo $title;?></a>
                <?php if(isset($this->verifiedLabelActive) && $page->verified):?><i class="sespage_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
              </div>	
            <?php endif;?>
            <div class="_date">
              <?php if(SESPAGESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
                <span class="_owner_name sesbasic_text_light"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
              <?php endif;?>
              <?php if(isset($this->creationDateActive)):?>
                -&nbsp;<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_date.tpl';?>
              <?php endif;?>
            </div>
          </div>
        </div>
    	</div>
      <?php if(isset($this->contactDetailActive) && (isset($page->page_contact_phone) || isset($page->page_contact_email) || isset($page->page_contact_website))):?>
        <div class="_contactbtns sesbasic_clearfix sesbasic_animation">
          <?php if($page->page_contact_phone):?>
            <div class="sesbasic_clearfix">
              <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $page->page_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
              <?php endif;?>
            </div>
          <?php endif;?>
          <?php if($page->page_contact_email):?>
            <div class="sesbasic_clearfix">
              <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                <a href='mailto:<?php echo $page->page_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
              <?php endif;?>
            </div>
          <?php endif;?>
          <?php if($page->page_contact_website):?>
            <div class="sesbasic_clearfix">
              <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                <a href="<?php echo parse_url($page->page_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $page->page_contact_website : $page->page_contact_website; ?>" target="_blank" ><?php echo $this->translate("Visit Website")?></a>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
              <?php endif;?>
            </div>
          <?php endif;?>
        </div>
      <?php endif;?>
    </div>  
    <div class="_cont sesbasic_clearfix">
      <?php if(isset($this->priceActive)):?>
        <div class="_price sespage_button">
        	<i class="fa fa-usd"></i><span><?php echo $page->price;?></span>
      	</div>
      <?php endif;?>
      <div class="_stats_rating">
        <?php if(isset($category) && isset($this->categoryActive)):?>
          <div class="_stats sesbasic_text_light">
            <span><i class="fa fa-folder-open"></i> <span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></span>
          </div>
        <?php endif;?>       
          <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagereview') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.pluginactivated')):?>
            <?php echo $this->partial('_pageRating.tpl', 'sespagereview', array('showRating' =>(isset($this->ratingActive) ? 1 : 0), 'rating' => $page->rating, 'review' => $page->review_count,'page_id' => $page->page_id));?>
          <?php endif;?>
      </div>
      <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($page->follow_count)) || (isset($this->memberActive) && isset($page->member_count))):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix">
        <i class="fa fa-bar-chart"></i>
        <span><?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataStatics.tpl';?></span>
      </div>
     <?php endif;?>
      <?php if(isset($this->locationActive) && $page->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage_enable_location', 1)):?>
      	<div class="_stats sesbasic_text_light _location">
          <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
          <span title="<?php echo $page->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sespage.enable.map.integration', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)):?><a href="<?php echo $this->url(array('resource_id' => $page->page_id,'resource_type'=>'sespage_page','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $page->location;?></a><?php else:?><?php echo $page->location;?><?php endif;?></span>
      	</div>
      <?php endif;?>
      <?php if($descriptionLimit):?>
        <div class="_des"><?php echo $this->partial('_description.tpl', 'sespage', array('limit' =>$descriptionLimit, 'description' => $page->description));?></div>
      <?php endif;?>
    </div>
    <div class="_footer sesbasic_clearfix">
      <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataSharing.tpl';?>
    </div>
	</article>
</li>

