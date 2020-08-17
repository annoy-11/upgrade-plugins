<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advgridView.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($this->params['advgrid_limit_member'])):?>
  <?php $limitMember = $this->params['advgrid_limit_member'];?>
<?php else:?>
  <?php $limitMember = $this->params['limit_member'];?>
<?php endif;?>
<?php $title = '';?>
<?php if(isset($this->titleActive)):?>
  <?php if(isset($this->params['advgrid_title_truncation'])):?>
    <?php $titleLimit = $this->params['advgrid_title_truncation'];?>
  <?php else:?>
    <?php $titleLimit = $this->params['title_truncation'];?>
  <?php endif;?>
  <?php if(strlen($group->getTitle()) > $titleLimit):?>
    <?php $title = mb_substr($group->getTitle(),0,$titleLimit).'...';?>
  <?php else:?>
    <?php $title = $group->getTitle();?>
  <?php endif; ?>
<?php endif;?>
<?php $owner = $group->getOwner();?>
<li class="sesgroup_advgrid_item" style="width:<?php echo $width ?>px;">
  <article>
    <div class="_thumb sesgroup_thumb" style="height:<?php echo $height ?>px;">
      <a href="<?php echo $group->getHref();?>" class="sesgroup_thumb_img">
        <span class="sesbasic_animation" style="background-image:url(<?php echo $group->getPhotoUrl('thumb.profile'); ?>);"></span>
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
    <div class="_cont sesbasic_animation">
      <div class="_continner">
        <div class="sesbasic_clearfix">
          <?php if(isset($this->locationActive) && $group->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup_enable_location', 1)):?>
            <div class="_stats sesbasic_text_light _location">
              <span title="<?php echo $group->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesgroup.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $group->group_id,'resource_type'=>'sesgroup_group','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $group->location;?></a><?php else:?><?php echo $group->location;?><?php endif;?></span>
            </div>
          <?php endif;?>
          <?php if(!empty($title)):?>
            <div class="_title">
              <a href="<?php echo $group->getHref();?>"><?php echo $title;?></a>
              <?php if(isset($this->verifiedLabelActive)&& $group->verified):?><i class="sesgroup_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
            </div>
          <?php endif;?>
          <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_groupMemberStatics.tpl';?>
          <?php if(isset($this->contactDetailActive) && (isset($group->group_contact_phone) || isset($group->group_contact_email) || isset($group->group_contact_website))):?>
            <div class="_contactlinks sesbasic_clearfix sesbasic_animation">
              <?php if($group->group_contact_phone):?>
                <span>
                  <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                    <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $group->group_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
                  <?php endif;?>
                </span>
              <?php endif;?>
              <?php if($group->group_contact_email):?>
                <span>
                  <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                    <a href='mailto:<?php echo $group->group_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
                  <?php endif;?>
                </span>
              <?php endif;?>
              <?php if($group->group_contact_website):?>
                <span>
                  <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                    <a href="<?php echo parse_url($group->group_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $group->group_contact_website : $group->group_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
                  <?php endif;?>
                </span>
              <?php endif;?>
            </div>
          <?php endif;?>
          <div class="_footer">
            <div class="_sharebuttons sesbasic_clearfix">
              <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataSharing.tpl';?>
            </div>
          </div>
          <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_groupMemberPhoto.tpl';?>
        </div>
      </div>
    </div>  
  </article>
</li>



