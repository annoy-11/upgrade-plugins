<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if (!empty($this->viewer_id)): ?>
  <?php $likeStatus = Engine_Api::_()->eclassroom()->getLikeStatus($this->subject->classroom_id,$this->subject->getType()); ?>
  <?php $likeClass = (!$likeStatus) ? 'fa fa-thumbs-up' : 'fa fa-thumbs-down' ;?>
  <?php $likeText = ($likeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
  <div class="eclassroom_sidebar_button">
    <a href='javascript:;' data-type='like_classroom_button_view' data-url='<?php echo $this->subject->getIdentity(); ?>' data-status='<?php echo $likeStatus;?>' class="sesbasic_animation eclassroom_link_btn eclassroom_likefavfollow eclassroom_like_view_<?php echo $this->subject->getIdentity(); ?> eclassroom_like_classroom_view"><i class='fa <?php echo $likeClass ; ?>'></i><span style="display:none"><?php echo $this->subject->like_count; ?></span><span><?php echo $likeText; ?></span></a>
  </div>
<?php endif; ?>
