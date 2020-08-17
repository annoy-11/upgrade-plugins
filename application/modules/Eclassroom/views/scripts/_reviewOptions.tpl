<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _reviewOption.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php 
$item = $this->subject; 
$viewer = $this->viewer;
$classroom = Engine_Api::_()->getItem('classroom',$item->classroom_id);
?>
<div class="eclassroom_review_listing_footer clear sesbasic_clearfix">
	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.review.votes', 1)){ ?>
    <p><b><?php echo $this->translate("Was this Review...?"); ?></b></p>
    <div class="eclassroom_review_listing_btn_left floatL">
    	<?php $isGivenVoteTypeone = Engine_Api::_()->getDbTable('reviewvotes','eclassroom')->isReviewVote(array('review_id'=>$item->getIdentity(),'classroom_id'=>$classroom->getIdentity(),'type'=>1)); ?>
      <a class="sesbasic_button <?php if($viewer->getIdentity()){ ?> eclassroom_review_useful <?php } ?> sesbasic_animation <?php echo $isGivenVoteTypeone ? 'active' : '' ?>" href="javascript:;" data-href="<?php echo $item->getIdentity(); ?>" data-type="1"><i></i><span class="title"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.review.first', 'Useful')); ?></span> <span><?php echo $item->useful_count ?></span></a>
      <?php $isGivenVoteTypetwo = Engine_Api::_()->getDbTable('reviewvotes','eclassroom')->isReviewVote(array('review_id'=>$item->getIdentity(),'classroom_id'=>$classroom->getIdentity(),'type'=>2)); ?>
      <a class="sesbasic_button <?php if($viewer->getIdentity()){ ?>eclassroom_review_funny<?php } ?> sesbasic_animation <?php echo $isGivenVoteTypetwo ? 'active' : '' ?>" href="javascript:;" data-href="<?php echo $item->getIdentity(); ?>" data-type="2"><i></i><span class="title"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.review.second', 'Funny')); ?></span> <span><?php echo $item->funny_count ?></span></a>
      <?php $isGivenVoteTypethree = Engine_Api::_()->getDbTable('reviewvotes','eclassroom')->isReviewVote(array('review_id'=>$item->getIdentity(),'classroom_id'=>$classroom->getIdentity(),'type'=>3)); ?>
      <a class="sesbasic_button <?php if($viewer->getIdentity()){ ?>eclassroom_review_cool<?php } ?> sesbasic_animation <?php echo $isGivenVoteTypethree ? 'active' : '' ?>" href="javascript:;" data-href="<?php echo $item->getIdentity(); ?>" data-type="3"><i></i><span class="title"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.review.third', 'Cool')); ?></span> <span><?php echo $item->cool_count ?></span></a>
    </div>
  <?php } ?>
  <?php $ownerSelf = $viewer->getIdentity() == $item->owner_id ? true : false; ?>
	<div class="eclassroom_review_listing_btn_right floatR">
		<?php if($item->authorization()->isAllowed($viewer, 'edit') && $ownerSelf) { ?>
			<a class="fa fa-pencil sesbasic_button sesbasic_button_icon sessmoothbox <?php if($ownerSelf) { echo 'eclassroom_own_update_review'; } ?>" href="<?php echo $this->url(array('route' => 'eclassroomreview_view', 'action' => 'edit-review', 'review_id' => $item->review_id,'format' => 'smoothbox'),'eclassroomreview_view',true); ?>" <?php if(!$ownerSelf) { ?> onclick='return opensmoothboxurl(this.href);' <?php  } ?> ><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Edit Review'); ?></span></a>
		<?php } ?>
		<?php if($item->authorization()->isAllowed($viewer, 'delete')) { ?>
		<a class="fa fa-trash sesbasic_button sesbasic_button_icon" href="<?php echo $this->url(array('route' => 'eclassroomreview_view', 'action' => 'delete', 'review_id' => $item->review_id,'format' => 'smoothbox'),'eclassroomreview_view',true); ?>" onclick='return opensmoothboxurl(this.href);'><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Delete Review'); ?></span></a>
		<?php } ?>
		<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.show.report', 1) && $viewer->getIdentity() && in_array('report', $this->stats)): ?>
		<a class="fa fa-flag sesbasic_button sesbasic_button_icon" href="<?php echo $this->url(array('route' => 'default', 'module' => 'core', 'controller' => 'report', 'action' => 'create', 'subject' => $item->getGuid(), 'format' => 'smoothbox',),'default',true); ?>" onclick='return opensmoothboxurl(this.href);'><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Report');?></span></a>
		<?php endif; ?>
		<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.share', 1) && $viewer->getIdentity() && in_array('share', $this->stats)): ?>
		<a class="fa fa-share sesbasic_button sesbasic_button_icon" href="<?php echo $this->url(array('route' => 'default', 'module' => 'activity', 'controller' => 'index', 'action' => 'share', 'type' => $item->getType(), 'id' => $item->getIdentity(), 'format' => 'smoothbox'),'default',true); ?>" onclick='return opensmoothboxurl(this.href);'><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Share Review');?></span></a>
		<?php endif; ?>
		</div>
</div>
