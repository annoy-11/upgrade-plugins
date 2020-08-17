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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); ?>
<?php if(empty($_SESSION["sesproduct_add_to_compare"])){ ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("Select product to compare"); ?>
    </span>
  </div>
<?php
  return;
} ?>
<div class="sesproduct_addto_Compare sesbasic_clearfix sesbasic_bxs">
  <div class="sesproduct_compare_table">
    <table class="compare_product">
      <tbody class="sesproduct_compare_cnt">
        <tr>
          <td>
          </td>
         <?php foreach($this->products as $product){ $item = $product; ?>
          <td>
            <div class="product_compare_info">
            <a href="<?php echo $product->getHref(); ?>">
                <img src="<?php echo $product->getPhotoUrl(); ?>"/>
            </a>
                <?php if(count($this->products) > 2) { ?>
                  <a href="javascript:;" class="" data-rel="<?php echo $product->getIdentity() ?>"><span class="sesproduct_remove_conpare compare_close"><i class="fa fa-close"></i></span></a>
                <?php } ?>
                 <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)):?>
                    <div class="sesproduct_labels ">
                        <?php  if(isset($this->featuredLabelActive) && $product->featured == 1):?>
                        <span class="sesproduct_label_featured" title="Featured"> <i class="fa fa-star"></i> </span>
                        <?php endif;?>
                        <?php if(isset($this->sponsoredLabelActive) && $product->sponsored == 1):?>
                        <span class="sesproduct_label_sponsored" title="Sponsored"> <i class="fa fa-star"></i> </span>
                        <?php endif;?>
                        <?php if(isset($this->verifiedLabelActive) && $product->verified == 1):?>
                        <span class="sesproduct_label_verified" title="Verified"> <i class="fa fa-star"></i> </span>
                        <?php endif;?>
                    </div>
                <?php endif;?>
                <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)): ?>
                <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
                    <div class="sesproduct_img_thumb_over"> 
                    <div class="sesproduct_grid_btns">
                        <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
                        <?php if($this->socialshare_icon_limit): ?>
                            <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                            <?php else: ?>
                            <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_listview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listview1limit)); ?>
                        <?php endif; ?>
                        <?php endif;?>
                    <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                        <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                        <?php if(isset($this->likeButtonActive) && $canComment):?>
                            <?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatus($item->product_id,$item->getType()); ?>
                            <a href="javascript:;" data-url="<?php echo $item->product_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product_<?php echo $item->product_id ?> sesproduct_like_sesproduct_product <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>">
                                <i class="fa fa-thumbs-up"></i>
                                <span><?php echo $item->like_count; ?></span>
                            </a>
                            <?php endif;?>
                        <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)): ?>
                            <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$item->product_id)); ?>
                            <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product_<?php echo $item->product_id ?> sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>" data-url="<?php echo $item->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                        <?php endif;?>
                        <?php endif;?>
                    </div>
                    <div class="sesproduct_quick_view">
                    <a href="javascript:;" data-url="<?php echo "sesproduct/index/quick-view/product_id/". $item->product_id; ?>" class="quick_vbtn sessmoothbox">Quick View</a>
                    </div>
                </div>
                <?php endif;?>
                <?php if(isset($this->productTitleActive)) { ?>
                    <div class="product_compare_title">
                        <a href="<?php echo $product->getHref(); ?>"><h5><?php echo $product->getTitle(); ?></h5></a>
                    </div>
                 <?php } ?>
                 <div class="sesproduct_product_stat sesbasic_text_light">
              <?php if(isset($this->storeNameActive)){ ?>
                <?php $store = Engine_Api::_()->getItem('stores',$product->store_id); ?>
                    <div class="sesproduct_store_name">
                        <div class="store_logo">
                            <img src="<?php echo $store->getPhotoUrl(); ?>"/>
                        </div>
                        <div class="store_name">
                            <a href="<?php echo $store->getHref(); ?>"><span><?php echo $store->title; ?></span></a>
                        </div>
                    </div> 
                <?php } ?>
              </div>   
                <?php if(isset($this->productDescActive)) { ?>
                    <div class="product_compare_title">
                        <p><?php echo $product->body; ?></p>
                    </div>
                 <?php } ?>
                <?php if(isset($this->ratingActive)) { ?>
                    <div class="sesproduct_rating_review">
                        <?php $item = $product; ?>
                        <?php include "application/modules/Sesproduct/views/scripts/_rating.tpl"; ?>
                    </div>
                <?php } ?>
                 <?php if(isset($this->priceActive)) { ?>
                    <div class="product_compare_price">
                        <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
                    </div>
                <?php } ?>
               <?php if(isset($this->stockActive)){ ?>
                  <?php  include APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'; ?>
               <?php }?>
            <?php if(isset($this->addCartActive)) { ?>
                <div class="product_compare_action sesproduct_add_cart">
                    <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$product)); ?>
                        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1) && isset($this->addWishlistActive)): ?>
                        <a href="javascript:void(0)" data-rel="<?php echo $item->getIdentity(); ?>" class="sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>" title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="fa fa-bookmark-o"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php } ?>
          <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
            <div class="sesproduct_compare_social">
            <?php if($this->socialshare_icon_limit): ?>
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
              <?php else: ?>
              <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_listview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_listview1limit)); ?>
            <?php endif; ?>
          <?php endif;?>
            <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
              <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
            <?php if(isset($this->likeButtonActive) && $canComment):?>
              <?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatus($item->product_id,$item->getType()); ?>
                <a href="javascript:;" data-url="<?php echo $item->product_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product_<?php echo $item->product_id ?> sesproduct_like_sesproduct_product <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>">
                  <i class="fa fa-thumbs-up"></i>
                  <span><?php echo $item->like_count; ?></span>
                </a>
                
              <?php endif;?>
              <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)): ?>
              <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$item->product_id)); ?>
                <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product_<?php echo $item->product_id ?> sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>" data-url="<?php echo $item->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
            <?php endif;?>
            </div>
          <?php endif;?>
			<div class="sesproduct_desc_stats sesbasic_text_light">
				<?php if(isset($this->likeCountActive) && isset($item->favourite_count)): ?>
					<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
				<?php endif;?>
				
				<?php if(isset($this->favouriteCountActive) && isset($item->favourite_count)): ?>
					<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count; ?></span>
				<?php endif; ?>
				
				<?php if(isset($this->commentCountActive) && isset($item->favourite_count)): ?>
					<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count; ?></span>
				<?php endif; ?>
				
				<?php if(isset($this->viewCountActive) && isset($item->favourite_count)): ?>
					<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
				<?php endif; ?>
              </div>
              </div>
            </div>
          </td>
        <?php } ?>
        </tr>
		<?php if(isset($this->categoryActive)): ?>
        <tr>
          <td class="_title"><?php echo $this->translate('Category'); ?></td>
         <?php foreach($this->products as $product){ ?>
          <td>
            <?php if(!empty($product->category_id)) { ?>
                <?php  $category = Engine_Api::_()->getItem('sesproduct_category', $product->category_id);?>
                    <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a>
            <?php } else { ?> --
            <?php } ?> 
          </td>
        <?php } ?>
        </tr>
		<?php endif; ?>
		<?php if(isset($this->brandActive)): ?>
         <tr>
          <td class="_title"><?php echo $this->translate('Brand'); ?></td>
         <?php foreach($this->products as $product){ ?>
         <td>
            <?php if(!empty($product->brand))
                {?>
                <?php echo $product->brand; ?>
            <?php } else { ?> -
            <?php } ?> 
        </td>
        <?php } ?>
        </tr>
		<?php endif; ?>
        <?php if(isset($this->storeNameActive)) { ?>
        <tr>
          <td class="_title"><?php echo $this->translate('Store'); ?></td>
            <?php foreach($this->products as $product){ ?>
             <td>
                <?php if(!empty($product->store_id)) { ?>
                    <?php  $store = Engine_Api::_()->getItem('stores', $product->store_id);
                 if($store){ ?>
                 <a href="<?php echo $store->getHref(); ?>"><?php echo $store->getTitle(); ?></a>
                <?php
                 }
                 } else { ?> --
                <?php } ?> 
             </td>
            <?php } ?>
        </tr>
        <?php } ?>
		<?php  ?>
        <?php foreach($this->profile_fileds as $key=>$fields){ ?>
          <tr>
            <?php if($fields["type"] == "heading"){ ?>
              <td colspan="<?php echo count($this->products) + 1; ?>" class="full_specifications"><?php echo $fields["label"] ?></td>
            <?php }else{ ?>
              <td class="_title"><?php echo $fields["label"]; ?></td>
              <?php foreach($this->products as $pro){ ?>
                <?php if(isset($this->productCustomFields[$pro['product_id']][$key])){ ?>
                <td><?php echo $this->productCustomFields[$pro['product_id']][$key]; ?></td>
                <?php }else{ ?>
                  <td>-</td>
                <?php } ?>
              <?php } ?>
            <?php } ?>
          </tr>
        <?php } ?>
            
      </tbody>
    </table>
  </div>
</div>
<script typeof="application/javascript">
  sesJqueryObject(document).on('click','.sesproduct_remove_conpare',function (e) {
    var parentElem = sesJqueryObject(this).closest('td');
    var index = parentElem.index();
    sesJqueryObject('.sesproduct_compare_cnt > tr').each(function(){
       if(sesJqueryObject(this).find('.full_specifications').length){
           sesJqueryObject(this).find('.full_specifications').attr('colspan',sesJqueryObject(this).find('.full_specifications').attr('colspan') - 1)
       }else {
           sesJqueryObject(this).children().eq(index).remove();
       }
    });
      sesJqueryObject.post('sesproduct/index/compare-product/type/remove',{category_id:<?php echo $this->category_id; ?>,product_id:sesJqueryObject(this).parent().attr('data-rel')},function (res) {
      });
  })
</script>
