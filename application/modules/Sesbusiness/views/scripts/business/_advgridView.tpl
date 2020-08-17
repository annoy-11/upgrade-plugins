<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advgridView.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
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
  <?php if(strlen($business->getTitle()) > $titleLimit):?>
    <?php $title = mb_substr($business->getTitle(),0,$titleLimit).'...';?>
  <?php else:?>
    <?php $title = $business->getTitle();?>
  <?php endif; ?>
<?php endif;?>
<?php $owner = $business->getOwner();?>
<li class="sesbusiness_advgrid_item" style="width:<?php echo $width ?>px;">
  <article>
    <div class="_thumb sesbusiness_thumb" style="height:<?php echo $height ?>px;">
      <a href="<?php echo $business->getHref();?>" class="sesbusiness_thumb_img">
        <span class="sesbasic_animation" style="background-image:url(<?php echo $business->getPhotoUrl('thumb.profile'); ?>);"></span>
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
    <div class="_cont sesbasic_animation">
      <div class="_continner">
        <div class="sesbasic_clearfix">
          <?php if(isset($this->locationActive) && $business->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness_enable_location', 1)):?>
            <div class="_stats sesbasic_text_light _location">
              <span title="<?php echo $business->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesbusiness.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $business->business_id,'resource_type'=>'businesses','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $business->location;?></a><?php else:?><?php echo $business->location;?><?php endif;?></span>
            </div>
          <?php endif;?>
          <?php if(!empty($title)):?>
            <div class="_title">
              <a href="<?php echo $business->getHref();?>"><?php echo $title;?></a>
              <?php if(isset($this->verifiedLabelActive)&& $business->verified):?><i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
            </div>
          <?php endif;?>
          <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessreview') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.pluginactivated')):?>
  <?php echo $this->partial('_businessRating.tpl', 'sesbusinessreview', array('showRating' =>(isset($this->ratingActive) ? 1 : 0), 'rating' => $business->rating, 'review' => $business->review_count,'business_id' => $business->business_id));?>
          <?php endif;?>
          <?php if(isset($this->contactDetailActive) && (isset($business->business_contact_phone) || isset($business->business_contact_email) || isset($business->business_contact_website))):?>
            <div class="_contactlinks sesbasic_clearfix sesbasic_animation">
              <?php if($business->business_contact_phone):?>
                <span>
                  <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                    <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $business->business_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
                  <?php endif;?>
                </span>
              <?php endif;?>
              <?php if($business->business_contact_email):?>
                <span>
                  <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                    <a href='mailto:<?php echo $business->business_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
                  <?php endif;?>
                </span>
              <?php endif;?>
              <?php if($business->business_contact_website):?>
                <span>
                  <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                    <a href="<?php echo parse_url($business->business_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $business->business_contact_website : $business->business_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
                  <?php endif;?>
                </span>
              <?php endif;?>
            </div>
          <?php endif;?>
          <div class="_footer">
            <div class="_sharebuttons sesbasic_clearfix">
              <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataSharing.tpl';?>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </article>
</li>



