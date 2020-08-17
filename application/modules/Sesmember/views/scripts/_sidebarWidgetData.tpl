<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _sideabtWidgetData.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/member/membership.js'); ?>
<?php foreach( $this->results as $member ): ?>
<?php $userInfoItem = Engine_Api::_()->sesmember()->getUserInfoItem($member->user_id); ?>
<?php if(isset($widgetName) && $widgetName == 'peopleyoumayknow'):?>
  <?php $member = Engine_Api::_()->getItem('user', $member['mid']);?>
<?php endif;?>
<?php if($this->view_type == 'list'){ ?>
  <li class="sesmember_sidebar_list <?php if($this->image_type == 'rounded'):?>sesmember_sidebar_image_rounded<?php endif;?> sesbasic_clearfix">
    <?php echo $this->htmlLink($member, $this->itemPhoto($member, 'thumb.main'), array('class'=>'sesbasic_animation')); ?>
    <div class="sesmember_sidebar_list_info">
    <div class="clear">
      <?php  if(isset($this->titleActive)){ ?>
        <span class="sesmember_sidebar_list_title">
          <?php if(strlen($member->getTitle()) > $this->title_truncation_list){
          $title = mb_substr($member->getTitle(),0,($this->title_truncation_list-3)).'...';
          echo $this->htmlLink($member->getHref(),$title, array('class' => 'ses_tooltip', 'data-src' => $member->getGuid()));
          } else { ?>
          <?php echo $this->htmlLink($member->getHref(),$member->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $member->getGuid())) ?>
          <?php } ?>
        </span>
      <?php } ?>
      <?php if(isset($this->verifiedLabelActive) && $userInfoItem->user_verified == 1): ?>
	<i class="sesmember_verified_sign_<?php echo $member->user_id?> sesmember_verified_sign fa fa-check-circle"  title="Verified"></i>
      <?php else: ?>
	<i class="sesmember_verified_sign_<?php echo $member->user_id?> sesmember_verified_sign fa fa-check-circle" style="display:none;"></i>
      <?php endif;?>
      </div>
      <?php if(Engine_Api::_()->getApi('core', 'sesmember')->allowReviewRating() && $this->ratingActive):?>
	<?php echo $this->partial('_userRating.tpl', 'sesmember', array('rating' => $userInfoItem->rating)); ?>
      <?php endif;?>
      <?php if(isset($this->profileTypeActive)): ?>
	<div class="sesmember_list_stats sesmember_list_membertype "> 
	  <span class="widthfull"><i class="fa fa-user"></i><span><?php echo Engine_Api::_()->sesmember()->getProfileType($member);?></span></span>
        </div>
      <?php endif;?>
      <?php $memberAge =  $this->partial('_userAge.tpl', 'sesmember', array('ageActive' => $this->ageActive, 'member' => $member)); ?>
      <?php if($memberAge != ''):?>
        <?php echo $memberAge;?>
      <?php endif;?>
      <?php if(isset($this->locationActive) && $userInfoItem->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.enable.location', 1)): ?>
        <div class="sesmember_list_stats sesmember_list_location">
          <span class="widthfull"><i class="fa fa-map-marker"></i><span><a href="<?php echo $this->url(array('resource_id' => $member->user_id,'resource_type'=>'user','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="opensmoothboxurl" title="<?php echo $userInfoItem->location; ?>"><?php echo $userInfoItem->location ?></a></span></span>
        </div>
      <?php endif; ?>
      <?php if(Engine_Api::_()->getApi('settings', 'core')->user_friends_eligible):?>
        <?php if(isset($this->friendCountActive) && $friendsM = $member->membership()->getMemberCount($member)): ?>  
          <div class="sesmember_list_stats">
            <span class="widthfull"><i class="fa fa-users"></i><span><a href="<?php echo $this->url(array('user_id' => $member->user_id,'action'=>'get-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="opensmoothboxurl"><?php echo  $friendsM. $this->translate(' Friends');?></a></span></span>
          </div>
      	<?php endif;?>
        <?php if(isset($this->mutualFriendCountActive) && ($viewer->getIdentity() && !$viewer->isSelf($member)) && $mfriends = Engine_Api::_()->sesmember()->getMutualFriendCount($member, $viewer)): ?> 
          <div class="sesmember_list_stats">
            <span class="widthfull"><i class="fa fa-users"></i><span><a href="<?php echo $this->url(array('user_id' => $member->user_id,'action'=>'get-mutual-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="opensmoothboxurl"><?php echo   $mfriends. $this->translate(' Mutual Friends');?></a></span></span>
          </div>
	    	<?php endif;?>
      <?php endif;?>
      <?php if(isset($this->emailActive)): ?> 
        <div class="sesmember_list_stats sesmember_email_list">
          <span class="widthfull"><i class="fa fa-envelope"></i><span><?php echo $member->email;?></span></span>
        </div>
			<?php endif;?>
      <?php if(isset($member->review_count) && isset($this->ratingActive)):?>
        <div class="sesmember_list_stats">
          <span class="widthfull"><i class="fa fa-comments"></i><span><?php echo $this->translate('Total Reviews: ').$member->review_count;?></span></span>
        </div>
      <?php endif;?>
      <div class="sesmember_list_stats">
        <?php if(isset($this->likeActive) && isset($member->like_count)) { ?>
	  <span title="<?php echo $this->translate(array('%s like', '%s likes', $member->like_count), $this->locale()->toNumber($member->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $member->like_count; ?></span>
        <?php } ?>
        <?php if(isset($this->viewActive) && isset($member->view_count)) { ?>
	  <span title="<?php echo $this->translate(array('%s view', '%s views', $member->view_count), $this->locale()->toNumber($member->view_count))?>"><i class="fa fa-eye "></i><?php echo $member->view_count; ?></span>
        <?php } ?>
        <?php if(Engine_Api::_()->getApi('core', 'sesmember')->allowReviewRating() && $this->ratingActive && Engine_Api::_()->sesbasic()->getViewerPrivacy('sesmember_review', 'view')){
          echo '<span title="'.$this->translate(array('%s rating', '%s ratings', $userInfoItem->rating), $this->locale()->toNumber($userInfoItem->rating)).'"><i class="fa fa-star"></i>'.round($userInfoItem->rating,1).'/5'. '</span>';
        }
        ?>
        <?php if(isset($userInfoItem->compliment_count)):?>
          <?php $titleCompliment = $this->title;?>
          <span title='<?php echo $this->translate(array("%s $titleCompliment", "%s $titleCompliment.'s'", $userInfoItem->compliment_count), $this->locale()->toNumber($userInfoItem->compliment_count)); ?>'><i class="fa fa-smile-o"></i><?php echo $userInfoItem->compliment_count; ?></span>
        <?php endif;?>
      </div>
      <div class="sesmember_sidebar_list_btns clear">    
        <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->friendButtonActive)):?>
          <?php echo '<span>'.$this->partial('_addfriend.tpl', 'sesbasic', array('subject' => $member)).'</span>'; ?>
        <?php endif;?>
        <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->likemainButtonActive)):?>
          <?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($member->user_id,$member->getType());?>
          <?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
          <?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like') ;?>
          <?php echo "<span><a href='javascript:;' data-url='".$member->getIdentity()."' class='sesbasic_btn sesmember_add_btn sesmember_button_like_user sesmember_button_like_user_". $member->user_id."'><i class='fa ".$likeClass."'></i><span><i class='fa fa-caret-down'></i>$likeText</span></a></span>";?>
        <?php endif;?>
        <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.active',1) && !Engine_Api::_()->user()->getViewer()->isSelf($member)){
/*          $FollowUser = Engine_Api::_()->sesmember()->getFollowStatus($member->user_id);
          $followClass = (!$FollowUser) ? 'fa-check' : 'fa-times' ;
          $followText = ($FollowUser) ? $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.unfollowtext','Unfollow')) : $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.followtext','Follow'))  ;
          echo "<span><a href='javascript:;' data-url='".$member->getIdentity()."' class='sesbasic_btn sesmember_add_btn sesmember_follow_user sesmember_follow_user_".$member->getIdentity()."'><i class='fa ".$followClass."'></i> <span><i class='fa fa-caret-down'></i>$followText</span></a></span>";*/ 
          echo $this->partial('_followmembers.tpl', 'sesmember', array('subject' => $member));
        }
        ?>
        <?php if (Engine_Api::_()->sesbasic()->hasCheckMessage($member) && isset($this->messageActive)): ?>
          <?php $baseUrl = $this->baseUrl();?>
          <?php $messageText = $this->translate('Message');?>
          <?php echo "<span><a href=\"$baseUrl/messages/compose/to/$member->user_id\" target=\"_parent\" title=\"$messageText\" class=\"smoothbox sesbasic_btn sesmember_add_btn\"><i class=\"fa fa-commenting-o\"></i><span><i class=\"fa fa-caret-down\"></i>Message</span></a></span>"; ?>
        <?php endif; ?> 
      </div>
    </div>
  </li>
<?php }else if($this->view_type == 'gridInside'){ ?>
  <li class="sesmember_grid_view_three sesbasic_clearfix sesbasic_bxs sesmember_grid_btns_wrap sesmember_grid_view_three_sidebar" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
  <div class="sesmember_grid_view_three_inner sesbasic_clearfix <?php if($this->image_type == 'rounded'){?>_isrounded<?php } else { ?>_norounded<?php } ?> <?php if(isset($this->vipLabelActive) && $userInfoItem->vip):?> sesmeber_thumb_active_vip<?php endif; ?>">
    <div class="sesmember_grid_view_three_thumb sesbasic_clearfix" style="height:<?php echo is_numeric($this->photo_height) ? $this->photo_height.'px' : $this->photo_height ?>;width:<?php echo is_numeric($this->photo_width) ? $this->photo_width.'px' : $this->photo_width ?>;">
      <?php $href = $member->getHref();$imageURL = $member->getPhotoUrl('thumb.main');?>
      <a href="<?php echo $href; ?>" class="sesmember_grid_view_three_thumb_img member_of_day-thumb_img">
        <span class="sesmember_thumb"><img src="<?php echo $imageURL; ?>" alt=""/></span>
      </a>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
      <div class="sesmember_labels">
        <?php if(isset($this->featuredLabelActive) && $userInfoItem->featured){ ?>
        <p class="sesmember_label_featured"><?php echo $this->translate('FEATURED');?></p>
        <?php } ?>
        <?php if(isset($this->sponsoredLabelActive) && $userInfoItem->sponsored){ ?>
        <p class="sesmember_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
        <?php } ?>
      </div>
      <?php } ?>
      <?php if(isset($this->verifiedLabelActive) && $userInfoItem->user_verified == 1){ ?>
      <?php } ?>
      <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)) {
      $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $member->getHref()); ?>
        <div class="sesmember_grid_btns"> 
          <?php if(isset($this->socialSharingActive)){ ?>
            
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $member, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

          <?php } ?>
          <?php if(isset($this->likeButtonActive)):?>
            <?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($member->user_id,$member->getType());?>
            <?php $likeClass = ($LikeStatus) ? ' button_active' : '' ;?>
            <a href='javascript:;' data-url="<?php echo $member->user_id;?>" class="sesbasic_icon_btn sesmember_like_user_<?php echo $member->user_id;?> sesbasic_icon_btn_count sesbasic_icon_like_btn sesmember_like_user <?php echo $likeClass;?>"><i class='fa fa-thumbs-up'></i><span><?php echo $member->like_count;?></span></a>
          <?php endif;?>
        </div>
      <?php } ?>
    </div>
   	<div class="sesmember_grid_view_main_info_bototm" style="height:<?php echo is_numeric($this->photo_height) ? $this->photo_height.'px' : $this->photo_height ?>;width:<?php echo is_numeric($this->photo_width) ? $this->photo_width.'px' : $this->photo_width ?>;">
   	  <?php if(isset($this->profileTypeActive)): ?>
	    <div class="sesmember_list_stats sesmember_list_membertype "> 
	      <span><i class="fa fa-user"></i><?php echo Engine_Api::_()->sesmember()->getProfileType($member);?></span>
	    </div>
          <?php endif;?>
	  <?php $memberAge =  $this->partial('_userAge.tpl', 'sesmember', array('ageActive' => $this->ageActive, 'member' => $member)); ?>
	  <?php if($memberAge != ''):?><?php echo $memberAge;?><?php endif;?>
          <ul>
	    <?php if(isset($this->locationActive) &&  $userInfoItem->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.enable.location', 1)): ?>
	      <li class="list_tooltip_btns"><span><i class="fa fa-map-marker"></i><samp><i class="fa fa-caret-down"></i><a href="<?php echo $this->url(array('resource_id' => $member->user_id,'resource_type'=>'user','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="openSmoothbox" title="<?php echo $userInfoItem->location; ?>"><?php echo $userInfoItem->location ?></a></samp></span>
	      </li>
	    <?php endif; ?>
            <?php if(Engine_Api::_()->getApi('settings', 'core')->user_friends_eligible):?>
	      <?php if(isset($this->friendCountActive) && $memberC = $member->membership()->getMemberCount($member)): ?>  
		<li class="list_tooltip_btns"><span class=""><i class="fa fa-users"></i><samp><i class="fa fa-caret-down"></i><a href="<?php echo $this->url(array('user_id' => $member->user_id,'action'=>'get-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="openSmoothbox"><?php echo  $memberC. $this->translate(' Friends'); ?></a></samp></span></li>
	      <?php endif;?>
		<?php if(isset($this->mutualFriendCountActive) && ($viewer->getIdentity() && !$viewer->isSelf($member)) && $mfriends = Engine_Api::_()->sesmember()->getMutualFriendCount($member, $viewer)): ?> 
		<li class="list_tooltip_btns"><span class=""><i class="fa fa-users"></i><samp><i class="fa fa-caret-down"></i><a href="<?php echo $this->url(array('user_id' => $member->user_id,'action'=>'get-mutual-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="openSmoothbox"><?php echo  $mfriends . $this->translate(' Mutual Friends');?></a></samp></span></li>
	      <?php endif;?>
          <?php endif;?>
          <?php if(isset($this->emailActive)): ?> 
	    <li class="list_tooltip_btns"><span class=""><i class="fa fa-envelope"></i><samp><i class="fa fa-caret-down"></i> <?php echo $member->email;?></samp></span></li>
          <?php endif;?>
          <?php if(isset($this->likeActive) && isset($member->like_count)) { ?>
          	<li class="list_tooltip_btns"><span><i class="fa fa-thumbs-up"></i><samp><i class="fa fa-caret-down"></i> <?php echo $this->translate(array('%s like', '%s likes', $member->like_count), $this->locale()->toNumber($member->like_count)); ?></samp></span></li>
          <?php } ?>
          <?php if(isset($this->viewActive) && isset($member->view_count)) { ?>
          	<li class="list_tooltip_btns"><span><i class="fa fa-eye"></i><samp><i class="fa fa-caret-down"></i> <?php echo $this->translate(array('%s view', '%s views', $member->view_count), $this->locale()->toNumber($member->view_count))?></samp></span></li>
          <?php } ?>
          <?php if(Engine_Api::_()->getApi('core', 'sesmember')->allowReviewRating() && $this->ratingActive && Engine_Api::_()->sesbasic()->getViewerPrivacy('sesmember_review', 'view')){ ?>
          <li class="list_tooltip_btns"><span><i class="fa fa-star"></i><samp><i class="fa fa-caret-down"></i> <?php echo $this->translate(array('%s rating', '%s ratings', $userInfoItem->rating), $this->locale()->toNumber($userInfoItem->rating)); ?></samp></span></li>
          <?php } ?>
						<?php if(isset($userInfoItem->compliment_count)):?>
							<?php $titleCompliment = $this->title;?>
							<li class="list_tooltip_btns"><span><i class="fa fa-smile-o"></i><samp><i class="fa fa-caret-down"></i> <?php echo $this->translate(array("%s $titleCompliment", "%s $titleCompliment.'s'", $userInfoItem->compliment_count), $this->locale()->toNumber($userInfoItem->compliment_count)); ?></samp></span></li>
						<?php endif;?>
          </ul>
    
          </div>
                <?php if(isset($this->vipLabelActive) && $userInfoItem->vip):?>
				<div class="sesmember_vip_label" title="VIP"></div>
      <?php endif;?>
    <div class="sesmember_grid_view_three_info sesbasic_clearfix">
      <?php if(isset($this->titleActive) ){ ?>
	<div class="sesmember_grid_view_info_title">
	  <?php if(strlen($member->getTitle()) > $this->title_truncation_grid){ 
	  $title = mb_substr($member->getTitle(),0,($this->title_truncation_grid - 3)).'...';
	  echo $this->htmlLink($member->getHref(),$title, array('class' => 'ses_tooltip', 'data-src' => $member->getGuid())) ?>
	  <?php }else{ ?>
	  <?php echo $this->htmlLink($member->getHref(),$member->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $member->getGuid())) ?>
	  <?php } ?>
	</div>
      <?php } ?>
      <?php if(isset($this->verifiedLabelActive) && $userInfoItem->user_verified == 1): ?>
	<i class="sesmember_verified_sign_<?php echo $member->user_id?> sesmember_verified_sign fa fa-check-circle" title="Verified"></i>
      <?php else: ?>
	<i class="sesmember_verified_sign_<?php echo $member->user_id?> sesmember_verified_sign fa fa-check-circle" style="display:none;"></i>
      <?php endif;?>
      <?php if(Engine_Api::_()->getApi('core', 'sesmember')->allowReviewRating() && $this->ratingActive):?>
	<?php echo $this->partial('_userRating.tpl', 'sesmember', array('rating' => $userInfoItem->rating)); ?>
      <?php endif;?>
      <div class="sesmember_grid_view_three_info_btns">    
	<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->friendButtonActive)):?>
	  <?php echo '<span>'.$this->partial('_addfriend.tpl', 'sesbasic', array('subject' => $member)).'</span>'; ?>
	<?php endif;?>
	<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->likemainButtonActive)):?>
	  <?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($member->user_id,$member->getType());?>
	  <?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
	  <?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like') ;?>
	  <?php echo "<span><a href='javascript:;' data-url='".$member->getIdentity()."' class='sesbasic_btn sesmember_add_btn sesmember_button_like_user sesmember_button_like_user_". $member->user_id."'><i class='fa ".$likeClass."'></i><span><i class='fa fa-caret-down'></i>$likeText</span></a></span>";?>
	<?php endif;?>
	<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.active',1)  && !Engine_Api::_()->user()->getViewer()->isSelf($member)){
// 	  $FollowUser = Engine_Api::_()->sesmember()->getFollowStatus($member->user_id);
// 	  $followClass = (!$FollowUser) ? 'fa-check' : 'fa-times' ;
// 	  $followText = ($FollowUser) ?  $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.unfollowtext','Unfollow')) : $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.followtext','Follow'))  ;
// 	  echo "<span><a href='javascript:;' data-url='".$member->getIdentity()."' class='sesbasic_btn sesmember_add_btn sesmember_follow_user sesmember_follow_user_".$member->getIdentity()."'><i class='fa ".$followClass."'  title='$followText'></i> <span><i class='fa fa-caret-down'></i>".$this->translate('Follow')."</span></a></span>";
	  
	  echo $this->partial('_followmembers.tpl', 'sesmember', array('subject' => $member));
	}
	?>
	<?php if (Engine_Api::_()->sesbasic()->hasCheckMessage($member) && isset($this->messageActive)): ?>
	  <?php $baseUrl = $this->baseUrl();?>
	  <?php $messageText = $this->translate('Message');?>
	  <?php echo "<span><a href=\"$baseUrl/messages/compose/to/$member->user_id\" target=\"_parent\" title=\"$messageText\" class=\"smoothbox sesbasic_btn sesmember_add_btn\"><i class=\"fa fa-commenting-o\"></i><span><i class=\"fa fa-caret-down\"></i>".$this->translate('Message')."</span></a></span>"; ?>
	<?php endif; ?> 
      </div>      
    </div>
     </div>
  </li>
<?php } elseif($this->view_type == 'thumbView') { ?>

  <li class="sesmember_member_thumb_view sesbasic_clearfix sesbasic_bxs <?php if($this->image_type == 'rounded'):?>isrounded<?php endif;?>" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
    <div class="sesmember_member_thumb_view_block">
      <?php $href = $member->getHref();$imageURL = $member->getPhotoUrl('thumb.profile');?>
      <a href="<?php echo $href; ?>" class="sesmember_member_thumb_view_img floatL">
        <span class="floatL sesbasic_animation ses_tooltip" data-src = "<?php echo $member->getGuid();?>" style="background-image:url(<?php echo $imageURL; ?>);"></span>
      </a>
      <?php if(isset($this->titleActive) && $this->image_type == 'square'){ ?>
        <span>
          <?php if(strlen($member->getTitle()) > $this->title_truncation_grid){ 
          $title = mb_substr($member->getTitle(),0,($this->title_truncation_grid - 3)).'...';
          echo $this->htmlLink($member->getHref(),$title, array('class' => 'ses_tooltip', 'data-src' => $member->getGuid()) ) ?>
          <?php } else { ?>
          <?php echo $this->htmlLink($member->getHref(),$member->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $member->getGuid())) ?>
          <?php } ?>
        </span>
      <?php } ?>
    </div>
  </li>

<?php } else { ?>
  <li class="sesmember_member_grid sesmember_member_grid_sidebar sesbasic_clearfix sesbasic_bxs sesmember_grid_btns_wrap<?php if(isset($this->vipLabelActive) && $userInfoItem->vip):?> sesmeber_thumb_active_vip<?php endif; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
    <div class="sesmember_thumb semember_member_grid_thumb floatL">
      <?php $href = $member->getHref();$imageURL = $member->getPhotoUrl('thumb.main');?>
      <a href="<?php echo $href; ?>" class="semember_member_grid_thumb_img floatL">
        <span class="floatL sesbasic_animation" style="background-image:url(<?php echo $imageURL; ?>);"></span>
      </a>
      <?php if(isset($this->vipLabelActive) && $userInfoItem->vip):?>
				<div class="sesmember_vip_label" title="VIP"></div>
      <?php endif;?>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
        <div class="sesmember_labels">
          <?php if(isset($this->featuredLabelActive) && $userInfoItem->featured){ ?>
          <p class="sesmember_label_featured"><?php echo $this->translate('FEATURED');?></p>
          <?php } ?>
          <?php if(isset($this->sponsoredLabelActive) && $userInfoItem->sponsored){ ?>
          <p class="sesmember_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
    <div class="sesmember_member_grid_info  sesbasic_clearfix sesbasic_item_grid_info  sesbasic_clearfix">
          <?php if(isset($this->titleActive) ){ ?>
          <div class='sesmember_member_info_profile_img'><a href='' class=''><?php echo $this->itemPhoto($member, 'thumb.icon')?></a></div>
        <div class="sesmember_member_grid_title sesbasic_clearfix">
          <?php if(strlen($member->getTitle()) > $this->title_truncation_grid){ 
          $title = mb_substr($member->getTitle(),0,($this->title_truncation_grid - 3)).'...';
          echo $this->htmlLink($member->getHref(),$title, array('class' => 'ses_tooltip', 'data-src' => $member->getGuid()) ) ?>
          <?php }else{ ?>
          <?php echo $this->htmlLink($member->getHref(),$member->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $member->getGuid())) ?>
          <?php } ?>
        </div>
      <?php } ?>
      <?php if(isset($this->verifiedLabelActive) && $userInfoItem->user_verified == 1): ?>
	<i class="sesmember_verified_sign_<?php echo $member->user_id?> sesmember_verified_sign fa fa-check-circle" title="Verified"></i>
      <?php else: ?>
	<i class="sesmember_verified_sign_<?php echo $member->user_id?> sesmember_verified_sign fa fa-check-circle" style="display:none;"></i>
      <?php endif;?>
      <?php if(Engine_Api::_()->getApi('core', 'sesmember')->allowReviewRating() && $this->ratingActive):?>
	<?php echo $this->partial('_userRating.tpl', 'sesmember', array('rating' => $userInfoItem->rating)); ?>
      <?php endif;?>
      <?php if(isset($this->profileTypeActive)): ?>
	<div class="sesmember_list_stats sesmember_list_membertype "> 
	<span class="widthfull"><i class="fa fa-user"></i><span><?php echo Engine_Api::_()->sesmember()->getProfileType($member);?></span></span>
      </div>
      <?php endif;?>
      <?php $memberAge =  $this->partial('_userAge.tpl', 'sesmember', array('ageActive' => $this->ageActive, 'member' => $member)); ?>
      <?php if($memberAge != ''):?>
        <?php echo $memberAge;?>
      <?php endif;?>
      <?php if(isset($this->locationActive) &&  $userInfoItem->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.enable.location', 1)): ?>
        <div class="sesmember_list_stats sesmember_list_location">
          <span class="widthfull"><i class="fa fa-map-marker"></i><span><a href="<?php echo $this->url(array('resource_id' => $member->user_id,'resource_type'=>'user','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="openSmoothbox" title="<?php echo $userInfoItem->location; ?>"><?php echo $userInfoItem->location ?></a></span></span>
        </div>
      <?php endif; ?>
      <?php if(Engine_Api::_()->getApi('settings', 'core')->user_friends_eligible):?>
        <?php if(isset($this->friendCountActive) && $friendC = $member->membership()->getMemberCount($member)): ?>  
          <div class="sesmember_list_stats">
            <span class="widthfull"><i class="fa fa-users"></i><span><a href="<?php echo $this->url(array('user_id' => $member->user_id,'action'=>'get-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="openSmoothbox"><?php echo  $friendC. $this->translate(' Friends');?></a></span></span>
          </div>
      	<?php endif;?>
        <?php if(isset($this->mutualFriendCountActive) && ($viewer->getIdentity() && !$viewer->isSelf($member)) && $mcount = Engine_Api::_()->sesmember()->getMutualFriendCount($member, $viewer)): ?> 
          <div class="sesmember_list_stats">
            <span class="widthfull"><i class="fa fa-users"></i><span><a href="<?php echo $this->url(array('user_id' => $member->user_id,'action'=>'get-mutual-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="openSmoothbox"><?php echo  $mcount . $this->translate(' Mutual Friends');?></a></span></span>
          </div>
	    	<?php endif;?>
      <?php endif;?>
      <?php if(isset($this->emailActive)): ?> 
        <div class="sesmember_list_stats sesmember_email_list">
          <span class="widthfull"><i class="fa fa-envelope"></i><span><?php echo $member->email;?></span></span>
        </div>
			<?php endif;?>
      <?php if(isset($userInfoItem->review_count)):?>
      <div class="sesmember_list_stats">
          <span class="widthfull"><i class="fa fa-comments"></i><span><?php echo $this->translate('Total Reviews: ').$userInfoItem->review_count;?></span></span>
          </div>
      <?php endif;?>
      <div class="sesmember_list_stats">
        <?php if(isset($this->likeActive) && isset($member->like_count)) { ?>
	  <span title="<?php echo $this->translate(array('%s like', '%s likes', $member->like_count), $this->locale()->toNumber($member->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $member->like_count; ?></span>
        <?php } ?>
        <?php if(isset($this->viewActive) && isset($member->view_count)) { ?>
	  <span title="<?php echo $this->translate(array('%s view', '%s views', $member->view_count), $this->locale()->toNumber($member->view_count))?>"><i class="fa fa-eye "></i><?php echo $member->view_count; ?></span>
        <?php } ?>
        <?php if(Engine_Api::_()->getApi('core', 'sesmember')->allowReviewRating() && $this->ratingActive && Engine_Api::_()->sesbasic()->getViewerPrivacy('sesmember_review', 'view')){
          echo '<span title="'.$this->translate(array('%s rating', '%s ratings', $userInfoItem->rating), $this->locale()->toNumber($userInfoItem->rating)).'"><i class="fa fa-star"></i>'.round($userInfoItem->rating,1).'/5'. '</span>';
        }
        ?>
        <?php if(isset($userInfoItem->compliment_count)):?>
          <?php $titleCompliment = $this->title;?>
          <span title='<?php echo $this->translate(array("%s $titleCompliment", "%s $titleCompliment.'s'", $userInfoItem->compliment_count), $this->locale()->toNumber($userInfoItem->compliment_count)); ?>'><i class="fa fa-smile-o"></i><?php echo $userInfoItem->compliment_count; ?></span>
        <?php endif;?>
      </div>
      <div class="sesmember_add_btn_bg">    
        <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->friendButtonActive)):?>
          <?php echo '<span>'.$this->partial('_addfriend.tpl', 'sesbasic', array('subject' => $member)).'</span>'; ?>
        <?php endif;?>
        <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->likemainButtonActive)):?>
          <?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($member->user_id,$member->getType());?>
          <?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
          <?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like') ;?>
          <?php echo "<span><a href='javascript:;' data-url='".$member->getIdentity()."' class='sesbasic_btn sesmember_add_btn sesmember_button_like_user sesmember_button_like_user_". $member->user_id."'><i class='fa ".$likeClass."'></i><span><i class='fa fa-caret-down'></i>$likeText</span></a></span>";?>
        <?php endif;?>
        <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.active',1)  && !Engine_Api::_()->user()->getViewer()->isSelf($member)){
          $FollowUser = Engine_Api::_()->sesmember()->getFollowStatus($member->user_id);
          $followClass = (!$FollowUser) ? 'fa-check' : 'fa-times' ;
          $followText = ($FollowUser) ? $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.unfollowtext','Unfollow')) : $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.followtext','Follow'))  ;
          echo "<span><a href='javascript:;' data-url='".$member->getIdentity()."' class='sesbasic_btn sesmember_add_btn sesmember_follow_user sesmember_follow_user_".$member->getIdentity()."'><i class='fa ".$followClass."'  title='$followText'></i> <span><i class='fa fa-caret-down'></i>".$this->translate('Follow')."</span></a></span>"; 
        }
        ?>
        <?php if (Engine_Api::_()->sesbasic()->hasCheckMessage($member) && isset($this->messageActive)): ?>
          <?php $baseUrl = $this->baseUrl();?>
          <?php $messageText = $this->translate('Message');?>
          <?php echo "<span><a href=\"$baseUrl/messages/compose/to/$member->user_id\" target=\"_parent\" title=\"$messageText\" class=\"smoothbox sesbasic_btn sesmember_add_btn\"><i class=\"fa fa-commenting-o\"></i><span><i class=\"fa fa-caret-down\"></i>".$this->translate('Message')."</span></a></span>"; ?>
        <?php endif; ?> 
      </div>
    </div>
        <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive)) {
      $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $member->getHref()); ?>
        <div class="sesmember_grid_btns"> 
          <?php if(isset($this->socialSharingActive)){ ?>
          
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $member, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

          <?php } ?>	
          <?php if(isset($this->likeButtonActive)):?>
            <?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($member->user_id,$member->getType());?>
            <?php $likeClass = ($LikeStatus) ? ' button_active' : '' ;?>
            <a href='javascript:;' data-url="<?php echo $member->user_id;?>" class="sesbasic_icon_btn sesmember_like_user_<?php echo $member->user_id;?> sesbasic_icon_btn_count sesbasic_icon_like_btn sesmember_like_user <?php echo $likeClass;?>"><i class='fa fa-thumbs-up'></i><span><?php echo $member->like_count;?></span></a>
          <?php endif;?>	
        </div>
      <?php } ?>
  </li>
<?php } ?>
<?php endforeach; ?>
