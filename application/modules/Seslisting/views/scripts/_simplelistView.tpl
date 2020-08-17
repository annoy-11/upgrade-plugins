<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _simplelistView.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<li class="seslisting_list_second_listing sesbasic_clearfix clear">
	<div class="seslisting_list_thumb seslisting_thumb" style="height:<?php echo is_numeric($this->height_simplelist) ? $this->height_simplelist.'px' : $this->height_simplelist ?>;width:<?php echo is_numeric($this->width_simplelist) ? $this->width_simplelist.'px' : $this->width_simplelist ?>;">
		<?php $href = $item->getHref();$imageURL = $photoPath;?>
		<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="seslisting_thumb_img">
		<span style="background-image:url(<?php echo $imageURL; ?>);"></span>
		</a>
		<?php if(isset($this->creationDateActive)){ ?>
			<div class="seslisting_list_second_listing_date">
        <?php if($item->publish_date): ?>
          <p class=""><span class="month"><?php echo date('M',strtotime($item->publish_date));?></span> <span class="date"><?php echo date('d',strtotime($item->publish_date));?></span> <span class="year"><?php echo date('Y',strtotime($item->publish_date));?></span></p>
				<?php else: ?>
          <p class=""><span class="month"><?php echo date('M',strtotime($item->creation_date));?></span> <span class="date"><?php echo date('d',strtotime($item->creation_date));?></span> <span class="year"><?php echo date('Y',strtotime($item->creation_date));?></span></p>
				<?php endif; ?>
			</div>
		<?php } ?>
		<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
			<div class="seslisting_list_labels ">
				<?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
					<p class="seslisting_label_featured"><?php echo $this->translate('FEATURED');?></p>
				<?php endif;?>
				<?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
					<p class="seslisting_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
				<?php endif;?>
			</div>
      				<?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
					<div class="seslisting_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
				<?php endif;?>
		<?php endif;?>
		<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
			<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
			<div class="seslisting_list_thumb_over">
				<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
				<div class="seslisting_grid_btns"> 
					<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
            
            <?php if($this->socialshare_icon_limit): ?>
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
            <?php else: ?>
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_listview2plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listview2limit)); ?>
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
							<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count seslisting_favourite_seslisting_listing_<?php echo $item->listing_id ?>  sesbasic_icon_fav_btn seslisting_favourite_seslisting_listing <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->listing_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
						<?php endif;?>
					<?php endif;?>
				</div>
			</div>
		<?php endif;?> 
	</div>
	<div class="seslisting_list_info">
	  <?php if(Engine_Api::_()->getApi('core', 'seslisting')->allowReviewRating() && isset($this->ratingStarActive)):?>
    	<?php echo $this->partial('_listingRating.tpl', 'seslisting', array('rating' => $item->rating, 'class' => 'seslisting_list_rating seslisting_list_view_ratting floatR', 'style' => ''));?>
    <?php endif;?>
    	 	  <?php if(isset($this->titleActive)): ?>
			<div class="seslisting_list_info_title floatL">
				<?php if(strlen($item->getTitle()) > $this->title_truncation_simplelist):?>
					<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_simplelist).'...';?>
					<?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
				<?php else: ?>
					<?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
				<?php endif;?>
			</div>
    <?php endif;?>
    

    <div class="seslisting_admin_list">
			<?php if(isset($this->byActive)){ ?>
				<div class="seslisting_stats_list admin_img sesbasic_text_dark">
					<?php $owner = $item->getOwner(); ?>
					<span>
						<?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>
						<?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
					</span>
				</div>
			<?php } ?>
			<?php if(isset($this->categoryActive)){ ?>
				<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
					<?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
					<?php if($categoryItem):?>
						<div class="seslisting_stats_list sesbasic_text_dark">
							<span>
							<i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> 
							<a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
							</span>
						</div>
					<?php endif;?>
				<?php endif;?>
			<?php } ?>
			<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)){ ?>
				<div class="seslisting_stats_list  sesbasic_text_dark seslisting_list_location">
					<span>
						<i class="fa fa-map-marker"></i>
						<a href="<?php echo $this->url(array('resource_id' => $item->listing_id,'resource_type'=>'seslisting','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a>
					</span>
				</div>
			<?php } ?>
		<div class="seslisting_stats_list sesbasic_text_dark seslisting_list_stats" style="">
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
			<?php include APPLICATION_PATH .  '/application/modules/Seslisting/views/scripts/_listingRatingStat.tpl';?>
		</div>
    
		</div>
    <div class="seslisting_list_contant">
		<?php if(isset($this->descriptionsimplelistActive)){ ?>
			<p class="seslisting_list_des">
				<?php echo $item->getDescription($this->description_truncation_simplelist);?>
			</p>
		<?php } ?>      
		</div>
		<?php if(isset($this->readmoreActive)):?>
			<div class="seslisting_list_readmore"><a class="seslisting_animation" href="<?php echo $item->getHref();?>"><?php echo $this->translate('Read More');?></a></div>
		<?php endif;?>
		<div class="seslisting_options_buttons seslisting_list_options sesbasic_clearfix">
			<?php if(isset($this->my_listings) && $this->my_listings){ ?> 
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
			<?php } ?>
		</div>
	</div>
</li>
