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
<?php 

$allParams = $this->allParams;
$baseUrl = $this->layout()->staticBaseUrl;

$this->headLink()->appendStylesheet($baseUrl . 'application/modules/Eblog/externals/styles/styles.css');
$this->headScript()->appendFile($baseUrl . 'application/modules/Eblog/externals/scripts/infinite-scroll.js'); 

?>

<?php if($this->eblog->style == 1):?>
	<div class="eblog_layout_contant sesbasic_clearfix sesbasic_bxs">
    <div class="eblog_layout_contant_header">
      <?php if(isset($allParams['show_criteria']) && in_array('category', $allParams['show_criteria'])) { ?>
        <p class="eblog_cat"><a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a></p>
      <?php } ?>
      <div> <a href="javascript:;" class="sesbasic_pulldown_toggle eblog_profile_options"><i class="fa fa-ellipsis-h"></i></a>
      <div class="sesbasic_pulldown_options">
        <ul>
					<?php if(isset($this->ownerOptionsActive) && $this->isBlogAdmin):?>
          	<?php if($this->coreSettings->getSetting('eblog.enable.subblog', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->eblog->blog_id), 'eblog_general', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Blog');?></a></li>
           <?php } ?>
						<li><a href="<?php echo $this->url(array('action' => 'edit', 'blog_id' => $this->eblog->custom_url), 'eblog_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
						<li><a href="<?php echo $this->url(array('action' => 'delete', 'blog_id' => $this->eblog->getIdentity()), 'eblog_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Blog');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && isset($this->smallShareButtonActive) && $this->enableSharng):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->eblog->getType(), "id" => $this->eblog->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i><?php echo $this->translate('Share');?></a></li>
					<?php endif;?>

                    <?php if($this->viewer_id){  ?>
					<?php if($this->viewer_id && $this->viewer_id != $this->eblog->owner_id && $this->coreSettings->getSetting('eblog.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->eblog->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>

                  <?php  } else { ?>
                  <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'claim') && $this->coreSettings->getSetting('eblog.enable.report', 1)) { ?>
                        <li><a onclick="nonlogisession(window.location.href);" href="javascript:;"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
                  <?php  } ?>
                <?php } ?>

                 <?php if($this->viewer_id){  ?>
					<?php if(isset($this->postCommentActive) && $this->canComment):?>
						<li><a href="javascript:void(0);" class="eblog_comment"><i class="eblog_comment fa fa-commenting"></i><?php echo $this->translate('Post Comment');?></a></li>
                   <?php endif;?>
                   <?php  } else { ?>
                   <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'commenting') && isset($this->postCommentActive)) { ?>
                         <li><a onclick="nonlogisession(window.location.href);" href="javascript:void(0);"><i class="eblog_comment fa fa-commenting"></i><?php echo $this->translate('Post Comment');?></a></li>
                   <?php  } ?>
                   <?php  } ?>
				</ul>
     </div>
     </div>
   </div>
	  <?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->eblog->getTitle() ?></h2>
		<?php endif;?>
		<div class="eblog_entrylist_entry_date">
    	<p><?php echo $this->translate('By');?> <b><?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?></b> &nbsp;-&nbsp;</p>
			<p><?php echo $this->timestamp($this->eblog->creation_date) ?><?php if( $this->category ): ?>&nbsp;-&nbsp;</p>

          <?php   if(isset($this->eblog->readtime) && !empty($this->eblog->readtime)) {  ?>
            <p><?php  echo $this->eblog->readtime; ?>
              <?php  } ?>
			<?php if(isset($this->staticsActive)):?>
				&nbsp;-&nbsp;</p>

				<p>
					<?php if(isset($this->viewActive)):?>
						<span><?php echo $this->translate(array('%s View', '%s Views', $this->eblog->view_count), $this->locale()->toNumber($this->eblog->view_count)) ?>&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->commentActive)):?>
						<span><?php echo $this->translate(array('%s Comment', '%s Comments', $this->eblog->comment_count), $this->locale()->toNumber($this->eblog->comment_count)) ?>&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->likeActive)):?>
						<span><?php echo $this->translate(array('%s Like', '%s Likes', $this->eblog->like_count), $this->locale()->toNumber($this->eblog->like_count)) ?></span>
					<?php endif;?>
					<?php if($this->isAllowReview && isset($this->reviewActive)):?>
                       &nbsp;
						<span><?php echo $this->translate(array('%s Review', '%s Reviews', $this->reviewCount), $this->locale()->toNumber($this->reviewCount)) ?></span>
					<?php endif;?>
				</p>
			<?php endif;?>
       <?php if(isset($this->ratingActive)):?>
        &nbsp;-&nbsp;
				<p class="sesbasic_rating_star">
					<?php $ratingCount = $this->eblog->rating; $x=0; ?>
					<?php if( $ratingCount > 0 ): ?>
						<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
							<span id="" class="eblog_rating_star"></span>
						<?php endfor; ?>
						<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
						<span class="eblog_rating_star eblog_rating_star_half"></span>
						<?php }else{ $x = $x - 1;} ?>
						<?php if($x < 5){ 
						for($j = $x ; $j < 5;$j++){ ?>
						<span class="eblog_rating_star eblog_rating_star_disable"></span>
						<?php }   	
						} ?>
					<?php endif; ?>
				</p>
			<?php endif;?>
		</div>
		<div class="eblog_entrylist_entry_body">
		  <?php if(isset($this->photoActive) && $this->eblog->photo_id):?>
				<div class="eblog_blog_image clear" style="height: <?php echo $this->image_height; ?>px;overflow: hidden;">
					<img src="<?php echo Engine_Api::_()->storage()->get($this->eblog->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
          <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)):?>
				<div class="eblog_list_labels">
					<?php if($item->sponsored == 1):?>
						<p class="eblog_label_sponsored"><?php echo $this->translate('Sponsored');?></p>
					<?php endif;?>
          <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
						<p class="eblog_label_featured"><?php echo $this->translate('Featured');?></p>
					<?php endif;?>
					<?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
						<p class="eblog_label_verified"><?php echo $this->translate('VERIFIED');?></p>
					<?php endif;?>
				</div>
			<?php endif;?>
				</div>
			<?php endif;?>
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
					<div class="eblog_morebtn" style="display:none"><a href="javascript:void(0);" onclick="continuereading();"><?php echo $this->translate("Continue Reading"); ?></a></div>
				<?php endif; ?>
			<?php endif;?>
		</div>
		<?php if(isset($allParams['show_criteria']) && in_array('tags', $allParams['show_criteria'])) { ?>
     <p class="eblog_profile_tags"><?php if (count($this->eblogTags )):?>
				<?php foreach ($this->eblogTags as $tag): ?>
					<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
				<?php endforeach; ?>
			<?php endif; ?> 
    <?php } ?>
    <div class="eblog_footer_two_blog clear">
      <div class="eblog_shear_blog sesbasic_bxs">
        <?php if(isset($this->socialShareActive) && $this->enableSharng):?>
        
          <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->eblog, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
			  <?php endif;?>
				<?php if($this->viewer_id && $this->enableSharng && isset($this->shareButtonActive)):?>
						<a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->eblog->getType(), "id" => $this->eblog->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="share_icon sesbasic_icon_btn smoothbox"><i class="fa fa-share "></i></a>
				<?php endif;?>
			<?php if($this->viewer_id) { ?>
					<?php if(isset($this->likeButtonActive) && $this->canComment):?>
							<a href="javascript:;" data-url="<?php echo $this->eblog->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_like_btn  eblog_like_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_like_eblog_blog_view <?php echo ($this->LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $this->likeClass;?>"></i></a>
					<?php endif;?>
					<?php if(isset($this->favouriteButtonActive) && $this->coreSettings->getSetting('eblog.enable.favourite', 1)):?>
							<a href="javascript:;" data-url="<?php echo $this->eblog->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_fav_btn  eblog_favourite_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_favourite_eblog_blog_view <?php echo ($this->favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i></a>
					<?php endif;?>
        <?php } else {  ?>
              <?php if(isset($this->likeButtonActive) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'like')) { ?>
                    <a href="javascript:;" onclick="nonlogisession(window.location.href);" class="sesbasic_icon_btn sesbasic_icon_like_btn  eblog_like_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_like_eblog_blog_view <?php echo ($this->LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $this->likeClass;?>"></i></a>
              <?php } ?>
              <?php if(isset($this->favouriteButtonActive) && $this->coreSettings->getSetting('eblog.enable.favourite', 1) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'favourite')) {  ?>
                    <a href="javascript:;" onclick="nonlogisession(window.location.href);"  class="sesbasic_icon_btn sesbasic_icon_fav_btn  eblog_favourite_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_favourite_eblog_blog_view <?php echo ($this->favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i></a>
              <?php } ?>

        <?php   } ?>
			</div>
		</div>
	</div>
	<?php  endif; ?>
<?php elseif($this->eblog->style == 2):?>
  <style>
	  #global_page_eblog-index-view #global_wrapper{
			 padding-top:0 !important;
		}
	</style>
	<!--second profile blog start-->
	<div class="eblog_profile_layout_second sesbasic_clearfix sesbasic_bxs">

    <?php if(isset($this->photoActive) && $this->eblog->photo_id):?>
      <div class="eblog_profile_layout_second_image clear" >
          <a href="<?php echo $this->eblog->getHref(); ?>"><img  src="<?php echo Engine_Api::_()->storage()->get($this->eblog->photo_id)->getPhotoUrl('thumb.main'); ?>" alt=""></a>
     <div class="eblog_list_labels">
					<?php if($item->sponsored == 1):?>
						<p class="eblog_label_sponsored"><?php echo $this->translate('Sponsored');?></p>
					<?php endif;?>
          <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
						<p class="eblog_label_featured"><?php echo $this->translate('Featured');?></p>
					<?php endif;?>
					<?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
						<p class="eblog_label_verified"><?php echo $this->translate('VERIFIED');?></p>
					<?php endif;?>
				</div>
        <div class="eblog_second_options"> 
        <a href="javascript:;" class="sesbasic_pulldown_toggle eblog_profile_options"><i class="fa fa-ellipsis-h"></i></a>
     <div class="sesbasic_pulldown_options">
      				<ul>
					<?php if(isset($this->ownerOptionsActive) && $this->isBlogAdmin):?>
          	<?php if($this->coreSettings->getSetting('eblog.enable.subblog', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->eblog->blog_id), 'eblog_general', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Blog');?></a></li>
           <?php } ?>
						<li><a href="<?php echo $this->url(array('action' => 'edit', 'blog_id' => $this->eblog->custom_url), 'eblog_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
						<li><a href="<?php echo $this->url(array('action' => 'delete', 'blog_id' => $this->eblog->getIdentity()), 'eblog_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Blog');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && isset($this->smallShareButtonActive) && $this->enableSharng):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->eblog->getType(), "id" => $this->eblog->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i><?php echo $this->translate('Share');?></a></li>
					<?php endif;?>

                    <?php if($this->viewer_id){  ?>
					<?php if($this->viewer_id && $this->viewer_id != $this->eblog->owner_id && $this->coreSettings->getSetting('eblog.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->eblog->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>

                  <?php  } else { ?>
                  <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'claim') && $this->coreSettings->getSetting('eblog.enable.report', 1)) { ?>
                        <li><a onclick="nonlogisession(window.location.href);" href="javascript:;"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
                  <?php  } ?>
                <?php } ?>

                 <?php if($this->viewer_id){  ?>
					<?php if(isset($this->postCommentActive) && $this->canComment):?>
						<li><a href="javascript:void(0);" class="eblog_comment"><i class="eblog_comment fa fa-commenting"></i><?php echo $this->translate('Post Comment');?></a></li>
                   <?php endif;?>
                   <?php  } else { ?>
                   <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'commenting') && isset($this->postCommentActive)) { ?>
                         <li><a onclick="nonlogisession(window.location.href);" href="javascript:void(0);"><i class="eblog_comment fa fa-commenting"></i><?php echo $this->translate('Post Comment');?></a></li>
                   <?php  } ?>
                   <?php  } ?>
				</ul>
     </div>
     </div>
      <div class="eblog_profile_layout_second_info">
	  <?php if( $this->category ): ?>
    				<?php echo $this->translate('') ?>
  	<div class="eblog_category_teg">
     <p>   
				<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
			</p>
		</div><?php endif; ?>
		<?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->eblog->getTitle() ?></h2>
		<?php endif;?>
   <?php if(isset($this->ratingActive)):?>
				<div class="sesbasic_rating_star">
					<?php $ratingCount = $this->eblog->rating; $x=0; ?>
					<?php if( $ratingCount > 0 ): ?>
						<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
							<span id="" class="eblog_rating_star"></span>
						<?php endfor; ?>
						<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
						<span class="eblog_rating_star eblog_rating_star_half"></span>
						<?php }else{ $x = $x - 1;} ?>
						<?php if($x < 5){ 
						for($j = $x ; $j < 5;$j++){ ?>
						<span class="eblog_rating_star eblog_rating_star_disable"></span>
						<?php }   	
						} ?>
					<?php endif; ?>
				</div>
			<?php endif;?>
    <p class="eblog_owner">
        <?php  $owner=Engine_Api::_()->getItem('user', $this->owner);  ?>
    <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle())); ?>
    <?php echo $this->translate('By');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?>
    </p>
		
    <div class="eblog_entrylist_entry_date">
      <p><?php echo $this->translate('<i class="fa fa-calendar-o"></i>') ?>&nbsp;
			<?php echo $this->timestamp($this->eblog->publish_date) ?>
			<?php  ?>
				</p>
          <?php  if(isset($this->eblog->readtime) && !empty($this->eblog->readtime)) {  ?>
            <p><i class="fa fa-clock-o"></i>
              <?php  echo $this->eblog->readtime; ?></p>
              <?php  } ?>
			<?php if(isset($this->staticsActive)):?>
				<p>
				<?php if(isset($this->viewActive)):?>
					<span><i class="sesbasic_icon_view"></i>&nbsp;
					<?php echo $this->translate(array('%s view', '%s views', $this->eblog->view_count), $this->locale()->toNumber($this->eblog->view_count)) ?></span>
				<?php endif;?>
				<?php if(isset($this->commentActive)):?>
					<span><i class="sesbasic_icon_comment_o"></i>&nbsp;<?php echo $this->translate(array('%s comment', '%s comments', $this->eblog->comment_count), $this->locale()->toNumber($this->eblog->comment_count)) ?></span>
				<?php endif;?>
				<?php if(isset($this->likeActive)):?>
					<span><i class="sesbasic_icon_like_o"></i>&nbsp;<?php echo $this->translate(array('%s like', '%s likes', $this->eblog->like_count), $this->locale()->toNumber($this->eblog->like_count)) ?></span>
				<?php endif;?>
				<?php if($this->isAllowReview && isset($this->reviewActive)):?>
                    
					<span><i class="fa fa-star-o"></i>&nbsp;<?php echo $this->translate(array('%s review', '%s reviews', $this->reviewCount), $this->locale()->toNumber($this->reviewCount)) ?></span>
				<?php endif;?>
				</p>
      <?php endif;?>
		</div>
    </div>
      </div>
    <?php endif;?>
    </div>
	</div>
	<!--second profile blog end-->
<?php elseif($this->eblog->style == 3):?>
	<!--three profile blog start-->
	<div class="eblog_profile_layout_three sesbasic_clearfix sesbasic_bxs">
    <div class="eblog_profile_three_main">
     <div class="eblog_profile_three_header">
       <?php if( $this->category ): ?>
				<p class="category">
				<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
				</p>
      <?php endif; ?>
		<?php if(isset($this->ratingActive)):?>
			<div class="sesbasic_rating_star">
				<?php $ratingCount = $this->eblog->rating; $x=0; ?>
				<?php if( $ratingCount > 0 ): ?>
					<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
						<span id="" class="eblog_rating_star"></span>
					<?php endfor; ?>
					<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
					<span class="eblog_rating_star eblog_rating_star_half"></span>
					<?php }else{ $x = $x - 1;} ?>
					<?php if($x < 5){ 
					for($j = $x ; $j < 5;$j++){ ?>
					<span class="eblog_rating_star eblog_rating_star_disable"></span>
					<?php }   	
					} ?>
				<?php endif; ?>
			</div>
		<?php endif;?>
     </div>
    <?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->eblog->getTitle() ?></h2>
		<?php endif;?>
		<div class="eblog_entrylist_entry_date">
			<p class="sesbasic_text_light">
      	<span><i class=" fa fa-user-o"></i> <?php echo $this->translate('');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?></span>
      	<span><?php echo $this->translate('<i class="fa fa-calendar-o"></i>') ?>&nbsp;<?php echo $this->timestamp($this->eblog->publish_date) ?></span>
      	 <?php   if(isset($this->eblog->readtime) && !empty($this->eblog->readtime)) {  ?>
            <span><i class="fa fa-clock-o"></i>
              <?php  echo $this->eblog->readtime; ?>
              <?php  } ?>
              </span>
			</p>
      <p class="sesbasic_text_light">
      <?php if(isset($this->staticsActive)):?>
      	  <?php if(isset($this->viewActive)):?>
						<span><i class="sesbasic_icon_view"></i> <?php echo $this->translate(array('%s view', '%s views', $this->eblog->view_count), $this->locale()->toNumber($this->eblog->view_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->commentActive)):?>
						<span><i class="sesbasic_icon_comment_o"></i><?php echo $this->translate(array('%s Comment', '%s Comments', $this->eblog->comment_count), $this->locale()->toNumber($this->eblog->comment_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->likeActive)):?>
						<span><i class="sesbasic_icon_like_o"></i><?php echo $this->translate(array('%s Like', '%s Likes', $this->eblog->like_count), $this->locale()->toNumber($this->eblog->like_count)) ?></span>
					<?php endif;?>
					<?php if($this->isAllowReview && isset($this->reviewActive)):?>
					<span><i class="fa fa-star-o"></i><?php echo $this->translate(array('%s Review', '%s Reviews', $this->reviewCount), $this->locale()->toNumber($this->reviewCount)) ?></span>
					<?php endif;?>
				<?php endif;?>
      </p>
		</div>
    </div>
		<div class="eblog_entrylist_entry_body">
		  <?php if(isset($this->photoActive) && $this->eblog->photo_id):?>
				<div class="eblog_blog_image clear" style="height: <?php echo $this->image_height ?>px;overflow: hidden;">
					<img src="<?php echo Engine_Api::_()->storage()->get($this->eblog->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
          <div class="eblog_list_labels">
					<?php if($item->sponsored == 1):?>
						<p class="eblog_label_sponsored"><?php echo $this->translate('Sponsored');?></p>
					<?php endif;?>
          <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
						<p class="eblog_label_featured"><?php echo $this->translate('Featured');?></p>
					<?php endif;?>
					<?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
						<p class="eblog_label_verified"><?php echo $this->translate('VERIFIED');?></p>
					<?php endif;?>
				</div>
				</div>
			<?php endif;?>
		</div>
	</div>
	<!--three profile blog start-->
<?php elseif($this->eblog->style == 4):?>
	<div class="eblog_profile_layout_four sesbasic_clearfix sesbasic_bxs">
		<div class="eblog_entrylist_entry_body">
      <div class="eblog_profile_four_top">
      <div class="eblog_second_options"> <a href="javascript:;" class="sesbasic_pulldown_toggle eblog_profile_options"><i class="fa fa-ellipsis-h"></i></a>
     <div class="sesbasic_pulldown_options">
      				<ul>
					<?php if(isset($this->ownerOptionsActive) && $this->isBlogAdmin):?>
          	<?php if($this->coreSettings->getSetting('eblog.enable.subblog', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->eblog->blog_id), 'eblog_general', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Blog');?></a></li>
           <?php } ?>
						<li><a href="<?php echo $this->url(array('action' => 'edit', 'blog_id' => $this->eblog->custom_url), 'eblog_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
						<li><a href="<?php echo $this->url(array('action' => 'delete', 'blog_id' => $this->eblog->getIdentity()), 'eblog_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Blog');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && isset($this->smallShareButtonActive) && $this->enableSharng):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->eblog->getType(), "id" => $this->eblog->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i><?php echo $this->translate('Share');?></a></li>
					<?php endif;?>

                    <?php if($this->viewer_id){  ?>
					<?php if($this->viewer_id && $this->viewer_id != $this->eblog->owner_id && $this->coreSettings->getSetting('eblog.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->eblog->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>

                  <?php  } else { ?>
                  <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'claim') && $this->coreSettings->getSetting('eblog.enable.report', 1)) { ?>
                        <li><a onclick="nonlogisession(window.location.href);" href="javascript:;"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
                  <?php  } ?>
                <?php } ?>

                 <?php if($this->viewer_id){  ?>
					<?php if(isset($this->postCommentActive) && $this->canComment):?>
						<li><a href="javascript:void(0);" class="eblog_comment"><i class="eblog_comment fa fa-commenting"></i><?php echo $this->translate('Post Comment');?></a></li>
                   <?php endif;?>
                   <?php  } else { ?>
                   <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'commenting') && isset($this->postCommentActive)) { ?>
                         <li><a onclick="nonlogisession(window.location.href);" href="javascript:void(0);"><i class="eblog_comment fa fa-commenting"></i><?php echo $this->translate('Post Comment');?></a></li>
                   <?php  } ?>
                   <?php  } ?>
				</ul>
     </div>
     </div>
        <div class="eblog_profile_four_data">
         <div class="eblog_profile_four_header">
        <?php if( $this->category ): ?>
					<span class="eblog_cat">
					<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
				</span>
        <?php endif; ?>
        <?php if(isset($this->ratingActive)):?>
			<div class="sesbasic_rating_star floatR">
				<?php $ratingCount = $this->eblog->rating; $x=0; ?>
				<?php if( $ratingCount > 0 ): ?>
					<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
						<span id="" class="eblog_rating_star"></span>
					<?php endfor; ?>
					<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
					<span class="eblog_rating_star eblog_rating_star_half"></span>
					<?php }else{ $x = $x - 1;} ?>
					<?php if($x < 5){ 
					for($j = $x ; $j < 5;$j++){ ?>
					<span class="eblog_rating_star eblog_rating_star_disable"></span>
					<?php }   	
					} ?>
				<?php endif; ?>
			</div>
		<?php endif;?>
    </div>
      <?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->eblog->getTitle() ?></h2>
		<?php endif;?>
		<div class="eblog_entrylist_entry_date">
			<span class="eblog_entry_border"></span>
			<p>
				<span>
        <?php echo $this->translate('');?>&nbsp; <?php echo $this->htmlLink($this->owner->getHref(), 
        $this->itemPhoto($this->owner),
				array('class' => 'eblogs_gutter_photo')) ?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?> &nbsp;-&nbsp;</span>
				<span>
					<?php echo $this->translate('<i class="fa fa-calendar-o"></i>') ?>
					<?php echo $this->timestamp($this->eblog->creation_date) ?>
					&nbsp;-&nbsp;
        </span>
        <?php  ?>
  <?php   if(isset($this->eblog->readtime) && !empty($this->eblog->readtime)) {  ?>
            <p><i class="fa fa-clock-o"></i>
              <?php  echo $this->eblog->readtime; ?> &nbsp;-&nbsp;</p>
              <?php  } ?>
				<?php if(isset($this->staticsActive)):?>
				  <?php if(isset($this->viewActive)):?>
						<span><i class="sesbasic_icon_view"></i>
						<?php echo $this->translate(array('%s view', '%s views', $this->eblog->view_count), $this->locale()->toNumber($this->eblog->view_count)) ?>
						&nbsp;-&nbsp;
						</span>
          <?php endif;?>
          <?php if(isset($this->commentActive)):?>
						<span><i class="sesbasic_icon_comment-o"></i><?php echo $this->translate(array('%s Comment', '%s Comments', $this->eblog->comment_count), $this->locale()->toNumber($this->eblog->comment_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->likeActive)):?>
						<span><i class="sesbasic_icon_like_o"></i><?php echo $this->translate(array('%s Like', '%s Likes', $this->eblog->like_count), $this->locale()->toNumber($this->eblog->like_count)) ?></span>
					<?php endif;?>
					<?php if($this->isAllowReview && isset($this->reviewActive)):?>
                        &nbsp;-&nbsp;
						<span><i class="fa fa-star-o"></i><?php echo $this->translate(array('%s Review', '%s Reviews', $this->reviewCount), $this->locale()->toNumber($this->reviewCount)) ?></span>
					<?php endif;?>
				<?php endif;?>
			</p>
		</div>
    </div>
		  <?php if(isset($this->photoActive) && $this->eblog->photo_id):?>
				<div class="eblog_blog_image clear" style="height: <?php echo $this->image_height; ?>px;overflow: hidden;">
					<img src="<?php echo Engine_Api::_()->storage()->get($this->eblog->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
				</div>
			<?php endif;?>
       <div class="eblog_list_labels">
					<?php if($item->sponsored == 1):?>
						<p class="eblog_label_sponsored"><?php echo $this->translate('Sponsored');?></p>
					<?php endif;?>
          <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
						<p class="eblog_label_featured"><?php echo $this->translate('Featured');?></p>
					<?php endif;?>
					<?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
						<p class="eblog_label_verified"><?php echo $this->translate('VERIFIED');?></p>
					<?php endif;?>
				</div>
    </div>
    <div class="eblog_content_four">
		<div class="eblog_social_tabs sesbasic_clearfix">
          <?php if($this->viewer_id){  ?>
				<?php if(isset($this->likeButtonActive)):?>
					<a href="javascript:;" data-url="<?php echo $this->eblog->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eblog_like_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_like_eblog_blog <?php echo ($this->LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $this->eblog->like_count; ?></span></a>
				<?php endif;?>
				<?php if(isset($this->favouriteButtonActive) && $this->coreSettings->getSetting('eblog.enable.favourite', 1)):?>
						<a href="javascript:;" data-url="<?php echo $this->eblog->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn eblog_favourite_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_favourite_eblog_blog <?php echo ($this->favStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-heart"></i><span><?php echo $this->eblog->favourite_count; ?></span></a>
				<?php endif;?>

              <?php }  else {  ?>

              <?php if(isset($this->likeButtonActive) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'like')) { ?>
                    <a href="javascript:;" onclick="nonlogisession(window.location.href);" class="sesbasic_icon_btn sesbasic_icon_like_btn  eblog_like_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_like_eblog_blog_view <?php echo ($this->LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $this->likeClass;?>"></i><span><?php echo $this->translate($this->likeText);?></span></a>
              <?php } ?>
              <?php if(isset($this->favouriteButtonActive) && $this->coreSettings->getSetting('eblog.enable.favourite', 1) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'favourite')) {  ?>
                    <a href="javascript:;" onclick="nonlogisession(window.location.href);"  class="sesbasic_icon_btn sesbasic_icon_fav_btn  eblog_favourite_eblog_blog_<?php echo $this->eblog->blog_id ?> eblog_favourite_eblog_blog_view <?php echo ($this->favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($this->favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>
              <?php } ?>

            <?php } ?>
				<?php if(isset($this->socialShareActive)):?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->eblog, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
				<?php endif;?>
		</div>
    <div>
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
				<?php if(in_array('tags', $allParams['show_criteria'])) { ?>
          <?php if (count($this->eblogTags )):?>
            <span class="eblog_profile_tags">
              <?php foreach ($this->eblogTags as $tag): ?>
                <a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
              <?php endforeach; ?>
            </span>
          <?php endif; ?>
        <?php } ?>
			<?php endif;?>
		</div>
    </div>
    </div>
	</div>

<?php endif;?>

<script type="text/javascript">
    var allblogidjson=<?php  echo json_encode(Engine_Api::_()->getDbtable('blogs', 'eblog')->getBlogIdForScroll($this->eblog->blog_id,$this->eblog->category_id));  ?>;
    var allid=JSON.parse(JSON.stringify(allblogidjson));
    window.addEvent('domready', function() {
      var height = sesJqueryObject('.rich_content_body').height();
      <?php if($this->eblog->cotinuereading && $this->eblog->continue_height) { ?>
      if(height > '<?php echo $this->eblog->continue_height; ?>'){
        sesJqueryObject('.eblog_morebtn').css("display","block");
        sesJqueryObject('.rich_content_body').css("height",'<?php echo $this->eblog->continue_height; ?>');
        sesJqueryObject('.rich_content_body').css("overflow","hidden");
      }
      <?php } ?>
      sesJqueryObject('.rich_content_body').css("visibility","visible");
    });
  

  $$('.core_main_eblog').getParent().addClass('active');
  sesJqueryObject('.eblog_comment').click(function() {
    sesJqueryObject('.comments_options').find('a').eq(0).trigger('click');
    sesJqueryObject('#adv_comment_subject_btn_<?php echo $this->eblog->blog_id; ?>').trigger('click');
  });
	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"browse"),"eblog_general",true); ?>'+'?tag_id='+tag_id;
	}
	var logincheck = '<?php echo $this->coreSettings->getSetting('eblog.login.continuereading', 1); ?>';
	
	var viwerId = <?php echo $this->viewer_id ?>;
	function continuereading(){

	    var fornonlogin='<?php echo Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'cotinuereading'); ?>';
		
		if(logincheck>0 && !viwerId){
		    if(fornonlogin>0) {
                nonlogisession(window.location.href);
            }
            window.location.href = en4.core.baseUrl +'login';
		}else{
			sesJqueryObject('.rich_content_body').css('height', 'auto');
			sesJqueryObject('.eblog_morebtn').hide();
		}
	}
    sesJqueryObject(function(){
        sesJqueryObject(window).scroll(function(){
            if(allid.length>0) {
                var id=allid.pop()['blog_id'];
                var ajaxurl = en4.core.baseUrl + "eblog/index/viewpagescroll";
                sesJqueryObject.ajax({
                    url: ajaxurl,
                    type: "POST",
                    data: {settings: <?php  echo json_encode($this->allParams); ?>, id:id },
                    success: function (html) {
                        //sesJqueryObject(".layout_eblog_view_blog").append(html);
                    }
                });
            }

        });

    });

</script>
