<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design1.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/owl.carousel.min.css'); ?>
<?php 
  $baseURL = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesproduct/externals/scripts/jquery.js');
  $this->headScript()->appendFile($baseURL . 'application/modules/Sesproduct/externals/scripts/owl.carousel.js'); 
  $item = $this->item;
?>

<div class="sesproduct_information_view1 sesbasic_clearfix sesbasic_bxs">
  <?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
  <div class="sesproduct_information_leftcolumn">
    <?php if(count($this->paginator) || $item->getPhotoUrl() != ''){ ?>
    <?php  if(Engine_Api::_()->sesproduct()->saleRunning($item,$this->viewer()->getIdentity()) && $this->show_sale && $settings->getSetting('sesproduct.enable.sale', 1)){ ?>
    <div class="sesproduct_sale">
      <p class="sale_label"><?php echo $this->translate("Sale"); ?></p>
    </div>
    <?php } ?>
    <div class="sesproduct_information">
      <?php if($item->getPhotoUrl() != ''){ ?>
      <div class="_img" id="userselected-image"> <img  src="<?php echo $item->getPhotoUrl(); ?>"/> </div>
      <?php } ?>
    </div>
    <?php if(count($this->paginator) > 0){ ?>
    <div class="_horizontaltabs owl-carousel owl-theme">
      <?php if($item->getPhotoUrl() != ''){ ?>
      <div class="item"><span><a href="javascript:;" onclick="showSelectedImage(this)"><img src="<?php echo $item->getPhotoUrl(); ?>"/></a></span></div>
      <?php } ?>
      <?php foreach($this->paginator as $paginator){ ?>
      <?php $file = Engine_Api::_()->getItem('storage_file',$paginator->file_id);
                  if($file){
                  if($paginator->type == 1){
                      preg_match('/src="([^"]+)"/', $paginator->code, $match);
                      $url = $match[1];
                  }
              ?>
      <?php if($paginator->type == 1){ ?>
      <div class="item"> <span><a href="javascript:;" onclick="showSelectedImage(this)" data-video="1"><img src="<?php echo $file->map(); ?>"/>
        <p style="display: none;"><?php echo $paginator->code; ?></p>
        </a></span> </div>
      <?php } else { ?>
      <div class="item"> <span><a href="javascript:;" onclick="showSelectedImage(this)"><img src="<?php echo $file->map(); ?>"/></a></span> </div>
      <?php } ?>
      <?php } ?>
      <?php } ?>
    </div>
    <?php } ?>
    <?php } else { ?>
    <div class="sesproduct_default_img"> <img src="./application/modules/Sesproduct/externals/images/nophoto_product_thumb_profile.png"/> </div>
    <?php } ?>
  </div>
  <div class="sesproduct_information_right_column">
    <div class="sesproduct_information_header">
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)):?>
      <div class="sesproduct_labels">
        <?php if(isset($this->featuredLabelActive) && $item->featured == 1): ?>
        <span class="sesproduct_label_featured" title = "Featured Label"><?php echo $this->translate('Featured');?></span>
        <?php endif;?>
        <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
        <span class="sesproduct_label_sponsored" title = "Sponsored Label"><?php echo $this->translate('Sponsored');?></span>
        <?php endif;?>
      </div>
      <?php endif;?>
      <div class="sesproduct_profile_options"> <a href="javascript:;" class="sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a>
        <div class="sesbasic_pulldown_options"> <?php echo $this->content()->renderWidget("sesproduct.gutter-menu")?> </div>
      </div>
    </div>
    <?php if(isset($this->categoryActive)){ ?>
    <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
    <?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
    <?php if($categoryItem):?>
    <div class="sesproduct_category sesproduct_product_stat sesbasic_text_light"> <span><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a> </div>
    <?php endif;?>
    <?php endif;?>
    <?php } ?>
    <?php if(isset($this->ratingActive)){ ?>
    <div class="sesproduct_rating_review">
      <?php include APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_rating.tpl"; ?>
    </div>
    <?php } ?>
    <div class="sesproduct_information_infotitle">
      <h3><?php echo $item->getTitle(); ?></h3>
      <?php if(isset($this->verifiedLabelActive) && $item->verified == 1): ?>
      <div class="sesproduct_verify"> <i class="sesproduct_label_verified sesbasic_verified_icon" title="Verified"></i> </div>
      <?php endif; ?>
    </div>
    <div class="sesproduct_information_innerL">
      <div class="sesproduct_admin_stat">
        <div class="sesproduct_product_stat sesbasic_text_light">
          <?php if(isset($this->storeNamePhotoActive)){ ?>
          <?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
          <div class="sesproduct_store_name">
            <div class="store_name"> <a href="<?php echo $store->getHref(); ?>"><span class="sesbasic_text_light">Store:</span><span><?php echo $store->title; ?></span></a> </div>
          </div>
          <?php } ?>
        </div>
        <?php if(isset($this->stockActive)){ ?>
        <?php  include APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'; ?>
        <?php } ?>
        <div class="sesproduct_view_middle">
          <?php if(isset($this->priceActive)){ ?>
          <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
          <?php } ?>
          <div class="sesproduct_add_cart sesbasic_clearfix">
            <div class="cart_only_text">
              <?php if(isset($this->addCartActive)){
               
								echo $this->form;
								
                } ?>
              <?php if($this->settings->getSetting('sesproduct.enable.wishlist', 1) && isset($this->addWishlistActive)): ?>
              <a href="javascript:;" data-rel="<?php echo $item->getIdentity(); ?>" class="sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>" title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="far fa-bookmark"></i>Add to Wishlist</a>
              <?php endif; ?>
            </div>
            <?php if(isset($this->addCompareActive)){ ?>
            <div class="sesproduct_product_compare sesbasic_clearfix">
              <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="sesproduct_information_desc">
        <?php if($item->sku != '' && isset($this->skuActive)){ ?>
        <div> <span><b><?php echo $this->translate("SKU:"); ?></b><?php echo $item->sku; ?></span> </div>
        <?php } ?>
        <?php if(isset($this->tagsActive)){ ?>
        <div> <span><b><?php echo $this->translate("Tags:"); ?></b><?php echo $item->getKeywords(); ?></span> </div>
        <?php } ?>
        <?php if($item->brand != '' && isset($this->brandActive)){ ?>
        <div> <span><b><?php echo $this->translate("Brand:"); ?></b><?php echo $item->brand ?></span> </div>
        <?php } ?>
        <?php if($this->settings->getSetting('sesproduct.enable.location', 1) && isset($this->locationActive)){ ?>
        <div> <span><b><?php echo $this->translate("Location:"); ?></b>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
          <a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a>
          <?php } else { ?>
          <?php echo $item->location;?>
          <?php } ?>
          </span> </div>
        <?php } ?>
        <?php if(isset($this->dateActive)){ ?>
        <div> <span><b><?php echo $this->translate("Creation Date:"); ?></b>
          <?php if($item->publish_date): ?>
          <?php echo date('M d, Y',strtotime($item->publish_date));?>
          <?php else: ?>
          <?php echo date('M d, Y',strtotime($item->creation_date));?>
          <?php endif; ?>
          </span> </div>
        <?php } ?>
        <?php if($item->discount) { ?>
        <?php if($this->settings->getSetting('sesproduct.start.date', 1) && isset($item->discount_start_date)) { ?>
        <div> <span class="_Dstart"><b><?php echo $this->translate("Discount Start Date :"); ?></b><?php echo date('M d, Y',strtotime($item->discount_start_date)); ?></span> </div>
        <?php } ?>
        <?php if($this->settings->getSetting('sesproduct.end.date', 1)  && isset($item->discount_end_date) && $item->discount_end_type != 0) { ?>
        <div> <span class="_Dend"><b><?php echo $this->translate("Discount End Date :"); ?></b><?php echo date('M d, Y',strtotime($item->discount_end_date)); ?></span> </div>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
    <div class="sesproduct_static_list_group">
      <div class="sesproduct_desc_stats sesbasic_text_light"> <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><?php echo $item->like_count; ?> Likes</span> <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><?php echo $item->comment_count; ?> Comments</span> <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><?php echo $item->favourite_count; ?> Favourites</span> <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><?php echo $item->view_count; ?> Views</span> </div>
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
      <div class="sesproduct_share_btns">
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
        <a href="javascript:;" data-url="<?php echo $item->product_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product_<?php echo $item->product_id ?> sesproduct_like_sesproduct_product <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i> <span><?php echo $item->like_count; ?></span> </a>
        <?php endif;?>
        <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)): ?>
        <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$item->product_id)); ?>
        <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product_<?php echo $item->product_id ?> sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>" data-url="<?php echo $item->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
        <?php endif;?>
        <?php endif;?>
      </div>
      <?php endif;?>
    </div>
    <div class="sesproduct_information_conditions"> <span class="payment_method"><?php echo $this->translate("Payment Accepted By"); ?></span>
      <?php if(in_array('paypal',$this->paymentMethods)){ ?>
      <label for="payment_type_paypal"><img src="./application/modules/Sesproduct/externals/images/paypal.png"/></label>
      <?php } ?>
      <?php if(in_array('stripe',$this->paymentMethods)){ ?>
      <label for="payment_type_stripe"><img src="./application/modules/Sesproduct/externals/images/stripe.png"/></label>
      <?php } ?>
      <?php if(in_array(0,$this->paymentMethods) && isset($settings->getSetting('estore.payment.siteadmin', array())['0'])){ ?>
      <label for="payment_type_check"><img src="./application/modules/Sesproduct/externals/images/cash.png"/></label>
      <?php } ?>
      <?php if(in_array(1,$this->paymentMethods) && isset($settings->getSetting('estore.payment.siteadmin', array())['1'])){ ?>
      <label for="payment_type_check"><img src="./application/modules/Sesproduct/externals/images/cheque.png"/></label>
      <?php } ?>
      <?php if($this->settings->getSetting('sesproduct.purchasenote', 1) && $item->purchase_note) { ?>
      <div class="sesbasic_clearfix sesbasic_bxs"> <span><i class="far fa-hand-point-right"></i><?php echo $item->purchase_note; ?></span> </div>
      <?php } ?>
    </div>
  </div>
</div>
<script type="text/javascript">
sesproductJqueryObject('._horizontaltabs').owlCarousel({
  nav: true,
  autoplay:true,
  loop:false,
  items:6,
  smartSpeed :900,
  navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
  responsiveClass:true,
});
function showSelectedImage(obj){
  if(sesproductJqueryObject(obj).attr("data-video")){
    sesproductJqueryObject("#userselected-image").html(sesproductJqueryObject(obj).find("p").html());
  } else {
    sesproductJqueryObject("#userselected-image").html(sesproductJqueryObject(obj).html());
  }
}
sesproductJqueryObject(document.body).addClass('product-view-pageone');
</script>