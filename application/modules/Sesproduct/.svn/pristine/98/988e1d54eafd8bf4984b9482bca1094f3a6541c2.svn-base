<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _supergridView.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<!-- <li class="sesproduct_new_grid_block sesbasic_bxs <?php if((isset($this->my_products) && $this->my_products)){ ?>isoptions<?php } ?>" style="width:<?php echo is_numeric($this->width_supergrid) ? $this->width_supergrid.'px' : $this->width_supergrid ?>;">
  <div class="sesproduct_grid_inner">
    <div class="sesproduct_grid_thumb sesproduct_thumb" style="height:<?php echo is_numeric($this->height_supergrid) ? $this->height_supergrid.'px' : $this->height_supergrid ?>;">
      <?php $href = $item->getHref();$imageURL = $photoPath;?>
      <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>" class="sesproduct_thumb_img"> <span style="background-image:url(<?php echo $imageURL; ?>);"></span> </a>
      <?php if(Engine_Api::_()->sesproduct()->saleRunning($item,$this->viewer()->getIdentity())){ ?>
      <div class="sesproduct_sale">
        <p class="sale_label"><?php echo $this->translate("Sale"); ?></p>
      </div>
      <?php } ?>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
      <div class="sesproduct_labels">
        <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
        <p class="sesproduct_label_featured"><?php echo $this->translate('Featured');?></p>
        <?php endif;?>
        <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
        <p class="sesproduct_label_sponsored"><?php echo $this->translate('Sponsored');?></p>
        <?php endif;?>
      </div>
      <?php endif;?>
      <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
      <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
      <div class="sesproduct_img_thumb_over"> <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
        <div class="sesproduct_list_grid_thumb_btns">
          <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
          <?php if($this->socialshare_icon_limit): ?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
          <?php else: ?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_gridview3plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_gridview3limit)); ?>
          <?php endif; ?>
          <?php endif;?>
          <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
          <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
          <?php if(isset($this->likeButtonActive) && $canComment):?>
          <?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatus($item->product_id,$item->getType()); ?>
          <a href="javascript:;" data-url="<?php echo $item->product_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product_<?php echo $item->product_id ?> sesproduct_like_sesproduct_product <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
          <?php endif;?>
          <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)): ?>
          <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$item->product_id)); ?>
          <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesproduct_favourite_sesproduct_product_<?php echo $item->product_id ?> sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
          <?php endif;?>
          <?php endif;?>
        </div>
        <div class="sesproduct_quick_view"> <a href="javascript:;" data-url="<?php echo "sesproduct/index/quick-view/product_id/". $item->product_id; ?>" class="quick_vbtn sessmoothbox">Quick View</a> </div>
        <div class="sesproduct_add_cart sesbasic_clearfix">
          <div class="cart_only_text hidden">
            <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item)); ?>
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1)): ?>
            <a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><?php echo $this->translate('Add to Wishlist'); ?></a>
            <?php endif; ?>
          </div>
          <div class="cart_only_icon">
            <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item,'icon'=>true)); ?>
            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1)): ?>
            <a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="fa fa-plus"></i></a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endif;?>
      <div class="sesproduct_grid_memta_title">
        <?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
        <?php if($categoryItem):?>
        <span><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></span>
        <?php endif;?>
      </div>
    </div>
    <div class="sesproduct_grid_info clear clearfix sesbm">
      <?php if(Engine_Api::_()->getApi('core', 'sesproduct')->allowReviewRating() && isset($this->ratingStarActive)):?>
      <?php echo $this->partial('_productRating.tpl', 'sesproduct', array('rating' => $item->rating, 'class' => 'sesproduct_list_rating sesproduct_list_view_ratting floatR', 'style' => ''));?>
      <?php endif;?>
      <?php if(isset($this->titleActive)): ?>
      <div class="sesproduct_grid_aligned">
        <div class="sesproduct_second_grid_info_title">
          <?php if(strlen($item->getTitle()) > $this->title_truncation_supergrid):?>
          <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_supergrid).'...';?>
          <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
          <?php else: ?>
          <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
          <?php endif; ?>
        </div>
        <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
        <div class="sesproduct_verify">
          <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
          <div class="sesproduct_verified_label" title="<?php echo $this->translate('Verified');?>"><i class="fa fa-check"></i></div>
          <?php endif;?>
        </div>
        <?php endif;?>
        <?php endif;?>
      </div>
      <div class="sesproduct_grid_meta_block">
        <?php if(isset($this->byActive)){ ?>
        <div class="sesproduct_product_stat sesbasic_text_dark"> <span>
          <?php $owner = $item->getOwner(); ?>
          <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?> <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?> </span> </div>
        <?php if(isset($this->creationDateActive)): ?>
        <div class="sesproduct_product_stat sesbasic_text_light"> <span><i class=" fa fa-clock-o"></i>
          <?php if($item->publish_date): ?>
          <?php echo date('M d, Y',strtotime($item->publish_date));?>
          <?php else: ?>
          <?php echo date('M d, Y',strtotime($item->creation_date));?>
          <?php endif; ?>
          &nbsp;|</span> </div>
        <?php endif;?>
        <?php include(APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'); ?>
        <?php if(isset($this->categoryActive)){ ?>
        <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
        <?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
        <?php if($categoryItem):?>
        <div class="sesproduct_product_stat sesbasic_text_light"> <span><i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a> </span> </div>
        <?php endif;?>
        <?php endif;?>
        <?php } ?>
        <?php } ?>
        <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1)){ ?>
        <div class="sesproduct_product_stat sesproduct_list_location sesbasic_text_dark"> <span> <i class="fa fa-map-marker"></i> <a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a> </span> </div>
        <?php } ?>
      </div>
      <?php  if(isset($this->descriptionsupergridActive)){?>
      <div class="sesproduct_listing_item_des"> <?php echo $this->string()->truncate($this->string()->stripTags($item->body), $this->description_truncation_supergrid) ?> </div>
      <?php } ?>
      <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_productRatingStat.tpl';?>
      <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
      <div class="sesproduct_product_offers"> <span class="offer">Offer</span> <span>No Cost EMI</span> </div>
      <div class="sesproduct_product_compare">
        <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
      </div>
      <div class="sesproduct_add_cart double sesbasic_clearfix">
        <div class="cart_only_icon">
          <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item,'icon'=>true)); ?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1)): ?>
            <a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="fa fa-plus"></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</li>
 -->