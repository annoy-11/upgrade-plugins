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

<?php $identity = $this->identity;?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslisting/externals/styles/styles.css'); ?>
<div class="slide sesbasic_clearfix sesbasic_bxs seslisting_listings_carousel_wrapper <?php echo $this->isfullwidth ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->height ?>px;display:none;" id="seslisting_carousel_<?php echo $this->identity; ?>">
  <div class="listingslide_<?php echo $this->identity; ?>">
    <?php foreach( $this->paginator as $item): ?>
    <div class="seslisting_grid_inside seslisting_category_carousel_item sesbasic_clearfix seslisting_grid_btns_wrap" style="height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;">
    	<div class="seslisting_grid_inside_inner">
      <div class="seslisting_category_carousel_item_thumb seslisting_thumb" style="height:<?php echo $this->height ?>px;">       
        <?php
        $href = $item->getHref();
        $imageURL = $item->getPhotoUrl();
        ?>
        <a href="<?php echo $href; ?>" class="seslisting_list_thumb_img">
          <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
        </a>
        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)):?>
          <div class="seslisting_list_labels">
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
			<?php endif;?> 
        </div>
				<div class="seslisting_grid_inside_info sesbasic_clearfix ">
					<?php if(isset($this->categoryActive)){ ?>
						<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
							<?php $categoryItem = Engine_Api::_()->getItem('seslisting_category', $item->category_id);?>
							<?php if($categoryItem):?>
								<div class="category_tag sesbasic_clearfix">
										<a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
								</div>
							<?php endif;?>
						<?php endif;?>
					<?php } ?>
          <?php if(isset($this->titleActive) ){ ?>
            <span class="seslisting_category_carousel_item_info_title">
              <?php if(strlen($item->getTitle()) > $this->title_truncation){ 
                $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';
                echo $this->htmlLink($item->getHref(),$title) ?>
              <?php }else{ ?>
              	<?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
              <?php } ?>
							<?php if(Engine_Api::_()->getApi('core', 'seslisting')->allowReviewRating() && isset($this->ratingStarActive)):?>
								<?php echo $this->partial('_listingRating.tpl', 'seslisting', array('rating' => $item->rating, 'class' => 'seslisting_list_rating seslisting_list_view_ratting', 'style' => 'margin-bottom:0px; margin-top:5px;'));?>
							<?php endif;?>
            </span>
          <?php } ?>
          <?php if(isset($this->priceActive) ){ ?>
          <div class="seslisting_list_grid_price">
             <?php echo Engine_Api::_()->seslisting()->getCurrencyPrice($item->price); ?>
          </div>
          <?php } ?>
          <?php if(isset($this->byActive)){ ?>
				<div class="admin_teg seslisting_list_stats sesbasic_text_dark">
					<i class="fa fa-user"></i> <?php $owner = $item->getOwner(); ?>
					<span>
						<?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?>
					</span>
				</div>
			<?php } ?>
      <?php if(isset($this->creationDateActive)){ ?>
				<div class="admin_teg seslisting_list_stats sesbasic_text_dark"><i class="fa fa-calendar"></i> <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?></div>
			<?php } ?>
      <div class="seslisting_list_stats">
			<?php if(isset($this->likeActive) && isset($item->like_count)) { ?>
				<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
			<?php } ?>
			<?php if(isset($this->commentActive) && isset($item->comment_count)) { ?>
				<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count;?> </span>
			<?php } ?>
			<?php if(isset($this->favouriteActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('seslisting.enable.favourite', 1)) { ?>
				<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i>
        <?php echo $item->favourite_count;?> </span>
			<?php } ?>
			<?php if(isset($this->viewActive) && isset($item->view_count)) { ?>
				<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
			<?php } ?>
			<?php include APPLICATION_PATH .  '/application/modules/Seslisting/views/scripts/_listingRatingStat.tpl';?>
		</div>
        </div>
        </div>
    	</div>
    <?php endforeach; ?>
  </div>
</div>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seslisting/externals/scripts/slick/slick.js') ?>
<script type="text/javascript">
  window.addEvent('domready', function () {
		<?php if($this->isfullwidth){ ?>
			var htmlElement = document.getElementsByTagName("body")[0];
			htmlElement.addClass('seslisting_listings_carousel');
		<?php } ?>
		<?php if($this->autoplay){ ?>
			var autoplay_<?php echo $this->identity; ?> = true;
		<?php }else{ ?>
			var autoplay_<?php echo $this->identity; ?> = false;
		<?php } ?>
	<?php if($this->carousel_type == 1){ ?>
		sesBasicAutoScroll('.listingslide_<?php echo $this->identity; ?>').slick({
			dots: false,
			infinite: true,
			autoplaySpeed: <?php echo $this->speed ?>,
			slidesToShow: <?php echo $this->slidesToShow ?>,
			centerMode: true,
			variableWidth: true,
			autoplay: autoplay_<?php echo $this->identity; ?>,
		});
	<?php }else{ ?>
		sesBasicAutoScroll('.listingslide_<?php echo $this->identity; ?>').slick({
			slidesToShow: <?php echo $this->slidesToShow ?>,
			slidesToScroll: 1,
			autoplay: autoplay_<?php echo $this->identity; ?>,
			autoplaySpeed: <?php echo $this->speed ?>,
			autoplay: autoplay_<?php echo $this->identity; ?>,
		});
	<?php } ?>
  });
// On before slide change
sesBasicAutoScroll('.listingslide_<?php echo $this->identity; ?>').on('init', function(event, slick, currentSlide, nextSlide){
  sesBasicAutoScroll('#seslisting_carousel_<?php echo $this->identity; ?>').show();
});
</script>

