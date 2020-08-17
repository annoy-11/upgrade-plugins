<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _reviewOptions.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
$item = $this->subject; 
$viewer = $this->viewer;
$store = Engine_Api::_()->getItem('stores',$item->store_id);
?>
<div class="estore_review_listing_footer clear sesbasic_clearfix">
	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.review.votes', 1)){ ?>
    <p><b><?php echo $this->translate("Was this Review...?"); ?></b></p>
    <div class="estore_review_listing_btn_left floatL">
    	<?php $isGivenVoteTypeone = Engine_Api::_()->getDbTable('reviewvotes','estore')->isReviewVote(array('review_id'=>$item->getIdentity(),'store_id'=>$store->getIdentity(),'type'=>1)); ?>
      <a class="sesbasic_button <?php if($viewer->getIdentity()){ ?> estore_review_useful <?php } ?> sesbasic_animation <?php echo $isGivenVoteTypeone ? 'active' : '' ?>" href="javascript:;" data-href="<?php echo $item->getIdentity(); ?>" data-type="1"><i></i><span class="title"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.review.first', 'Useful')); ?></span> <span><?php echo $item->useful_count ?></span></a>
      <?php $isGivenVoteTypetwo = Engine_Api::_()->getDbTable('reviewvotes','estore')->isReviewVote(array('review_id'=>$item->getIdentity(),'store_id'=>$store->getIdentity(),'type'=>2)); ?>
      <a class="sesbasic_button <?php if($viewer->getIdentity()){ ?>estore_review_funny<?php } ?> sesbasic_animation <?php echo $isGivenVoteTypetwo ? 'active' : '' ?>" href="javascript:;" data-href="<?php echo $item->getIdentity(); ?>" data-type="2"><i></i><span class="title"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.review.second', 'Funny')); ?></span> <span><?php echo $item->funny_count ?></span></a>
      <?php $isGivenVoteTypethree = Engine_Api::_()->getDbTable('reviewvotes','estore')->isReviewVote(array('review_id'=>$item->getIdentity(),'store_id'=>$store->getIdentity(),'type'=>3)); ?>
      <a class="sesbasic_button <?php if($viewer->getIdentity()){ ?>estore_review_cool<?php } ?> sesbasic_animation <?php echo $isGivenVoteTypethree ? 'active' : '' ?>" href="javascript:;" data-href="<?php echo $item->getIdentity(); ?>" data-type="3"><i></i><span class="title"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.review.third', 'Cool')); ?></span> <span><?php echo $item->cool_count ?></span></a>
    </div>
  <?php } ?>
  <?php $ownerSelf = $viewer->getIdentity() == $item->owner_id ? true : false; ?>
	<div class="estore_review_listing_btn_right floatR">
		<?php if($item->authorization()->isAllowed($viewer, 'edit') && $ownerSelf) { ?>
			<a class="fa fa-edit sesbasic_button sesbasic_button_icon <?php if($ownerSelf) { echo 'estore_own_update_review'; } ?>" href="<?php echo $this->url(array('route' => 'estorereview_view', 'action' => 'edit-review', 'review_id' => $item->review_id,'format' => 'smoothbox'),'estorereview_view',true); ?>" <?php if(!$ownerSelf) { ?> onclick='return opensmoothboxurl(this.href);' <?php  } ?> ><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Edit Review'); ?></span></a>
		<?php } ?>
		<?php if($item->authorization()->isAllowed($viewer, 'delete')) { ?>
		<a class="fa fa-trash sesbasic_button sesbasic_button_icon" href="<?php echo $this->url(array('route' => 'estorereview_view', 'action' => 'delete', 'review_id' => $item->review_id,'format' => 'smoothbox'),'estorereview_view',true); ?>" onclick='return opensmoothboxurl(this.href);'><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Delete Review'); ?></span></a>
		<?php } ?>
		<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.show.report', 1) && $viewer->getIdentity() && in_array('report', $this->stats)): ?>
		<a class="fa fa-flag sesbasic_button sesbasic_button_icon" href="<?php echo $this->url(array('route' => 'default', 'module' => 'core', 'controller' => 'report', 'action' => 'create', 'subject' => $item->getGuid(), 'format' => 'smoothbox',),'default',true); ?>" onclick='return opensmoothboxurl(this.href);'><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Report');?></span></a>
		<?php endif; ?>
		<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.share', 1) && $viewer->getIdentity() && in_array('share', $this->stats)): ?>
		<a class="fa fa-share sesbasic_button sesbasic_button_icon" href="<?php echo $this->url(array('route' => 'default', 'module' => 'activity', 'controller' => 'index', 'action' => 'share', 'type' => $item->getType(), 'id' => $item->getIdentity(), 'format' => 'smoothbox'),'default',true); ?>" onclick='return opensmoothboxurl(this.href);'><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Share Review');?></span></a>
		<?php endif; ?>
		</div>
</div>
