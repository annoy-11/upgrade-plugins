<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercovervideo
 * @package    Sesusercovervideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: icon_button.tpl 2016-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if($this->showicontype == 2): ?>

  <?php if(in_array('editinfo',$this->option) && $this->viewer->getIdentity() == $this->subject->getIdentity()): ?>
    <div><a href='members/edit/profile/' class='sesbasic_button'><i class='fa fa-pencil'></i><span><?php  echo $this->translate("Update Info"); ?></span></a></div>
  <?php endif; ?>

  <?php if(in_array('addfriend',$this->option) && $this->viewer->getIdentity() && $this->subject->getIdentity() != $this->viewer->getIdentity()){ ?>
    <?php
      $subject = $this->subject;
      $viewer = $this->viewer;
    ?>
    <div><?php include APPLICATION_PATH .  '/application/modules/Sesbasic/views/scripts/_addfriend_button.tpl';?></div>
  <?php } ?>
  
  <?php if(in_array('message',$this->option) && Engine_Api::_()->sesbasic()->hasCheckMessage($this->subject)){ ?>
  <!-- get Message Btn -->
  <div><a href="messages/compose/to/<?php echo $this->subject->getIdentity(); ?>/format/smoothbox" class="sesbasic_button smoothbox menu_user_profile user_profile_message" target=""><i class="fa fa-envelope"></i><span><?php echo $this->translate("Send Message"); ?></span></a></div>
  <?php } ?>
  
  <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 && $this->sesmemberenable && in_array('likebtn',$this->option)){ 
    $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($this->subject->user_id,$this->subject->getType());
    $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
    $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like') ;
  ?>
  <div><a href='javascript:;' data-url='<?php echo $this->subject->getIdentity(); ?>' class='sesbasic_button sesmember_button_like_user sesmember_button_like_user_<?php echo $this->subject->user_id; ?>'><i class='fa <?php echo $likeClass; ?>'></i><span><?php  echo $likeText ; ?></span></a></div>
  <?php } ?>
  
  <?php if($this->sesmemberenable && in_array('followbtn',$this->option) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.active',1)  && !Engine_Api::_()->user()->getViewer()->isSelf($this->subject)){ 
    $FollowUser = Engine_Api::_()->sesmember()->getFollowStatus($this->subject->user_id);
    $followClass = (!$FollowUser) ? 'fa-check' : 'fa-times' ;
    $followText = ($FollowUser) ?  $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.unfollowtext','Unfollow')) : $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.followtext','Follow')) ;
  ?>
  <div>
  <a href='javascript:;' data-url='<?php echo $this->subject->getIdentity(); ?>' class='sesbasic_button sesmember_follow_user sesmember_follow_user_<?php echo $this->subject->getIdentity(); ?>'><i class='fa <?php echo $followClass; ?>'  title='<?php echo $followText ; ?>'></i> <span><?php echo $followText; ?></span></a>
  </div>
  <?php } ?>
  
  
  <?php if(($this->module == 'user' || $this->module == 'sesmember') && $this->controller == 'profile' && $this->action == 'index'): ?>
    <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 && in_array('options',$this->option)){ ?>
      <div><a href="javascript:void(0);" class="sesbasic_button sesusercover_option_btn fa fa-cog" id="parent_container_option"></a></div>
    <?php } ?>
  <?php endif; ?>

<?php else: ?>
  <?php if(in_array('editinfo',$this->option) && $this->viewer->getIdentity() == $this->subject->getIdentity()): ?>
    <div><a href='members/edit/profile/' class='sesbasic_btn'><i class='fa fa-pencil'></i><span><i class='fa fa-caret-down'></i><?php  echo $this->translate("Update Profile"); ?></span></a></div>
  <?php endif; ?>
  
  <?php if(in_array('addfriend',$this->option) && $this->viewer->getIdentity() && $this->subject->getIdentity() != $this->viewer->getIdentity()){ ?>
    <?php
      $subject = $this->subject;
      $viewer = $this->viewer;
    ?>
    <div><?php include APPLICATION_PATH .  '/application/modules/Sesbasic/views/scripts/_addfriend.tpl';?></div>
  <?php } ?>
  
  <?php if(in_array('message',$this->option) && Engine_Api::_()->sesbasic()->hasCheckMessage($this->subject)){ ?>
  <!-- get Message Btn -->
  <div><a href="messages/compose/to/<?php echo $this->subject->getIdentity(); ?>/format/smoothbox" class="sesbasic_btn smoothbox menu_user_profile user_profile_message" target=""><i class="fa fa-envelope"></i><span><i class="fa fa-caret-down"></i><?php echo $this->translate("Send Message"); ?></span></a></div>
  <?php } ?>
  <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 && $this->sesmemberenable && in_array('likebtn',$this->option)){ 
    $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($this->subject->user_id,$this->subject->getType());
    $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
    $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like') ;
  ?>
  <div><a href='javascript:;' data-url='<?php echo $this->subject->getIdentity(); ?>' class='sesbasic_btn sesmember_button_like_user sesmember_button_like_user_<?php echo $this->subject->user_id; ?>'><i class='fa <?php echo $likeClass; ?>'></i><span><i class='fa fa-caret-down'></i><?php  echo $likeText ; ?></span></a></div>
  <?php } ?>
  <?php if($this->sesmemberenable && in_array('followbtn',$this->option) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.active',1)  && !Engine_Api::_()->user()->getViewer()->isSelf($this->subject)){ 
    $FollowUser = Engine_Api::_()->sesmember()->getFollowStatus($this->subject->user_id);
    $followClass = (!$FollowUser) ? 'fa-check' : 'fa-times' ;
    $followText = ($FollowUser) ?  $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.unfollowtext','Unfollow')) : $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.followtext','Follow')) ;
  ?>
  <div>
  <a href='javascript:;' data-url='<?php echo $this->subject->getIdentity(); ?>' class='sesbasic_btn sesmember_follow_user sesmember_follow_user_<?php echo $this->subject->getIdentity(); ?>'><i class='fa <?php echo $followClass; ?>'  title='<?php echo $followText ; ?>'></i> <span><i class='fa fa-caret-down'></i><?php echo $followText; ?></span></a>
  </div>
  <?php } ?>
  <?php if(($this->module == 'user' || $this->module == 'sesmember') && $this->controller == 'profile' && $this->action == 'index'): ?>
    <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 && in_array('options',$this->option)){ ?>
      <div><a href="javascript:void(0);" class="sesbasic_btn sesusercover_option_btn fa fa-ellipsis-h" id="parent_container_option"><span><i class='fa fa-caret-down'></i><?php echo $this->translate('Options'); ?></span></a></div>
    <?php } ?>
  <?php endif; ?>
<?php endif; ?>