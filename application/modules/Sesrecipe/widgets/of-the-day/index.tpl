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
<?php if($this->type == 'grid1'):?>
	<div class="sesrecipe_recipe_of_the_day">
		<ul class="sesrecipe_album_listing sesbasic_bxs">
			<?php $limit = 0;?>
			<?php $itemRecipe = Engine_Api::_()->getItem('sesrecipe_recipe',$this->recipe_id);?>
			<?php if($itemRecipe):?>
				<li class="sesrecipe_grid sesrecipe_list_grid_thumb sesrecipe_list_grid sesa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sesa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
					<div class="sesrecipe_grid_inner sesrecipe_thumb">
						<div class="sesrecipe_grid_thumb sesrecipe_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> <a class="sesrecipe_thumb_img" href="<?php echo $itemRecipe->getHref(); ?>"> <span class="main_image_container" style="background-image: url(<?php echo $itemRecipe->getPhotoUrl('thumb.normal'); ?>);"></span> </a>
							<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)){ ?>
								<div class="sesrecipe_grid_labels">
									<?php if(isset($this->featuredLabelActive) && $itemRecipe->featured == 1){ ?>
										<p class="sesrecipe_label_featured"><?php echo $this->translate("Featured"); ?></p>
									<?php } ?>
									<?php if(isset($this->sponsoredLabelActive)  && $itemRecipe->sponsored == 1){ ?>
										<p class="sesrecipe_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
									<?php } ?>
								</div>
								<?php if(isset($this->verifiedLabelActive) && $itemRecipe->verified == 1):?>
									<div class="sesrecipe_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
								<?php endif;?>
							<?php } ?>
						</div>
						<?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
							<div class="sesrecipe_grid_info clear sesbasic_clearfix sesbm">
								<?php if(isset($this->titleActive)) { ?>
									<div class="sesrecipe_grid_info_title"> <?php echo $this->htmlLink($itemRecipe, $this->string()->truncate($itemRecipe->getTitle(), $this->title_truncation),array('title'=>$itemRecipe->getTitle())) ; ?> </div>
								<?php } ?>
								<div class="sesrecipe_list_grid_info sesbasic_clearfix">
									<div class="sesrecipe_list_stats">
										<?php if(isset($this->byActive)) { ?>
											<span class="sesrecipe_list_grid_owner"> <a href="<?php echo $itemRecipe->getOwner()->getHref();?>"><?php echo $this->itemPhoto($itemRecipe->getOwner(), 'thumb.icon');?></a> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemRecipe->getOwner()->getHref(), $itemRecipe->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
										<?php }?>
									</div>
									<div class="sesrecipe_list_stats sesrecipe_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i><?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_location_direction.tpl';?></span> </div>
								</div>
							</div>
						<?php } ?>
						<div class="sesrecipe_grid_hover_block">
							<div class="sesrecipe_grid_info_hover_title"> 
								<?php echo $this->htmlLink($itemRecipe, $this->string()->truncate($itemRecipe->getTitle(), $this->title_truncation),array('title'=>$itemRecipe->getTitle())) ; ?> <span></span> 
							</div>
							<div class="sesrecipe_grid_des clear"><?php echo $this->string()->truncate($this->string()->stripTags($itemRecipe->body), $this->description_truncation) ?></div>
							<div class="sesrecipe_grid_hover_block_footer">
								<div class="sesrecipe_list_stats sesbasic_text_light">
									<?php if(isset($this->likeActive)) { ?>
										<span class="sesrecipe_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemRecipe->like_count), $this->locale()->toNumber($itemRecipe->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $itemRecipe->like_count;?> </span>
									<?php } ?>
									<?php if(isset($this->commentActive)) { ?>
										<span class="sesrecipe_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemRecipe->comment_count), $this->locale()->toNumber($itemRecipe->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $itemRecipe->comment_count;?> </span>
									<?php } ?>
									<?php if(isset($this->viewActive)) { ?>
										<span class="sesrecipe_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemRecipe->view_count), $this->locale()->toNumber($itemRecipe->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $itemRecipe->view_count;?> </span>
									<?php } ?>
									<?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
										<span class="sesrecipe_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemRecipe->favourite_count), $this->locale()->toNumber($itemRecipe->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $itemRecipe->favourite_count;?> </span>
									<?php } ?>
									<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('sesrecipe_review', 'view') && isset($this->ratingActive) && isset($itemRecipe->rating)): ?>
										<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemRecipe->rating,1)), $this->locale()->toNumber(round($itemRecipe->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemRecipe->rating,1).'/5';?></span>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
							<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemRecipe->getHref()); ?>
							<div class="sesrecipe_list_grid_thumb_btns"> 
								<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)):?>
								
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemRecipe, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
								<?php endif;?>
								<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
									<?php $canComment =  $itemRecipe->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
									<?php if(isset($this->likeButtonActive) && $canComment):?>
										<!--Like Button-->
										<?php $LikeStatus = Engine_Api::_()->sesrecipe()->getLikeStatus($itemRecipe->recipe_id,$itemRecipe->getType()); ?>
										<a href="javascript:;" data-url="<?php echo $itemRecipe->recipe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesrecipe_like_sesrecipe_recipe_<?php echo $itemRecipe->recipe_id ?> sesrecipe_like_sesrecipe_recipe <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemRecipe->like_count; ?></span></a>
									<?php endif;?>
									<?php if(isset($this->favouriteButtonActive) && isset($itemRecipe->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)): ?>
										<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesrecipe')->isFavourite(array('resource_type'=>'sesrecipe_recipe','resource_id'=>$itemRecipe->recipe_id)); ?>
										<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesrecipe_favourite_sesrecipe_recipe_<?php echo $itemRecipe->recipe_id ?> sesrecipe_favourite_sesrecipe_recipe <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $itemRecipe->recipe_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemRecipe->favourite_count; ?></span></a>
									<?php endif;?>
								<?php endif;?>
							</div>
						<?php endif;?> 
						</div>
				</li>
			<?php endif;?>
			<?php $limit++;?>
		</ul>
	</div>
<?php elseif($this->type == 'grid2'):?>
	<div class="sesrecipe_recipe_second_of_the_day">
		<ul class="sesrecipe_album_listing sesbasic_bxs">
			<?php $limit = 0;?>
			<?php $itemRecipe = Engine_Api::_()->getItem('sesrecipe_recipe',$this->recipe_id);?>
			<?php if($itemRecipe):?>
			<li class="sesrecipe_grid sesrecipe_list_grid_thumb sesrecipe_list_grid sesa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sesa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
				<div class="sesrecipe_grid_inner sesrecipe_thumb">
					<div class="sesrecipe_grid_thumb sesrecipe_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> <a class="sesrecipe_thumb_img" href="<?php echo $itemRecipe->getHref(); ?>"> <span class="main_image_container" style="background-image: url(<?php echo $itemRecipe->getPhotoUrl('thumb.main'); ?>);"></span> </a>
						<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
						<div class="sesrecipe_grid_labels">
							<?php if(isset($this->featuredLabelActive) && $itemRecipe->featured == 1){ ?>
							<p class="sesrecipe_label_featured"><?php echo $this->translate("Featured"); ?></p>
							<?php } ?>
							<?php if(isset($this->sponsored)  && $itemRecipe->sponsoredLabelActive == 1){ ?>
							<p class="sesrecipe_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
							<?php } ?>
						</div>
						<?php if(isset($this->verifiedLabelActive) && $itemRecipe->verified == 1):?>
							<div class="sesrecipe_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
						<?php endif;?>
						<?php } ?>
						</div>
						<?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
					<div class="sesrecipe_grid_info clear sesbasic_clearfix sesbm">
						<?php if(isset($this->titleActive)) { ?>
						<div class="sesrecipe_category_grid_info_title"> <?php echo $this->htmlLink($itemRecipe, $this->string()->truncate($itemRecipe->getTitle(), $this->title_truncation),array('title'=>$itemRecipe->getTitle())) ; ?> </div>
						<?php } ?>
						<div class="sesrecipe_list_grid_info sesbasic_clearfix">
							<div class="sesrecipe_list_stats">
								<?php if(isset($this->byActive)) { ?>
									<span class="sesrecipe_list_grid_owner"> <a href="<?php echo $itemRecipe->getOwner()->getHref();?>">
									<?php echo $this->itemPhoto($itemRecipe->getOwner(), 'thumb.icon');?></a> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemRecipe->getOwner()->getHref(), $itemRecipe->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
								<?php }?>
							</div>
							<div class="sesrecipe_list_stats sesrecipe_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_location_direction.tpl';?> </span> </div>
						</div>
						<?php } ?>
						<div class="sesrecipe_list_stats sesbasic_text_light">
							<?php if(isset($this->likeActive)) { ?>
								<span class="sesrecipe_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemRecipe->like_count), $this->locale()->toNumber($itemRecipe->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $itemRecipe->like_count;?> </span>
							<?php } ?>
							<?php if(isset($this->commentActive)) { ?>
								<span class="sesrecipe_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemRecipe->comment_count), $this->locale()->toNumber($itemRecipe->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $itemRecipe->comment_count;?> </span>
							<?php } ?>
							<?php if(isset($this->viewActive)) { ?>
								<span class="sesrecipe_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemRecipe->view_count), $this->locale()->toNumber($itemRecipe->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $itemRecipe->view_count;?> </span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
								<span class="sesrecipe_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemRecipe->favourite_count), $this->locale()->toNumber($itemRecipe->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $itemRecipe->favourite_count;?> </span>
							<?php } ?>
							<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('sesrecipe_review', 'view') && isset($this->ratingActive) && isset($itemRecipe->rating)): ?>
								<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemRecipe->rating,1)), $this->locale()->toNumber(round($itemRecipe->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemRecipe->rating,1).'/5';?></span>
							<?php endif; ?>
					</div>
					
				</div>
				<div class="sesrecipe_list_thumb_over">
											<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
							<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemRecipe->getHref()); ?>
							<div class="sesrecipe_list_grid_thumb_btns"> 
								<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)):?>
                  
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemRecipe, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

								<?php endif;?>
								<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
									<?php $canComment =  $itemRecipe->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
									<?php if(isset($this->likeButtonActive) && $canComment):?>
										<!--Like Button-->
										<?php $LikeStatus = Engine_Api::_()->sesrecipe()->getLikeStatus($itemRecipe->recipe_id,$itemRecipe->getType()); ?>
										<a href="javascript:;" data-url="<?php echo $itemRecipe->recipe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesrecipe_like_sesrecipe_recipe_<?php echo $itemRecipe->recipe_id ?> sesrecipe_like_sesrecipe_recipe <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemRecipe->like_count; ?></span></a>
									<?php endif;?>
									<?php if(isset($this->favouriteButtonActive) && isset($itemRecipe->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)): ?>
										<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesrecipe')->isFavourite(array('resource_type'=>'sesrecipe_recipe','resource_id'=>$itemRecipe->recipe_id)); ?>
										<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesrecipe_favourite_sesrecipe_recipe_<?php echo $itemRecipe->recipe_id ?> sesrecipe_favourite_sesrecipe_recipe <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $itemRecipe->recipe_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemRecipe->favourite_count; ?></span></a>
									<?php endif;?>
								<?php endif;?>
							</div>
						<?php endif;?>
					</div>
				</div>
			</li>
			<?php endif;?>
			<?php $limit++;
		?>
		</ul>
	</div>
<?php elseif($this->type == 'grid3'):?>
<div class="sesrecipe_recipe_three_of_the_day">
 <?php $limit = 0;?>
    <?php $itemRecipe = Engine_Api::_()->getItem('sesrecipe_recipe',$this->recipe_id);?>
    <?php if($itemRecipe):?>
  <div class="sesrecipe_last_grid_block sesbasic_bxs " style="width:140px;">
    <div class="sesrecipe_grid_inner">
      <div class="sesrecipe_grid_thumb sesrecipe_thumb" style="height:160px;"> <a class="sesrecipe_thumb_img" href="<?php echo $itemRecipe->getHref(); ?>"> 
      <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
      <span class="main_image_container" style="background-image: url(<?php echo $itemRecipe->getPhotoUrl('thumb.main'); ?>);"></span> </a>
        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
        <div class="sesrecipe_grid_labels">
          <?php if(isset($this->featuredLabelActive) && $itemRecipe->featured == 1){ ?>
          <p class="sesrecipe_label_featured"><?php echo $this->translate("Featured"); ?></p>
          <?php } ?>
          <?php if(isset($this->sponsoredLabelActive)  && $itemRecipe->sponsored == 1){ ?>
          <p class="sesrecipe_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
          <?php } ?>
        </div>
        <?php } ?>
				<?php if(isset($this->verifiedLabelActive) && $itemRecipe->verified == 1):?>
					<div class="sesrecipe_grid_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
				<?php endif;?>
        <div class="sesrecipe_grid_thumb_over">
          <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
						<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemRecipe->getHref()); ?>
						<div class="sesrecipe_list_grid_thumb_btns"> 
							<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)):?>
                
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemRecipe, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
							<?php endif;?>
							<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
								<?php $canComment =  $itemRecipe->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
								<?php if(isset($this->likeButtonActive) && $canComment):?>
									<!--Like Button-->
									<?php $LikeStatus = Engine_Api::_()->sesrecipe()->getLikeStatus($itemRecipe->recipe_id,$itemRecipe->getType()); ?>
									<a href="javascript:;" data-url="<?php echo $itemRecipe->recipe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesrecipe_like_sesrecipe_recipe_<?php echo $itemRecipe->recipe_id ?> sesrecipe_like_sesrecipe_recipe <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemRecipe->like_count; ?></span></a>
								<?php endif;?>
								<?php if(isset($this->favouriteButtonActive) && isset($itemRecipe->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)): ?>
									<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesrecipe')->isFavourite(array('resource_type'=>'sesrecipe_recipe','resource_id'=>$itemRecipe->recipe_id)); ?>
									<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesrecipe_favourite_sesrecipe_recipe_<?php echo $itemRecipe->recipe_id ?> sesrecipe_favourite_sesrecipe_recipe <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $itemRecipe->recipe_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemRecipe->favourite_count; ?></span></a>
								<?php endif;?>
							<?php endif;?>
						</div>
					<?php endif;?>
        </div>
      </div>
      <div class="sesrecipe_grid_info clear clearfix sesbm">
        <div class="sesrecipe_grid_meta_block">
					<?php if($itemRecipe->category_id != '' && intval($itemRecipe->category_id) && !is_null($itemRecipe->category_id)):?> 
						<?php $categoryItem = Engine_Api::_()->getItem('sesrecipe_category', $itemRecipe->category_id);?>
						<?php if($categoryItem):?>
							<div class="sesrecipe_grid_memta_title floatL">
								<span>
									<a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
								</span>
							</div>
						<?php endif;?>
					<?php endif;?>
          <?php if(Engine_Api::_()->getApi('core', 'sesrecipe')->allowReviewRating() && isset($this->ratingStarActive)):?>
				<?php echo $this->partial('_recipeRating.tpl', 'sesrecipe', array('rating' => $itemRecipe->rating, 'class' => 'sesrecipe_list_rating sesrecipe_list_view_ratting floatR', 'style' => 'margin:0px;'));?>
			<?php endif;?>
        </div>
        <?php if(isset($this->titleActive)) { ?>
        <div class="sesrecipe_grid_three_info_title"> <?php echo $this->htmlLink($itemRecipe, $this->string()->truncate($itemRecipe->getTitle(), $this->title_truncation),array('title'=>$itemRecipe->getTitle())) ; ?> </div>
        <?php } ?>
        <div class="sesrecipe_grid_meta_block">
          <div class="sesrecipe_list_stats sesbasic_text_dark">
            <?php if(isset($this->byActive)) { ?>
            <span class="sesrecipe_list_grid_owner"> <a href="<?php $itemRecipe->getOwner()->getHref();?>"><?php echo $this->itemPhoto($itemRecipe->getOwner(), 'thumb.icon');?></a> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemRecipe->getOwner()->getHref(), $itemRecipe->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
            <?php }?>
             <span><i class="fa fa-map-marker"></i>&nbsp; <?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_location_direction.tpl';?> </span> </div>
        </div>
        <div class="sesrecipe_grid_contant">
          <?php echo $this->string()->truncate($this->string()->stripTags($itemRecipe->body), $this->description_truncation) ?>
        </div>
        <div class="sesrecipe_comment_list sesrecipe_list_stats sesbasic_text_dark floatL">
          <?php if(isset($this->likeActive)) { ?>
          <span class="sesrecipe_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemRecipe->like_count), $this->locale()->toNumber($itemRecipe->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $itemRecipe->like_count;?> </span>
          <?php } ?>
          <?php if(isset($this->commentActive)) { ?>
          <span class="sesrecipe_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemRecipe->comment_count), $this->locale()->toNumber($itemRecipe->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $itemRecipe->comment_count;?> </span>
          <?php } ?>
          <?php if(isset($this->viewActive)) { ?>
          <span class="sesrecipe_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemRecipe->view_count), $this->locale()->toNumber($itemRecipe->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $itemRecipe->view_count;?> </span>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
          <span class="sesrecipe_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemRecipe->favourite_count), $this->locale()->toNumber($itemRecipe->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $itemRecipe->favourite_count;?> </span>
          <?php } ?>
          <?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('sesrecipe_review', 'view') && isset($this->ratingActive) && isset($itemRecipe->rating)): ?>
							<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemRecipe->rating,1)), $this->locale()->toNumber(round($itemRecipe->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemRecipe->rating,1).'/5';?></span>
						<?php endif; ?></div>
        <div class="sesrecipe_second_readmore_link floatR"> <a href="<?php echo $itemRecipe->getHref();?>"><?php echo $this->translate('Read More...');?></a> </div>
      </div>
      <?php } ?>
    </div>
  </div>
      <?php endif;?>
    <?php $limit++;
   ?></div>
 <?php endif;?>
