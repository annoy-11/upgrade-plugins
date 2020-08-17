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
<div class="seslisting-featured_listing_view sesbasic_clearfix sesbasic_bxs clear">
	<?php $itemCount = 1;?>
	<?php foreach($this->listings as $item):?>
		<?php if($itemCount == 1):?>
			<div class="featured_listing_list featured_listing_listing sesbasic_bxs">
				<div class="featured_listing_list_inner seslisting_thumb">
        <a href="<?php echo $item->getHref();?>"><img src="<?php echo $item->getPhotoUrl();?>" /></a>
				<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
					<?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
					<?php if($categoryItem):?>
						<p class="featured_teg"><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></p>
					<?php endif;?>
				<?php endif;?>
				<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
					<div class="seslisting_list_labels ">
						<?php if(isset($this->featuredLabelActive) &&$item->featured == 1):?>
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
						<a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>"></a>
						<div class="seslisting_list_grid_thumb_btns"> 
							<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
                
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
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
				<div class="featured_listing_list_contant">
          <?php if(isset($this->titleActive)): ?>
            <p class="title"><a href="<?php echo $item->getHref();?>"><?php echo $item->getTitle();?></a></p>
					<?php endif; ?>
          <?php if(isset($this->byActive)): ?>
            <div class="featured_listing_date_location"><div class="seslisting_list_stats floatL">
              <p class="featured-date">
              <?php $owner = $item->getOwner(); ?>
              <?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?>
              </p>
              </div>
            </div>
          <?php endif; ?>
					<?php if(Engine_Api::_()->getApi('core', 'seslisting')->allowReviewRating() && isset($this->ratingStarActive)):?>
						<?php echo $this->partial('_listingRating.tpl', 'seslisting', array('rating' => $item->rating, 'class' => 'seslisting_list_rating seslisting_list_view_ratting', 'style' => 'margin:0px;'));?>
					<?php endif;?>
				  <div class="featured_listing_date_location"> 	
				    <?php if(isset($this->creationDateActive)):?>
							<div class="seslisting_list_stats floatL"><p class="featured-date"><i class="fa fa-calendar"></i> <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></p></div>
						<?php endif;?>
						<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)){ ?>
							<div class="seslisting_list_stats  seslisting_list_location floatL">
								<p>
									<i class="fa fa-map-marker"></i>
									<a href="<?php echo $this->url(array('resource_id' => $item->listing_id,'resource_type'=>'seslisting','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $item->location;?></a>
								</p>
							</div>
						<?php } ?>
						<div class="seslisting_list_stats floatL">
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
							<?php if(isset($this->ratingActive) && isset($item->rating) && $item->rating > 0 && Engine_Api::_()->sesbasic()->getViewerPrivacy('seslistingreview', 'view')): ?>
								<span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>">
									<i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?>
								</span>
							<?php endif; ?>
							<?php include APPLICATION_PATH .  '/application/modules/Seslisting/views/scripts/_listingRatingStat.tpl';?>
						</div>
          </div>
        </div>
			</div>
		</div>
	<?php else:?>
	<div class="featured_listing_list sesbasic_bxs">
		<div class="featured_listing_list_inner seslisting_thumb">
			<a href="<?php echo $item->getHref();?>"><img src="<?php echo $item->getPhotoUrl();?>" /></a>
			<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
				<?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
				<?php if($categoryItem):?>
					<p class="featured_teg"><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></p>
				<?php endif;?>
			<?php endif;?>
			<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
				<div class="seslisting_list_labels ">
					<?php if(isset($this->featuredLabelActive) &&$item->featured == 1):?>
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
					<a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>"></a>
					<div class="seslisting_list_grid_thumb_btns"> 
						<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.sharing', 1)):?>
              
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
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
				<div class="featured_listing_list_contant">
          <?php if(isset($this->titleActive)): ?>
            <p class="title"><a href="<?php echo $item->getHref();?>"><?php echo $item->getTitle();?></a></p>
					<?php endif; ?>
          <?php if(isset($this->byActive)): ?>
            <div class="featured_listing_date_location"><div class="seslisting_list_stats floatL">
              <p class="featured-date">
              <?php $owner = $item->getOwner(); ?>
              <?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?>
              </p>
              </div>
            </div>
          <?php endif; ?>
					<?php if(Engine_Api::_()->getApi('core', 'seslisting')->allowReviewRating() && isset($this->ratingStarActive)):?>
						<?php echo $this->partial('_listingRating.tpl', 'seslisting', array('rating' => $item->rating, 'class' => 'seslisting_list_rating seslisting_list_view_ratting', 'style' => 'margin:0px;'));?>
					<?php endif;?>
					<div class="featured_listing_date_location">
            <?php if(isset($this->creationDateActive)):?>
						<div class="seslisting_list_stats floatL"><p class="featured-date"><i class="fa fa-calendar"></i> <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></p></div>
						<?php endif; ?>
						<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.location', 1)){ ?>
							<div class="seslisting_list_stats  seslisting_list_location floatL">
								<p>
									<i class="fa fa-map-marker"></i>
									<a href="<?php echo $this->url(array('resource_id' => $item->listing_id,'resource_type'=>'seslisting','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $item->location;?></a>
								</p>
							</div>
						<?php } ?>
						<div class="seslisting_list_stats floatL">
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
							<?php if(isset($this->ratingActive) && isset($item->rating) && $item->rating > 0 && Engine_Api::_()->sesbasic()->getViewerPrivacy('seslistingreview', 'view')): ?>
								<span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>">
								<i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?>	</span>
							<?php endif; ?>
							<?php // include APPLICATION_PATH .  '/application/modules/Seslisting/views/scripts/_listingRatingStat.tpl';?>
						</div>
          </div>
        </div>
				</div>
			</div>
		<?php endif;?>
		<?php $itemCount++;?>
	<?php endforeach;?>
</div>
