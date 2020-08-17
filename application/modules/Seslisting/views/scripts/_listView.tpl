<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $reviewCount = Engine_Api::_()->seslisting()->getTotalReviews($item->listing_id);?>
<li class="seslisting_list_listing_view sesbasic_clearfix clear">
	<div class="seslisting_list_thumb seslisting_thumb" style="height:<?php echo is_numeric($this->height_list) ? $this->height_list.'px' : $this->height_list ?>;width:<?php echo is_numeric($this->width_list) ? $this->width_list.'px' : $this->width_list ?>;">
		<?php $href = $item->getHref();$imageURL = $photoPath;?>
		<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="seslisting_thumb_img">
		<span style="background-image:url(<?php echo $imageURL; ?>);"></span>
		</a>
		<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
			<div class="seslisting_list_labels ">
				<?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
					<p class="seslisting_label_featured"><?php echo $this->translate('FEATURED');?></p>
				<?php endif;?>
				<?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
					<p class="seslisting_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
				<?php endif;?>
			</div>
		<?php endif;?>
		<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
			<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
			<div class="seslisting_list_thumb_over">
				<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
				<div class="seslisting_grid_btns"> 
					<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
            
            <?php if($this->socialshare_icon_limit): ?>
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
            <?php else: ?>
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_listview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listview1limit)); ?>
            <?php endif; ?>
						
					<?php endif;?>
					<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
						<?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
						<?php if(isset($this->likeButtonActive) && $canComment):?>
							<!--Like Button-->
							<?php $LikeStatus = Engine_Api::_()->seslisting()->getLikeStatus($item->listing_id,$item->getType()); ?>
							<a href="javascript:;" data-url="<?php echo $item->listing_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn seslisting_like_seslisting_listing_<?php echo $item->listing_id ?> seslisting_like_seslisting_listing <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
						<?php endif;?>
						<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)): ?>
							<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'seslisting')->isFavourite(array('resource_type'=>'seslisting','resource_id'=>$item->listing_id)); ?>
							<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing_<?php echo $item->listing_id ?> seslisting_favourite_seslisting_listing <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->listing_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
						<?php endif;?>
					<?php endif;?>
				</div>
			</div>
		<?php endif;?> 
	</div>
	<div class="seslisting_list_info">
		<div class="seslisting_list_top">
		<?php if(isset($this->categoryActive)){ ?>
				<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
					<?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
					<?php if($categoryItem):?>
						<div class="seslisting_stats_list sesbasic_text_dark">
							<span>
							<a href="<?php echo $categoryItem->getHref(); ?>" title="Category"><?php echo $categoryItem->category_name; ?></a>
							</span>
						</div>
					<?php endif;?>
				<?php endif;?>
			<?php } ?>
         <?php if(isset($this->ratingActive)):?>
        <div class="sesbasic_rating_star">
          <?php $ratingCount = $item->rating; $x=0; ?>
          <?php if( $ratingCount > 0 ): ?>
            <?php for( $x=1; $x<=$ratingCount; $x++ ): ?>
              <span id="" class="seslisting_rating_star"></span>
            <?php endfor; ?>
            <?php if( (round($ratingCount) - $ratingCount) > 0){ ?>
            <span class="seslisting_rating_star seslisting_rating_star_half"></span>
            <?php }else{ $x = $x - 1;} ?>
            <?php if($x < 5){ 
            for($j = $x ; $j < 5;$j++){ ?>
            <span class="seslisting_rating_star seslisting_rating_star_disable"></span>
            <?php }     
            } ?>
          <?php endif; ?>
        </div>
      <?php endif;?>
	   </div>
		<?php if(isset($this->titleActive)): ?>
			<div class="seslisting_list_info_title">
				<?php if(strlen($item->getTitle()) > $this->title_truncation_list):?>
					<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_list).'...';?>
					<?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
				<?php else: ?>
					<?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
				<?php endif;?>
                <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
					<div class="seslisting_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
				<?php endif;?>
			</div>
		<?php endif;?>
 	<?php if(isset($this->priceActive) ){ ?>
    <div class="seslisting_list_grid_price">
         <?php echo Engine_Api::_()->seslisting()->getCurrencyPrice($item->price); ?>
    </div>
    <?php } ?>
		<div class="seslisting_list_contant">
		<?php if(isset($this->descriptionlistActive)){ ?>
			<p class="seslisting_list_des sesbasic_text_light">
				<?php echo $item->getDescription($this->description_truncation_list);?>
			</p>
		<?php } ?>      
		</div>
    <div class="seslisting_admin_list">
			<?php if(isset($this->byActive)){ ?>
				<div class="seslisting_stats_list sesbasic_text_light">
					<?php $owner = $item->getOwner(); ?>
					<span>
						
						<?php echo $this->translate("<i class='fa fa-user'></i>") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
					</span>
				</div>
			<?php } ?>
      <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)){ ?>
        <div class="seslisting_stats_list seslisting_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $item->listing_id,'resource_type'=>'seslisting_listing','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a> </span> </div>
        <?php } ?>
			<div class="seslisting_list_stats seslisting_list_counts sesbasic_text_light">
			<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
				<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
			<?php } ?>
			<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
				<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
			<?php } ?>
			<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
				<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
			<?php } ?>
			<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
				<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
			<?php } ?>
		</div>
			
		</div>
		<?php if(isset($this->my_listings) && $this->my_listings){ ?> 
    <div class="seslisting_options_buttons seslisting_list_options sesbasic_clearfix">
				<?php if($this->can_edit){ ?>
				<a href="<?php echo $this->url(array('action' => 'edit', 'listing_id' => $item->listing_id), 'seslisting_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Edit Listing'); ?>">
				<i class="fa fa-pencil"></i>
				</a>
				<?php } ?>
				<?php if ($this->can_delete){ ?>
					<a href="<?php echo $this->url(array('action' => 'delete', 'listing_id' => $item->listing_id), 'seslisting_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Delete Listing'); ?>" onclick='opensmoothboxurl(this.href);return false;'>
					<i class="fa fa-trash"></i>
					</a>
				<?php } ?>

		</div>
			<?php } ?>
	</div>
</li>
