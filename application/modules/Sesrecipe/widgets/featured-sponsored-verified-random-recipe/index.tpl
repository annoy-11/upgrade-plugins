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
<div class="sesrecipe-featured_recipe_view sesbasic_clearfix sesbasic_bxs clear">
	<?php $itemCount = 1;?>
	<?php foreach($this->recipes as $item):?>
		<?php if($itemCount == 1):?>
			<div class="featured_recipe_list featured_recipe_listing sesbasic_bxs">
				<div class="featured_recipe_list_inner sesrecipe_thumb">
        <a href="<?php echo $item->getHref();?>"><img src="<?php echo $item->getPhotoUrl();?>" /></a>
				<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
					<?php $categoryItem = Engine_Api::_()->getItem('sesrecipe_category', $item->category_id);?>
					<?php if($categoryItem):?>
						<p class="featured_teg"><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></p>
					<?php endif;?>
				<?php endif;?>
				<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
					<div class="sesrecipe_list_labels ">
						<?php if(isset($this->featuredLabelActive) &&$item->featured == 1):?>
							<p class="sesrecipe_label_featured"><?php echo $this->translate('FEATURED');?></p>
						<?php endif;?>
						<?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
							<p class="sesrecipe_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
						<?php endif;?>
					</div>
					<?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
						<div class="sesrecipe_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
					<?php endif;?>
				<?php endif;?>
        <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
			    <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
					<div class="sesrecipe_list_thumb_over">
						<a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>"></a>
						<div class="sesrecipe_list_grid_thumb_btns"> 
							<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)):?>
                
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
							<?php endif;?>
							<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
								<?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
								<?php if(isset($this->likeButtonActive) && $canComment):?>
									<!--Like Button-->
									<?php $LikeStatus = Engine_Api::_()->sesrecipe()->getLikeStatus($item->recipe_id,$item->getType()); ?>
									<a href="javascript:;" data-url="<?php echo $item->recipe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesrecipe_like_sesrecipe_recipe_<?php echo $item->recipe_id ?> sesrecipe_like_sesrecipe_recipe <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
								<?php endif;?>
								<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)): ?>
									<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesrecipe')->isFavourite(array('resource_type'=>'sesrecipe_recipe','resource_id'=>$item->recipe_id)); ?>
									<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesrecipe_favourite_sesrecipe_recipe_<?php echo $item->recipe_id ?> sesrecipe_favourite_sesrecipe_recipe <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->recipe_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
								<?php endif;?>
							<?php endif;?>
						</div>
					</div>
		    <?php endif;?>		
				<div class="featured_recipe_list_contant">
					<p class="title"><a href="<?php echo $item->getHref();?>"><?php echo $item->getTitle();?></a></p>
					<?php if(Engine_Api::_()->getApi('core', 'sesrecipe')->allowReviewRating() && isset($this->ratingStarActive)):?>
						<?php echo $this->partial('_recipeRating.tpl', 'sesrecipe', array('rating' => $item->rating, 'class' => 'sesrecipe_list_rating sesrecipe_list_view_ratting', 'style' => 'margin:0px;'));?>
					<?php endif;?>
				  <div class="featured_recipe_date_location"> 	
				    <?php if(isset($this->creationDateActive)):?>
							<div class="sesrecipe_list_stats floatL"><p class="featured-date"><i class="fa fa-calendar"></i> <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></p></div>
						<?php endif;?>
						<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.location', 1)){ ?>
							<div class="sesrecipe_list_stats  sesrecipe_list_location floatL">
								<p>
									<i class="fa fa-map-marker"></i>
									<?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_location_direction.tpl';?>
								</p>
							</div>
						<?php } ?>
						<div class="sesrecipe_list_stats floatL">
							<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
								<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
							<?php } ?>
							<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
								<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
								<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
							<?php } ?>
							<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
								<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
							<?php } ?>
							<?php if(isset($this->ratingActive) && isset($item->rating) && $item->rating > 0 && Engine_Api::_()->sesbasic()->getViewerPrivacy('sesrecipe_review', 'view')): ?>
								<span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>">
									<i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?>
								</span>
							<?php endif; ?>
							<?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_recipeRatingStat.tpl';?>
						</div>
          </div>
        </div>
			</div>
		</div>
	<?php else:?>
	<div class="featured_recipe_list sesbasic_bxs">
		<div class="featured_recipe_list_inner sesrecipe_thumb">
			<a href="<?php echo $item->getHref();?>"><img src="<?php echo $item->getPhotoUrl();?>" /></a>
			<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
				<?php $categoryItem = Engine_Api::_()->getItem('sesrecipe_category', $item->category_id);?>
				<?php if($categoryItem):?>
					<p class="featured_teg"><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></p>
				<?php endif;?>
			<?php endif;?>
			<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
				<div class="sesrecipe_list_labels ">
					<?php if(isset($this->featuredLabelActive) &&$item->featured == 1):?>
						<p class="sesrecipe_label_featured"><?php echo $this->translate('FEATURED');?></p>
					<?php endif;?>
					<?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
						<p class="sesrecipe_label_sponsored"><?php echo $this->translate('SPONSORED');?></p>
					<?php endif;?>
				</div>
				<?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
					<div class="sesrecipe_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
				<?php endif;?>
			<?php endif;?>
      <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
				<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
				<div class="sesrecipe_list_thumb_over">
					<a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>"></a>
					<div class="sesrecipe_list_grid_thumb_btns"> 
						<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.sharing', 1)):?>
              
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
						<?php endif;?>
						<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
							<?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
							<?php if(isset($this->likeButtonActive) && $canComment):?>
								<!--Like Button-->
								<?php $LikeStatus = Engine_Api::_()->sesrecipe()->getLikeStatus($item->recipe_id,$item->getType()); ?>
								<a href="javascript:;" data-url="<?php echo $item->recipe_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesrecipe_like_sesrecipe_recipe_<?php echo $item->recipe_id ?> sesrecipe_like_sesrecipe_recipe <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
							<?php endif;?>
							<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)): ?>
								<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesrecipe')->isFavourite(array('resource_type'=>'sesrecipe_recipe','resource_id'=>$item->recipe_id)); ?>
								<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesrecipe_favourite_sesrecipe_recipe_<?php echo $item->recipe_id ?> sesrecipe_favourite_sesrecipe_recipe <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->recipe_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
							<?php endif;?>
						<?php endif;?>
					</div>
				</div>
		  <?php endif;?>		
				<div class="featured_recipe_list_contant">
					<p class="title"><a href="<?php echo $item->getHref();?>"><?php echo $item->getTitle();?></a></p>
					<?php if(Engine_Api::_()->getApi('core', 'sesrecipe')->allowReviewRating() && isset($this->ratingStarActive)):?>
						<?php echo $this->partial('_recipeRating.tpl', 'sesrecipe', array('rating' => $item->rating, 'class' => 'sesrecipe_list_rating sesrecipe_list_view_ratting', 'style' => 'margin:0px;'));?>
					<?php endif;?>
					<div class="featured_recipe_date_location">
            <?php if(isset($this->creationDateActive)):?>
						<div class="sesrecipe_list_stats floatL"><p class="featured-date"><i class="fa fa-calendar"></i> <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></p></div>
						<?php endif; ?>
						<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.location', 1)){ ?>
							<div class="sesrecipe_list_stats  sesrecipe_list_location floatL">
								<p>
									<i class="fa fa-map-marker"></i>
									<?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_location_direction.tpl';?>
								</p>
							</div>
						<?php } ?>
						<div class="sesrecipe_list_stats floatL">
							<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
								<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
							<?php } ?>
							<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
								<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enable.favourite', 1)) { ?>
								<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
							<?php } ?>
							<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
								<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
							<?php } ?>
							<?php if(isset($this->ratingActive) && isset($item->rating) && $item->rating > 0 && Engine_Api::_()->sesbasic()->getViewerPrivacy('sesrecipe_review', 'view')): ?>
								<span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>">
								<i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?>	</span>
							<?php endif; ?>
							<?php // include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/_recipeRatingStat.tpl';?>
						</div>
          </div>
        </div>
				</div>
			</div>
		<?php endif;?>
		<?php $itemCount++;?>
	<?php endforeach;?>
</div>
