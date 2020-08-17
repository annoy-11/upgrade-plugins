<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _pinboardView.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<!--Pinboard View-->
<li class="sesproduct_pinboard_list sesbasic_bxs new_image_pinboard_<?php echo $randonNumber; ?>">
  <div class="sesproduct_pinboard_list_item <?php if((isset($this->my_products) && $this->my_products)){ ?>isoptions<?php } ?>">
    <div class="sesproduct_pinboard_list_item_top sesproduct_thumb sesbasic_clearfix">
      <div class="sesproduct_pinboard_list_item_thumb">
      <?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
        <?php if(Engine_Api::_()->sesproduct()->saleRunning($item,$this->viewer()->getIdentity()) && $this->show_sale && $settings->getSetting('sesproduct.enable.sale', 1)){ ?>
        <div class="sesproduct_sale">
          <p class="sale_label"><?php echo $this->translate("Sale"); ?></p>
        </div>
        <?php } ?>
        <a href="<?php echo $item->getHref()?>" data-url = "<?php echo $item->getType() ?>" class="<?php echo $item->getType() != 'sesproduct_chanel' ? 'sesproduct_thumb_img' : 'sesproduct_thumb_nolightbox' ?>"> <img src="<?php echo $photoPath; ?>"> <span style="background-image:url(<?php echo $photoPath; ?>);display:none;"> </span> </a> 
      </div>
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
        <div class="sesproduct_labels">
          <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
          <span class="sesproduct_label_featured"  title='<?php echo $this->translate("Featured")?>'><?php echo $this->translate("Featured")?></span>
          <?php endif;?>
          <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
          <span class="sesproduct_label_sponsored" title='<?php echo $this->translate("Sponsored")?>'><?php echo $this->translate("Sponsored")?></span>
          <?php endif;?>
        </div>
      <?php endif;?>
      <?php if(isset($this->quickViewActive)) { ?>
        <div class="sesproduct_quick_view">
            <a href="javascript:;" data-url="<?php echo "sesproduct/index/quick-view/product_id/". $itemProduct->product_id; ?>" class="quick_vbtn sessmoothbox">Quick View</a>
        </div>
     <?php } ?>
      <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
      <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
      <div class="sesproduct_img_thumb_over"> <a href="<?php echo $href; ?>" data-url = "<?php echo $item->getType() ?>"></a>
        <div class="sesproduct_list_grid_thumb_btns">
          <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
          <?php if($this->socialshare_icon_limit): ?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
          <?php else: ?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_pinviewplusicon, 'socialshare_icon_limit' => $this->socialshare_icon_pinviewlimit)); ?>
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
          <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product_<?php echo $item->product_id ?> sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
          <?php endif;?>
          <?php endif;?>
        </div>
        <?php  if(isset($this->quickViewActive)): ?>
					<div class="sesproduct_quick_view">
						<a href="javascript:;" data-url="<?php echo "sesproduct/index/quick-view/product_id/". $item->product_id; ?>" class="quick_vbtn sessmoothbox"><?php echo $this->translate("Quick View"); ?></a>
					</div>
				<?php endif;?>
			</div>
    </div>
     <?php endif;?>
    <div class="sesproduct_pinboard_info_product sesbasic_clearfix">
      <div class="sesproduct_pinboard_list_item_cont sesbasic_clearfix">
      <?php if(isset($this->storeNameActive)){ ?>
        <?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
          <?php if(count($store)) { ?>
           <div class="sesproduct_product_stat sesbasic_text_light">
                  <span>By: <a href="<?php echo $store->getHref(); ?>"><?php echo $store->getTitle(); ?></a></span>
          </div>
        <?php } ?>
        <?php } ?>
       <?php if(isset($this->addCompareActive)){ ?>
          <div class="sesproduct_product_compare sesbasic_clearfix">
              <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
          </div>
        <?php } ?>
        <?php if(isset($this->titleActive)):?>
        <div class="sesproduct_grid_aligned">
          <div class="sesproduct_pinboard_title">
            <?php if(strlen($item->getTitle()) > $this->title_truncation_pinboard):?>
            <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_pinboard).'...';?>
            <?php echo $this->htmlLink($item->getHref(),$title ) ?>
            <?php else: ?>
            <?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
            <?php endif;?>
          </div>
          <div class="sesproduct_verify">
            <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
            <i class="sesproduct_label_verified sesbasic_verified_icon" title="Verified"></i>
            <?php endif;?>
          </div>
        </div>
        <?php endif;?>
         <?php if(isset($this->ratingActive)){ ?>
             <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_rating.tpl';?>
        <?php } ?>
         <?php if(isset($this->priceActive)){ ?>
            <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
         <?php } ?>
        <div>
          <div class="sesproduct_add_cart sesbasic_clearfix">
            <div class="cart_only_text">
             <?php if(isset($this->addCartActive)){ ?>
                <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item)); ?>
              <?php } ?>
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1) && isset($this->addWishlistActive)): ?>
              <a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="far fa-bookmark"></i><?php echo $this->translate('Add to Wishlist'); ?></a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="sesproduct_pinboard_list_item_btm sesbasic_clearfix">          
          <?php if(isset($this->my_products) && $this->my_products ){ ?>
          <?php if($this->can_edit || $this->can_delete){ ?>
          <div class="sesproduct_listing_in_grid2_date sesbasic_text_light"> <span class="sesproduct_list_option_toggle fa fa-ellipsis-v sesbasic_text_light"></span>
            <div class="sesproduct_listing_options_pulldown">
              <?php if($this->can_edit){ 
                  echo $this->htmlLink(array('route' => 'sesproduct_specific','action' => 'edit','product_id' => $item->product_id), $this->translate('Edit Product')) ; 
                  } ?>
              <?php if ($this->can_delete){
                  echo $this->htmlLink(array('route' => 'sesproduct_specific','action' => 'delete', 'product_id' => $item->product_id), $this->translate('Delete Product'), array('onclick' =>'opensmoothboxurl(this.href);return false;'));
                  } ?>
            </div>
          </div>
          <?php } ?>
          <?php } ?>
          <?php if(isset($this->enableCommentPinboardActive)):?>
          <?php $itemType = '';?>
          <?php if(isset($item->product_id)):?>
          <?php $item_id = $item->product_id;?>
          <?php $itemType = 'sesproduct';?>
          <?php endif; ?>
          <?php if(($itemType != '')): ?>
          <div class="sesproduct_pinboard_list_comments"> <?php echo (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedcomment') ? $this->action('list', 'comment', 'sesadvancedcomment', array('type' => $itemType, 'id' => $item_id,'page'=>'')) : $this->action("list", "comment", "sesbasic", array("item_type" => $itemType, "item_id" => $item_id,"widget_identity"=>$randonNumber))); ?></div>
          <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</li>
