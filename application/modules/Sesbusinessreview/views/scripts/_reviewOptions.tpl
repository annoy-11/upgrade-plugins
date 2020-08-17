<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _reviewOptions.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $item = $this->subject; $viewer = $this->viewer;?>
<div class="sesbusinessreview_review_listing_footer clear sesbasic_clearfix">
  <?php if(in_array('voteButton', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.review.votes', 1)){ ?>
    <p><b><?php echo $this->translate("SESBUSINESS Was this Review...?"); ?></b></p>
    <div class="sesbusinessreview_review_listing_btn_left floatL">
      <?php $isGivenVoteTypeone = Engine_Api::_()->getDbTable('reviewvotes','sesbusinessreview')->isReviewVote(array('review_id'=>$item->getIdentity(),'user_id'=>$viewer->getIdentity(),'type'=>1)); ?>
      <a class="sesbasic_button <?php if($viewer->getIdentity()){ ?> sesbusinessreview_review_useful <?php } ?> sesbasic_animation <?php echo $isGivenVoteTypeone ? 'active' : '' ?>" href="javascript:;" data-href="<?php echo $item->getIdentity(); ?>" data-type="1"><i></i><span class="title"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.review.first', 'Useful')); ?></span> <span><?php echo $item->useful_count ?></span></a>
      <?php $isGivenVoteTypetwo = Engine_Api::_()->getDbTable('reviewvotes','sesbusinessreview')->isReviewVote(array('review_id'=>$item->getIdentity(),'user_id'=>$viewer->getIdentity(),'type'=>2)); ?>
      <a class="sesbasic_button <?php if($viewer->getIdentity()){ ?>sesbusinessreview_review_funny<?php } ?> sesbasic_animation <?php echo $isGivenVoteTypetwo ? 'active' : '' ?>" href="javascript:;" data-href="<?php echo $item->getIdentity(); ?>" data-type="2"><i></i><span class="title"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.review.second', 'Funny')); ?></span> <span><?php echo $item->funny_count ?></span></a>
      <?php $isGivenVoteTypethree = Engine_Api::_()->getDbTable('reviewvotes','sesbusinessreview')->isReviewVote(array('review_id'=>$item->getIdentity(),'user_id'=>$viewer->getIdentity(),'type'=>3)); ?>
      <a class="sesbasic_button <?php if($viewer->getIdentity()){ ?>sesbusinessreview_review_cool<?php } ?> sesbasic_animation <?php echo $isGivenVoteTypethree ? 'active' : '' ?>" href="javascript:;" data-href="<?php echo $item->getIdentity(); ?>" data-type="3"><i></i><span class="title"><?php echo $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.review.third', 'Cool')); ?></span> <span><?php echo $item->cool_count ?></span></a>
    </div>
  <?php } ?>
  <?php $ownerSelf = $viewer->getIdentity() == $item->owner_id ? true : false; ?>
  <div class="sesbusinessreview_review_listing_btn_right floatR">
    <?php if(in_array('likeButton', $this->stats) && $item->authorization()->isAllowed($viewer, 'comment')): ?>
      <?php $likeStatus = Engine_Api::_()->sesbusinessreview()->getLikeStatus($item->review_id,$item->getType()); ?>
      <div class="sesbusinessreview_grid_btns">
        <a href="javascript:;" data-type="like_view" data-url="<?php echo $item->review_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesbusinessreview_like_<?php echo $item->review_id ?> sesbusinessreview_like <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count;?></span></a>
      </div>
    <?php endif;?>
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.show.report', 1) && $viewer->getIdentity() && in_array('report', $this->stats)): ?>
      <div><a class="sesbasic_icon_btn" href="<?php echo $this->url(array('route' => 'default', 'module' => 'core', 'controller' => 'report', 'action' => 'create', 'subject' => $item->getGuid(), 'format' => 'smoothbox',),'default',true); ?>" onclick='return opensmoothboxurl(this.href);'><i class="fa fa-flag"></i><!-- <span><?php echo $this->translate('Report');?></span> --></a></div>
    <?php endif; ?>
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.allow.share', 1) && $viewer->getIdentity() && in_array('share', $this->stats)): ?>
      <div class="_listbuttons_share">
        <a href="javascript:void(0);" class="sesbasic_icon_btn sesbasic_animation sesbusiness_button_toggle"><i class="fa fa-share-alt"></i></a>
        <div class="sesbusinessreview_listing_share_popup">
          <p><?php echo $this->translate("Share This Business");?></p>
          <?php if(isset($this->socialshare_enable_plusicon)):?>
            <?php $socialsharePlusIcon = $this->socialshare_enable_plusicon;?>
            <?php $socialshareLimit =    $this->socialshare_icon_limit;?>
          <?php else:?>
            <?php $socialsharePlusIcon = $this->params["socialshare_enable_plusicon"];?>
            <?php $socialshareLimit = $this->params["socialshare_icon_limit"];?>
          <?php endif;?>
          <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $socialsharePlusIcon, 'socialshare_icon_limit' => $socialshareLimit)); ?>
          <a href="<?php echo $this->url(array('module' => 'activity','controller' => 'index','action' => 'share','type' => $item->getType(),'id' => $item->getIdentity(),'format' => 'smoothbox'),'default',true);?>" class="openSmoothbox sesbasic_icon_btn sesbasic_icon_share_btn" title='<?php echo $this->translate("Share on Site")?>'><i class="fa fa-share"></i></a>
        </div>
      </div> 
    <?php endif; ?>
    <?php if($item->authorization()->isAllowed($viewer, 'edit')) { ?>     
        <?php if(isset($this->updateReview)):?>
          <div><a id="sesbusinessreview_edit_button" href="javascript:void(0)" onclick="showReviewForm();" class="sesbasic_icon_btn"><i class="fa fa-pencil"></i><span><?php echo $this->translate('SESBUSINESS Edit Review'); ?></span></a></div>
        <?php else:?>
          <div><a class="sesbasic_icon_btn sessmoothbox <?php if($ownerSelf) { echo 'sesbusinessreview_own_update_review'; } ?>" href="<?php echo $this->url(array('route' => 'sesbusinessreview_view', 'action' => 'edit-review', 'review_id' => $item->review_id),'sesbusinessreview_view',true); ?>" <?php if(!$ownerSelf) { ?> onclick='return opensmoothboxurl(this.href);' <?php  } ?> ><i class="fa fa-pencil"></i></a></div>
        <?php endif;?>
      <?php } ?>
    <?php if($item->authorization()->isAllowed($viewer, 'delete')) { ?>     
      <div><a class="sesbasic_icon_btn" href="<?php echo $this->url(array('route' => 'sesbusinessreview_view', 'action' => 'delete', 'review_id' => $item->review_id),'sesbusinessreview_view',true); ?>" onclick='return opensmoothboxurl(this.href);'><i class="fa fa-trash"></i></a></div>
    <?php } ?>
  </div>
</div>