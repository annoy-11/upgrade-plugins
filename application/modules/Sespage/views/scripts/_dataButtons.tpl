<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataButtons.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php  if(!$viewerId)
  return;
?>
<?php if($page->is_approved):?>
  <?php $canComment = Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'comment');?>
  <?php if(isset($this->likeButtonActive) && $canComment):?>
    <?php $likeStatus = Engine_Api::_()->sespage()->getLikeStatus($page->page_id,$page->getType()); ?>
    <a href="javascript:;" data-type="like_view" data-url="<?php echo $page->page_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sespage_like_<?php echo $page->page_id ?> sespage_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $page->like_count;?></span></a>
  <?php endif;?>
  <?php if($viewerId):?>
    <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.favourite', 1)):?>
      <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sespage')->isFavourite(array('resource_id' => $page->page_id,'resource_type' => $page->getType())); ?>
      <a href="javascript:;" data-type="favourite_view" data-url="<?php echo $page->page_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sespage_favourite_<?php echo $page->page_id ?> sespage_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $page->favourite_count;?></span></a>
    <?php endif;?>
    <?php if($viewerId != $page->owner_id && isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.allow.follow', 1)):?>
      <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sespage')->isFollow(array('resource_id' => $page->page_id,'resource_type' => $page->getType())); ?>
      <a href="javascript:;" data-type="follow_view" data-url="<?php echo $page->page_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_follow_btn sespage_follow_<?php echo $page->page_id ?> sespage_likefavfollow <?php echo ($followStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-check"></i><span><?php echo $page->follow_count;?></span></a>
    <?php endif;?>
  <?php endif;?>
<?php endif;?>