<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _dataButton.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php  if(!$viewerId)
  return;
?>
<?php if($classroom->is_approved):?>
<?php $canComment = Engine_Api::_()->authorization()->isAllowed('eclassroom', $viewer, 'create');?>
  <?php if(isset($this->likeButtonActive) && $canComment):?>
    <?php $likeStatus = Engine_Api::_()->eclassroom()->getLikeStatus($classroom->classroom_id,$classroom->getType()); ?>
    <a href="javascript:;" data-url="<?php echo $classroom->classroom_id; ?>" data-type="eclassroom_like_view" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eclassroom_like_<?php echo $classroom->classroom_id; ?> seslisting_like_seslisting_listing eclassroom_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $classroom->like_count;?></span></a>
  <?php endif;  ?>
  <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.favourite', 1)):?>
    <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'eclassroom')->isFavourite(array('resource_id' => $classroom->classroom_id,'resource_type' => $classroom->getType())); ?>
      <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing eclassroom_likefavfollow  eclassroom_favourite_<?php echo $classroom->classroom_id; ?>  <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>" data-type="eclassroom_favourite_view" data-url="<?php echo $classroom->classroom_id; ?>"><i class="fa fa-heart"></i><span><?php echo $classroom->favourite_count;?></span></a>
  <?php endif; ?>
  <?php if(isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.follow', 1)): ?>
  <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'eclassroom')->isFollow(array('resource_id' => $classroom->classroom_id,'resource_type' => $classroom->getType()));?>
    <a href="javascript:;" data-type="eclassroom_follow_view" data-url="<?php echo $classroom->classroom_id; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn eclassroom_likefavfollow <?php echo ($followStatus) ? 'button_active' : ''; ?> eclassroom_follow_<?php echo $classroom->classroom_id; ?>"> <i class="fa fa-check"></i><span><?php echo $classroom->follow_count;?></span></a>
<?php endif; ?>

<?php endif; ?>
