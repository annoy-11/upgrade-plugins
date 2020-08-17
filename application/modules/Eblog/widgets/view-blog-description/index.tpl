<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/styles/styles.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/scripts/infinite-scroll.js'); ?>
<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->eblog->getHref()); ?>
<?php $isBlogAdmin = Engine_Api::_()->eblog()->isBlogAdmin($this->eblog, 'edit');?>
<?php $reviewCount = Engine_Api::_()->eblog()->getTotalReviews($this->eblog->blog_id);?>
<?php $canComment =  $this->eblog->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
<?php $LikeStatus = Engine_Api::_()->eblog()->getLikeStatus($this->eblog->blog_id,$this->eblog->getType()); ?> 
<?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
<?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'eblog')->isFavourite(array('resource_type'=>'eblog_blog','resource_id'=>$this->eblog->blog_id)); ?>
<?php $isAllowReview = Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.allow.review', 1);?>
<?php $enableSharng = Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1);?>
   <div class="eblog_profile_layout_second">
    		<?php if(isset($this->descriptionActive)):?>
			<?php if($this->eblog->cotinuereading){
					$check = true;
					$style = 'style="height:400px; overflow:hidden;"';
				}else{
					$check = false;
					$style = '';
				} ?>
				<div class="rich_content_body sesbasic_text_light" style="visibility:hidden"><?php echo htmlspecialchars_decode($this->eblog->body);?></div>
				<?php if($check): ?>
					<div class="eblog_entrylist_entry_body eblog_morebtn" style="display:none"><a href="javascript:void(0);" onclick="continuereading();"><?php echo $this->translate("Continue Reading"); ?></a></div>
				<?php endif; ?>
		<?php endif;?>
    <p class="eblog_profile_tags">
    <?php foreach ($this->eblogTags as $tag): ?>
					<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
				<?php endforeach; ?>
    </p>
      <div class="eblog_shear_blog sesbasic_bxs">
        <div class="eblog_second_footer">
        <?php if(isset($this->socialShareActive) && $enableSharng):?>
        
          <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->eblog, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
			  <?php endif;?>
				<?php if($this->viewer_id && $enableSharng && isset($this->shareButtonActive)):?>
						<a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->eblog->getType(), "id" => $this->eblog->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="share_icon sesbasic_icon_btn smoothbox"><i class="fa fa-share "></i></a>
				<?php endif;?>
			<?php if($this->viewer_id) { ?>
					<?php if(isset($this->likeButtonActive) && $canComment):?>
							<a href="javascript:;" data-url="<?php echo $this->eblog->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_like_btn  eblog_like_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_like_eblog_blog_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i></a>
					<?php endif;?>
					<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)):?>
							<a href="javascript:;" data-url="<?php echo $this->eblog->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_fav_btn  eblog_favourite_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_favourite_eblog_blog_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i></a>
					<?php endif;?>
        <?php } else {  ?>
              <?php if(isset($this->likeButtonActive) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'like')) { ?>
                    <a href="javascript:;" onclick="nonlogisession(window.location.href);" class="sesbasic_icon_btn sesbasic_icon_like_btn  eblog_like_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_like_eblog_blog_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i></a>
              <?php } ?>
              <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'favourite')) {  ?>
                    <a href="javascript:;" onclick="nonlogisession(window.location.href);"  class="sesbasic_icon_btn sesbasic_icon_fav_btn  eblog_favourite_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_favourite_eblog_blog_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i></a>
              <?php } ?>

        <?php   } ?>
        </div>
			</div>
      </div>
  
