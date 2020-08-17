<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessteam
 * @package    Sesbusinessteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusinessteam/externals/styles/styles.css'); ?>
<?php $user = $this->team;  ?>
<div class="sesbusinessteam_member_profile_wrapper clear sesbasic_clearfix">
  <?php if($user->type == 'sitemember') { ?>
    <?php $userItem = Engine_Api::_()->getItem('user', $user->user_id); ?>
  <?php } ?>
  <div class="sesbusinessteam_member_profile_left">
    <div class="sesbusinessteam_member_profile_photo">
      <?php if(!empty($this->infoshow) && in_array('profilePhoto', $this->infoshow)): ?>
        <div class="sesbusinessteam_member_profile_photo_inner">
          <?php if($user->type == 'sitemember') { ?>
            <?php echo $this->itemPhoto($userItem, 'thumb.profile', $userItem->getTitle()); ?>
          <?php } else if($user->type == 'nonsitemember') { ?>
            <a href="javascript:void(0);">
            <?php echo $this->itemPhoto($user, 'thumb.profile', $user->getTitle()); ?>
            </a>
          <?php } ?>
        </div>
      <?php endif; ?>
    </div>
    <div class="sesbusinessteam_member_profile_contact_info">
      <?php if($user->email && in_array('email', $this->infoshow)): ?>
        <span class="clear sesbasic_clearfix">
          <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email ?>"><i class="fa fa-envelope sesbasic_text_light"></i><?php echo $user->email; ?>
          </a> 
        </span>
      <?php endif; ?>
      
      <?php if($user->phone && in_array('phone', $this->infoshow)): ?>
        <span class="clear sesbasic_clearfix">
          <i class="fa fa-phone sesbasic_text_light"></i>
          <?php echo $user->phone ?>
        </span>
      <?php endif; ?>
      
      <?php if($user->location && in_array('location', $this->infoshow)): ?>
        <span class="clear sesbasic_clearfix">
          <i class="fa fa-map-marker sesbasic_text_light"></i>
          <?php echo $this->htmlLink('http://maps.google.com/?q='.urlencode($user->location), $user->location, array('target' => 'blank')) ?>
        </span>
      <?php endif; ?>
    </div>  
    <div class="sesbusinessteam_member_profile_social_icon sesbusinessteam-social-icon">
      <?php if($user->email && in_array('email', $this->infoshow)): ?>
      <a href="mailto:<?php echo $user->email ?>" title="<?php echo $user->email; ?>"><i class="fa fa-envelope sesbasic_text_light"></i>
      </a> 
      <?php endif; ?>

      <?php if($user->website && in_array('website', $this->infoshow)): ?>
      <?php $website = (preg_match("#https?://#", $user->website) === 0) ? 'http://'.$user->website : $user->website; ?>
      <a href="<?php echo $website ?>" target="_blank" title="<?php echo $website ?>">
        <i class="fa fa-globe sesbasic_text_light"></i>
      </a> 
      <?php endif; ?>
      <?php if($user->facebook && in_array('facebook', $this->infoshow)): ?>
      <?php $facebook = (preg_match("#https?://#", $user->facebook) === 0) ? 'http://'.$user->facebook : $user->facebook; ?>
      <a href="<?php echo $facebook ?>" target="_blank" title="<?php echo $facebook ?>">
        <i class="fa fa-facebook sesbasic_text_light"></i>
      </a> 
      <?php endif; ?>
      <?php if($user->twitter && in_array('twitter', $this->infoshow)): ?>
      <?php $twitter = (preg_match("#https?://#", $user->twitter) === 0) ? 'http://'.$user->twitter : $user->twitter; ?>
      <a href="<?php echo $twitter ?>" target="_blank" title="<?php echo $twitter ?>">
        <i class="fa fa-twitter sesbasic_text_light"></i>
      </a>
      <?php endif; ?>
      <?php if($user->linkdin && in_array('linkdin', $this->infoshow)): ?>
      <?php $linkdin = (preg_match("#https?://#", $user->linkdin) === 0) ? 'http://'.$user->linkdin : $user->linkdin; ?>
      <a href="<?php echo $linkdin ?>" target="_blank" title="<?php echo $linkdin ?>">
        <i class="fa fa-linkedin sesbasic_text_light"></i>
      </a>
      <?php endif; ?>
      <?php if($user->googleplus && in_array('googleplus', $this->infoshow)): ?>
      <?php $googleplus = (preg_match("#https?://#", $user->googleplus) === 0) ? 'http://'.$user->googleplus : $user->googleplus; ?>
      <a href="<?php echo $googleplus ?>" target="_blank" title="<?php echo $googleplus ?>">
        <i class="fa fa-google-plus sesbasic_text_light"></i>
      </a>
      <?php endif; ?>
      <?php if($user->type == 'sitemember') { ?>
        <a href="<?php echo $userItem->getHref() ?>" title="<?php echo $userItem->getTitle() ?>">
          <i class="fa fa-eye sesbasic_text_light" title="<?php echo $this->translate('View Profile'); ?>"></i>
        </a>
      <?php } ?>
    </div>
  </div>
  <div class="sesbusinessteam_member_profile_right">
    <?php if(!empty($this->infoshow)): ?>
      <?php if(in_array('displayname', $this->infoshow)): ?>
        <div class='sesbusinessteam_member_profile_title'>
          <?php echo $user->name; ?>
        </div>
      <?php endif; ?>
      <?php if($user->designation && in_array('designation', $this->infoshow)): ?>
        <div class='sesbusinessteam_member_profile_designation'>
          <?php echo $this->translate($user->designation); ?>
        </div>
      <?php endif; ?>
      <?php if($user->description): ?>
      <div class="sesbusinessteam_member_short_desc">
      	<?php echo $user->description; ?>
      </div>
      <?php endif; ?>
			
      <?php if($user->detail_description && in_array('detaildescription', $this->infoshow)): ?>
        <div class="sesbusinessteam_member_profile_heading">
          <?php if($this->descriptionText): ?>
            <?php echo $this->translate($this->descriptionText); ?>
          <?php else: ?>
            <?php echo $this->translate("Description"); ?>
          <?php endif; ?>          
        </div>
        <div class="sesbasic_html_block">
          <?php echo $user->detail_description; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>
