<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataSharing.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $store = empty($this->mapstore) ? $store : $this->mapstore;?>
<?php $contactButton = empty($this->contactButton) ? isset($this->contactButtonActive) : $this->contactButton;?>
<?php $joinButton = empty($this->joinButton) ? isset($this->joinButtonActive) : $this->joinButton;?>
<?php $socialSharing = empty($this->socialSharing) ? isset($this->socialSharingActive) : $this->socialSharing;?>
<?php if($store->is_approved):?>

<div class="estore_sharebtn_list sesbasic_bxs sesbasic_clearfix">
  <div class="_listbuttons _joineneble">
    <?php if($this->contactButtonActive): ?>
      <div class="_listbuttons_contact"><a href="<?php echo $this->url(array('owner_id' => $store->owner_id,'action'=>'contact'), 'estore_general', true); ?>" class="sessmoothbox estore_button sesbasic_animation"><i class="fa fa-envelope"></i><span><?php echo $this->translate('Contact');?></span></a></div>
    <?php endif;?>
    <?php $levelId = ($viewerId) ? $viewer->level_id : 5;?>
    <?php $canJoin = Engine_Api::_()->authorization()->getPermission($levelId, 'stores', 'bs_can_join');?>
    <?php if($canJoin && $this->joinButtonActive): ?>
    <div class="_listbuttons_join">
      <?php $store = Engine_Api::_()->getItem('stores',$store->store_id);?>
      <?php if($viewerId):?>
      <?php $row = $store->membership()->getRow($viewer);?>
      <?php if(null === $row):?>
      <?php if($store->membership()->isResourceApprovalRequired()):?>
      <?php $action = 'request';?>
      <?php else:?>
      <?php $action = 'join';?>
      <?php endif;?>
      <a href="<?php echo $this->url(array('controller' => 'member','action' => $action,'store_id' => $store->store_id),'estore_extended',true);?>" class="openSmoothbox estore_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
      <?php else:?>
      <?php if($row->active):?>
      <a href="javascript:void(0);" class="estore_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Joined');?></span></a>
      <?php else:?>
      <a href="javascript:void(0);" id="estore_user_approval" class="estore_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Requested');?></span></a>
      <?php endif;?>
      <?php endif;?>
      <?php else:?>
      <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" id="estore_user_approval" class="smoothbox estore_button sesbasic_animation"><i class="fa fa-plus"></i><span><?php echo $this->translate('Join');?></span></a>
      <?php endif;?>
    </div>
    <?php endif;?>
    <?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.share', 1);?>
    <?php if($this->socialSharingActive && $shareType):?>
    <div class="_listbuttons_share"> <a href="javascript:void(0);" class="estore_button sesbasic_animation estore_button_toggle"><i class="fa fa-share-alt"></i><span><?php echo $this->translate('Share');?></span></a>
      <div class="estore_listing_share_popup">
       <!-- <p><?php echo $this->translate("Share This Store");?></p>-->
        <?php if($shareType == 2): ?>
        <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $store, 'socialshare_enable_plusicon' => $this->params["socialshare_enable_plusicon"], 'socialshare_icon_limit' => $this->params["socialshare_icon_limit"])); ?>
        <?php endif;?>
        <a href="<?php echo $this->url(array('module' => 'activity','controller' => 'index','action' => 'share','type' => $store->getType(),'id' => $store->getIdentity(),'format' => 'smoothbox'),'default',true);?>" class="openSmoothbox sesbasic_icon_btn sesbasic_icon_share_btn" title='<?php echo $this->translate("Share on Site")?>'><i class="fa fa-share"></i></a> </div>
    </div>
    <?php endif;?>
  </div>
  <?php endif;?>
</div>
