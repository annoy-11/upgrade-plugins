<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _profileCompliments.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $randonNumber = 'sesmember_compliment'; ?>
<?php if(!$this->is_ajax){ ?>
  <div class="sesmember_profile_compl_head sesbasic_clearfix">
    <span><?php echo ucwords($this->subject->displayname); ?><?php echo $this->translate('\'s Compliments');?></span>
    <?php if($this->canCompliment):?>
      <a class="sesbasic_button sessmoothbox" href="sesmember/index/compliments/id/<?php  echo $this->subject->getIdentity(); ?>"><i class="fa fa-smile-o"></i><?php echo $this->translate('Send compliment');?></a>
    <?php endif;?>
  </div>
<?php } ?>
<?php if(!$this->is_ajax){ ?>
<div class="sesmember_profile_comp_list sesbasic_clearfix sesbasic_bxs">
<ul id="<?php echo $randonNumber; ?>" class="sesbasic_bxs">
<?php } ?>
<?php if(isset($this->single) || $this->paginator->getTotalItemCount() > 0){ ?>
<?php foreach($this->paginator as $compliment){ 
			$user = Engine_Api::_()->getItem('user',$compliment->resource_id);
?>
 <li class="sesbasic_clearfix" id="sesmember_compliment_<?php echo $compliment->usercompliment_id; ?>">
 <div class="sesmember_profile_comp_left">
 <?php if(in_array('photo',$this->options)){ ?>
   <div class="sesembre_profile_compl_img sesmember_sidebar_image_rounded floatL">
   	 <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle()), array('title'=>$user->getTitle(),'class'=>'ses_tooltip','id'=>'member_title_'.$user->getGuid(),'data-src'=>$user->getGuid())) ?>
   </div>
 <?php } ?>
    <div class="sesmember_profile_comp_details">
     <?php if(in_array('username',$this->options)){ ?>
     <span class="sesmember_profile_comp_details_friends"> <?php echo $this->htmlLink($user->getHref(),$user->getTitle()."'s", array('title'=>$user->getTitle(),'class'=>'ses_tooltip','id'=>'member_title_'.$user->getGuid(),'data-src'=>$user->getGuid())) ?></span>
     <?php  } ?>
     <?php if(in_array('location',$this->options) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.enable.location', 1) && $user->location){ ?>
      <p>
      <i class="fa fa-map-marker floatL"></i>
      <span class="sesbasic_text_light">
      	<a href='<?php echo $this->url(array('resource_id' => $user->user_id,'resource_type'=>'user','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>' class="opensmoothboxurl"> <?php echo $user->location ?></a></span>
      </p>
      <?php } ?>
     <?php if(!$this->viewer->isSelf($user) && $this->viewer){ ?>
      <?php if(in_array('friends',$this->options) && $totalfriends = $user->membership()->getMemberCount($user)){ ?>
      <p><i class="fa fa-users floatL"></i><span class="sesbasic_text_light"><a href="<?php echo $this->url(array('user_id' => $user->user_id,'action'=>'get-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="opensmoothboxurl"><?php echo $this->translate(array('%s friend', '%s  friends', $totalfriends), $this->locale()->toNumber($totalfriends))?></a></span></p>
       <?php } ?>
      
       <?php if(in_array('mutual',$this->options) && $mutualFirends = Engine_Api::_()->getApi('core', 'sesmember')->getMutualFriendCount($user,$this->viewer)){ ?>
      	<p><i class="fa fa-users floatL"></i> <span class="sesbasic_text_light"><a href="<?php echo $this->url(array('user_id' => $user->user_id,'action'=>'get-mutual-friends','format'=>'smoothbox'), 'sesmember_general', true); ?>" class="opensmoothboxurl"> <?php echo $this->translate(array('%s mutual friend', '%s  mutual friends', $mutualFirends), $this->locale()->toNumber($mutualFirends))?></a></span></p>
      <?php } ?>
     <?php } ?>
    </div>
         <?php if((in_array('addfriend',$this->options) || in_array('follow',$this->options) || in_array('like',$this->options) ) && $this->viewer->getIdentity() && $user->getIdentity() != $this->viewer->getIdentity()){ ?>
        <?php
          $subject = $user;
          $viewer = $this->viewer;
        ?>
        <div class="sesmember_adds_buttons sesbasic_clearfix">
          <?php if(in_array('friendButton',$this->options)):?>
	    <?php include APPLICATION_PATH .  '/application/modules/Sesbasic/views/scripts/_addfriend.tpl';?>
	  <?php endif;?>
	  <?php if(in_array('message',$this->options) && $this->viewer->getIdentity() && $user->getIdentity() != $this->viewer->getIdentity()){ ?>
	    <!-- get Message Btn -->
	    <a href="messages/compose/to/<?php echo $user->getIdentity(); ?>/format/smoothbox" class="sesbasic_btn sesmember_message_btn smoothbox menu_user_profile user_profile_message" target=""><i class="fa fa-envelope"></i><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Messages');?></span></a>
	  <?php } ?>  
	  <?php if($this->viewer->getIdentity() != 0 &&  in_array('like',$this->options) && $user->getIdentity() != $this->viewer->getIdentity()):?>
	    <?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($user->user_id,$user->getType());?>
	    <?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
	    <?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like') ;?>
	    <?php echo "<span><a href='javascript:;' data-url='".$user->getIdentity()."' class='sesbasic_btn sesmember_add_btn sesmember_button_like_user sesmember_button_like_user_". $user->user_id."'><i class='fa ".$likeClass."'></i><span><i class='fa fa-caret-down'></i>$likeText</span></a></span>";?>
	  <?php endif;?>
	  <?php
	  if(in_array('follow',$this->options)  && $this->viewer->getIdentity() != 0 && $user->getIdentity() != $this->viewer->getIdentity() && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.active',1)){
	    $FollowUser = Engine_Api::_()->sesmember()->getFollowStatus($user->user_id);
	    $followClass = (!$FollowUser) ? 'fa-check' : 'fa-times' ;
	    $followText = ($FollowUser) ?  $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.unfollowtext','Unfollow')) : $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.followtext','Follow')) ;
	    ?>
	    <a href='javascript:;' data-url='<?php echo $user->getIdentity(); ?>' class='sesbasic_btn sesmember_follow_user sesmember_follow_user_<?php echo $user->getIdentity(); ?>'><i class='fa <?php echo $followClass; ?>'></i><span><i class="fa fa-caret-down"></i><?php echo $followText;  ?></span></a>  
	    <?php
	  }
	  ?>
        </div>
      <?php }else{ ?>
      <div class="sesmember_adds_buttons sesbasic_clearfix">
	<?php if($this->viewer->isSelf($user)){ ?>
	  <a href="<?php echo $this->url(array( 'action' => 'edit-compliment', 'compliment_id' => $compliment->usercompliment_id,'format' => 'smoothbox'),'sesmember_general',true); ?>" class="sessmoothbox sesbasic_btn sesmember_message_btn menu_user_profile user_profile_message" target=""><i class="fa fa-pencil"></i><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Edit Compliment');?></span></a>
	  <a href="<?php echo $this->url(array('action' => 'delete-compliment', 'compliment_id' => $compliment->usercompliment_id,'format' => 'smoothbox'),'sesmember_general',true); ?>" onclick="return opensmoothboxurl(this.href);" class="sesbasic_btn sesmember_message_btn menu_user_profile user_profile_message" target=""><i class="fa fa-trash"></i><span><i class="fa fa-caret-down"></i><?php echo $this->translate('Delete Compliment');?></span></a>
	<?php } ?>
      </div>
      <?php } ?>
    </div>
    <div class="sesmember_profile_comp_info">
    <?php
      $compliment_img = Engine_Api::_()->storage()->get($compliment->comfile_id, '')->getPhotoUrl();
      $compliment_img =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on' ? "https://" : 'http://') . $_SERVER['HTTP_HOST'] . $compliment_img;
     ?>
     <p class="comp_info_tittle"><img class="floatL" src="<?php echo $compliment_img; ?>"/> <span><?php echo $compliment->comtitle; ?></span></p>
      <p class="comp_info_date sesbasic_text_light"><i class="fa fa-calendar"></i> <?php echo date('m-d-Y',strtotime($compliment->creation_date)); ?></p>
      <p class="comp_info_contant clear"><span>"</span><?php echo $compliment->description; ?><span>"</span></p>
    </div>

  </li>
<?php } ?>
		<?php if($this->loadOptionData == 'pagging' && empty($this->single)){ ?>
      <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesmember"),array('identityWidget'=>$randonNumber)); ?>
    <?php } ?>
<?php }else{ ?>
	<div class="tip">
  <span>
    <?php echo $this->translate("No compliment created yet.");?>
  </span>
</div>
<?php } ?>
<?php if(!$this->is_ajax){ ?>
</ul>
</div>
<?php } ?>
<?php if($this->loadOptionData != 'pagging' && !$this->is_ajax):?>
<div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" ><a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a></div>
<div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
<?php endif;?>

<script type="application/javascript">


  <?php if(!$this->is_ajax):?>
	var sesmemenr_compliment_tab_id = <?php echo $this->identity; ?>;
    <?php if($this->loadOptionData == 'auto_load'){ ?>
    window.addEvent('load', function() {
      sesJqueryObject(window).scroll( function() {
	var containerId = '#<?php echo $randonNumber;?>';
        if(typeof sesJqueryObject(containerId).offset() != 'undefined') {
	  var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject(containerId).offset().top;
	  var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
	  if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
	    document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
	  }
        }
      });
    });
    <?php } ?>
  <?php endif; ?>
<?php if(empty($this->single)){ ?>
	var page<?php echo $randonNumber; ?> = <?php echo $this->page + 1; ?>;
	var params<?php echo $randonNumber; ?> = '<?php echo json_encode($this->params); ?>';
	<?php if($this->loadOptionData != 'pagging') { ?>
	viewMoreHide_<?php echo $randonNumber; ?>();
	function viewMoreHide_<?php echo $randonNumber; ?>() {
			if ($('view_more_<?php echo $randonNumber; ?>'))
			$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
		}
	 function viewMore_<?php echo $randonNumber; ?> () {
			sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
			sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
			
			requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/sesmember/name/profile-compliments",
				'data': {
		format: 'html',
		page: page<?php echo $randonNumber; ?>,    
		params : params<?php echo $randonNumber; ?>, 
		is_ajax : 1,
		subject_id:'<?php echo $this->subject->getIdentity(); ?>'
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				sesJqueryObject('#<?php echo $randonNumber?>').append(responseHTML);
				sesJqueryObject('.sesbasic_view_more_loading_<?php echo $randonNumber;?>').hide();
				viewMoreHide_<?php echo $randonNumber; ?>();
				}
			});
			requestViewMore_<?php echo $randonNumber; ?>.send();
			return false;
		}
	<?php }else{ ?>
		function paggingNumber<?php echo $randonNumber; ?>(pageNum){
			sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display','block');
			requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/sesmember/name/profile-compliments",
				'data': {
					format: 'html',
					page: pageNum,
					params :params<?php echo $randonNumber; ?> , 
					is_ajax : 1,
					subject_id:'<?php echo $this->subject->getIdentity(); ?>'
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					sesJqueryObject('#<?php echo $randonNumber?>').html(responseHTML);
					sesJqueryObject('#sesbasic_loading_cont_overlay_<?php echo $randonNumber?>').css('display', 'none');
				}
			}));
			requestViewMore_<?php echo $randonNumber; ?>.send();
			return false;
		}
	<?php } ?>
<?php } ?>
</script>

<?php if(isset($this->single)){ 
	die;
 } ?>