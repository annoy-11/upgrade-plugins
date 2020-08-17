<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advlistView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<li class="sesarticle_list_full_view sesbasic_clearfix clear">
  <?php if(isset($this->creationDateActive)){ ?>
		<div class="sesarticle_list_full_date_article">
			<p>						<?php if($item->publish_date): ?>
              <?php echo date('M d, Y',strtotime($item->publish_date));?>
						<?php else: ?>
              <?php echo date('M d, Y',strtotime($item->creation_date));?>
						<?php endif; ?></p>
		</div>
  <?php } ?>
		<div class="sesarticle_list_full_thumb sesarticle_list_thumb sesarticle_thumb">
			<?php $href = $item->getHref();$imageURL = $photoPath;?>
			<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="<?php echo $item->getType() != 'sesarticle_chanel' ? 'sesarticle_thumb_img' : 'sesarticle_thumb_nolightbox' ?>">
				<!--<span style="background-image:url(<?php echo $imageURL; ?>);"></span>-->
        <img src="<?php echo $imageURL; ?>" alt="" align="left" />
			</a>
			<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)):?>
				<div class="sesarticle_list_labels">
					<?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
						<p class="sesarticle_label_featured"><?php echo $this->translate('FEATURED');?></p>
					<?php endif;?>
					<?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
						<p class="sesarticle_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
					<?php endif;?>
		
				</div>
        			<?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
						<div class="sesarticle_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
					<?php endif;?>
			<?php endif;?>
			<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
				<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
				<div class="sesarticle_list_thumb_over">
					<a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
					<div class="sesarticle_grid_btns"> 
						<?php if(isset($this->socialSharingActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.sharing', 1)):?>
						
              <?php if($this->socialshare_icon_limit): ?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
              <?php else: ?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_listview3plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listview3limit)); ?>
              <?php endif; ?>
							
						<?php endif;?>
						<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
							<?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
							<?php if(isset($this->likeButtonActive) && $canComment):?>
								<!--Like Button-->
								<?php $LikeStatus = Engine_Api::_()->sesarticle()->getLikeStatus($item->article_id,$item->getType()); ?>
								<a href="javascript:;" data-url="<?php echo $item->article_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesarticle_like_sesarticle_<?php echo $item->article_id ?> sesarticle_like_sesarticle <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
							<?php endif;?>
							<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)): ?>
								<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesarticle')->isFavourite(array('resource_type'=>'sesarticle','resource_id'=>$item->article_id)); ?>
								<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesarticle_favourite_sesarticle_<?php echo $item->article_id ?> sesarticle_favourite_sesarticle <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->article_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
							<?php endif;?>
						<?php endif;?>
					</div>
				</div>
			<?php endif;?> 
		</div>
		<div class="sesarticle_list_full_view_info">
			<?php  if(isset($this->titleActive)): ?>
				<div class="sesarticle_list_info_title floatL">
					<?php if(strlen($item->getTitle()) > $this->title_truncation_list):?>
						<?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_list).'...';?>
						<?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
					<?php else: ?>
						<?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
					<?php endif;?>
				</div>
			<?php endif; ?>
		<?php if(Engine_Api::_()->getApi('core', 'sesarticle')->allowReviewRating() && isset($this->ratingStarActive)):?>
			<?php echo $this->partial('_articleRating.tpl', 'sesarticle', array('rating' => $item->rating, 'class' => 'sesarticle_list_rating sesarticle_list_view_ratting floatR', 'style' => ''));?>
		<?php endif;?>
		<div class="sesarticle_list_full_meta">
			<?php if(isset($this->byActive)){ ?>
				<div class="sesarticle_list_stats sesbasic_text_dark">
					<?php $owner = $item->getOwner(); ?>
					<span>
						<?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>
						<?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
					</span>
				</div>
			<?php } ?>
			<?php if(isset($this->categoryActive)){ ?>
				<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
					<?php $categoryItem = Engine_Api::_()->getItem('sesarticle_category', $item->category_id);?>
					<?php if($categoryItem):?>
						<div class="sesarticle_list_stats sesbasic_text_dark">
							<span>
								<i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> 
								<a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
							</span>
						</div>
					<?php endif;?>
				<?php endif;?>
			<?php } ?>
			<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.location', 1)){ ?>
				<div class="sesarticle_list_stats sesbasic_text_dark sesarticle_list_location">
					<span>
						<i class="fa fa-map-marker"></i><a href="<?php echo $this->url(array('resource_id' => $item->article_id,'resource_type'=>'sesarticle','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a>
					</span>
				</div>
			<?php } ?>
		</div>
		<div class="sesarticle_list_full_border">
			<div class="sesarticle_list_border_one floatL"></div>
			<div class="sesarticle_list_border_two floatL"></div>
			<div class="sesarticle_list_border_three floatL"></div>
		</div>
		<div class="sesarticle_list_full_contant_article">
			<?php if(isset($this->descriptionlistActive)){ ?>
				<div class="sesarticle_list_des">
					<?php echo $item->getDescription($this->description_truncation_list);?>
				</div>
			<?php } ?>
		</div>
		<div class="sesarticle_list_full_stats">
			<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
				<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?> Likes</span>
			<?php } ?>
			<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
				<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?> Comments</span>
			<?php } ?>
			<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.enable.favourite', 1)) { ?>
				<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?> Favourite</samp></span>
			<?php } ?>
			<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
				<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?> View</span>
			<?php } ?>
			<?php include APPLICATION_PATH .  '/application/modules/Sesarticle/views/scripts/_articleRatingStat.tpl';?>
		</div>
		<div class="sesarticle_options_buttons sesarticle_list_options sesbasic_clearfix">
			<?php if(isset($this->my_articles) && $this->my_articles){ ?> 
				<?php if($this->can_edit){ ?>
					<a href="<?php echo $this->url(array('action' => 'edit', 'article_id' => $item->article_id), 'sesarticle_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Edit Article'); ?>">
						<i class="fa fa-pencil"></i>
					</a>
				<?php } ?>
				<?php if ($this->can_delete){ ?>
					<a href="<?php echo $this->url(array('action' => 'delete', 'article_id' => $item->article_id), 'sesarticle_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Delete Article'); ?>" onclick='opensmoothboxurl(this.href);return false;'>
						<i class="fa fa-trash"></i>
					</a>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</li>
