<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesrecipe/externals/styles/styles.css'); ?>
<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->sesrecipe->getHref()); ?>
<?php $isRecipeAdmin = Engine_Api::_()->sesrecipe()->isRecipeAdmin($this->sesrecipe, 'edit');?>
<?php $reviewCount = Engine_Api::_()->sesrecipe()->getTotalReviews($this->sesrecipe->recipe_id);?>
<?php $canComment =  $this->sesrecipe->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
<?php $LikeStatus = Engine_Api::_()->sesrecipe()->getLikeStatus($this->sesrecipe->recipe_id,$this->sesrecipe->getType()); ?> 
<?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
<?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesrecipe')->isFavourite(array('resource_type'=>'sesrecipe_recipe','resource_id'=>$this->sesrecipe->recipe_id)); ?>
<?php $enableSharng = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1);?>
<?php if($this->sesrecipe->style == 1):?>
	<div class="sesrecipe_layout_contant sesbasic_clearfix sesbasic_bxs">
	  <?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->sesrecipe->getTitle() ?></h2>
		<?php endif;?>
		<div class="sesrecipe_entrylist_entry_date">
    	<p><?php echo $this->translate('<i>Posted by -</i>');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?> &nbsp;-&nbsp;</p>
			<p><?php echo $this->translate('<i>on - </i>') ?><?php echo $this->timestamp($this->sesrecipe->creation_date) ?><?php if( $this->category ): ?>&nbsp;-&nbsp;</p>
				<p><?php echo $this->translate('<i>Filed in - </i>') ?>
				<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a><?php endif; ?>&nbsp;-&nbsp;</p>
			<p><?php if (count($this->sesrecipeTags )):?>
				<?php foreach ($this->sesrecipeTags as $tag): ?>
					<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if(isset($this->staticsActive)):?>
				&nbsp;-&nbsp;</p>
				<p>
					<?php if(isset($this->viewActive)):?>
						<span><?php echo $this->translate(array('%s View', '%s Views', $this->sesrecipe->view_count), $this->locale()->toNumber($this->sesrecipe->view_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->commentActive)):?>
						<span><?php echo $this->translate(array('%s Comment', '%s Comments', $this->sesrecipe->comment_count), $this->locale()->toNumber($this->sesrecipe->comment_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->likeActive)):?>
						<span><?php echo $this->translate(array('%s Like', '%s Likes', $this->sesrecipe->like_count), $this->locale()->toNumber($this->sesrecipe->like_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->reviewActive)):?>
						<span><?php echo $this->translate(array('%s Review', '%s Reviews', $reviewCount), $this->locale()->toNumber($reviewCount)) ?></span>
					<?php endif;?>
				</p>
			<?php endif;?>
		</div>
		<div class="sesrecipe_entrylist_entry_body">
		  <?php if(isset($this->photoActive) && $this->sesrecipe->photo_id):?>
				<div class="sesrecipe_recipe_image clear">
					<img src="<?php echo Engine_Api::_()->storage()->get($this->sesrecipe->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
				</div>
			<?php endif;?>
			<?php if(isset($this->descriptionActive)):?>
				<div class="rich_content_body"><?php echo $this->sesrecipe->body ?></div>
			<?php endif;?>
		</div>
    <div class="sesrecipe_footer_two_recipe clear">
      <?php if(isset($this->ratingActive)):?>
				<div class="sesbasic_rating_star floatL">
					<?php $ratingCount = $this->sesrecipe->rating; $x=0; ?>
					<?php if( $ratingCount > 0 ): ?>
						<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
							<span id="" class="sesrecipe_rating_star"></span>
						<?php endfor; ?>
						<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
						<span class="sesrecipe_rating_star sesrecipe_rating_star_half"></span>
						<?php }else{ $x = $x - 1;} ?>
						<?php if($x < 5){ 
						for($j = $x ; $j < 5;$j++){ ?>
						<span class="sesrecipe_rating_star sesrecipe_rating_star_disable"></span>
						<?php }   	
						} ?>
					<?php endif; ?>
				</div>
			<?php endif;?>
			<div class="sesrecipe_deshboard_recipe floatR">
				<ul>
					<?php if(isset($this->ownerOptionsActive) && $isRecipeAdmin):?>
          	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.subrecipe', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->sesrecipe->recipe_id), 'sesrecipe_general', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Recipe');?></a></li>
           <?php } ?>
						<li><a href="<?php echo $this->url(array('action' => 'edit', 'recipe_id' => $this->sesrecipe->custom_url), 'sesrecipe_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
						<li><a href="<?php echo $this->url(array('action' => 'delete', 'recipe_id' => $this->sesrecipe->getIdentity()), 'sesrecipe_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Recipe');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && isset($this->smallShareButtonActive) && $enableSharng):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesrecipe->getType(), "id" => $this->sesrecipe->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i> <?php echo $this->translate('Share');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && $this->viewer_id != $this->sesrecipe->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->sesrecipe->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>
					<?php if(isset($this->postCommentActive) && $canComment):?>
						<li><a href="javascript:void(0);" class="sesrecipe_comment"><i class="sesrecipe_comment fa fa-commenting"></i><?php echo $this->translate('Post Comment');?></a></li>
          <?php endif;?>
				</ul>
			</div>
      <div class="sesrecipe_shear_recipe sesbasic_bxs">
        <?php if(isset($this->socialShareActive) && $enableSharng):?>
        
          <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesrecipe, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
			  <?php endif;?>
				<?php if($this->viewer_id && $enableSharng && isset($this->shareButtonActive)):?>
						<a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesrecipe->getType(), "id" => $this->sesrecipe->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="share_icon sesbasic_icon_btn smoothbox"><i class="fa fa-share "></i><span><?php echo $this->translate('Share');?></span></a>
				<?php endif;?>
				<?php if($this->viewer_id):?>
					<?php if(isset($this->likeButtonActive) && $canComment):?>
							<a href="javascript:;" data-url="<?php echo $this->sesrecipe->recipe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_like_btn  sesrecipe_like_sesrecipe_recipe_<?php echo $this->sesrecipe->recipe_id ?> sesrecipe_like_sesrecipe_recipe_view <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $this->translate($likeText);?></span></a>
					<?php endif;?>
					<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)):?>
							<a href="javascript:;" data-url="<?php echo $this->sesrecipe->recipe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_fav_btn  sesrecipe_favourite_sesrecipe_recipe_<?php echo $this->sesrecipe->recipe_id ?> sesrecipe_favourite_sesrecipe_recipe_view <?php echo ($favStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>
					<?php endif;?>
        <?php endif;?>
			</div>
		</div>
	</div>
<?php elseif($this->sesrecipe->style == 2):?>
	<!--second profile recipe start-->
	<div class="sesrecipe_profile_layout_second sesbasic_clearfix sesbasic_bxs">

    <?php if(isset($this->photoActive) && $this->sesrecipe->photo_id):?>
      <div class="sesrecipe_profile_layout_second_image clear">
        <img src="<?php echo Engine_Api::_()->storage()->get($this->sesrecipe->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
      </div>
    <?php endif;?>
		
	  <?php if( $this->category ): ?>
    				<?php echo $this->translate('') ?>
  	<div class="sesrecipe_category_teg">
     <p>   
				<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
			</p>
		</div><?php endif; ?>
		<?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->sesrecipe->getTitle() ?></h2>
		<?php endif;?>
		<div class="sesrecipe_entrylist_entry_date">
			<p><?php echo $this->translate('<i>Posted by -</i>');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?> &nbsp;\&nbsp;</p>
      <p><?php echo $this->translate('<i class="fa fa-calendar-o"></i>') ?>&nbsp;
			<?php echo $this->timestamp($this->sesrecipe->publish_date) ?>
			<?php  ?>
			<?php if (count($this->sesrecipeTags )):?> &nbsp;\&nbsp;
				</p>
        <p><?php echo $this->translate('<i>Filed in - </i>') ?>
				<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
        &nbsp;\&nbsp;</p>
        <p>
        <?php foreach ($this->sesrecipeTags as $tag): ?>
					<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
				<?php endforeach; ?>
			<?php endif; ?>
			<?php if(isset($this->staticsActive)):?>
				&nbsp;\&nbsp;</p>
				<p>
				<?php if(isset($this->viewActive)):?>
					<span><i class="fa fa-eye"></i>&nbsp;
					<?php echo $this->translate(array('%s view', '%s views', $this->sesrecipe->view_count), $this->locale()->toNumber($this->sesrecipe->view_count)) ?>&nbsp;\&nbsp;</span>
				<?php endif;?>
				<?php if(isset($this->commentActive)):?>
					<span><i class="fa fa-comment"></i>&nbsp;<?php echo $this->translate(array('%s comment', '%s comments', $this->sesrecipe->comment_count), $this->locale()->toNumber($this->sesrecipe->comment_count)) ?>&nbsp;\&nbsp;</span>
				<?php endif;?>
				<?php if(isset($this->likeActive)):?>
					<span><i class="fa fa-thumbs-up"></i>&nbsp;<?php echo $this->translate(array('%s like', '%s likes', $this->sesrecipe->like_count), $this->locale()->toNumber($this->sesrecipe->like_count)) ?>&nbsp;\&nbsp;</span>
				<?php endif;?>
				<?php if(isset($this->reviewActive)):?>
					<span><i class="fa fa-edit"></i>&nbsp;<?php echo $this->translate(array('%s review', '%s reviews', $reviewCount), $this->locale()->toNumber($reviewCount)) ?></span>
				<?php endif;?>
				</p>
      <?php endif;?>
		</div>
		<?php if(isset($this->descriptionActive)):?>
			<div class="sesrecipe_entrylist_entry_body rich_content_body">
				<?php echo $this->sesrecipe->body ?>
      </div>		
		<?php endif;?>
    <div class="sesrecipe_view_footer_top clear sesbasic_clearfix">
      <?php if(isset($this->ratingActive)):?>
				<div class="sesbasic_rating_star floatL">
					<?php $ratingCount = $this->sesrecipe->rating; $x=0; ?>
					<?php if( $ratingCount > 0 ): ?>
						<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
							<span id="" class="sesrecipe_rating_star"></span>
						<?php endfor; ?>
						<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
						<span class="sesrecipe_rating_star sesrecipe_rating_star_half"></span>
						<?php }else{ $x = $x - 1;} ?>
						<?php if($x < 5){ 
						for($j = $x ; $j < 5;$j++){ ?>
						<span class="sesrecipe_rating_star sesrecipe_rating_star_disable"></span>
						<?php }   	
						} ?>
					<?php endif; ?>
				</div>
			<?php endif;?>
      <div class="sesrecipe_view_footer_links floatR">
				<ul>
					<?php if(isset($this->ownerOptionsActive) && $isRecipeAdmin):?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.subrecipe', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->sesrecipe->recipe_id), 'sesrecipe_general', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Recipe');?>
            </a></li>
          <?php } ?>
						<li><a href="<?php echo $this->url(array('action' => 'edit', 'recipe_id' => $this->sesrecipe->custom_url), 'sesrecipe_dashboard', 'true');?>"><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
						<li><a href="<?php echo $this->url(array('action' => 'delete', 'recipe_id' => $this->sesrecipe->getIdentity()), 'sesrecipe_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Recipe');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesrecipe->getType(), "id" => $this->sesrecipe->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i><?php echo $this->translate('Share');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && $this->viewer_id != $this->sesrecipe->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->sesrecipe->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>
				</ul>
			</div>
    </div>
    <div class="sesrecipe_view_footer_top_bottom clear sesbasic_clearfix">
			<div class="sesrecipe_view_footer_links floatL">
        <ul>
          <?php if($this->viewer_id):?>
						<?php if(isset($this->likeButtonActive) && $canComment):?>
							<li><a href="javascript:;" data-url="<?php echo $this->sesrecipe->recipe_id ; ?>" class="sesrecipe_like_link  sesrecipe_like_sesrecipe_recipe_<?php echo $this->sesrecipe->recipe_id ?> sesrecipe_like_sesrecipe_recipe_view"><i class="<?php if($LikeStatus):?>fa fa-thumbs-down<?php else:?>fa fa-thumbs-up<?php endif;?>"></i><span><?php if($LikeStatus):?><?php echo $this->translate('Unlike');?><?php else:?><?php echo $this->translate('Like');?><?php endif;?></span></a>&nbsp;/&nbsp;</li>
						<?php endif;?>
						<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)):?>
							<li><a href="javascript:;" data-url="<?php echo $this->sesrecipe->recipe_id ; ?>" class="sesrecipe_fav_link sesrecipe_favourite_sesrecipe_recipe_<?php echo $this->sesrecipe->recipe_id ?> sesrecipe_favourite_sesrecipe_recipe_view"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>&nbsp;/&nbsp;</li>
						<?php endif;?>
					<?php endif;?>
					<?php if(isset($this->postCommentActive) && $canComment):?>
						<li><a href="javascript:void(0);" class="sesrecipe_comment"><i class="sesrecipe_comment fa fa-commenting"></i><span><?php echo $this->translate('Post Comment');?></span></a></li>
          <?php endif;?>
        </ul>
			</div>
			<?php if(isset($this->socialShareActive)):?>
				<div class="sesrecipe_view_footer_social_share floatR">
					<?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesrecipe, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
				</div>
			<?php endif;?>
		</div>
	</div>
	<!--second profile recipe end-->
<?php elseif($this->sesrecipe->style == 3):?>
	<!--three profile recipe start-->
	<div class="sesrecipe_profile_layout_three sesbasic_clearfix sesbasic_bxs">
		<?php if(isset($this->ratingActive)):?>
			<div class="sesbasic_rating_star floatR">
				<?php $ratingCount = $this->sesrecipe->rating; $x=0; ?>
				<?php if( $ratingCount > 0 ): ?>
					<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
						<span id="" class="sesrecipe_rating_star"></span>
					<?php endfor; ?>
					<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
					<span class="sesrecipe_rating_star sesrecipe_rating_star_half"></span>
					<?php }else{ $x = $x - 1;} ?>
					<?php if($x < 5){ 
					for($j = $x ; $j < 5;$j++){ ?>
					<span class="sesrecipe_rating_star sesrecipe_rating_star_disable"></span>
					<?php }   	
					} ?>
				<?php endif; ?>
			</div>
		<?php endif;?>
    <?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->sesrecipe->getTitle() ?></h2>
		<?php endif;?>
		<div class="sesrecipe_entrylist_entry_date">
      <?php if( $this->category ): ?>
				<p class="catogery floatR">
				<?php echo $this->translate('<i class="fa fa-folder"></i>') ?>
				<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
				</p>
      <?php endif; ?>
			<p class="">
      	<span><i class=" fa fa-user"></i> <?php echo $this->translate('');?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?></span>
      	<span><?php echo $this->translate('<i class="fa fa-calendar-o"></i>') ?>&nbsp;<?php echo $this->timestamp($this->sesrecipe->publish_date) ?></span>
      	<?php if(isset($this->staticsActive)):?>
      	  <?php if(isset($this->viewActive)):?>
						<span><i class="fa fa-eye"></i> <?php echo $this->translate(array('%s view', '%s views', $this->sesrecipe->view_count), $this->locale()->toNumber($this->sesrecipe->view_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->commentActive)):?>
						<span><i class="fa fa-comment"></i><?php echo $this->translate(array('%s Comment', '%s Comments', $this->sesrecipe->comment_count), $this->locale()->toNumber($this->sesrecipe->comment_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->likeActive)):?>
						<span><i class="fa fa-thumbs-up"></i><?php echo $this->translate(array('%s Like', '%s Likes', $this->sesrecipe->like_count), $this->locale()->toNumber($this->sesrecipe->like_count)) ?></span>
					<?php endif;?>
					<?php if(isset($this->reviewActive)):?>
					<span><i class="fa fa-edit"></i><?php echo $this->translate(array('%s Review', '%s Reviews', $reviewCount), $this->locale()->toNumber($reviewCount)) ?></span>
					<?php endif;?>
				<?php endif;?>
				<?php if (count($this->sesrecipeTags )):?>
					<span>
						<i class="fa fa-tag"></i>
						<?php foreach ($this->sesrecipeTags as $tag): ?>
						<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
					<?php endforeach; ?>
					</span>
				<?php endif; ?>
			</p>
		</div>
		<div class="sesrecipe_entrylist_entry_body">
		  <?php if(isset($this->photoActive) && $this->sesrecipe->photo_id):?>
				<div class="sesrecipe_recipe_image clear">
					<img src="<?php echo Engine_Api::_()->storage()->get($this->sesrecipe->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
				</div>
			<?php endif;?>
			<?php if(isset($this->descriptionActive)):?>
				<div class="rich_content_body"><?php echo $this->sesrecipe->body;?></div>
			<?php endif;?>
		</div>
		<div class="sesrecipe_three_recipe_footer">
    	<div class="sesrecipe_three_recipe_footer_links floatL">
      <ul>
        <?php if(isset($this->likeButtonActive) && $canComment):?>
					<li><a href="javascript:;" data-url="<?php echo $this->sesrecipe->recipe_id ; ?>" class="sesrecipe_like_link sesrecipe_like_sesrecipe_recipe_<?php echo $this->sesrecipe->recipe_id ?> sesrecipe_like_sesrecipe_recipe_view"><i class="<?php if($LikeStatus):?>fa fa-thumbs-down<?php else:?>fa fa-thumbs-up<?php endif;?>"></i><span><?php if($LikeStatus):?><?php echo $this->translate('Unlike');?><?php else:?><?php echo $this->translate('Like');?><?php endif;?></span></a>&nbsp;|&nbsp;</li>
        <?php endif;?>
        <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)):?>
					<li><a href="javascript:;" data-url="<?php echo $this->sesrecipe->recipe_id ; ?>" class="sesrecipe_fav_link sesrecipe_favourite_sesrecipe_recipe_<?php echo $this->sesrecipe->recipe_id ?> sesrecipe_favourite_sesrecipe_recipe_view"><i class="fa fa-heart"></i><span><?php if($favStatus):?><?php echo $this->translate('Un-Favourite');?><?php else:?><?php echo $this->translate('Favourite');?><?php endif;?></span></a>&nbsp;|&nbsp;	</li>
        <?php endif;?>
        <?php if(isset($this->postCommentActive) && $canComment):?>
					<li><a href="javascript:void(0);" class="sesrecipe_comment"><i class="sesrecipe_comment fa fa-commenting"></i><span><?php echo $this->translate('Post Comment');?></span></a></li>
        <?php endif;?>
      </ul>
			</div>
      <div class="sesrecipe_three_recipe_footer_links floatR">
				<ul>
					<?php if(isset($this->ownerOptionsActive) && $isRecipeAdmin):?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.subrecipe', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->sesrecipe->recipe_id), 'sesrecipe_general', 'true');?>" class=""><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Recipe');?>
            </a>&nbsp;|&nbsp;</li>
          <?php } ?>
						<li><a href="<?php echo $this->url(array('action' => 'edit', 'recipe_id' => $this->sesrecipe->custom_url), 'sesrecipe_dashboard', 'true');?>" class=""><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a>&nbsp;|&nbsp;</li>
						<li><a href="<?php echo $this->url(array('action' => 'delete', 'recipe_id' => $this->sesrecipe->getIdentity()), 'sesrecipe_specific', true);?>" class="smoothbox"><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Recipe');?></a>&nbsp;|&nbsp;</li>
					<?php endif;?>
					<?php if($this->viewer_id):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesrecipe->getType(), "id" => $this->sesrecipe->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox share_icon"><i class="fa fa-share "></i><?php echo $this->translate('Share');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && $this->viewer_id != $this->sesrecipe->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->sesrecipe->getGuid()),'default', true);?>" class="smoothbox report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>
				</ul>
			</div>
    </div>
    <?php if(isset($this->socialShareActive)):?>
			<div class="sesrecipe_footer_recipe clear">
				<p><?php echo $this->translate('SHARE THIS STORY');?></p>
				<div class="sesrecipe_footer_recipe_social_share sesbasic_clearfix">
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesrecipe, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
				</div>
			</div>
		<?php endif;?>
	</div>
	<!--three profile recipe start-->
<?php elseif($this->sesrecipe->style == 4):?>
	<div class="sesrecipe_profile_layout_four sesbasic_clearfix sesbasic_bxs">
	 <?php if(isset($this->ratingActive)):?>
			<div class="sesbasic_rating_star floatR">
				<?php $ratingCount = $this->sesrecipe->rating; $x=0; ?>
				<?php if( $ratingCount > 0 ): ?>
					<?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
						<span id="" class="sesrecipe_rating_star"></span>
					<?php endfor; ?>
					<?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
					<span class="sesrecipe_rating_star sesrecipe_rating_star_half"></span>
					<?php }else{ $x = $x - 1;} ?>
					<?php if($x < 5){ 
					for($j = $x ; $j < 5;$j++){ ?>
					<span class="sesrecipe_rating_star sesrecipe_rating_star_disable"></span>
					<?php }   	
					} ?>
				<?php endif; ?>
			</div>
		<?php endif;?>
    <?php if(isset($this->titleActive)):?>
			<h2><?php echo $this->sesrecipe->getTitle() ?></h2>
		<?php endif;?>
		<div class="sesrecipe_entrylist_entry_date">
			<span class="sesrecipe_entry_border"></span>
			<p>
				<span>
        <?php echo $this->translate('');?>&nbsp; <?php echo $this->htmlLink($this->owner->getHref(), 
        $this->itemPhoto($this->owner),
				array('class' => 'sesrecipes_gutter_photo')) ?> <?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle()) ?> &nbsp;-&nbsp;</span>
				<span>
					<?php echo $this->translate('<i class="fa fa-calendar-o"></i>') ?>
					<?php echo $this->timestamp($this->sesrecipe->creation_date) ?>
					&nbsp;-&nbsp;
        </span>
        <?php  ?>
				<?php if( $this->category ): ?>
					<span>
					<?php echo $this->translate('<i class="fa fa-tag"></i>') ?>
					<a href="<?php echo $this->category->getHref(); ?>"><?php echo $this->translate($this->category->category_name) ?></a>
				</span>
        <?php endif; ?>
        <?php if (count($this->sesrecipeTags )):?>
					<span>
          <?php foreach ($this->sesrecipeTags as $tag): ?>
						<a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'><?php echo $tag->getTag()->text?></a>&nbsp;
					<?php endforeach; ?>
					&nbsp;-&nbsp;
        </span>
        <?php endif; ?>
				<?php if(isset($this->staticsActive)):?>
				  <?php if(isset($this->viewActive)):?>
						<span><i class="fa fa-eye"></i>
						<?php echo $this->translate(array('%s view', '%s views', $this->sesrecipe->view_count), $this->locale()->toNumber($this->sesrecipe->view_count)) ?>
						&nbsp;-&nbsp;
						</span>
          <?php endif;?>
          <?php if(isset($this->commentActive)):?>
						<span><i class="fa fa-comment-o"></i><?php echo $this->translate(array('%s Comment', '%s Comments', $this->sesrecipe->comment_count), $this->locale()->toNumber($this->sesrecipe->comment_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->likeActive)):?>
						<span><i class="fa fa-thumbs-o-up"></i><?php echo $this->translate(array('%s Like', '%s Likes', $this->sesrecipe->like_count), $this->locale()->toNumber($this->sesrecipe->like_count)) ?>&nbsp;-&nbsp;</span>
					<?php endif;?>
					<?php if(isset($this->reviewActive)):?>
						<span><i class="fa fa-edit"></i><?php echo $this->translate(array('%s Review', '%s Reviews', $reviewCount), $this->locale()->toNumber($reviewCount)) ?></span>
					<?php endif;?>
				<?php endif;?>
			</p>
		</div>
		<div class="sesrecipe_entrylist_entry_body">
		  <?php if(isset($this->photoActive) && $this->sesrecipe->photo_id):?>
				<div class="sesrecipe_recipe_image clear">
					<img src="<?php echo Engine_Api::_()->storage()->get($this->sesrecipe->photo_id)->getPhotoUrl('thumb.main'); ?>" alt="">
				</div>
			<?php endif;?>
		<div class="sesrecipe_social_tabs sesbasic_clearfix">
				<?php if(isset($this->postCommentActive) && $canComment):?>
					<a href="javascript:void(0);" class="sesrecipe_comment commenting"><i class="sesrecipe_comment fa fa-comment"></i><?php echo ' '.$this->sesrecipe->comment_count;?></a>
				<?php endif;?>
				<?php if(isset($this->likeButtonActive)):?>
					<a href="javascript:;" data-url="<?php echo $this->sesrecipe->recipe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesrecipe_like_sesrecipe_recipe_<?php echo $this->sesrecipe->recipe_id ?> sesrecipe_like_sesrecipe_recipe <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $this->sesrecipe->like_count; ?></span></a>
				<?php endif;?>
				<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)):?>
						<a href="javascript:;" data-url="<?php echo $this->sesrecipe->recipe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesrecipe_favourite_sesrecipe_recipe_<?php echo $this->sesrecipe->recipe_id ?> sesrecipe_favourite_sesrecipe_recipe <?php echo ($favStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-heart"></i><span><?php echo $this->sesrecipe->favourite_count; ?></span></a>
				<?php endif;?>
				<?php if(isset($this->socialShareActive)):?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $this->sesrecipe, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
				<?php endif;?>
		</div>
			<?php if(isset($this->descriptionActive)):?>
				<div class="rich_content_body"><?php echo $this->sesrecipe->body; ?></div>
			<?php endif;?>
		</div>
    <div class="sesrecipe_deshboard_links ">
        <?php if(isset($this->postCommentActive) && $canComment):?>
					<p class="profile_layout_fore_post_com floatL"><a href="javascript:void(0);" class="sesrecipe_comment"><i class="sesrecipe_comment fa fa-commenting"></i><span><?php echo $this->translate('Post Comment');?></span></a></p>
				<?php endif;?>
				<ul class="floatR">
					<?php if(isset($this->ownerOptionsActive) && $isRecipeAdmin):?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.subrecipe', 1)){ ?>
						<li><a href="<?php echo $this->url(array('action' => 'create', 'parent_id' => $this->sesrecipe->recipe_id), 'sesrecipe_general', 'true');?>" class="sesbasic_button "><i class="fa fa-edit"></i><?php echo $this->translate('Create Sub Recipe');?>
            </a></li>
          <?php } ?>
						<li><a href="<?php echo $this->url(array('action' => 'edit', 'recipe_id' => $this->sesrecipe->custom_url), 'sesrecipe_dashboard', 'true');?>" class="sesbasic_button "><i class="fa fa-edit"></i><?php echo $this->translate('Dashboard');?></a></li>
						<li><a href="<?php echo $this->url(array('action' => 'delete', 'recipe_id' => $this->sesrecipe->getIdentity()), 'sesrecipe_specific', true);?>" class="smoothbox sesbasic_button "><i class="fa fa-trash "></i><?php echo $this->translate('Delete This Recipe');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id):?>
						<li><a href="<?php echo $this->url(array("module" => "activity","controller" => "index","action" => "share", "type" => $this->sesrecipe->getType(), "id" => $this->sesrecipe->getIdentity(), "format" => "smoothbox"), 'default', true);?>" class="smoothbox sesbasic_button  share_icon"><i class="fa fa-share "></i><?php echo $this->translate('Share');?></a></li>
					<?php endif;?>
					<?php if($this->viewer_id && $this->viewer_id != $this->sesrecipe->owner_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.report', 1)):?>
						<li><a href="<?php echo $this->url(array("module" => "core","controller" => "report","action" => "create", 'subject' => $this->sesrecipe->getGuid()),'default', true);?>" class="smoothbox sesbasic_button report_link"><i class="fa fa-flag"></i><?php echo $this->translate('Report');?></a></li>
					<?php endif;?>
				</ul>
			</div>
	</div>

<?php endif;?>

<script type="text/javascript">
  $$('.core_main_sesrecipe').getParent().addClass('active');
  sesJqueryObject('.sesrecipe_comment').click(function() {
    sesJqueryObject('.comments_options').find('a').eq(0).trigger('click');
    sesJqueryObject('#adv_comment_subject_btn_<?php echo $this->sesrecipe->recipe_id; ?>').trigger('click');
  });
	
	function tagAction(tag_id){
		window.location.href = '<?php echo $this->url(array("action"=>"browse"),"sesrecipe_general",true); ?>'+'?tag_id='+tag_id;
	}
</script>