<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _dataSharing.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php  $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $contactButton = empty($this->contactButton) ? isset($this->contactButtonActive) : $this->contactButton;?>
<?php $joinButton = empty($this->joinButton) ? isset($this->joinButtonActive) : $this->joinButton;?>
<?php $socialSharing = empty($this->socialSharing) ? isset($this->socialSharingActive) : $this->socialSharing;?>
<?php if($classroom->is_approved): ?>
  <?php $levelId = ($viewerId) ? $viewer->level_id : 5;?>
  <?php $canJoin = Engine_Api::_()->authorization()->getPermission($levelId, 'eclassroom', 'bs_can_join');?>
  <?php if($canJoin && $this->joinButtonActive): ?>
    <?php if($viewerId):?>
      <?php $row = $classroom->membership()->getRow($viewer);?>
      <?php if(null === $row): ?>
        <?php if($classroom->membership()->isResourceApprovalRequired()): ?>
          <?php $action = 'request';?>
        <?php else:?>
          <?php $action = 'join';?>
        <?php endif;?>
        <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'classroom_id' => $classroom->classroom_id),'eclassroom_extended',true);?>" class="join_btn openSmoothbox sesbasic_animation"><i class="fa fa-plus"></i></a>
      <?php else:?>
        <?php if($row->active):?>
          <a href="javascript:void(0);" class="join_btn sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
        <?php else:?>
          <a href="javascript:void(0);" id="courses_user_approval" class="join_btn sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
        <?php endif;?>
      <?php endif;?>
    <?php else:?>
      <a href="<?php echo $this->url(array('action' => 'show-login-page'),'eclassroom_extended',true);?>" id="courses_user_approval" class="smoothbox join_btn sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
    <?php endif;?>
    <?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.share', 1); ?>
    <?php if($this->socialSharingActive && $shareType):?>
        <?php if($shareType == 2): ?>
          <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $classroom, 'socialshare_enable_plusicon' => $this->params["socialshare_enable_plusicon"], 'socialshare_icon_limit' => $this->params["socialshare_icon_limit"])); ?>
        <?php endif;?>
      <a href="<?php echo $this->url(array('module' => 'activity','controller' => 'index','action' => 'share','type' => $classroom->getType(),'id' => $classroom->getIdentity(),'format' => 'smoothbox'),'default',true);?>" class="openSmoothbox share_btn"><i class="fa fa-share-alt"></i></a>
    <?php endif;?>
  <?php endif;?>
<?php endif;?>
