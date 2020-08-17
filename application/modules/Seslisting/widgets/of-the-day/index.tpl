<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslisting/externals/styles/styles.css'); ?>
<?php if($this->type == 'grid1'):?>
	<div class="seslisting_listing_of_the_day">
		<ul class="seslisting_album_listing sesbasic_bxs">
			<?php $limit = 0;?>
			<?php $itemListing = Engine_Api::_()->getItem('seslisting',$this->listing_id);?>
			<?php if($itemListing):?>
				<li class="seslisting_grid seslisting_list_grid_thumb seslisting_list_grid sesa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sesa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
					<div class="seslisting_grid_inner seslisting_thumb">
						<div class="seslisting_grid_thumb seslisting_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> <a class="seslisting_thumb_img" href="<?php echo $itemListing->getHref(); ?>"> <span class="main_image_container" style="background-image: url(<?php echo $itemListing->getPhotoUrl('thumb.normal'); ?>);"></span> </a>
							<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)){ ?>
								<div class="seslisting_grid_labels">
									<?php if(isset($this->featuredLabelActive) && $itemListing->featured == 1){ ?>
										<p class="seslisting_label_featured"><?php echo $this->translate("Featured"); ?></p>
									<?php } ?>
									<?php if(isset($this->sponsoredLabelActive)  && $itemListing->sponsored == 1){ ?>
										<p class="seslisting_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
									<?php } ?>
								</div>
								<?php if(isset($this->verifiedLabelActive) && $itemListing->verified == 1):?>
									<div class="seslisting_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
								<?php endif;?>
							<?php } ?>
						</div>
						<?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
							<div class="seslisting_grid_info clear sesbasic_clearfix sesbm">
								<?php if(isset($this->titleActive)) { ?>
									<div class="seslisting_grid_info_title"> <?php echo $this->htmlLink($itemListing, $this->string()->truncate($itemListing->getTitle(), $this->title_truncation),array('title'=>$itemListing->getTitle())) ; ?> </div>
								<?php } ?>
				<?php if(isset($this->priceActive) ){ ?>
                <div class="seslisting_list_grid_price">
                  <?php echo Engine_Api::_()->seslisting()->getCurrencyPrice($item->price); ?>
                </div>
                <?php } ?>
								<div class="seslisting_list_grid_info sesbasic_clearfix">
									<div class="seslisting_list_stats">
										<?php if(isset($this->byActive)) { ?>
											<span class="seslisting_list_grid_owner sesbasic_text_light"><i class="fa fa-user"></i> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemListing->getOwner()->getHref(), $itemListing->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
										<?php }?>
									</div>
									<div class="seslisting_list_stats seslisting_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $itemListing->listing_id,'resource_type'=>'seslisting','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $itemListing->location;?></a></span> </div>
								</div>
							</div>
						<?php } ?>
						<div class="seslisting_grid_hover_block">
							<div class="seslisting_grid_info_hover_title"> 
								<?php echo $this->htmlLink($itemListing, $this->string()->truncate($itemListing->getTitle(), $this->title_truncation),array('title'=>$itemListing->getTitle())) ; ?> <span></span> 
							</div>
							<div class="seslisting_grid_des clear"><?php echo $itemListing->getDescription($this->description_truncation);?></div>
							<div class="seslisting_grid_hover_block_footer">
								<div class="seslisting_list_stats sesbasic_text_light">
									<?php if(isset($this->likeActive)) { ?>
										<span class="seslisting_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemListing->like_count), $this->locale()->toNumber($itemListing->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $itemListing->like_count;?> </span>
									<?php } ?>
									<?php if(isset($this->commentActive)) { ?>
										<span class="seslisting_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemListing->comment_count), $this->locale()->toNumber($itemListing->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $itemListing->comment_count;?> </span>
									<?php } ?>
									<?php if(isset($this->viewActive)) { ?>
										<span class="seslisting_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemListing->view_count), $this->locale()->toNumber($itemListing->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $itemListing->view_count;?> </span>
									<?php } ?>
									<?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
										<span class="seslisting_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemListing->favourite_count), $this->locale()->toNumber($itemListing->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $itemListing->favourite_count;?> </span>
									<?php } ?>
									<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('seslistingreview', 'view') && isset($this->ratingActive) && isset($itemListing->rating)): ?>
										<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemListing->rating,1)), $this->locale()->toNumber(round($itemListing->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemListing->rating,1).'/5';?></span>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
							<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemListing->getHref()); ?>
							<div class="seslisting_list_grid_thumb_btns"> 
								<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
								
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemListing, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
								<?php endif;?>
								<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
									<?php $canComment =  $itemListing->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
									<?php if(isset($this->likeButtonActive) && $canComment):?>
										<!--Like Button-->
										<?php $LikeStatus = Engine_Api::_()->seslisting()->getLikeStatus($itemListing->listing_id,$itemListing->getType()); ?>
										<a href="javascript:;" data-url="<?php echo $itemListing->listing_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn seslisting_like_seslisting_listing_<?php echo $itemListing->listing_id ?> seslisting_like_seslisting_listing <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemListing->like_count; ?></span></a>
									<?php endif;?>
									<?php if(isset($this->favouriteButtonActive) && isset($itemListing->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)): ?>
										<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'seslisting')->isFavourite(array('resource_type'=>'seslisting','resource_id'=>$itemListing->listing_id)); ?>
										<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing_<?php echo $itemListing->listing_id ?> seslisting_favourite_seslisting_listing <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $itemListing->listing_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemListing->favourite_count; ?></span></a>
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
	<div class="seslisting_listing_second_of_the_day">
		<ul class="seslisting_album_listing sesbasic_bxs">
			<?php $limit = 0;?>
			<?php $itemListing = Engine_Api::_()->getItem('seslisting',$this->listing_id);?>
			<?php if($itemListing):?>
			<li class="seslisting_grid seslisting_list_grid_thumb seslisting_list_grid sesa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sesa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
				<div class="seslisting_grid_inner seslisting_thumb">
					<div class="seslisting_grid_thumb seslisting_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> <a class="seslisting_thumb_img" href="<?php echo $itemListing->getHref(); ?>"> <span class="main_image_container" style="background-image: url(<?php echo $itemListing->getPhotoUrl('thumb.main'); ?>);"></span> </a>
						<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
						<div class="seslisting_grid_labels">
							<?php if(isset($this->featuredLabelActive) && $itemListing->featured == 1){ ?>
							<p class="seslisting_label_featured"><?php echo $this->translate("Featured"); ?></p>
							<?php } ?>
							<?php if(isset($this->sponsored)  && $itemListing->sponsoredLabelActive == 1){ ?>
							<p class="seslisting_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
							<?php } ?>
						</div>
						<?php if(isset($this->verifiedLabelActive) && $itemListing->verified == 1):?>
							<div class="seslisting_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
						<?php endif;?>
						<?php } ?>
						</div>
						<?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
					<div class="seslisting_grid_info clear sesbasic_clearfix sesbm">
						<?php if(isset($this->titleActive)) { ?>
						<div class="seslisting_category_grid_info_title"> <?php echo $this->htmlLink($itemListing, $this->string()->truncate($itemListing->getTitle(), $this->title_truncation),array('title'=>$itemListing->getTitle())) ; ?> </div>
						<?php } ?>
						<?php if(isset($this->priceActive) ){ ?>
             <div class="seslisting_list_grid_price">
                <?php echo Engine_Api::_()->seslisting()->getCurrencyPrice($item->price); ?>
             </div>
             <?php } ?>
						<div class="seslisting_list_grid_info sesbasic_clearfix">
							<div class="seslisting_list_stats">
								<?php if(isset($this->byActive)) { ?>
									<span class="seslisting_list_grid_owner sesbasic_text_light"><i class="fa fa-user"></i> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemListing->getOwner()->getHref(), $itemListing->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
								<?php }?>
							</div>
							<div class="seslisting_list_stats seslisting_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $itemListing->listing_id,'resource_type'=>'seslisting','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $itemListing->location;?></a></span> </div>
						</div>
						<?php } ?>
						<div class="seslisting_list_stats sesbasic_text_light">
							<?php if(isset($this->likeActive)) { ?>
								<span class="seslisting_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemListing->like_count), $this->locale()->toNumber($itemListing->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $itemListing->like_count;?> </span>
							<?php } ?>
							<?php if(isset($this->commentActive)) { ?>
								<span class="seslisting_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemListing->comment_count), $this->locale()->toNumber($itemListing->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $itemListing->comment_count;?> </span>
							<?php } ?>
							<?php if(isset($this->viewActive)) { ?>
								<span class="seslisting_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemListing->view_count), $this->locale()->toNumber($itemListing->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $itemListing->view_count;?> </span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
								<span class="seslisting_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemListing->favourite_count), $this->locale()->toNumber($itemListing->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $itemListing->favourite_count;?> </span>
							<?php } ?>
							<?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('seslistingreview', 'view') && isset($this->ratingActive) && isset($itemListing->rating)): ?>
								<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemListing->rating,1)), $this->locale()->toNumber(round($itemListing->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemListing->rating,1).'/5';?></span>
							<?php endif; ?>
					</div>
					
				</div>
				<div class="seslisting_list_thumb_over">
											<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
							<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemListing->getHref()); ?>
							<div class="seslisting_list_grid_thumb_btns"> 
								<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
                  
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemListing, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

								<?php endif;?>
								<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
									<?php $canComment =  $itemListing->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
									<?php if(isset($this->likeButtonActive) && $canComment):?>
										<!--Like Button-->
										<?php $LikeStatus = Engine_Api::_()->seslisting()->getLikeStatus($itemListing->listing_id,$itemListing->getType()); ?>
										<a href="javascript:;" data-url="<?php echo $itemListing->listing_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn seslisting_like_seslisting_listing_<?php echo $itemListing->listing_id ?> seslisting_like_seslisting_listing <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemListing->like_count; ?></span></a>
									<?php endif;?>
									<?php if(isset($this->favouriteButtonActive) && isset($itemListing->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)): ?>
										<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'seslisting')->isFavourite(array('resource_type'=>'seslisting','resource_id'=>$itemListing->listing_id)); ?>
										<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing_<?php echo $itemListing->listing_id ?> seslisting_favourite_seslisting_listing <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $itemListing->listing_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemListing->favourite_count; ?></span></a>
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
<div class="seslisting_listing_three_of_the_day">
 <?php $limit = 0;?>
    <?php $itemListing = Engine_Api::_()->getItem('seslisting',$this->listing_id);?>
    <?php if($itemListing):?>
  <div class="seslisting_last_grid_block sesbasic_bxs " style="width:140px;">
    <div class="seslisting_grid_inner">
      <div class="seslisting_grid_thumb seslisting_thumb" style="height:160px;"> <a class="seslisting_thumb_img" href="<?php echo $itemListing->getHref(); ?>"> 
      <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
      <span class="main_image_container" style="background-image: url(<?php echo $itemListing->getPhotoUrl('thumb.main'); ?>);"></span> </a>
        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
        <div class="seslisting_list_labels">
          <?php if(isset($this->featuredLabelActive) && $itemListing->featured == 1){ ?>
          <p class="seslisting_label_featured"><?php echo $this->translate("Featured"); ?></p>
          <?php } ?>
          <?php if(isset($this->sponsoredLabelActive)  && $itemListing->sponsored == 1){ ?>
          <p class="seslisting_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
          <?php } ?>
        </div>
        <?php } ?>
				<?php if(isset($this->verifiedLabelActive) && $itemListing->verified == 1):?>
					<div class="seslisting_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
				<?php endif;?>
        <div class="seslisting_grid_thumb_over">
          <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
						<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemListing->getHref()); ?>
						<div class="seslisting_list_grid_thumb_btns"> 
							<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
                
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemListing, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
							<?php endif;?>
							<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
								<?php $canComment =  $itemListing->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
								<?php if(isset($this->likeButtonActive) && $canComment):?>
									<!--Like Button-->
									<?php $LikeStatus = Engine_Api::_()->seslisting()->getLikeStatus($itemListing->listing_id,$itemListing->getType()); ?>
									<a href="javascript:;" data-url="<?php echo $itemListing->listing_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn seslisting_like_seslisting_listing_<?php echo $itemListing->listing_id ?> seslisting_like_seslisting_listing <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemListing->like_count; ?></span></a>
								<?php endif;?>
								<?php if(isset($this->favouriteButtonActive) && isset($itemListing->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)): ?>
									<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'seslisting')->isFavourite(array('resource_type'=>'seslisting','resource_id'=>$itemListing->listing_id)); ?>
									<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing_<?php echo $itemListing->listing_id ?> seslisting_favourite_seslisting_listing <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $itemListing->listing_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemListing->favourite_count; ?></span></a>
								<?php endif;?>
							<?php endif;?>
						</div>
					<?php endif;?>
        </div>
      </div>
      <div class="seslisting_grid_info clear clearfix sesbm">
        <div class="seslisting_grid_meta_block">
					<?php if($itemListing->category_id != '' && intval($itemListing->category_id) && !is_null($itemListing->category_id)):?> 
						<?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $itemListing->category_id);?>
						<?php if($categoryItem):?>
							<div class="seslisting_grid_memta_title">
								<span>
									<a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
								</span>
							</div>
						<?php endif;?>
					<?php endif;?>
          <?php if(Engine_Api::_()->getApi('core', 'seslisting')->allowReviewRating() && isset($this->ratingStarActive)):?>
				<?php echo $this->partial('_listingRating.tpl', 'seslisting', array('rating' => $itemListing->rating, 'class' => 'seslisting_list_rating seslisting_list_view_ratting floatR', 'style' => 'margin:0px;'));?>
			<?php endif;?>
        </div>
        <?php if(isset($this->titleActive)) { ?>
        <div class="seslisting_grid_three_info_title"> <?php echo $this->htmlLink($itemListing, $this->string()->truncate($itemListing->getTitle(), $this->title_truncation),array('title'=>$itemListing->getTitle())) ; ?> </div>
        <?php } ?>
        <?php if(isset($this->priceActive) ){ ?>
        <div class="seslisting_list_grid_price">
                <?php echo Engine_Api::_()->seslisting()->getCurrencyPrice($item->price); ?>
             </div>
             <?php } ?>
        <div class="seslisting_grid_meta_block">
          <div class="seslisting_list_stats sesbasic_text_light">
            <?php if(isset($this->byActive)) { ?>
            <span class="seslisting_list_grid_owner sesbasic_text_light"><i class="fa fa-user"></i> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemListing->getOwner()->getHref(), $itemListing->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
            <?php }?>
            | <span><i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $itemListing->listing_id,'resource_type'=>'seslisting','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $itemListing->location;?></a></span> </div>
        </div>
        <div class="seslisting_grid_contant">
          <?php echo $itemListing->getDescription($this->description_truncation);?>
        </div>
        <div class="seslisting_comment_list seslisting_list_stats sesbasic_text_dark floatL">
          <?php if(isset($this->likeActive)) { ?>
          <span class="seslisting_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemListing->like_count), $this->locale()->toNumber($itemListing->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $itemListing->like_count;?> </span>
          <?php } ?>
          <?php if(isset($this->commentActive)) { ?>
          <span class="seslisting_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemListing->comment_count), $this->locale()->toNumber($itemListing->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $itemListing->comment_count;?> </span>
          <?php } ?>
          <?php if(isset($this->viewActive)) { ?>
          <span class="seslisting_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemListing->view_count), $this->locale()->toNumber($itemListing->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $itemListing->view_count;?> </span>
          <?php } ?>
          <?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
          <span class="seslisting_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemListing->favourite_count), $this->locale()->toNumber($itemListing->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $itemListing->favourite_count;?> </span>
          <?php } ?>
          <?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('seslistingreview', 'view') && isset($this->ratingActive) && isset($itemListing->rating)): ?>
							<span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemListing->rating,1)), $this->locale()->toNumber(round($itemListing->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemListing->rating,1).'/5';?></span>
						<?php endif; ?></div>
        <div class="seslisting_second_readmore_link floatR"> <a href="<?php echo $itemListing->getHref();?>"><?php echo $this->translate('Read More...');?></a> </div>
      </div>
      <?php } ?>
    </div>
  </div>
      <?php endif;?>
    <?php $limit++;
   ?></div>
 <?php endif;?>
