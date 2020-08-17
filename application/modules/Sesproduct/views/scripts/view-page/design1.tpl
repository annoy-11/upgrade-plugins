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

<?php  $item = $this->item; ?>
<div class="sesproduct_information_view1 sesbasic_clearfix sesbasic_bxs">
<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
 <?php  if(Engine_Api::_()->sesproduct()->saleRunning($item,$this->viewer()->getIdentity()) && $this->show_sale && $settings->getSetting('sesproduct.enable.sale', 1)){ ?>
  <div class="sesproduct_sale">
    <p class="sale_label"><?php echo $this->translate("Sale"); ?></p>
  </div>
<?php  } ?>
  <div class="sesproduct_information_leftcolumn">
     <?php if(count($this->paginator)){ ?>
        <?php foreach($this->paginator as $paginator){ ?>
        <?php $file = Engine_Api::_()->getItem('storage_file',$paginator->file_id);
            if($file){
                if($paginator->type == 1){
                    preg_match('/src="([^"]+)"/', $paginator->code, $match);
                    $url = $match[1];
                } ?>
                <?php if($paginator->type == 1){ ?>
                    <div id="V1Img1<?php echo $paginator->file_id; ?>" class="video tabcontent">
                        <?php echo $paginator->code; ?>
                    </div>
                <?php } else { ?> 
                    <div id="V1Img1<?php echo $paginator->file_id; ?>" class="item tabcontent">
                        <img src="<?php echo $file->map(); ?>"/>
                    </div>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <div class="vertical_blk">
            <?php foreach($this->paginator as $paginator){ ?>
                <?php $file = Engine_Api::_()->getItem('storage_file',$paginator->file_id);
                if($file){
                if($paginator->type == 1){
                    preg_match('/src="([^"]+)"/', $paginator->code, $match);
                    $url = $match[1];
                } ?>
                    <a class="tablinks" onclick="openCity(event, 'V1Img1<?php echo $paginator->file_id; ?>')" id="defaultOpen">
                        <img src="<?php echo $file->map(); ?>"/>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
       <?php } else { ?>
        <div class="sesproduct_default_img">
          <img src="./application/modules/Sesproduct/externals/images/nophoto_product_thumb_profile.png"/>
        </div>
       <?php } ?>
       
      <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel) || isset($this->verifiedLabel) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
      <div class="sesproduct_labels">
        <?php if(isset($this->featuredLabelActive) && $item->featured == 1): ?>
        <span class="sesproduct_label_featured" title = "Featured Label"> <i class="fa fa-star" ></i> </span>
        <?php endif;?>
        <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
        <span class="sesproduct_label_sponsored" title = "Sponsored Label"> <i class="fa fa-star"></i> </span>
        <?php endif;?>
      </div>
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
      <?php endif;?> 
    </div>
      <div class="sesproduct_information_right_column">
        <div class="sesproduct_information_infotitle">
          <h3><?php echo $item->getTitle(); ?></h3>
          <div class="sesproduct_verify">
            <i class="sesproduct_label_verified sesbasic_verified_icon" title="Verified"></i>
          </div>
        </div>
          <div class="sesproduct_information_innerL"> 
            <div class="sesproduct_admin_stat">
              <div class="sesproduct_product_stat sesbasic_text_light">
              <?php if(isset($this->storeNamePhotoActive)){ ?>
                <?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
                    <div class="sesproduct_store_name">
                        <div class="store_logo">
                            <img src="<?php echo $store->getPhotoUrl('thumb.icon'); ?>"/>
                        </div>
                        <div class="store_name">
                            <a href="<?php echo $store->getHref(); ?>"><span><?php echo $store->title; ?></span></a>
                        </div>
                    </div> 
                <?php } ?>
              </div>              
              <?php if(isset($this->creationDateActive)){ ?>
              <div class="sesproduct_product_stat sesbasic_text_light"> <span><i class="fa fa-calendar"></i>
                <?php if($item->publish_date): ?>
                    <?php echo date('M d, Y',strtotime($item->publish_date));?>
                <?php else: ?>
                    <?php echo date('M d, Y',strtotime($item->creation_date));?>
                <?php endif; ?>
                </span>&nbsp;|
              </div>
              <?php } ?>    
               <?php if(isset($this->stockActive)){ ?>
                <?php  include APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'; ?>
              <?php } ?>
              <?php if($item->brand != '' && isset($this->brandAction)){ ?>
                <div class="sesproduct_product_brand sesbasic_text_light">
                    <span> <i class="fa fa-cube" title=""></i><?php echo $item->brand ?></span>&nbsp;|
                </div>  
              <?php } ?>
                <?php if(isset($this->categoryActive)){ ?>
                    <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
                    <?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
                    <?php if($categoryItem):?>
                        <div class="sesproduct_product_stat sesbasic_text_light">
                        <span> <i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a> </span>&nbsp;|
                        </div>
                    <?php endif;?>
                    <?php endif;?>
                <?php } ?>
              <?php if($this->settings->getSetting('sesproduct.enable.location', 1) && isset($this->locationActive)){ ?>
                <div class="sesproduct_product_stat sesbasic_text_light">
                  <span> <i class="fa fa-map-marker"></i> <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a><?php } else { ?><?php echo $item->location;?><?php } ?> </span>
                </div>
              <?php } ?>
            </div>
            <div class="sesbasic_clearfic">
               <?php if(isset($this->ratingActive)){ ?>
                  <div class="sesproduct_rating_review">
                      <?php include APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_rating.tpl"; ?>
                  </div>
              <?php } ?>
              <?php $identity = Engine_Api::_()->sesproduct()->getIdentityWidget('sesproduct.product-reviews','widget','sesproduct_index_view_1');
               ?>
              <?php if($identity): ?>
                  <div class="sesproduct_writeReview sesbasic_clearfix sesbasic_bxs">
                      <a class="sesbasic_button sesproduct_product_review_btn" data-id="<?php echo $identity; ?>" href="javascript:;"><i class="fa fa-pencil"></i> <?php echo $this->translate("Write a Review"); ?></a>
                  </div>  
              <?php endif; ?>
            <script type="application/javascript">
                sesJqueryObject(document).on('click','.sesproduct_product_review_btn',function (e) {
                    var id = sesJqueryObject(this).data('id');
                   if(sesJqueryObject('.tab_'+id).length){
                       sesJqueryObject('.tab_'+id).not('.generic_layout_container').find('a').trigger('click');
                       sesJqueryObject('html, body').animate({
                           scrollTop: sesJqueryObject('.tab_'+id).not('.generic_layout_container').offset().top
                       }, 2000);
                   }else{

                       sesJqueryObject('html, body').animate({
                           scrollTop: sesJqueryObject('.layout_sesproduct_product_reviews').offset().top
                       }, 2000);
                   }
                });
            </script>
            </div>
            <div class="sesproduct_information_desc">
              <p>
                <?php echo $item->body; ?>
              </p>
              <?php if($item->discount) { ?>
                <?php if($this->settings->getSetting('sesproduct.start.date', 1) && isset($item->discount_start_date)) { ?>
                    <div>
                        <span class="_Dstart"><b><?php echo $this->translate("Discount Start Date :"); ?></b> <?php echo date('M d, Y',strtotime($item->discount_start_date)); ?></span>
                    </div>
                <?php } ?>
                <?php if($this->settings->getSetting('sesproduct.end.date', 1)  && isset($item->discount_end_date) && $item->discount_end_type != 0) { ?>
                    <div>
                        <span class="_Dend"><b><?php echo $this->translate("Discount End Date :"); ?></b> <?php echo date('M d, Y',strtotime($item->discount_end_date)); ?></span>
                    </div>
                <?php } ?>
            <?php } ?>
            </div> 
             <?php if($this->settings->getSetting('sesproduct.backinstock', 1)): ?>
                <!-- <div class="sesproduct_pre_notify">
                    <input type="email" name="notify_gmail" placeholder="Enter Email">
                    <a href="javascript:;" class="btn_notify" onclick = "notifyMe(this)" data-product-id='<?php //echo $item->product_id; ?>'>Notify Me</a>
                </div>  -->
             <?php endif; ?>
          </div> 
          <div class="sesproduct_information_innerR"> 
            <?php if(isset($this->priceActive)){ ?>
                <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?> 
            <?php } ?>
            <div class="sesproduct_add_cart sesbasic_clearfix">
              <div class="cart_only_text">
               <?php if(isset($this->addCartActive)){
               
								echo $this->form;
								
                } ?>
                <?php if($this->settings->getSetting('sesproduct.enable.wishlist', 1) && isset($this->addWishlistActive)): ?>
                  <a href="javascript:;" data-rel="<?php echo $item->getIdentity(); ?>" class="sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>" title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="fa fa-bookmark-o"></i></a>
                <?php endif; ?>
              </div>
            </div>
            <div class="sesproduct_static_list_group">
              <div class="sesproduct_desc_stats sesbasic_text_light">
                <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
                <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count; ?></span>
                <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count; ?></span>
                <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
              </div>
            </div>
             <?php if(isset($this->addCompareActive)){ ?>
                <div class="sesproduct_product_compare sesbasic_clearfix">
                    <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
                </div>
             <?php } ?>
           <!-- <div class="sesproduct_quantity sesbasic_clearfix sesbasic_bxs">
              <h4>Quantity</h4>
              <input type="number" name="" value="1">
            </div> -->
        </div>
        <div class="sesproduct_information_conditions">
          <span class="payment_method"><?php echo $this->translate("Payment Accepted By"); ?></span>
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
            <div class="sesbasic_clearfix sesbasic_bxs">
              <span><i class="fa fa-hand-o-right"></i><?php echo $item->purchase_note; ?></span>
            </div>
          <?php } ?>
        </div>
    </div>
</div>
