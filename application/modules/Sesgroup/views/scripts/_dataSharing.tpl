<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataSharing.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $group = empty($this->mapgroup) ? $group : $this->mapgroup;?>
<?php $contactButton = empty($this->contactButton) ? isset($this->contactButtonActive) : $this->contactButton;?>
<?php $joinButton = empty($this->joinButton) ? isset($this->joinButtonActive) : $this->joinButton;?>
<?php $socialSharing = empty($this->socialSharing) ? isset($this->socialSharingActive) : $this->socialSharing;?>
<?php if($group->is_approved):?>
  <div class="_listbuttons _joineneble">
    <?php $levelId = ($viewerId) ? $viewer->level_id : 5;?>
    <?php $canJoin = Engine_Api::_()->authorization()->getPermission($levelId, 'sesgroup_group', 'group_can_join');?>
    <?php if($canJoin && $joinButton):?>
      <div class="_listbuttons_join">
        <?php $group = Engine_Api::_()->getItem('sesgroup_group',$group->group_id);?>
        <?php if($viewerId):?>
          <?php $row = $group->membership()->getRow($viewer);?>
          <?php if(null === $row):?>
            <?php if($group->membership()->isResourceApprovalRequired()):?>
              <?php $action = 'request';?>
            <?php else:?>
              <?php $action = 'join';?>
            <?php endif;?>
            <a href="<?php echo $this->url(array('action' =>'join-group','group_id' => $group->group_id),'egroupjoinfees_user_order',true);?>" class="sesgroup_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
          <?php else:?>
            <?php if($row->active):?>
              <a href="javascript:void(0);" class="sesgroup_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
            <?php else:?>
              <a href="javascript:void(0);" id="sesgroup_user_approval" class="sesgroup_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
            <?php endif;?>
          <?php endif;?>
        <?php else:?>
          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" id="sesgroup_user_approval" class="smoothbox sesgroup_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
        <?php endif;?>
      </div>
    <?php endif;?>
    <?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.allow.share', 1);?>
    <?php if($socialSharing && $shareType):?>
      <div class="_listbuttons_share">
        <a href="javascript:void(0);" class="sesgroup_button sesbasic_animation sesgroup_button_toggle"><i class="fa fa-share-alt"></i><span><?php echo $this->translate('Share');?></span></a>
        <div class="sesgroup_listing_share_popup">
          <p><?php echo $this->translate("Share This Group");?></p>	
          <?php if($shareType == 2):?>
            <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $group, 'socialshare_enable_plusicon' => $this->params["socialshare_enable_plusicon"], 'socialshare_icon_limit' => $this->params["socialshare_icon_limit"])); ?>
          <?php endif;?>
          <a href="<?php echo $this->url(array('module' => 'activity','controller' => 'index','action' => 'share','type' => $group->getType(),'id' => $group->getIdentity(),'format' => 'smoothbox'),'default',true);?>" class="openSmoothbox sesbasic_icon_btn sesbasic_icon_share_btn" title='<?php echo $this->translate("Share on Site")?>'><i class="fa fa-share"></i></a>
        </div>
      </div>
    <?php endif;?>
    <?php if($contactButton):?>
      <div class="_listbuttons_contact"><a href="<?php echo $this->url(array('owner_id' => $group->owner_id,'action'=>'contact'), 'sesgroup_general', true); ?>" class="sessmoothbox sesgroup_button sesbasic_animation"><i class="fa fa-envelope"></i><span><?php echo $this->translate('Contact');?></span></a></div>
    <?php endif;?>
  </div>  
<?php endif;?>
