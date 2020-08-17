<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $identity = $this->identity;?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); ?>
<div class="slide sesbasic_clearfix sesbasic_bxs sesproduct_products_carousel_wrapper <?php echo $this->isfullwidth ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->height ?>px;display:none;" id="sesproduct_carousel_<?php echo $this->identity; ?>">
  <div class="productslide_<?php echo $this->identity; ?>">
    <?php foreach( $this->paginator as $item): ?>
    <div class="sesproduct_grid_inside sesproduct_category_carousel_item sesbasic_clearfix" style="height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;">
    	<div class="sesproduct_grid_inside_inner">
        <div class="sesproduct_category_carousel_item_thumb sesproduct_thumb" style="height:<?php echo $this->height ?>px;">       
          <?php
          $href = $item->getHref();
          $imageURL = $item->getPhotoUrl();
          ?>
          <a href="<?php echo $href; ?>" class="sesproduct_list_thumb_img">
            <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
          </a>
          <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)):?>
            <div class="sesproduct_labels">
              <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
                <span class="sesproduct_label_featured" title='<?php echo $this->translate("Featured")?>'> <i class="fa fa-star"></i> </span>
              <?php endif;?>
              <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
                <span class="sesproduct_label_sponsored" title='<?php echo $this->translate("Sponsored")?>'> <i class="fa fa-star"></i> </span>
              <?php endif;?>
            </div>
          <?php endif;?>
          <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
              <div class="sesproduct_list_grid_thumb_btns"> 
                <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
                  <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
    
                <?php endif;?>
                <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                  <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                  <?php if(isset($this->likeButtonActive) && $canComment):?>
                    <!--Like Button-->
                    <?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatus($item->product_id,$item->getType()); ?>
                    <a href="javascript:;" data-url="<?php echo $item->product_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product_<?php echo $item->product_id ?> sesproduct_like_sesproduct_product <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
                  <?php endif;?>
                  <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)): ?>
                    <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$item->product_id)); ?>
                    <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product_<?php echo $item->product_id ?> sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                  <?php endif;?>
                <?php endif;?>
              </div>
            <?php endif;?> 
          </div>
          <div class="sesproduct_grid_inside_info sesbasic_clearfix">
            <?php if(isset($this->titleActive)){ ?>
              <div class="sesproduct_grid_inside_info_title">
                <div class="_name">
                  <?php if(strlen($item->getTitle()) > $this->title_truncation){ 
                    $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';
                    echo $this->htmlLink($item->getHref(),$title) ?>
                  <?php }else{ ?>
                    <?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
                  <?php } ?>
                </div>
                <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
                  <div class="sesproduct_verify">
                    <i class="sesproduct_label_verified sesbasic_verified_icon" title="Verified"></i>
                  </div>
                <?php endif;?>
              </div>
            <?php } ?>
            <div class="sesproduct_grid_meta_block">
              <?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
              <?php if(isset($this->storeNameActive) && count($store)){ ?>
                <div class="sesproduct_product_stat sesbasic_text_light">
                  <div class="sesproduct_store_name">
                    <div class="store_logo">
                      <a href="<?php echo $store->getHref(); ?>"><?php echo $this->itemPhoto($store, 'thumb.icon');?></a>
                    </div>
                    <div class="store_name">
                      <a href="<?php echo $store->getHref(); ?>"><?php echo $store->title; ?></a>
                    </div>
                  </div> 
                </div>
              <?php } ?>
              <?php if(isset($this->creationDateActive)){ ?>
                <div class="sesproduct_product_stat">
                  <span>
                    <i class="fa fa-calendar"></i>
                    <?php echo ' '.date('M d, Y',strtotime($item->publish_date));?>
                  </span>
                </div>
              <?php } ?>
              <?php if(isset($this->brandActive) && $item->brand != ''): ?>
                <div class="sesproduct_product_brand sesbasic_text_light">
                  <span> <i class="fa fa-cube" title=""></i> <a href="#"><?php echo $item->brand ?></a> </span>
                </div>
              <?php endif;?>
              <?php if(isset($this->stockActive)){  ?>
                <?php include(APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'); ?>
              <?php } ?>
              <?php if(isset($this->categoryActive)){ ?>
                <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?> 
                  <?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
                  <?php if($categoryItem):?>
                    <div class="sesproduct_product_stat"> 
                      <span><i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> 
                        <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></span>
                    </div>
                  <?php endif;?>
                <?php endif;?>
              <?php } ?>
            </div>
            <?php if(isset($this->priceActive)){ ?>
              <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
            <?php } ?>
            <?php if(isset($this->ratingStarActive)){ ?>
              <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_productRatingStat.tpl';?>
            <?php } ?>
            <div class="sesproduct_add_cart sesbasic_clearfix">
              <div class="cart_only_text hidden">
               <?php if(isset($this->addCartActive)){ ?>
                  <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item)); ?>
              <?php } ?>
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1) && isset($this->addWishlistActive)): ?>
                <a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><?php echo $this->translate('Add to Wishlist'); ?></a>
              <?php endif; ?>
             </div>
              <div class="cart_only_icon">
                <?php if(isset($this->addCartActive) ){ ?>
                  <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item,'icon'=>true)); ?>
               <?php } ?>
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1)  && isset($this->addWishlistActive)): ?>
                <a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="far fa-bookmark"></i></a>
                <?php endif; ?>  
              </div>
            </div>
            <?php if(isset($this->addCartActive) ){ ?>
              <div class="sesproduct_product_compare sesbasic_clearfix">
                <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
              </div>
            <?php } ?>
        	</div>
        </div>
    	</div>
    <?php endforeach; ?>
  </div>
</div>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/scripts/slick/slick.js') ?>
<script type="text/javascript">
  window.addEvent('domready', function () {
		<?php if($this->isfullwidth){ ?>
			var htmlElement = document.getElementsByTagName("body")[0];
			htmlElement.addClass('sesproduct_products_carousel');
		<?php } ?>
		<?php if($this->autoplay){ ?>
			var autoplay_<?php echo $this->identity; ?> = true;
		<?php }else{ ?>
			var autoplay_<?php echo $this->identity; ?> = false;
		<?php } ?>
	<?php if($this->carousel_type == 1){ ?>
		sesBasicAutoScroll('.productslide_<?php echo $this->identity; ?>').slick({
			dots: false,
			infinite: true,
			autoplaySpeed: <?php echo $this->speed ?>,
			slidesToShow: <?php echo $this->slidesToShow ?>,
			centerMode: true,
			variableWidth: true,
			autoplay: autoplay_<?php echo $this->identity; ?>,
		});
	<?php }else{ ?>
		sesBasicAutoScroll('.productslide_<?php echo $this->identity; ?>').slick({
			slidesToShow: <?php echo $this->slidesToShow ?>,
			slidesToScroll: 1,
			autoplay: autoplay_<?php echo $this->identity; ?>,
			autoplaySpeed: <?php echo $this->speed ?>,
			autoplay: autoplay_<?php echo $this->identity; ?>,
		});
	<?php } ?>
  });
// On before slide change
sesBasicAutoScroll('.productslide_<?php echo $this->identity; ?>').on('init', function(event, slick, currentSlide, nextSlide){
  sesBasicAutoScroll('#sesproduct_carousel_<?php echo $this->identity; ?>').show();
});
</script>

