<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/styles/styles.css'); ?> 
<?php if($this->description) { ?>
  <p><?php echo $this->translate($this->description); ?></p>
<?php } ?>
<div class="eblog-featured_blog_view sesbasic_clearfix sesbasic_bxs clear">
	<?php $itemCount = 1;?>
	<?php foreach($this->blogs as $item):?>
		<?php if($itemCount == 1):?>
			<div class="featured_blog_list featured_blog_listing sesbasic_bxs">
				<div class="featured_blog_list_inner eblog_thumb">
        <a href="<?php echo $item->getHref();?>"><img src="<?php echo $item->getPhotoUrl('thumb.normal');?>" /></a>
				<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id) && isset($this->categoryActive) && $this->categoryActive):?>
					<?php $categoryItem = Engine_Api::_()->getItem('eblog_category', $item->category_id);?>
					<?php if($categoryItem):?>
						<p class="featured_teg"><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></p>
					<?php endif;?>
				<?php endif;?>
				<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
					<div class="eblog_list_labels ">
						<?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
							<p class="eblog_label_sponsored"><?php echo $this->translate('Sponsored');?></p>
						<?php endif;?>
            <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
							<p class="eblog_label_featured"><?php echo $this->translate('Featured');?></p>
						<?php endif;?>
            <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
						<p class="eblog_label_verified"><?php echo $this->translate('Verified');?></div>
					<?php endif;?>
					</div>
				<?php endif;?>
        <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
			    <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
					<div class="eblog_list_share_btns">
						<div class="eblog_list_btns"> 
							<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)):?>
                
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
							<?php endif;?>
							<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
								<?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
								<?php if(isset($this->likeButtonActive) && $canComment):?>
									<!--Like Button-->
									<?php $LikeStatus = Engine_Api::_()->eblog()->getLikeStatus($item->blog_id,$item->getType()); ?>
									<a href="javascript:;" data-url="<?php echo $item->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eblog_like_eblog_blog_<?php echo $item->blog_id ?> eblog_like_eblog_blog <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
								<?php endif;?>
								<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)): ?>
									<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'eblog')->isFavourite(array('resource_type'=>'eblog_blog','resource_id'=>$item->blog_id)); ?>
									<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn eblog_favourite_eblog_blog_<?php echo $item->blog_id ?> eblog_favourite_eblog_blog <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->blog_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
								<?php endif;?>
							<?php endif;?>
						</div>
					</div>
		    <?php endif;?>		
				<div class="featured_blog_list_contant">
          <?php if(isset($this->titleActive)): ?>
            <p class="title"><a href="<?php echo $item->getHref();?>"><?php echo $item->getTitle();?></a></p>
					<?php endif; ?>
          <?php if(isset($this->byActive)): ?>
            <div class="featured_blog_date_location"><div class="eblog_list_stats floatL">
              <p class="featured-date">
              <?php $owner = $item->getOwner(); ?>
              <?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?>
              </p>
              </div>
            </div>
          <?php endif; ?>
					<?php if(Engine_Api::_()->getApi('core', 'eblog')->allowReviewRating() && isset($this->ratingStarActive)):?>
						<?php echo $this->partial('_blogRating.tpl', 'eblog', array('rating' => $item->rating, 'class' => 'eblog_list_rating eblog_list_view_ratting'));?>
					<?php endif;?>
				  <div class="featured_blog_date_location"> 	
				    <?php if(isset($this->creationDateActive)):?>
							<div class="eblog_list_stats floatL"><p class="featured-date"><i class="fa fa-calendar"></i> <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></p></div>
						<?php endif;?>
						<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.location', 1)){ ?>
							<div class="eblog_list_stats  eblog_list_location floatL">
								<p>
									<i class="fa fa-map-marker"></i>
									<a href="<?php echo $this->url(array('resource_id' => $item->blog_id,'resource_type'=>'eblog_blog','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $item->location;?></a>
								</p>
							</div>
						<?php } ?>
						<div class="eblog_list_stats floatL">
							<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
								<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="sesbasic_icon_like_o"></i><?php echo $item->like_count; ?></span>
							<?php } ?>
							<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
								<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="sesbasic_icon_comment_o"></i><?php echo $item->comment_count;?></span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)) { ?>
								<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="sesbasic_icon_favourite_o"></i><?php echo $item->favourite_count;?></span>
							<?php } ?>
							<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
								<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="sesbasic_icon_view"></i><?php echo $item->view_count; ?></span>
							<?php } ?>
							<?php if(isset($this->ratingActive) && isset($item->rating) && $item->rating > 0 && Engine_Api::_()->sesbasic()->getViewerPrivacy('eblog_review', 'view')): ?>
								<span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>">
									<i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?>
								</span>
							<?php endif; ?>
							<?php include APPLICATION_PATH .  '/application/modules/Eblog/views/scripts/_blogRatingStat.tpl';?>
						</div>
          </div>
        </div>
			</div>
	<?php else:?>
	<div class="featured_blog_list sesbasic_bxs">
		<div class="featured_blog_list_inner eblog_thumb">
			<a href="<?php echo $item->getHref();?>"><img src="<?php echo $item->getPhotoUrl('thumb.normal');?>" /></a>
			<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id) && isset($this->categoryActive) && $this->categoryActive ):?>
				<?php $categoryItem = Engine_Api::_()->getItem('eblog_category', $item->category_id);?>
				<?php if($categoryItem):?>
					<p class="featured_teg"><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></p>
				<?php endif;?>
			<?php endif;?>
			<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
				<div class="eblog_list_labels ">
					<?php if(isset($this->featuredLabelActive) &&$item->featured == 1):?>
						<p class="eblog_label_featured"><?php echo $this->translate('Featured');?></p>
					<?php endif;?>
					<?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
						<p class="eblog_label_sponsored"><?php echo $this->translate('Sponsored');?></p>
					<?php endif;?>
				</div>
			<!-- 	<?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
					<div class="eblog_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
				<?php endif;?> -->
			<?php endif;?>
      <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
				<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
				<div class="eblog_list_thumb_over">
					<a href="<?php echo $item->getHref(); ?>" data-url = "<?php echo $item->getType() ?>"></a>
					<div class="eblog_list_grid_thumb_btns"> 
						<?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.sharing', 1)):?>
              
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
						<?php endif;?>
						<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
							<?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
							<?php if(isset($this->likeButtonActive) && $canComment):?>
								<!--Like Button-->
								<?php $LikeStatus = Engine_Api::_()->eblog()->getLikeStatus($item->blog_id,$item->getType()); ?>
								<a href="javascript:;" data-url="<?php echo $item->blog_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn eblog_like_eblog_blog_<?php echo $item->blog_id ?> eblog_like_eblog_blog <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
							<?php endif;?>
							<?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)): ?>
								<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'eblog')->isFavourite(array('resource_type'=>'eblog_blog','resource_id'=>$item->blog_id)); ?>
								<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn eblog_favourite_eblog_blog_<?php echo $item->blog_id ?> eblog_favourite_eblog_blog <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->blog_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
							<?php endif;?>
						<?php endif;?>
					</div>
				</div>
		  <?php endif;?>		
				<div class="featured_blog_list_contant">
          <?php if(isset($this->titleActive)): ?>
            <p class="title"><a href="<?php echo $item->getHref();?>"><?php echo $item->getTitle();?></a></p>
					<?php endif; ?>
          <?php if(isset($this->byActive)): ?>
            <div class="featured_blog_date_location"><div class="eblog_list_stats floatL">
              <p class="featured-date">
              <?php $owner = $item->getOwner(); ?>
              <?php echo $this->translate('By');?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle()) ?>
              </p>
              </div>
            </div>
          <?php endif; ?>
					<?php if(Engine_Api::_()->getApi('core', 'eblog')->allowReviewRating() && isset($this->ratingStarActive)):?>
						<?php echo $this->partial('_blogRating.tpl', 'eblog', array('rating' => $item->rating, 'class' => 'eblog_list_rating eblog_list_view_ratting'));?>
					<?php endif;?>
					<div class="featured_blog_date_location">
            <?php if(isset($this->creationDateActive)):?>
						<div class="eblog_list_stats floatL"><p class="featured-date"><i class="fa fa-calendar"></i> <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></p></div>
						<?php endif; ?>
						<?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.location', 1)){ ?>
							<div class="eblog_list_stats  eblog_list_location floatL">
								<p>
									<i class="fa fa-map-marker"></i>
									<a href="<?php echo $this->url(array('resource_id' => $item->blog_id,'resource_type'=>'eblog_blog','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl"><?php echo $item->location;?></a>
								</p>
							</div>
						<?php } ?>
						<div class="eblog_list_stats floatL">
							<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
								<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
							<?php } ?>
							<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
								<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?></span>
							<?php } ?>
							<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1)) { ?>
								<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
							<?php } ?>
							<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
								<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
							<?php } ?>
							<?php if(isset($this->ratingActive) && isset($item->rating) && $item->rating > 0 && Engine_Api::_()->sesbasic()->getViewerPrivacy('eblog_review', 'view')): ?>
								<span  title="<?php echo $this->translate(array('%s rating', '%s ratings', round($item->rating,1)), $this->locale()->toNumber(round($item->rating,1)))?>">
								<i class="fa fa-star"></i><?php echo round($item->rating,1).'/5';?>	</span>
							<?php endif; ?>
							<?php // include APPLICATION_PATH .  '/application/modules/Eblog/views/scripts/_blogRatingStat.tpl';?>
						</div>
          </div>
        </div>
				</div>
			</div>
		<?php endif;?>
		<?php $itemCount++;?>
	<?php endforeach;?>
</div>
