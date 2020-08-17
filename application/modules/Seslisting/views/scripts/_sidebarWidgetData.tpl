<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _sidebarWidgetData.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslisting/externals/styles/styles.css'); 
?>
<?php foreach( $this->results as $item ): ?>
	<?php if($this->view_type == 'list'):?>
		<li class="seslisting_sidebar_listing_list sesbasic_clearfix">
			<div class="seslisting_sidebar_listing_list_img <?php if($this->image_type == 'rounded'):?>seslisting_sidebar_image_rounded<?php endif;?> seslisting_list_thumb seslisting_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height_list ?>;width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
				<?php $href = $item->getHref();$imageURL = $item->getPhotoUrl('thumb.profile');?>
				<a href="<?php echo $href; ?>" class="seslisting_thumb_img">
					<span class="floatL" style="background-image:url(<?php echo $imageURL; ?>);"></span>
				</a>     
			</div>
			<div class="seslisting_sidebar_listing_list_cont">
				<?php  if(isset($this->titleActive)): ?>
					<div class="seslisting_sidebar_listing_list_title seslisting_list_info_title">
						<?php if(strlen($item->getTitle()) > $this->title_truncation):?>
							<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
							<?php echo $this->htmlLink($item->getHref(),$title, array('class' => 'ses_tooltip', 'data-src' => $item->getGuid()));?>
						<?php  else : ?>
							<?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $item->getGuid())) ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>    
		<?php if(isset($this->priceActive) ){ ?>		
        <div class="seslisting_list_grid_price">
            <?php echo Engine_Api::_()->seslisting()->getCurrencyPrice($item->price); ?>
         </div>   
         <?php } ?>
				<?php if(Engine_Api::_()->getApi('core', 'seslisting')->allowReviewRating() && isset($this->ratingStarActive)):?>
					<?php echo $this->partial('_listingRating.tpl', 'seslisting', array('rating' => $item->rating, 'class' => 'seslisting_list_rating seslisting_list_view_ratting', 'style' => 'margin-bottom:0px; margin-top:10px;'));?>
				<?php endif;?>  
				<div class="seslisting_sidebar_listing_list_date seslisting_sidebar_list_date">
					<?php if(isset($this->byActive)): ?>
						<?php $owner = $item->getOwner(); ?>
						<span><?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?></span>
					<?php endif; ?>
					<?php if(isset($this->creationDateActive)):?>
						<span><i class="fa fa-calendar"></i> <?php echo date('M d, Y',strtotime($item->publish_date));?></span>
					<?php endif;?>
				</div>
				<?php  if(isset($this->locationActive) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)): ?>
					<div class="seslisting_list_stats seslisting_list_location">
						<span class="widthfull">
							<i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
							<span title="<?php echo $item->location; ?>"><a href="<?php echo $this->url(array('resource_id' => $item->listing_id,'resource_type'=>'seslisting_listing','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="openSmoothbox"><?php echo $item->location ?></a></span>
						</span>
					</div>
				<?php endif; ?>
				<?php if(isset($this->categoryActive)): ?>
					<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
						<?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
            <?php if($categoryItem): ?>
              <div class="seslisting_sidebar_listing_list_date">
                  <i class="fa fa-folder-open sesbasic_text_light" title="<?php echo $this->translate('Category:'); ?>"></i> 
                  <span><a href="<?php echo $categoryItem->getHref(); ?>">
                  <?php echo $categoryItem->category_name; ?></a>
                  <?php $subcategory = Engine_Api::_()->getItem('seslisting_category',$item->subcat_id); ?>
                  <?php if($subcategory && $item->subcat_id): ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
                  <?php endif; ?>
                  <?php $subsubcategory = Engine_Api::_()->getItem('seslisting_category',$item->subsubcat_id); ?>
                  <?php if($subsubcategory && $item->subsubcat_id): ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
                  <?php endif; ?>
                </span>
              </div>
            <?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
				<div class="seslisting_sidebar_listing_list_date sesbasic_text_light">
					<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
						<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
					<?php } ?>
					<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
						<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $item->comment_count;?></span>
					<?php } ?>
					<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
						<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
					<?php } ?>
					<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
						<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
					<?php } ?>
					<?php include APPLICATION_PATH .  '/application/modules/Seslisting/views/scripts/_listingRatingStat.tpl';?>
				</div>
			</div>
		</li>
	<?php elseif($this->view_type == 'grid1'): ?>
		<li class="seslisting_sidebar_grid sesbasic_clearfix sesbasic_bxs sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?> ; ">
			<div class="seslisting_grid_inner seslisting_list_thumb seslisting_thumb">
				<div class="seslisting_grid_thumb seslisting_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
					<?php $href = $item->getHref();$imageURL = $item->getPhotoUrl('thumb.profile');?>
					<a href="<?php echo $href; ?>" class="seslisting_item_grid_thumb_img floatL">
						<span class="floatL" style="background-image:url(<?php echo $imageURL; ?>);"></span>
					</a>
					<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)): ?>
						<div class="seslisting_list_labels ">
							<?php if(isset($this->featuredLabelActive) && $item->featured): ?>
								<p class="seslisting_label_featured"><?php echo $this->translate('FEATURED');?></p>
							<?php endif; ?>
							<?php if(isset($this->sponsoredLabelActive) && $item->sponsored): ?>
								<p class="seslisting_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
						<div class="seslisting_verified_label" title="<?php echo $this->translate("VERIFIED"); ?>" style=""><i class="fa fa-check"></i></div>
					<?php endif; ?>
					<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
						<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
						<div class="seslisting_list_thumb_over"> 
							<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
							<div class="seslisting_list_grid_thumb_btns"> 
								<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)): ?>
                  
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item)); ?>

								<?php endif;?>
								<?php $itemtype = 'seslisting_listing';?>
								<?php $getId = 'listing_id';?>
								<?php $canComment =  $item->authorization()->isAllowed($this->viewer, 'comment');?>
								<?php if(isset($this->likeButtonActive) && $canComment):?>
									<!--Like Button-->
									<?php $LikeStatus = Engine_Api::_()->seslisting()->getLikeStatusListing($item->$getId, $item->getType()); ?>
									<a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn seslisting_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
								<?php endif; ?>
								<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && $this->viewer_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)):?>
									<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'seslisting')->isFavourite(array('resource_type'=>'seslisting','resource_id'=>$item->listing_id));
									$favClass = ($favStatus)  ? 'button_active' : '';?>
									<?php $shareOptions = "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count seslisting_favourite_seslisting_listing_". $item->listing_id." sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing ".$favClass ."' data-url=\"$item->listing_id\"><i class='fa fa-heart'></i><span>$item->favourite_count</span></a>";?>
									<?php echo $shareOptions;?>
								<?php endif;?>
								<?php if(isset($this->listButtonActive) && $this->viewer_id): ?>
									<a href="javascript:;" onclick="opensmoothboxurl('<?php echo $this->url(array('action' => 'add','module'=>'seslisting','controller'=>'list','listing_id'=>$item->listing_id),'default',true); ?>')" class="sesbasic_icon_btn  seslisting_add_list"  title="<?php echo  $this->translate('Add To List'); ?>" data-url="<?php echo $item->listing_id ; ?>"><i class="fa fa-plus"></i></a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
				<div class="seslisting_grid_info clear sesbasic_clearfix sesbm">
					<?php if(isset($this->titleActive) ): ?>
						<div class="seslisting_grid_info_title">
							<?php if(strlen($item->getTitle()) > $this->title_truncation):?>
								<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
								<?php echo $this->htmlLink($item->getHref(),$title, array('class' => 'ses_tooltip', 'data-src' => $item->getGuid())) ?>
							<?php else: ?>
								<?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $item->getGuid())) ?>
							<?php endif; ?>
							<?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
								<i class="seslisting_verified_sign fa fa-check-circle"></i>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if(isset($this->priceActive) ){ ?>
          <div class="seslisting_list_grid_price">
             <?php echo Engine_Api::_()->seslisting()->getCurrencyPrice($item->price); ?>
         </div>
         <?php } ?>
          <?php if(Engine_Api::_()->getApi('core', 'seslisting')->allowReviewRating() && isset($this->ratingStarActive)):?>
					<?php echo $this->partial('_listingRating.tpl', 'seslisting', array('rating' => $item->rating, 'class' => 'seslisting_list_rating seslisting_list_view_ratting', 'style' => 'margin-bottom:5px;'));?>
				<?php endif;?>
					<?php if(isset($this->byActive)): ?>
						<div class="seslisting_admin sesbasic_clearfix">
							<?php $owner = $item->getOwner(); ?>
							<p><i class="fa fa-user"></i> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?>
							</p>
						</div>
					<?php endif; ?>
					<?php if(isset($this->locationActive) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)):?>
						<div class="seslisting_list_location">
							<span class="widthfull">
							<i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
								<span title="<?php echo $item->location; ?>"><a href="<?php echo $this->url(array('resource_id' => $item->listing_id,'resource_type'=>'seslisting','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="openSmoothbox"><?php echo $item->location ?></a></span>
							</span>
						</div>
					<?php endif; ?>
					<?php if(isset($this->categoryActive)): ?>
						<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
							<?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
							<?php if($categoryItem): ?>
                <div class="seslisting_admin sesbasic_clearfix">
                  <span>
                    <i class="fa fa-folder-open sesbasic_text_light" title="<?php echo $this->translate('Category:'); ?>"></i>
                    <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
                    <?php $subcategory = Engine_Api::_()->getItem('seslisting_category',$item->subcat_id); ?>
                    <?php if($subcategory && $item->subcat_id) { ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
                    <?php } ?>
                    <?php $subsubcategory = Engine_Api::_()->getItem('seslisting_category',$item->subsubcat_id); ?>
                    <?php if($subsubcategory && $item->subsubcat_id) { ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
                    <?php } ?>
                  </span>
                </div>
              <?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
					<div class="seslisting_list_stats">
						<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
							<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
						<?php } ?>
						<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
							<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $item->comment_count;?></span>
						<?php } ?>
						<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
							<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
						<?php } ?>
						<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
							<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
						<?php } ?>
					</div>
				</div>
			</div>
		</li>
  <?php elseif($this->view_type == 'grid2'): ?>
    <li class="seslisting_grid seslisting_list_grid_thumb seslisting_list_grid" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
			<div class="seslisting_grid_inner seslisting_thumb">
				<div class="seslisting_grid_thumb seslisting_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
					<?php $href = $item->getHref();$imageURL = $item->getPhotoUrl('thumb.profile');?>
					<a href="<?php echo $href; ?>" class="seslisting_thumb_img">
						<span class="main_image_container" style="background-image:url(<?php echo $imageURL; ?>);"></span>
					</a>
					<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)): ?>
						<div class="seslisting_grid_labels">
							<?php if(isset($this->featuredLabelActive) && $item->featured): ?>
								<p class="seslisting_label_featured"><?php echo $this->translate('FEATURED');?></p>
							<?php endif; ?>
							<?php if(isset($this->sponsoredLabelActive) && $item->sponsored): ?>
								<p class="seslisting_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
          <?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
						<div class="seslisting_verified_label" title="<?php echo $this->translate("VERIFIED"); ?>" style=""><i class="fa fa-check"></i></div>
					<?php endif; ?>
				</div>
				<div class="seslisting_grid_info clear sesbasic_clearfix sesbm">
					<?php if(isset($this->titleActive) ): ?>
						<div class="seslisting_grid_info_title">
							<?php if(strlen($item->getTitle()) > $this->title_truncation):?>
								<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
								<?php echo $this->htmlLink($item->getHref(),$title) ?>
							<?php else: ?>
								<?php echo $this->htmlLink($item->getHref(),$item->getTitle()) ?>
							<?php endif; ?>
							<?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
								<i class="seslisting_verified_sign fa fa-check-circle"></i>
							<?php endif; ?>
						</div>
					<?php endif; ?>
          <?php if(Engine_Api::_()->getApi('core', 'seslisting')->allowReviewRating() && isset($this->ratingStarActive)):?>
					<?php echo $this->partial('_listingRating.tpl', 'seslisting', array('rating' => $item->rating, 'class' => 'seslisting_list_rating seslisting_list_view_ratting', 'style' => 'margin-bottom:5px;'));?>
				<?php endif;?>
					<?php if(isset($this->byActive)): ?>
          <div class="seslisting_list_grid_info sesbasic_clearfix">
						<div class="seslisting_list_stats">
							<?php $owner = $item->getOwner(); ?>
							<span class="seslisting_list_grid_owner">
								<a href="<?php echo $owner->getHref();?>"><?php echo $this->itemPhoto($owner, 'thumb.icon');?></a>
								<?php echo $this->translate('By');?>
								<?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?>
							</span>
						</div>
            <?php if(isset($this->locationActive) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)):?>
              <div class="seslisting_list_stats seslisting_list_location sesbasic_text_light">
                <span class="widthfull">
                <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
                  <span title="<?php echo $item->location; ?>"><a href="<?php echo $this->url(array('resource_id' => $item->listing_id,'resource_type'=>'seslisting','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="openSmoothbox"><?php echo $item->location ?></a></span>
                </span>
              </div>
					<?php endif; ?>
					<?php endif; ?>
          </div>
				</div>
        <div class="seslisting_grid_hover_block">
          <?php if(isset($this->titleActive) ): ?>
						<div class="seslisting_grid_info_hover_title">
							<?php if(strlen($item->getTitle()) > $this->title_truncation):?>
								<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';?>
								<?php echo $this->htmlLink($item->getHref(),$title, array('class' => 'ses_tooltip', 'data-src' => $item->getGuid())) ?>
							<?php else: ?>
								<?php echo $this->htmlLink($item->getHref(),$item->getTitle(), array('class' => 'ses_tooltip', 'data-src' => $item->getGuid())) ?>
							<?php endif; ?>
							<?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
								<i class="seslisting_verified_sign fa fa-check-circle"></i>
							<?php endif; ?>
              <span></span>
						</div>
					<?php endif; ?>
          <?php if(isset($this->categoryActive)): ?>
						<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
							<?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
							<?php if($categoryItem): ?>
                <div class="seslisting_admin_category sesbasic_clearfix">
                  <span>
                    <i class="fa fa-folder-open sesbasic_text_light" title="<?php echo $this->translate('Category:'); ?>"></i>
                    <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
                    <?php $subcategory = Engine_Api::_()->getItem('seslisting_category',$item->subcat_id); ?>
                    <?php if($subcategory && $item->subcat_id) { ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subcategory->getHref(); ?>"><?php echo $subcategory->category_name; ?></a>
                    <?php } ?>
                    <?php $subsubcategory = Engine_Api::_()->getItem('seslisting_category',$item->subsubcat_id); ?>
                    <?php if($subsubcategory && $item->subsubcat_id) { ?>
                    &nbsp;&raquo;&nbsp;<a href="<?php echo $subsubcategory->getHref(); ?>"><?php echo $subsubcategory->category_name; ?></a>
                    <?php } ?>
                  </span>
                </div>
              <?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
					<div class="seslisting_grid_des clear">
                      <?php echo $item->getDescription($this->description_truncation);?>
					</div>
					<div class="seslisting_grid_hover_block_footer">
						<div class="seslisting_list_stats sesbasic_text_light">
								<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
									<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up sesbasic_text_light"></i><?php echo $item->like_count; ?></span>
								<?php } ?>
								<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
									<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment sesbasic_text_light"></i><?php echo $item->comment_count;?></span>
								<?php } ?>
								<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
									<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye sesbasic_text_light"></i><?php echo $item->view_count; ?></span>
								<?php } ?>
								<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
									<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart sesbasic_text_light"></i><?php echo $item->favourite_count; ?></span>
								<?php } ?>
						</div>
					</div>
        </div>
          <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
						<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
						<div class="seslisting_list_thumb_over"> 
							<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
							<div class="seslisting_list_grid_thumb_btns"> 
								<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)): ?>
                  
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item)); ?>

								<?php endif;?>
								<?php $itemtype = 'seslisting';?>
								<?php $getId = 'listing_id';?>
								<?php $canComment =  $item->authorization()->isAllowed($this->viewer, 'comment');?>
								<?php if(isset($this->likeButtonActive) && $canComment):?>
									<!--Like Button-->
									<?php $LikeStatus = Engine_Api::_()->seslisting()->getLikeStatusListing($item->$getId, $item->getType()); ?>
									<a href="javascript:;" data-url="<?php echo $item->$getId ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn seslisting_like_seslisting_listing_<?php echo $item->listing_id ?> seslisting_like_<?php echo $itemtype; ?> <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
								<?php endif; ?>
								<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && $this->viewer_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)):?>
									<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'seslisting')->isFavourite(array('resource_type'=>'seslisting','resource_id'=>$item->listing_id));
									$favClass = ($favStatus)  ? 'button_active' : '';?>
									<?php $shareOptions = "<a href='javascript:;' class='sesbasic_icon_btn sesbasic_icon_btn_count seslisting_favourite_seslisting_listing_". $item->listing_id." sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing ".$favClass ."' data-url=\"$item->listing_id\"><i class='fa fa-heart'></i><span>$item->favourite_count</span></a>";?>
									<?php echo $shareOptions;?>
								<?php endif;?>
								<?php if(isset($this->listButtonActive) && $this->viewer_id): ?>
									<a href="javascript:;" onclick="opensmoothboxurl('<?php echo $this->url(array('action' => 'add','module'=>'seslisting','controller'=>'list','listing_id'=>$item->listing_id),'default',true); ?>')" class="sesbasic_icon_btn  seslisting_add_list"  title="<?php echo  $this->translate('Add To List'); ?>" data-url="<?php echo $item->listing_id ; ?>"><i class="fa fa-plus"></i></a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
			</div>
		</li>
	<?php endif; ?>
<?php endforeach; ?>
