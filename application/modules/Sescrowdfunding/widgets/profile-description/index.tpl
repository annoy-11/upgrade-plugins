<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sescf_profile_des sesbasic_clearfix sesbasic_bxs">
  <?php if(in_array('shourtdec', $this->showcriteria)) { ?>
  <div class="sescf_profile_des_about">
  	<?php echo $this->crowdfunding->short_description; ?>
  </div>
  <?php } ?>
  <?php if(in_array('slide', $this->showcriteria)) { ?>
  <div class="sescf_profile_des_photos">
  	<?php echo $this->content()->renderWidget('sescrowdfunding.profile-photos-slideshow'); ?>
  </div>  
  <?php } ?>
  <?php if(in_array('description', $this->showcriteria)) { ?>
  <div class="sescf_profile_des_heading">
  	<?php echo $this->translate("Story");?>
  </div>
  <div class="sescf_rich_content">
  	<?php echo $this->crowdfunding->description; ?>
  </div>
  <?php } ?>
  <?php if(in_array('otherinfo', $this->showcriteria)) { ?>
  <?php if($this->sesbasicFieldValueLoop($this->crowdfunding)) { ?>
		<div class="sescf_profile_info_row" id="sescf_custom_fields_val">
			<div class="sescf_profile_info_head"><?php echo $this->translate("Other Info"); ?></div>
			<div class="sescf_view_custom_fields">
				<?php
					//custom field data
					echo $this->sesbasicFieldValueLoop($this->crowdfunding);
				?>
			</div>
		</div>
  <?php } ?>
  <?php } ?>
  
  <div class="sescf_profile_des_buttons">
    <?php if(in_array('share', $this->showcriteria)) { ?>
    <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->crowdfunding->getHref()); ?>
    <?php $enableShare = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.sharing', 1); ?>
    <?php if($enableShare == 2):?>
      <div class="sesbasic_clearfix">
        <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $this->crowdfunding->getTitle(); ?>" class="sesbasic_animation facebook_link" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Facebook'); ?>')"><i class="fa fa-facebook"></i> <span><?php echo $this->translate('Facebook'); ?></span></a>
      </div>
      <div class="sesbasic_clearfix">
        <a href="<?php echo 'https://twitter.com/intent/tweet?url=' . $urlencode . '&title=' . $this->crowdfunding->getTitle(); ?>" class="sesbasic_animation twitter_link" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Twitter')?>')"><i class="fa fa-twitter"></i> <span><?php echo $this->translate('Twitter'); ?></span></a>
      </div>
      <div class="sesbasic_clearfix">
        <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($this->crowdfunding->getPhotoUrl(),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'].$this->crowdfunding->getPhotoUrl() ) : $this->crowdfunding->getPhotoUrl())); ?>&description=<?php echo $this->crowdfunding->getTitle();?>" class="sesbasic_animation pinterest_link" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')"><i class="fa fa-pinterest-p"></i> <span><?php echo $this->translate('Pinterest'); ?></span></a>
      </div>
    <?php endif;?>
    <?php if($this->viewer_id && $enableShare):?>
      <div class="sesbasic_clearfix">
        <a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->crowdfunding->getType(), "id" => $this->crowdfunding->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="sesbasic_animation share_link smoothbox"><i class="fa fa-share "></i><span><?php echo $this->translate('Share');?></span></a>
      </div>
    <?php endif;?>
    <?php } ?>
    
    <?php if(in_array('likebutton', $this->showcriteria) && $this->viewer_id):?>
      <?php $canComment =  $this->crowdfunding->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
      <?php $LikeStatus = Engine_Api::_()->sescrowdfunding()->getLikeStatusCrowdfunding($this->crowdfunding->crowdfunding_id, $this->crowdfunding->getType()); ?> 
      <?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
      <?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
      <?php if($canComment):?>
        <div class="sesbasic_clearfix">
          <a href="javascript:;" data-url="<?php echo $this->crowdfunding->crowdfunding_id ; ?>" class="sesbasic_animation like_link sescrowdfunding_like_sescrowdfunding_<?php echo $this->crowdfunding->crowdfunding_id ?> sescrowdfunding_like_sescrowdfunding_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $this->translate($likeText);?></span></a>
        </div>
      <?php endif;?>
    <?php endif;?>
  </div>

  <div class="layout_core_comments" style="display:block">
    <?php 
      if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment')) {
        echo $this->action("list", "comment", "sesadvancedcomment", array("type" => "crowdfunding", "id" => $this->crowdfunding->getIdentity(),'is_ajax_load'=>true)); 
      } 
      else {
        echo $this->action("list", "comment", "core", array("type" => "crowdfunding", "id" => $this->crowdfunding->getIdentity()));
      }
    ?>
  </div>
</div>
