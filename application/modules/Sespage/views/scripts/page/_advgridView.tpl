<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advgridView.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $title = '';?>
<?php if(isset($this->titleActive)):?>
  <?php if(isset($this->params['advgrid_title_truncation'])):?>
    <?php $titleLimit = $this->params['advgrid_title_truncation'];?>
  <?php else:?>
    <?php $titleLimit = $this->params['title_truncation'];?>
  <?php endif;?>
  <?php if(strlen($page->getTitle()) > $titleLimit):?>
    <?php $title = mb_substr($page->getTitle(),0,$titleLimit).'...';?>
  <?php else:?>
    <?php $title = $page->getTitle();?>
  <?php endif; ?>
<?php endif;?>
<?php $owner = $page->getOwner();?>
<li class="sespage_advgrid_item" style="width:<?php echo $width ?>px;">
  <article>
    <div class="_thumb sespage_thumb" style="height:<?php echo $height ?>px;">
      <a href="<?php echo $page->getHref();?>" class="sespage_thumb_img">
        <span class="sesbasic_animation" style="background-image:url(<?php echo $page->getPhotoUrl('thumb.profile'); ?>);"></span>
      </a>
      <div class="sespage_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataLabel.tpl';?>
      </div>
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        <div class="_btns sesbasic_animation">
          <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataButtons.tpl';?>
        </div>
      <?php endif;?>
    </div>
    <div class="_cont sesbasic_animation">
      <div class="_continner">
        <div class="sesbasic_clearfix">
          <?php if(isset($this->locationActive) && $page->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage_enable_location', 1)):?>
            <div class="sesbasic_text_light _location">
              <span title="<?php echo $page->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sespage.enable.map.integration', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)):?><a href="<?php echo $this->url(array('resource_id' => $page->page_id,'resource_type'=>'sespage_page','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $page->location;?></a><?php else:?><?php echo $page->location;?><?php endif;?></span>
            </div>
          <?php endif;?>
          <?php if(!empty($title)):?>
            <div class="_title">
              <a href="<?php echo $page->getHref();?>"><?php echo $title;?></a>
              <?php if(isset($this->verifiedLabelActive)&& $page->verified):?><i class="sespage_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
            </div>
          <?php endif;?>
          <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sespagereview') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagereview.pluginactivated')):?>
            <?php echo $this->partial('_pageRating.tpl', 'sespagereview', array('showRating' =>(isset($this->ratingActive) ? 1 : 0), 'rating' => $page->rating, 'review' => $page->review_count,'page_id' => $page->page_id));?>
          <?php endif;?>
          <?php if(isset($this->priceActive)):?>
            <div class="_price">
              <div class="sespage_button"><i class="fa fa-usd"></i><span><?php echo $page->price;?></span></div>
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
                    <a href="<?php echo parse_url($page->page_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $page->page_contact_website : $page->page_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
                  <?php endif;?>
                </span>
              <?php endif;?>
            </div>
          <?php endif;?>
          <div class="_footer">
            <div class="_sharebuttons sesbasic_clearfix">
              <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataSharing.tpl';?>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </article>
</li>



