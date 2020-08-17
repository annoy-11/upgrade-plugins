<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _ratingOptions.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $item = $this->subject; $viewer = $this->viewer;?>
<div class="sesarticle_review_listing_footer clear sesbasic_clearfix">
	<?php if(in_array('socialSharing', $this->stats) || in_array('likeButton', $this->stats)):?>
		<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
		<div class="sesarticle_review_article_social_btn floatL"> 
		  <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
			<?php if(in_array('likeButton', $this->stats) && $canComment):?>
				<?php $LikeStatus = Engine_Api::_()->sesarticle()->getLikeStatus($item->review_id,$item->getType()); ?>
				<a href="javascript:;" data-url="<?php echo $item->review_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesarticle_like_sesarticle_review_<?php echo $item->review_id ?> sesarticle_like_sesarticle_review <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
			<?php endif;?>
			<?php if(in_array('socialSharing', $this->stats)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1)):?>
        
        <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

			<?php endif;?>
		</div>  
	<?php endif;?>
  <?php $ownerSelf = $viewer->getIdentity() == $item->owner_id ? true : false; ?>
	<div class="sesarticle_review_listing_btn_right floatR">
		<?php if($item->authorization()->isAllowed($viewer, 'edit')) { ?>     
			<a class="fa fa-pencil sesbasic_button sesbasic_button_icon <?php if($ownerSelf) { echo 'sesarticle_own_update_review'; } ?>" href="<?php echo $this->url(array('route' => 'sesarticlereview_view', 'action' => 'edit', 'review_id' => $item->review_id,'format' => 'smoothbox'),'sesarticlereview_view',true); ?>" <?php if(!$ownerSelf) { ?> onclick='return opensmoothboxurl(this.href);' <?php  } ?> ><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Edit Review'); ?></span></a>
		<?php } ?>
		<?php if($item->authorization()->isAllowed($viewer, 'delete')) { ?>     
		<a class="fa fa-trash sesbasic_button sesbasic_button_icon" href="<?php echo $this->url(array('route' => 'sesarticlereview_view', 'action' => 'delete', 'review_id' => $item->review_id,'format' => 'smoothbox'),'sesarticlereview_view',true); ?>" onclick='return opensmoothboxurl(this.href);'><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Delete Review'); ?></span></a>
		<?php } ?>
		<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.show.report', 1) && $viewer->getIdentity() && in_array('report', $this->stats) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.report', 1)): ?>
		<a class="fa fa-flag sesbasic_button sesbasic_button_icon" href="<?php echo $this->url(array('route' => 'default', 'module' => 'core', 'controller' => 'report', 'action' => 'create', 'subject' => $item->getGuid(), 'format' => 'smoothbox',),'default',true); ?>" onclick='return opensmoothboxurl(this.href);'><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Report');?></span></a>
		<?php endif; ?>
		<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.allow.share', 1) && $viewer->getIdentity() && in_array('share', $this->stats)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1)): ?>
		<a class="fa fa-share sesbasic_button sesbasic_button_icon" href="<?php echo $this->url(array('route' => 'default', 'module' => 'activity', 'controller' => 'index', 'action' => 'share', 'type' => $item->getType(), 'id' => $item->getIdentity(), 'format' => 'smoothbox'),'default',true); ?>" onclick='return opensmoothboxurl(this.href);'><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Share Review');?></span></a> 
		<?php endif; ?>
		</div>
</div>