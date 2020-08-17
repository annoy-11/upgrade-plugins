<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesarticle/externals/styles/styles.css'); ?>
<?php if($this->type == 'grid1'):?>
	<div class="sesarticle_of_the_day">
		<ul class="sesarticle_listing sesbasic_bxs">
			<?php $limit = 0;?>
			<?php $itemArticle = Engine_Api::_()->getItem('sesarticle',$this->article_id);?>
			<?php if($itemArticle):?>
				<li class="sesarticle_grid sesbasic_bxs" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;;">
					<div class="sesarticle_grid_inner sesarticle_thumb">
						<div class="sesarticle_grid_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> <a class="sesarticle_thumb_img" href="<?php echo $itemArticle->getHref(); ?>"><span class="main_image_container" style="background-image: url(<?php echo $itemArticle->getPhotoUrl('thumb.normal'); ?>);"></span> </a>
							<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)){ ?>
								<div class="sesarticle_grid_labels">
									<?php if(isset($this->featuredLabelActive) && $itemArticle->featured == 1){ ?>
										<p class="sesarticle_label_featured"><?php echo $this->translate("Featured"); ?></p>
									<?php } ?>
									<?php if(isset($this->sponsoredLabelActive)  && $itemArticle->sponsored == 1){ ?>
										<p class="sesarticle_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
									<?php } ?>
								</div>
								<?php if(isset($this->verifiedLabelActive) && $itemArticle->verified == 1):?>
									<div class="sesarticle_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
								<?php endif;?>
							<?php } ?>
						</div>

						<?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>

							<div class="sesarticle_grid_info clear sesbasic_clearfix sesbm">

								<?php if(isset($this->titleActive)) { ?>

									<div class="sesarticle_grid_info_title"> <?php echo $this->htmlLink($itemArticle, $this->string()->truncate($itemArticle->getTitle(), $this->title_truncation),array('title'=>$itemArticle->getTitle())) ; ?> </div>

								<?php } ?>

								<div class="sesarticle_list_grid_info sesbasic_clearfix">

									<div class="sesarticle_list_stats">

										<?php if(isset($this->byActive)) { ?>

											<span class="sesarticle_list_grid_owner"> <a href="<?php echo $itemArticle->getOwner()->getHref();?>"><?php echo $this->itemPhoto($itemArticle->getOwner(), 'thumb.icon');?></a> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemArticle->getOwner()->getHref(), $itemArticle->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>

										<?php }?>

									</div>

									<div class="sesarticle_list_stats sesarticle_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i><a href="<?php echo $this->url(array('resource_id' => $itemArticle->article_id,'resource_type'=>'sesarticle','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $itemArticle->location;?></a></span> </div>

								</div>

							</div>

						<?php } ?>

						<div class="sesarticle_grid_hover_block">

							<div class="sesarticle_grid_info_hover_title"> 

								<?php echo $this->htmlLink($itemArticle, $this->string()->truncate($itemArticle->getTitle(), $this->title_truncation),array('title'=>$itemArticle->getTitle())) ; ?> <span></span> 

							</div>

							<?php if($this->descriptionActive): ?>

							<div class="sesarticle_grid_des clear"><?php echo $itemArticle->getDescription($this->description_truncation);?>

							</div>

							<?php endif; ?>

							<div class="sesarticle_grid_hover_block_footer">

								<div class="sesarticle_list_stats sesbasic_text_light">

									<?php if(isset($this->likeActive)) { ?>

										<span class="sesarticle_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemArticle->like_count), $this->locale()->toNumber($itemArticle->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $itemArticle->like_count;?> </span>

									<?php } ?>

									<?php if(isset($this->commentActive)) { ?>

										<span class="sesarticle_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemArticle->comment_count), $this->locale()->toNumber($itemArticle->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $itemArticle->comment_count;?> </span>

									<?php } ?>

									<?php if(isset($this->viewActive)) { ?>

										<span class="sesarticle_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemArticle->view_count), $this->locale()->toNumber($itemArticle->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $itemArticle->view_count;?> </span>

									<?php } ?>

									<?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)) { ?>

										<span class="sesarticle_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemArticle->favourite_count), $this->locale()->toNumber($itemArticle->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $itemArticle->favourite_count;?> </span>

									<?php } ?>

									<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('sesarticlereview', 'view') && isset($this->ratingActive) && isset($itemArticle->rating)): ?>

										<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemArticle->rating,1)), $this->locale()->toNumber(round($itemArticle->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemArticle->rating,1).'/5';?></span>

									<?php endif; ?>

								</div>

							</div>

						</div>

						<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>

							<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemArticle->getHref()); ?>

							<div class="sesarticle_list_grid_thumb_btns"> 

								<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1)):?>

								

                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemArticle, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

								<?php endif;?>

								<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>

									<?php $canComment =  $itemArticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>

									<?php if(isset($this->likeButtonActive) && $canComment):?>

										<!--Like Button-->

										<?php $LikeStatus = Engine_Api::_()->sesarticle()->getLikeStatus($itemArticle->article_id,$itemArticle->getType()); ?>

										<a href="javascript:;" data-url="<?php echo $itemArticle->article_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesarticle_like_sesarticle_<?php echo $itemArticle->article_id ?> sesarticle_like_sesarticle <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemArticle->like_count; ?></span></a>

									<?php endif;?>

									<?php if(isset($this->favouriteButtonActive) && isset($itemArticle->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)): ?>

										<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesarticle')->isFavourite(array('resource_type'=>'sesarticle','resource_id'=>$itemArticle->article_id)); ?>

										<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesarticle_favourite_sesarticle_<?php echo $itemArticle->article_id ?> sesarticle_favourite_sesarticle <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $itemArticle->article_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemArticle->favourite_count; ?></span></a>

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
	<div class="sesarticle_second_of_the_day">
		<ul class="sesarticle_album_listing sesbasic_bxs">
			<?php $limit = 0;?>
			<?php $itemArticle = Engine_Api::_()->getItem('sesarticle',$this->article_id);?>
			<?php if($itemArticle):?>
			<li class="sesarticle_grid sesarticle_list_grid_thumb sesarticle_list_grid sesa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sesa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
				<div class="sesarticle_grid_inner sesarticle_thumb">
					<div class="sesarticle_grid_thumb sesarticle_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> <a class="sesarticle_thumb_img" href="<?php echo $itemArticle->getHref(); ?>"> <span class="main_image_container" style="background-image: url(<?php echo $itemArticle->getPhotoUrl('thumb.main'); ?>);"></span> </a>
						<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
						<div class="sesarticle_grid_labels">
							<?php if(isset($this->featuredLabelActive) && $itemArticle->featured == 1){ ?>
							<p class="sesarticle_label_featured"><?php echo $this->translate("Featured"); ?></p>
							<?php } ?>
							<?php if(isset($this->sponsored)  && $itemArticle->sponsoredLabelActive == 1){ ?>
							<p class="sesarticle_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
							<?php } ?>
						</div>
						<?php if(isset($this->verifiedLabelActive) && $itemArticle->verified == 1):?>
							<div class="sesarticle_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
						<?php endif;?>
						<?php } ?>
						</div>
						<?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
					<div class="sesarticle_grid_info clear sesbasic_clearfix sesbm">
						<?php if(isset($this->titleActive)) { ?>
						<div class="sesarticle_category_grid_info_title"> <?php echo $this->htmlLink($itemArticle, $this->string()->truncate($itemArticle->getTitle(), $this->title_truncation),array('title'=>$itemArticle->getTitle())) ; ?> </div>
						<?php } ?>
						<div class="sesarticle_list_grid_info sesbasic_clearfix">
							<div class="sesarticle_list_stats">
								<?php if(isset($this->byActive)) { ?>
									<span class="sesarticle_list_grid_owner"> <a href="<?php echo $itemArticle->getOwner()->getHref();?>">
									<?php echo $this->itemPhoto($itemArticle->getOwner(), 'thumb.icon');?></a> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemArticle->getOwner()->getHref(), $itemArticle->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
								<?php }?>
							</div>
							<div class="sesarticle_list_stats sesarticle_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $itemArticle->article_id,'resource_type'=>'sesarticle','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $itemArticle->location;?></a></span> </div>
						</div>
						<?php } ?>
						<div class="sesarticle_list_stats sesbasic_text_light">
							<?php if(isset($this->likeActive)) { ?>
								<span class="sesarticle_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemArticle->like_count), $this->locale()->toNumber($itemArticle->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $itemArticle->like_count;?> </span>
							<?php } ?>
							<?php if(isset($this->commentActive)) { ?>
								<span class="sesarticle_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemArticle->comment_count), $this->locale()->toNumber($itemArticle->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $itemArticle->comment_count;?> </span>
							<?php } ?>
							<?php if(isset($this->viewActive)) { ?>
								<span class="sesarticle_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemArticle->view_count), $this->locale()->toNumber($itemArticle->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $itemArticle->view_count;?> </span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)) { ?>
								<span class="sesarticle_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemArticle->favourite_count), $this->locale()->toNumber($itemArticle->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $itemArticle->favourite_count;?> </span>
							<?php } ?>
							<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('sesarticlereview', 'view') && isset($this->ratingActive) && isset($itemArticle->rating)): ?>
								<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemArticle->rating,1)), $this->locale()->toNumber(round($itemArticle->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemArticle->rating,1).'/5';?></span>
							<?php endif; ?>
					</div>
					
				</div>
				<div class="sesarticle_list_thumb_over">
											<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
							<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemArticle->getHref()); ?>
							<div class="sesarticle_list_grid_thumb_btns"> 
								<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1)):?>
                  
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemArticle, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

								<?php endif;?>
								<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
									<?php $canComment =  $itemArticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
									<?php if(isset($this->likeButtonActive) && $canComment):?>
										<!--Like Button-->
										<?php $LikeStatus = Engine_Api::_()->sesarticle()->getLikeStatus($itemArticle->article_id,$itemArticle->getType()); ?>
										<a href="javascript:;" data-url="<?php echo $itemArticle->article_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesarticle_like_sesarticle_<?php echo $itemArticle->article_id ?> sesarticle_like_sesarticle <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemArticle->like_count; ?></span></a>
									<?php endif;?>
									<?php if(isset($this->favouriteButtonActive) && isset($itemArticle->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)): ?>
										<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesarticle')->isFavourite(array('resource_type'=>'sesarticle','resource_id'=>$itemArticle->article_id)); ?>
										<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesarticle_favourite_sesarticle_<?php echo $itemArticle->article_id ?> sesarticle_favourite_sesarticle <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $itemArticle->article_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemArticle->favourite_count; ?></span></a>
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
<div class="sesarticle_three_of_the_day">
 <?php $limit = 0;?>
    <?php $itemArticle = Engine_Api::_()->getItem('sesarticle',$this->article_id);?>
    <?php if($itemArticle):?>
  <div class="sesarticle_last_grid_block sesbasic_bxs " style="width:140px;">
    <div class="sesarticle_grid_inner">
      <div class="sesarticle_grid_thumb sesarticle_thumb" style="height:160px;"> <a class="sesarticle_thumb_img" href="<?php echo $itemArticle->getHref(); ?>"> 
      <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
      <span class="main_image_container" style="background-image: url(<?php echo $itemArticle->getPhotoUrl('thumb.main'); ?>);"></span> </a>
        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
        <div class="sesarticle_grid_labels">
          <?php if(isset($this->featuredLabelActive) && $itemArticle->featured == 1){ ?>
          <p class="sesarticle_label_featured"><?php echo $this->translate("Featured"); ?></p>
          <?php } ?>
          <?php if(isset($this->sponsoredLabelActive)  && $itemArticle->sponsored == 1){ ?>
          <p class="sesarticle_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
          <?php } ?>
        </div>
        <?php } ?>
				<?php if(isset($this->verifiedLabelActive) && $itemArticle->verified == 1):?>
					<div class="sesarticle_grid_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
				<?php endif;?>
        <div class="sesarticle_grid_thumb_over">
          <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
						<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemArticle->getHref()); ?>
						<div class="sesarticle_list_grid_thumb_btns"> 
							<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1)):?>
                
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemArticle, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
							<?php endif;?>
							<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
								<?php $canComment =  $itemArticle->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
								<?php if(isset($this->likeButtonActive) && $canComment):?>
									<!--Like Button-->
									<?php $LikeStatus = Engine_Api::_()->sesarticle()->getLikeStatus($itemArticle->article_id,$itemArticle->getType()); ?>
									<a href="javascript:;" data-url="<?php echo $itemArticle->article_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesarticle_like_sesarticle_<?php echo $itemArticle->article_id ?> sesarticle_like_sesarticle <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemArticle->like_count; ?></span></a>
								<?php endif;?>
								<?php if(isset($this->favouriteButtonActive) && isset($itemArticle->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)): ?>
									<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesarticle')->isFavourite(array('resource_type'=>'sesarticle','resource_id'=>$itemArticle->article_id)); ?>
									<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesarticle_favourite_sesarticle_<?php echo $itemArticle->article_id ?> sesarticle_favourite_sesarticle <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $itemArticle->article_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemArticle->favourite_count; ?></span></a>
								<?php endif;?>
							<?php endif;?>
						</div>
					<?php endif;?>
        </div>
      </div>
      <div class="sesarticle_grid_info clear clearfix sesbm">
        <div class="sesarticle_grid_meta_block">
					<?php if($itemArticle->category_id != '' && intval($itemArticle->category_id) && !is_null($itemArticle->category_id)):?> 
						<?php $categoryItem = Engine_Api::_()->getItem('sesarticle_category', $itemArticle->category_id);?>
						<?php if($categoryItem && $this->categoryActive):?>
							<div class="sesarticle_grid_memta_title floatL">
								<span>
									<a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
								</span>
							</div>
						<?php endif;?>
					<?php endif;?>
          <?php if(Engine_Api::_()->getApi('core', 'sesarticle')->allowReviewRating() && isset($this->ratingStarActive)):?>
				<?php echo $this->partial('_articleRating.tpl', 'sesarticle', array('rating' => $itemArticle->rating, 'class' => 'sesarticle_list_rating sesarticle_list_view_ratting floatR', 'style' => 'margin:0px;'));?>
			<?php endif;?>
        </div>
        <?php if(isset($this->titleActive)) { ?>
        <div class="sesarticle_grid_three_info_title"> <?php echo $this->htmlLink($itemArticle, $this->string()->truncate($itemArticle->getTitle(), $this->title_truncation),array('title'=>$itemArticle->getTitle())) ; ?> </div>
        <?php } ?>
        <div class="sesarticle_grid_meta_block">
          <div class="sesarticle_list_stats sesbasic_text_dark">
            <?php if(isset($this->byActive)) { ?>
            <span class="sesarticle_list_grid_owner"> <a href="<?php $itemArticle->getOwner()->getHref();?>"><?php echo $this->itemPhoto($itemArticle->getOwner(), 'thumb.icon');?></a> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemArticle->getOwner()->getHref(), $itemArticle->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
            <?php }?>
            | <span><i class="fa fa-map-marker"></i>&nbsp;<a href="<?php echo $this->url(array('resource_id' => $itemArticle->article_id,'resource_type'=>'sesarticle','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $itemArticle->location;?></a></span> </div>
        </div>
        <div class="sesarticle_grid_contant">
          <?php echo $itemArticle->getDescription($this->description_truncation);?>
        </div>
        <div class="sesarticle_comment_list sesarticle_list_stats sesbasic_text_dark floatL">
          <?php if(isset($this->likeActive)) { ?>
          <span class="sesarticle_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemArticle->like_count), $this->locale()->toNumber($itemArticle->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $itemArticle->like_count;?> </span>
          <?php } ?>
          <?php if(isset($this->commentActive)) { ?>
          <span class="sesarticle_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemArticle->comment_count), $this->locale()->toNumber($itemArticle->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $itemArticle->comment_count;?> </span>
          <?php } ?>
          <?php if(isset($this->viewActive)) { ?>
          <span class="sesarticle_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemArticle->view_count), $this->locale()->toNumber($itemArticle->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $itemArticle->view_count;?> </span>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)) { ?>
          <span class="sesarticle_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemArticle->favourite_count), $this->locale()->toNumber($itemArticle->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $itemArticle->favourite_count;?> </span>
          <?php } ?>
          <?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('sesarticlereview', 'view') && isset($this->ratingActive) && isset($itemArticle->rating)): ?>
							<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemArticle->rating,1)), $this->locale()->toNumber(round($itemArticle->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemArticle->rating,1).'/5';?></span>
						<?php endif; ?></div>
        <div class="sesarticle_second_readmore_link floatR"> <a href="<?php echo $itemArticle->getHref();?>"><?php echo $this->translate('Read More...');?></a> </div>
      </div>
      <?php } ?>
    </div>
  </div>
      <?php endif;?>
    <?php $limit++;
   ?></div>
 <?php endif;?>
