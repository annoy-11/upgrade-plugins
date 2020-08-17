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

<?php  $view=Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;  ?>
<?php $view->headLink()->appendStylesheet($view->layout()->staticBaseUrl . 'application/modules/Eblog/externals/styles/styles.css'); ?>
<?php $view->headScript()->appendFile($view->layout()->staticBaseUrl . 'application/modules/Eblog/externals/scripts/infinite-scroll.js'); ?>
<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $eblog->getHref()); ?>
<?php $isBlogAdmin = Engine_Api::_()->eblog()->isBlogAdmin($eblog, 'edit');?>
<?php $reviewCount = Engine_Api::_()->eblog()->getTotalReviews($eblog->blog_id);?>
<?php $canComment =  $eblog->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
<?php $LikeStatus = Engine_Api::_()->eblog()->getLikeStatus($eblog->blog_id,$eblog->getType()); ?> 
<?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
<?php $likeText = ($LikeStatus) ?  $view->translate('Unlike') : $view->translate('Like');?>
<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'eblog')->isFavourite(array('resource_type'=>'eblog_blog','resource_id'=>$eblog->blog_id)); ?>
<?php $isAllowReview = Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.allow.review', 1);?>
<?php $enableSharng = Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1);?>
<?php if($eblog->style == 1):?>
	<div class="eblog_layout_contant sesbasic_clearfix sesbasic_bxs">
	  <?php if(isset($params['titleActive'])):?>
			<h2><?php echo $eblog->getTitle() ?></h2>
		<?php endif;?>
		<div class="eblog_entrylist_entry_date">
    	<p><?php echo $view->translate('<i>Posted by -</i>');?> <?php echo $view->htmlLink($eblog->getOwner()->getHref(), $eblog->getOwner()->getTitle()) ?> &nbsp;-&nbsp;</p>
			<p><?php echo $view->translate('<i>on - </i>') ?><?php echo $view->timestamp($eblog->creation_date) ?><?php if( $category ): ?>&nbsp;-&nbsp;</p>
				<p><?php echo $view->translate('<i>Filed in - </i>') ?>
				<a href="<?php echo $category->getHref(); ?>"><?php echo $view->translate($category->category_name) ?></a><?php endif; ?>&nbsp;-&nbsp;</p>

          <?php   if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.readtime', 1) && isset($eblog->readtime) && !empty($eblog->readtime)) {  ?>
            <p><?php echo $view->translate('<i>Estimated Reading Time - </i>') ?>
              <?php  echo $eblog->readtime; ?>
              <?php  } ?>

            <p><?php if (count($eblog->tags()->getTagMaps() )):?>
				<?php foreach ($eblog->tags()->getTagMaps() as $tag): ?>
					<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if(isset($params['staticsActive'])):?>
				&nbsp;-&nbsp;</p>

				<p>
					<?php if(isset($params['viewActive'])):?>
						<span><?php echo $view->translate(array('%s View', '%s Views', $eblog->view_count), $view->locale()->toNumber($eblog->view_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($params['commentActive'])):?>
						<span><?php echo $view->translate(array('%s Comment', '%s Comments', $eblog->comment_count), $view->locale()->toNumber($eblog->comment_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($params['likeActive'])):?>
						<span><?php echo $view->translate(array('%s Like', '%s Likes', $eblog->like_count), $view->locale()->toNumber($eblog->like_count)) ?></span>
					<?php endif;?>
					<?php if($isAllowReview && isset($params['reviewActive'])):?>
                        &nbsp;-&nbsp;
						<span><?php echo $view->translate(array('%s Review', '%s Reviews', $reviewCount), $view->locale()->toNumber($reviewCount)) ?></span>
					<?php endif;?>
				</p>
			<?php endif;?>
		</div>
		<div class="eblog_entrylist_entry_body">
		  <?php if(isset($params['photoActive']) && $eblog->photo_id):?>
				<div class="eblog_blog_image clear" style="height: <?php echo $params['image_height']; ?>px;overflow: hidden;">
					<img src="<?php echo Engine_Api::_()->storage()->get($eblog->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
				</div>
			<?php endif;?>
			<?php if(isset($params['descriptionActive'])):?>
				<?php if($eblog->cotinuereading){
					$check = true;
					$style = 'style="height:400px; overflow:hidden;"';
				}else{
					$check = false;
					$style = '';
				} ?>
				<div class="rich_content_body" style="visibility:hidden"><?php echo htmlspecialchars_decode($eblog->body);?></div>
				<?php if($check): ?>
					<div class="eblog_morebtn" style="display:none"><a href="javascript:void(0);" onclick="continuereading();"><?php echo $view->translate("Continue Reading"); ?></a></div>
				<?php endif; ?>
			<?php endif;?>
		</div>
    <div class="eblog_footer_two_blog clear">
      <?php if(isset($params['ratingActive'])):?>
				<div class="sesbasic_rating_star floatL">
					<?php $ratingCount = $eblog->rating; $x=0; ?>
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
			<div class="eblog_deshboard_blog floatR">
				<ul>
					<?php if(isset($params['ownerOptionsActive']) && $isBlogAdmin):?>
          	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.subblog', 1)){ ?>
						<li><a href="<?php echo $view->url(array('action' => 'create', 'parent_id' => $eblog->blog_id), 'eblog_general', 'true');?>"><i class="fa fa-edit"></i><?php echo $view->translate('Create Sub Blog');?></a></li>
           <?php } ?>
						<li><a href="<?php echo $view->url(array('action' => 'edit', 'blog_id' => $eblog->custom_url), 'eblog_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $view->translate('Dashboard');?></a></li>
						<li><a href="<?php echo $view->url(array('action' => 'delete', 'blog_id' => $eblog->getIdentity()), 'eblog_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $view->translate('Delete This Blog');?></a></li>
					<?php endif;?>
					<?php if($params['viewer_id'] && isset($params['smallShareButtonActive']) && $enableSharng):?>
						<li><a href="<?php echo $view->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $eblog->getType(), "id" => $eblog->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i> <?php echo $view->translate('Share');?></a></li>
					<?php endif;?>

                    <?php if($params['viewer_id']){  ?>
					<?php if($params['viewer_id'] && $params['viewer_id'] != $eblog->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.report', 1)):?>
						<li><a href="<?php echo $view->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $eblog->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $view->translate('Report');?></a></li>
					<?php endif;?>

                  <?php  } else { ?>
                  <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'claim') && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.report', 1)) { ?>
                        <li><a onclick="nonlogisession(window.location.href);" href="javascript:;"><i class="fa fa-flag"></i><?php echo $view->translate('Report');?></a></li>
                  <?php  } ?>
                <?php } ?>

                 <?php if($params['viewer_id']){  ?>
					<?php if(isset($params['postCommentActive']) && $canComment):?>
						<li><a href="javascript:void(0);" class="eblog_comment"><i class="eblog_comment fa fa-commenting"></i><?php echo $view->translate('Post Comment');?></a></li>
                   <?php endif;?>
                   <?php  } else { ?>
                   <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'commenting') && isset($params['postCommentActive'])) { ?>
                         <li><a onclick="nonlogisession(window.location.href);" href="javascript:void(0);"><i class="eblog_comment fa fa-commenting"></i><?php echo $view->translate('Post Comment');?></a></li>
                   <?php  } ?>
                   <?php  } ?>
				</ul>
			</div>
      <div class="eblog_shear_blog sesbasic_bxs">
        <?php if(isset($params['socialShareActive']) && $enableSharng):?>
        
          <?php echo $view->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $eblog, 'socialshare_enable_plusicon' => $params['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $params['socialshare_icon_limit'])); ?>
			  <?php endif;?>
				<?php if($params['viewer_id'] && $enableSharng && isset($params['shareButtonActive'])):?>
						<a href="<?php echo $view->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $eblog->getType(), "id" => $eblog->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="share_icon sesbasic_icon_btn smoothbox"><i class="fa fa-share "></i><span><?php echo $view->translate('Share');?></span></a>
				<?php endif;?>
			<?php if($params['viewer_id']) { ?>
					<?php if(isset($params['likeButtonActive']) && $canComment):?>
							<a href="javascript:;" data-url="<?php echo $eblog->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_like_btn  eblog_like_eblog_blog_<?php echo $eblog->blog_id ?> eblog_like_eblog_blog_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $view->translate($likeText);?></span></a>
					<?php endif;?>
					<?php if(isset($params['favouriteButtonActive']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)):?>
							<a href="javascript:;" data-url="<?php echo $eblog->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_fav_btn  eblog_favourite_eblog_blog_<?php echo $eblog->blog_id ?> eblog_favourite_eblog_blog_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $view->translate('Un-Favourite');?><?php else:?><?php echo $view->translate('Favourite');?><?php endif;?></span></a>
					<?php endif;?>
        <?php } else {  ?>
              <?php if(isset($params['likeButtonActive']) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'like')) { ?>
                    <a href="javascript:;" onclick="nonlogisession(window.location.href);" class="sesbasic_icon_btn sesbasic_icon_like_btn  eblog_like_eblog_blog_<?php echo $eblog->blog_id ?> eblog_like_eblog_blog_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $view->translate($likeText);?></span></a>
              <?php } ?>
              <?php if(isset($params['favouriteButtonActive']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'favourite')) {  ?>
                    <a href="javascript:;" onclick="nonlogisession(window.location.href);"  class="sesbasic_icon_btn sesbasic_icon_fav_btn  eblog_favourite_eblog_blog_<?php echo $eblog->blog_id ?> eblog_favourite_eblog_blog_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $view->translate('Un-Favourite');?><?php else:?><?php echo $view->translate('Favourite');?><?php endif;?></span></a>
              <?php } ?>

        <?php   } ?>
			</div>
		</div>
	</div>
<?php elseif($eblog->style == 2):?>
	<!--second profile blog start-->
	<div class="eblog_profile_layout_second sesbasic_clearfix sesbasic_bxs">

    <?php if(isset($params['photoActive']) && $eblog->photo_id):?>
      <div class="eblog_profile_layout_second_image clear" >
          <a href="<?php echo $eblog->getHref(); ?>"><img  src="<?php echo Engine_Api::_()->storage()->get($eblog->photo_id)->getPhotoUrl('thumb.main'); ?>" alt=""></a>
      </div>
    <?php endif;?>
		
	  <?php if( $category ): ?>
    				<?php echo $view->translate('') ?>
  	<div class="eblog_category_teg">
     <p>   
				<a href="<?php echo $category->getHref(); ?>"><?php echo $view->translate($category->category_name) ?></a>
			</p>
		</div><?php endif; ?>
		<?php if(isset($params['titleActive'])):?>
			<h2><?php echo $eblog->getTitle() ?></h2>
		<?php endif;?>
		<div class="eblog_entrylist_entry_date">
			<p><?php echo $view->translate('<i>Posted by -</i>');?> <?php echo $view->htmlLink($eblog->getOwner()->getHref(), $eblog->getOwner()->getTitle()) ?> &nbsp;\&nbsp;</p>
      <p><?php echo $view->translate('<i class="fa fa-calendar-o"></i>') ?>&nbsp;
			<?php echo $view->timestamp($eblog->publish_date) ?>
			<?php  ?>
			<?php if (count($eblog->tags()->getTagMaps() )):?> &nbsp;\&nbsp;
				</p>
        <p><?php echo $view->translate('<i>Filed in - </i>') ?>
				<a href="<?php echo $category->getHref(); ?>"><?php echo $view->translate($category->category_name) ?></a>
        &nbsp;\&nbsp;</p>
        <p>
        <?php foreach ($eblog->tags()->getTagMaps() as $tag): ?>
					<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if(isset($params['staticsActive'])):?>
				&nbsp;\&nbsp;</p>
				<p>
				<?php if(isset($params['viewActive'])):?>
					<span><i class="fa fa-eye"></i>&nbsp;
					<?php echo $view->translate(array('%s view', '%s views', $eblog->view_count), $view->locale()->toNumber($eblog->view_count)) ?>&nbsp;\&nbsp;</span>
				<?php endif;?>
				<?php if(isset($params['commentActive'])):?>
					<span><i class="fa fa-comment"></i>&nbsp;<?php echo $view->translate(array('%s comment', '%s comments', $eblog->comment_count), $view->locale()->toNumber($eblog->comment_count)) ?>&nbsp;\&nbsp;</span>
				<?php endif;?>
				<?php if(isset($params['likeActive'])):?>
					<span><i class="fa fa-thumbs-up"></i>&nbsp;<?php echo $view->translate(array('%s like', '%s likes', $eblog->like_count), $view->locale()->toNumber($eblog->like_count)) ?></span>
				<?php endif;?>
				<?php if($isAllowReview && isset($params['reviewActive'])):?>
                    &nbsp;\&nbsp;
					<span><i class="fa fa-edit"></i>&nbsp;<?php echo $view->translate(array('%s review', '%s reviews', $reviewCount), $view->locale()->toNumber($reviewCount)) ?></span>
				<?php endif;?>
				</p>
      <?php endif;?>
		</div>
		<?php if(isset($params['descriptionActive'])):?>
			<?php if($eblog->cotinuereading){
					$check = true;
					$style = 'style="height:400px; overflow:hidden;"';
				}else{
					$check = false;
					$style = '';
				} ?>
				<div class="rich_content_body" style="visibility:hidden"><?php echo htmlspecialchars_decode($eblog->body);?></div>
				<?php if($check): ?>
					<div class="eblog_entrylist_entry_body eblog_morebtn" style="display:none"><a href="javascript:void(0);" onclick="continuereading();"><?php echo $view->translate("Continue Reading"); ?></a></div>
				<?php endif; ?>
		<?php endif;?>
    <div class="eblog_view_footer_top clear sesbasic_clearfix">
      <?php if(isset($params['ratingActive'])):?>
				<div class="sesbasic_rating_star floatL">
					<?php $ratingCount = $eblog->rating; $x=0; ?>
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
      <div class="eblog_view_footer_links floatR">
				<ul>
					<?php if(isset($params['ownerOptionsActive']) && $isBlogAdmin):?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.subblog', 1)){ ?>
						<li><a href="<?php echo $view->url(array('action' => 'create', 'parent_id' => $eblog->blog_id), 'eblog_general', 'true');?>"><i class="fa fa-edit"></i><?php echo $view->translate('Create Sub Blog');?>
            </a></li>
          <?php } ?>
						<li><a href="<?php echo $view->url(array('action' => 'edit', 'blog_id' => $eblog->custom_url), 'eblog_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $view->translate('Dashboard');?></a></li>
						<li><a href="<?php echo $view->url(array('action' => 'delete', 'blog_id' => $eblog->getIdentity()), 'eblog_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $view->translate('Delete This Blog');?></a></li>
					<?php endif;?>
					<?php if($params['viewer_id']):?>
						<li><a href="<?php echo $view->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $eblog->getType(), "id" => $eblog->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i><?php echo $view->translate('Share');?></a></li>
					<?php endif;?>
                  <?php if($params['viewer_id']){ ?>
					<?php if($params['viewer_id'] && $params['viewer_id'] != $eblog->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.report', 1)):?>
						<li><a href="<?php echo $view->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $eblog->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $view->translate('Report');?></a></li>
					<?php endif;?>
				    <?php  } else { ?>
                      <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'claim') && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.report', 1)) { ?>
                          <li><a onclick="nonlogisession(window.location.href);" href="javascript:;"><i class="fa fa-flag"></i><?php echo $view->translate('Report');?></a></li>
                    <?php  } ?>
				    <?php } ?>
				</ul>
			</div>
    </div>
    <div class="eblog_view_footer_top_bottom clear sesbasic_clearfix">
			<div class="eblog_view_footer_links floatL">
        <ul>
          <?php if($params['viewer_id']){ ?>
						<?php if(isset($params['likeButtonActive']) && $canComment):?>
							<li><a href="javascript:;" data-url="<?php echo $eblog->blog_id ; ?>" class="eblog_like_link  eblog_like_eblog_blog_<?php echo $eblog->blog_id ?> eblog_like_eblog_blog_view"><i class="<?php if($LikeStatus):?>fa fa-thumbs-down<?php else:?>fa fa-thumbs-up<?php endif;?>"></i><span><?php if($LikeStatus):?><?php echo $view->translate('Unlike');?><?php else:?><?php echo $view->translate('Like');?><?php endif;?></span></a>&nbsp;/&nbsp;</li>
						<?php endif;?>
						<?php if(isset($params['favouriteButtonActive']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)):?>
							<li><a href="javascript:;" data-url="<?php echo $eblog->blog_id ; ?>" class="eblog_fav_link eblog_favourite_eblog_blog_<?php echo $eblog->blog_id ?> eblog_favourite_eblog_blog_view"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $view->translate('Un-Favourite');?><?php else:?><?php echo $view->translate('Favourite');?><?php endif;?></span></a>&nbsp;/&nbsp;</li>
						<?php endif;?>
					<?php } else {  ?>

            <?php if(isset($params['likeButtonActive']) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'like')) { ?>
            <a href="javascript:;" onclick="nonlogisession(window.location.href);" class="sesbasic_icon_btn sesbasic_icon_like_btn  eblog_like_eblog_blog_<?php echo $eblog->blog_id ?> eblog_like_eblog_blog_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $view->translate($likeText);?></span></a>
          <?php } ?>
          <?php if(isset($params['favouriteButtonActive']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'favourite')) {  ?>
            <a href="javascript:;" onclick="nonlogisession(window.location.href);"  class="sesbasic_icon_btn sesbasic_icon_fav_btn  eblog_favourite_eblog_blog_<?php echo $eblog->blog_id ?> eblog_favourite_eblog_blog_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $view->translate('Un-Favourite');?><?php else:?><?php echo $view->translate('Favourite');?><?php endif;?></span></a>
          <?php } ?>

              <?php } ?>

          <?php if($params['viewer_id']){  ?>
            <?php if(isset($params['postCommentActive']) && $canComment):?>
                  <li><a href="javascript:void(0);" class="eblog_comment"><i class="eblog_comment fa fa-commenting"></i><?php echo $view->translate('Post Comment');?></a></li>
            <?php endif;?>
          <?php  } else { ?>
            <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'commenting') && isset($params['postCommentActive'])) { ?>
                  <li><a onclick="nonlogisession(window.location.href);" href="javascript:void(0);"><i class="eblog_comment fa fa-commenting"></i><?php echo $view->translate('Post Comment');?></a></li>
            <?php  } ?>
          <?php  } ?>
        </ul>
			</div>
			<?php if(isset($params['socialShareActive'])):?>
				<div class="eblog_view_footer_social_share floatR">
					<?php  echo $view->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $eblog, 'socialshare_enable_plusicon' => $params['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $params['socialshare_icon_limit'])); ?>
				</div>
			<?php endif;?>
		</div>
	</div>
	<!--second profile blog end-->
<?php elseif($eblog->style == 3):?>
	<!--three profile blog start-->
	<div class="eblog_profile_layout_three sesbasic_clearfix sesbasic_bxs">
		<?php if(isset($params['ratingActive'])):?>
			<div class="sesbasic_rating_star floatR">
				<?php $ratingCount = $eblog->rating; $x=0; ?>
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
    <?php if(isset($params['titleActive'])):?>
			<h2><?php echo $eblog->getTitle() ?></h2>
		<?php endif;?>
		<div class="eblog_entrylist_entry_date">
      <?php if( $category ): ?>
				<p class="catogery floatR">
				<?php echo $view->translate('<i class="fa fa-folder"></i>') ?>
				<a href="<?php echo $category->getHref(); ?>"><?php echo $view->translate($category->category_name) ?></a>
				</p>
      <?php endif; ?>
			<p class="">
      	<span><i class=" fa fa-user"></i> <?php echo $view->translate('');?> <?php echo $view->htmlLink($eblog->getOwner()->getHref(), $eblog->getOwner()->getTitle()) ?></span>
      	<span><?php echo $view->translate('<i class="fa fa-calendar-o"></i>') ?>&nbsp;<?php echo $view->timestamp($eblog->publish_date) ?></span>
      	<?php if(isset($params['staticsActive'])):?>
      	  <?php if(isset($params['viewActive'])):?>
						<span><i class="fa fa-eye"></i> <?php echo $view->translate(array('%s view', '%s views', $eblog->view_count), $view->locale()->toNumber($eblog->view_count)) ?></span>
					<?php endif;?>
					<?php if(isset($params['commentActive'])):?>
						<span><i class="fa fa-comment"></i><?php echo $view->translate(array('%s Comment', '%s Comments', $eblog->comment_count), $view->locale()->toNumber($eblog->comment_count)) ?></span>
					<?php endif;?>
					<?php if(isset($params['likeActive'])):?>
						<span><i class="fa fa-thumbs-up"></i><?php echo $view->translate(array('%s Like', '%s Likes', $eblog->like_count), $view->locale()->toNumber($eblog->like_count)) ?></span>
					<?php endif;?>
					<?php if($isAllowReview && isset($params['reviewActive'])):?>
					<span><i class="fa fa-edit"></i><?php echo $view->translate(array('%s Review', '%s Reviews', $reviewCount), $view->locale()->toNumber($reviewCount)) ?></span>
					<?php endif;?>
				<?php endif;?>
				<?php if (count($eblog->tags()->getTagMaps() )):?>
					<span>
						<i class="fa fa-tag"></i>
						<?php foreach ($eblog->tags()->getTagMaps() as $tag): ?>
						<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
					<?php endforeach; ?>
					</span>
				<?php endif; ?>
			</p>
		</div>
		<div class="eblog_entrylist_entry_body">
		  <?php if(isset($params['photoActive']) && $eblog->photo_id):?>
				<div class="eblog_blog_image clear" style="height: <?php echo $params['image_height'] ?>px;overflow: hidden;">
					<img src="<?php echo Engine_Api::_()->storage()->get($eblog->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
				</div>
			<?php endif;?>
			<?php if(isset($params['descriptionActive'])):?>
				<?php if($eblog->cotinuereading){
					$check = true;
					$style = 'style="height:400px; overflow:hidden;"';
				}else{
					$check = false;
					$style = '';
				} ?>
				<div class="rich_content_body" style="visibility:hidden"><?php echo htmlspecialchars_decode($eblog->body);?></div>
				<?php if($check): ?>
					<div class="eblog_entrylist_entry_body eblog_morebtn" style="display:none"><a href="javascript:void(0);" onclick="continuereading();"><?php echo $view->translate("Continue Reading"); ?></a></div>
				<?php endif; ?>
			<?php endif;?>
		</div>
		<div class="eblog_three_blog_footer">
    	<div class="eblog_three_blog_footer_links floatL">
      <ul>

      <?php if($params['viewer_id']){  ?>
            <?php if(isset($params['likeButtonActive']) && $canComment):?>
                        <li><a href="javascript:;" data-url="<?php echo $eblog->blog_id ; ?>" class="eblog_like_link eblog_like_eblog_blog_<?php echo $eblog->blog_id ?> eblog_like_eblog_blog_view"><i class="<?php if($LikeStatus):?>fa fa-thumbs-down<?php else:?>fa fa-thumbs-up<?php endif;?>"></i><span><?php if($LikeStatus):?><?php echo $view->translate('Unlike');?><?php else:?><?php echo $view->translate('Like');?><?php endif;?></span></a>&nbsp;|&nbsp;</li>
            <?php endif;?>
            <?php if(isset($params['favouriteButtonActive']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)):?>
                        <li><a href="javascript:;" data-url="<?php echo $eblog->blog_id ; ?>" class="eblog_fav_link eblog_favourite_eblog_blog_<?php echo $eblog->blog_id ?> eblog_favourite_eblog_blog_view"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $view->translate('Un-Favourite');?><?php else:?><?php echo $view->translate('Favourite');?><?php endif;?></span></a>&nbsp;|&nbsp;	</li>
            <?php endif;?>
        <?php }  else {  ?>

        <?php if(isset($params['likeButtonActive']) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'like')) { ?>
              <a href="javascript:;" onclick="nonlogisession(window.location.href);" class="sesbasic_icon_btn sesbasic_icon_like_btn  eblog_like_eblog_blog_<?php echo $eblog->blog_id ?> eblog_like_eblog_blog_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $view->translate($likeText);?></span></a>
        <?php } ?>
        <?php if(isset($params['favouriteButtonActive']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'favourite')) {  ?>
              <a href="javascript:;" onclick="nonlogisession(window.location.href);"  class="sesbasic_icon_btn sesbasic_icon_fav_btn  eblog_favourite_eblog_blog_<?php echo $eblog->blog_id ?> eblog_favourite_eblog_blog_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $view->translate('Un-Favourite');?><?php else:?><?php echo $view->translate('Favourite');?><?php endif;?></span></a>
        <?php } ?>

      <?php } ?>


        <?php if($params['viewer_id']){  ?>
          <?php if(isset($params['postCommentActive']) && $canComment):?>
                <li><a href="javascript:void(0);" class="eblog_comment"><i class="eblog_comment fa fa-commenting"></i><?php echo $view->translate('Post Comment');?></a></li>
          <?php endif;?>
        <?php  } else { ?>
          <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'commenting') && isset($params['postCommentActive'])) { ?>
                <li><a onclick="nonlogisession(window.location.href);" href="javascript:void(0);"><i class="eblog_comment fa fa-commenting"></i><?php echo $view->translate('Post Comment');?></a></li>
          <?php  } ?>
        <?php  } ?>
      </ul>
			</div>
      <div class="eblog_three_blog_footer_links floatR">
				<ul>
					<?php if(isset($params['ownerOptionsActive']) && $isBlogAdmin):?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.subblog', 1)){ ?>
						<li><a href="<?php echo $view->url(array('action' => 'create', 'parent_id' => $eblog->blog_id), 'eblog_general', 'true');?>" class=""><i class="fa fa-edit"></i><?php echo $view->translate('Create Sub Blog');?>
            </a>&nbsp;|&nbsp;</li>
          <?php } ?>
						<li><a href="<?php echo $view->url(array('action' => 'edit', 'blog_id' => $eblog->custom_url), 'eblog_dashboard', 'true');?>" class=""><i class="fa fa-edit"></i><?php echo $view->translate('Dashboard');?></a>&nbsp;|&nbsp;</li>
						<li><a href="<?php echo $view->url(array('action' => 'delete', 'blog_id' => $eblog->getIdentity()), 'eblog_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $view->translate('Delete This Blog');?></a>&nbsp;|&nbsp;</li>
					<?php endif;?>
					<?php if($params['viewer_id']):?>
						<li><a href="<?php echo $view->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $eblog->getType(), "id" => $eblog->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i><?php echo $view->translate('Share');?></a></li>
					<?php endif;?>
                <?php if($params['viewer_id']){  ?>
					<?php if($params['viewer_id'] && $params['viewer_id'] != $eblog->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.report', 1)):?>
						<li><a href="<?php echo $view->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $eblog->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $view->translate('Report');?></a></li>
					<?php endif;?>
              <?php  } else { ?>
              <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'claim') && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.report', 1)) { ?>
                    <li><a onclick="nonlogisession(window.location.href);" href="javascript:;"><i class="fa fa-flag"></i><?php echo $view->translate('Report');?></a></li>
              <?php  } ?>
            <?php } ?>
				</ul>
			</div>
    </div>
    <?php if(isset($params['socialShareActive'])):?>
			<div class="eblog_footer_blog clear">
				<p><?php echo $view->translate('SHARE THIS STORY');?></p>
				<div class="eblog_footer_blog_social_share sesbasic_clearfix">
            <?php  echo $view->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $eblog, 'socialshare_enable_plusicon' => $params['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $params['socialshare_icon_limit'])); ?>
				</div>
			</div>
		<?php endif;?>
	</div>
	<!--three profile blog start-->
<?php elseif($eblog->style == 4):?>
	<div class="eblog_profile_layout_four sesbasic_clearfix sesbasic_bxs">
	 <?php if(isset($params['ratingActive'])):?>
			<div class="sesbasic_rating_star floatR">
				<?php $ratingCount = $eblog->rating; $x=0; ?>
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
    <?php if(isset($params['titleActive'])):?>
			<h2><?php echo $eblog->getTitle() ?></h2>
		<?php endif;?>
		<div class="eblog_entrylist_entry_date">
			<span class="eblog_entry_border"></span>
			<p>
				<span>
        <?php echo $view->translate('');?>&nbsp; <?php echo $view->htmlLink($eblog->getOwner()->getHref(), 
        $view->itemPhoto($eblog->getOwner()),
				array('class' => 'eblogs_gutter_photo')) ?> <?php echo $view->htmlLink($eblog->getOwner()->getHref(), $eblog->getOwner()->getTitle()) ?> &nbsp;-&nbsp;</span>
				<span>
					<?php echo $view->translate('<i class="fa fa-calendar-o"></i>') ?>
					<?php echo $view->timestamp($eblog->creation_date) ?>
					&nbsp;-&nbsp;
        </span>
        <?php  ?>
				<?php if( $category ): ?>
					<span>
					<?php echo $view->translate('<i class="fa fa-tag"></i>') ?>
					<a href="<?php echo $category->getHref(); ?>"><?php echo $view->translate($category->category_name) ?></a>
				</span>
        <?php endif; ?>
        <?php if (count($eblog->tags()->getTagMaps() )):?>
					<span>
          <?php foreach ($eblog->tags()->getTagMaps() as $tag): ?>
						<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
					<?php endforeach; ?>
					&nbsp;-&nbsp;
        </span>
        <?php endif; ?>
				<?php if(isset($params['staticsActive'])):?>
				  <?php if(isset($params['viewActive'])):?>
						<span><i class="fa fa-eye"></i>
						<?php echo $view->translate(array('%s view', '%s views', $eblog->view_count), $view->locale()->toNumber($eblog->view_count)) ?>
						&nbsp;-&nbsp;
						</span>
          <?php endif;?>
          <?php if(isset($params['commentActive'])):?>
						<span><i class="fa fa-comment-o"></i><?php echo $view->translate(array('%s Comment', '%s Comments', $eblog->comment_count), $view->locale()->toNumber($eblog->comment_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($params['likeActive'])):?>
						<span><i class="fa fa-thumbs-o-up"></i><?php echo $view->translate(array('%s Like', '%s Likes', $eblog->like_count), $view->locale()->toNumber($eblog->like_count)) ?></span>
					<?php endif;?>
					<?php if($isAllowReview && isset($params['reviewActive'])):?>
                        &nbsp;-&nbsp;
						<span><i class="fa fa-edit"></i><?php echo $view->translate(array('%s Review', '%s Reviews', $reviewCount), $view->locale()->toNumber($reviewCount)) ?></span>
					<?php endif;?>
				<?php endif;?>
			</p>
		</div>
		<div class="eblog_entrylist_entry_body">
		  <?php if(isset($params['photoActive']) && $eblog->photo_id):?>
				<div class="eblog_blog_image clear" style="height: <?php echo $params['image_height']; ?>px;overflow: hidden;">
					<img src="<?php echo Engine_Api::_()->storage()->get($eblog->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
				</div>
			<?php endif;?>
		<div class="eblog_social_tabs sesbasic_clearfix">
          <?php if($params['viewer_id']){  ?>
            <?php if(isset($params['postCommentActive']) && $canComment):?>
                  <li><a href="javascript:void(0);" class="eblog_comment"><i class="eblog_comment fa fa-commenting"></i><?php echo $view->translate('Post Comment');?></a></li>
            <?php endif;?>
          <?php  } else { ?>
            <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'commenting') && isset($params['postCommentActive'])) { ?>
                  <li><a onclick="nonlogisession(window.location.href);" href="javascript:void(0);"><i class="eblog_comment fa fa-commenting"></i><?php echo $view->translate('Post Comment');?></a></li>
            <?php  } ?>
          <?php  } ?>
          <?php if($params['viewer_id']){  ?>
				<?php if(isset($params['likeButtonActive'])):?>
					<a href="javascript:;" data-url="<?php echo $eblog->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eblog_like_eblog_blog_<?php echo $eblog->blog_id ?> eblog_like_eblog_blog <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $eblog->like_count; ?></span></a>
				<?php endif;?>
				<?php if(isset($params['favouriteButtonActive']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)):?>
						<a href="javascript:;" data-url="<?php echo $eblog->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn eblog_favourite_eblog_blog_<?php echo $eblog->blog_id ?> eblog_favourite_eblog_blog <?php echo ($favStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-heart"></i><span><?php echo $eblog->favourite_count; ?></span></a>
				<?php endif;?>

              <?php }  else {  ?>

              <?php if(isset($params['likeButtonActive']) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'like')) { ?>
                    <a href="javascript:;" onclick="nonlogisession(window.location.href);" class="sesbasic_icon_btn sesbasic_icon_like_btn  eblog_like_eblog_blog_<?php echo $eblog->blog_id ?> eblog_like_eblog_blog_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $view->translate($likeText);?></span></a>
              <?php } ?>
              <?php if(isset($params['favouriteButtonActive']) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1) &&  Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'favourite')) {  ?>
                    <a href="javascript:;" onclick="nonlogisession(window.location.href);"  class="sesbasic_icon_btn sesbasic_icon_fav_btn  eblog_favourite_eblog_blog_<?php echo $eblog->blog_id ?> eblog_favourite_eblog_blog_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $view->translate('Un-Favourite');?><?php else:?><?php echo $view->translate('Favourite');?><?php endif;?></span></a>
              <?php } ?>

            <?php } ?>
				<?php if(isset($params['socialShareActive'])):?>
          <?php  echo $view->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $eblog, 'socialshare_enable_plusicon' => $params['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $params['socialshare_icon_limit'])); ?>
				<?php endif;?>
		</div>
			<?php if(isset($params['descriptionActive'])):?>
				<?php if($eblog->cotinuereading){
					$check = true;
					$style = 'style="height:400px; overflow:hidden;"';
				}else{
					$check = false;
					$style = '';
				} ?>
				<div class="rich_content_body" style="visibility:hidden"><?php echo htmlspecialchars_decode($eblog->body);?></div>
				<?php if($check): ?>
					<div class="eblog_entrylist_entry_body eblog_morebtn" style="display:none"><a href="javascript:void(0);" onclick="continuereading();"><?php echo $view->translate("Continue Reading"); ?></a></div>
				<?php endif; ?>
			<?php endif;?>
		</div>
    <div class="eblog_deshboard_links ">
        <?php if(isset($params['postCommentActive']) && $canComment):?>
					<p class="profile_layout_fore_post_com floatL"><a href="javascript:void(0);" class="eblog_comment"><i class="eblog_comment fa fa-commenting"></i><span><?php echo $view->translate('Post Comment');?></span></a></p>
				<?php endif;?>
				<ul class="floatR">
					<?php if(isset($params['ownerOptionsActive']) && $isBlogAdmin):?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.subblog', 1)){ ?>
						<li><a href="<?php echo $view->url(array('action' => 'create', 'parent_id' => $eblog->blog_id), 'eblog_general', 'true');?>" class="sesbasic_button "><i class="fa fa-edit"></i><?php echo $view->translate('Create Sub Blog');?>
            </a></li>
          <?php } ?>
						<li><a href="<?php echo $view->url(array('action' => 'edit', 'blog_id' => $eblog->custom_url), 'eblog_dashboard', 'true');?>" class="sesbasic_button "><i class="fa fa-edit"></i><?php echo $view->translate('Dashboard');?></a></li>
						<li><a href="<?php echo $view->url(array('action' => 'delete', 'blog_id' => $eblog->getIdentity()), 'eblog_specific', true);?>" class="smoothbox sesbasic_button "><i class="fa fa-trash "></i><?php echo $view->translate('Delete This Blog');?></a></li>
					<?php endif;?>
					<?php if($params['viewer_id']):?>
						<li><a href="<?php echo $view->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $eblog->getType(), "id" => $eblog->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox sesbasic_button  share_icon"><i class="fa fa-share "></i><?php echo $view->translate('Share');?></a></li>
					<?php endif;?>

                  <?php if($params['viewer_id']){ ?>
					<?php if($params['viewer_id'] && $params['viewer_id'] != $eblog->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.report', 1)):?>
						<li><a href="<?php echo $view->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $eblog->getGuid()),'default', true);?>" class="smoothbox sesbasic_button report_link"><i class="fa fa-flag"></i><?php echo $view->translate('Report');?></a></li>
					<?php endif;?>
                  <?php  } else { ?>
                  <?php if(Engine_Api::_()->authorization()->getPermission(5, 'eblog_blog', 'claim') && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.report', 1)) { ?>
                        <li><a onclick="nonlogisession(window.location.href);" href="javascript:;"><i class="fa fa-flag"></i><?php echo $view->translate('Report');?></a></li>
                  <?php  } ?>
                <?php } ?>
				</ul>
			</div>
	</div>

<?php endif;?>

<script type="text/javascript">
    var allblogid=[];
    allblogid[allblogid.length]=<?php  echo $eblog->blog_id;  ?>;
    window.addEvent('domready', function() {
      var height = sesJqueryObject('.rich_content_body').height();
      <?php if($eblog->cotinuereading && $eblog->continue_height) { ?>
      if(height > '<?php echo $eblog->continue_height; ?>'){
        sesJqueryObject('.eblog_morebtn').css("display","block");
        sesJqueryObject('.rich_content_body').css("height",'<?php echo $eblog->continue_height; ?>');
        sesJqueryObject('.rich_content_body').css("overflow","hidden");
      }
      <?php } ?>
      sesJqueryObject('.rich_content_body').css("visibility","visible");
    });
  

  $$('.core_main_eblog').getParent().addClass('active');
  sesJqueryObject('.eblog_comment').click(function() {
    sesJqueryObject('.comments_options').find('a').eq(0).trigger('click');
    sesJqueryObject('#adv_comment_subject_btn_<?php echo $eblog->blog_id; ?>').trigger('click');
  });
	
	function tagAction(tag_id){
		window.location.href = '<?php echo $view->url(array("action"=>"browse"),"eblog_general",true); ?>'+'?tag_id='+tag_id;
	}
	var logincheck = '<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.login.continuereading', 1); ?>';
	
	var viwerId = <?php echo $params['viewer_id'] ?>;
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

</script>
