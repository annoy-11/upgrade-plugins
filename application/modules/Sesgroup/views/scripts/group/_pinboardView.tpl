<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _pinboardView.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($this->params['pinboard_limit_member'])):?>
  <?php $limitMember = $this->params['pinboard_limit_member'];?>
<?php else:?>
  <?php $limitMember = $this->params['limit_member'];?>
<?php endif;?>
<?php $title = '';?>
<?php if(isset($this->titleActive)):?>
  <?php if(isset($this->params['pinboard_title_truncation'])):?>
    <?php $titleLimit = $this->params['pinboard_title_truncation'];?>
  <?php else:?>
    <?php $titleLimit = $this->params['title_truncation'];?>
  <?php endif;?>
  <?php if(strlen($group->getTitle()) > $titleLimit):?>
    <?php $title = mb_substr($group->getTitle(),0,$titleLimit).'...';?>
  <?php else:?>
    <?php $title = $group->getTitle();?>
  <?php endif; ?>
<?php endif;?>
<?php $descriptionLimit = 0;?>
<?php if(isset($this->pinboarddescriptionActive)):?>
  <?php $descriptionLimit = $this->params['pinboard_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)):?>
  <?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $owner = $group->getOwner();?>
<li class="sesgroup_pinboard_item sesbasic_bxs">
	<div class="sesgroup_pinboard_item_inner sesbm sesbasic_clearfix">
		<div class="_thumb sesbasic_clearfix">
    	<div class="_img"><a href="<?php echo $group->getHref();?>"><img class="" src="<?php echo $group->getPhotoUrl(); ?>" alt="" /></a></div>
      <a href="<?php echo $group->getHref();?>" class="_link"  data-url="<?php echo $group->getType() ?>"></a>
      <div class="sesgroup_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataLabel.tpl';?>
      </div>
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        <div class="_btns sesbasic_animation">
          <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataButtons.tpl';?>
        </div>
      <?php endif;?>
		</div>
  	<header class="sesbasic_clearfix">
      <?php if(!empty($title)):?>
        <p class="_title"><a href="<?php echo $group->getHref();?>"><?php echo $title;?></a><?php if(isset($this->verifiedLabelActive)&& $group->verified):?><i class="sesgroup_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?></p>
      <?php endif;?>
      <?php if(isset($category) && isset($this->categoryActive)):?>
        <p class="_category sesbasic_text_light">
          <i class="fa fa-folder-open"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
        </p> 
      <?php endif;?>
    </header>
    <div class="_info sesbasic_clearfix">
      <div class="_owner sesbasic_text_light">
        <?php if(SESGROUPSHOWUSERDETAIL == 1 && isset($this->ownerPhotoActive)):?>
          <span class="_owner_img">
            <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
          </span>
        <?php endif;?>
        <div class="_ownerinfo">
          <?php if(SESGROUPSHOWUSERDETAIL == 1 && isset($this->byActive)):?>
            <span class="_owner_name sesbasic_text_light"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
          <?php endif;?>
          <?php if(isset($this->creationDateActive)):?>
            -&nbsp;<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_date.tpl';?>
          <?php endif;?>
          <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($group->follow_count)) || (isset($this->memberActive) && isset($group->member_count))):?>
            <div class="_stats sesbasic_text_light">
              <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataStatics.tpl';?>
            </div>
          <?php endif;?>
        </div>
      </div>
      <?php if(isset($this->locationActive) && $group->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup_enable_location', 1)):?>
        <div class="_stats sesbasic_text_light _location">
          <span>
            <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
            <span title="<?php echo $group->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesgroup.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $group->group_id,'resource_type'=>'sesgroup_group','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $group->location;?></a><?php else:?><?php echo $group->location;?><?php endif;?></span>
          </span>
        </div>
      <?php endif;?>
      <?php if(isset($this->contactDetailActive) && (isset($group->group_contact_phone) || isset($group->group_contact_email) || isset($group->group_contact_website))):?>
        <?php if($group->group_contact_phone):?>
          <div class="_stats sesbasic_text_light">
            <span>
              <i class="fa fa-phone"></i>
              <span>                  
                <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                  <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $group->group_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                <?php else:?>
                  <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
                <?php endif;?>
              </span>
            </span>
          </div>
        <?php endif;?>
        <?php if($group->group_contact_email):?>
          <div class="_stats sesbasic_text_light">
            <span>
              <i class="fa fa-envelope-o"></i>
              <span>
                <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                  <a href='mailto:<?php echo $group->group_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
                <?php else:?>
                  <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
                <?php endif;?>
              </span>
            </span>
          </div>
        <?php endif;?>
        <?php if($group->group_contact_website):?>
          <div class="_stats sesbasic_text_light">
            <span>
              <i class="fa fa-globe"></i>
              <span>
                <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                  <a href="<?php echo parse_url($group->group_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $group->group_contact_website : $group->group_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
                <?php else:?>
                  <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
                <?php endif;?>
              </span>
            </span>
          </div>
        <?php endif;?>
      <?php endif;?> 
      <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_groupMemberStatics.tpl';?>
      <?php if($descriptionLimit):?>
        <p class="_des"><?php echo $this->string()->truncate($this->string()->stripTags($group->description), $descriptionLimit) ?></p>
      <?php endif;?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_groupMemberPhoto.tpl';?>
      <?php if(isset($this->socialSharingActive)):?>
        <div class="_socialbtns">
          <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataSharing.tpl';?> 
        </div>
      <?php endif;?>
  	</div>
  </div>
</li>