<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: quick-view.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $item = $this->product; ?>
<div class="sesproduct_quickview sesbasic_clearfix sesbasic_bxs">
  <div class="sesproduct_quickview_inner">
    <div class="sesproduct_quickview_left">
      <div class="tab_right">
        <div class="main_img sesproduct_image_quick_view">
            <div class="sesproduct_sale">
                <p class="sale_label">
                <?php echo $this->translate("Sale"); ?>
                </p>
            </div>
          <div class="quickviewoverlay"></div>
            <img onload="zoomImageSesproduct();" src="<?php echo $this->absoluteUrl($this->product->getPhotoUrl('thumb.normal')); ?>" id="sesproduct_preview_image"  alt="" class="img-responsive"/>
            <iframe id="sesproduct_preview_video" style="display: none;" src="" style="border: 0; top: 0; left: 0; width: 100%; height: 100%; position: absolute;" allowfullscreen scrolling="no"></iframe>
        </div>
      </div>
      <script type="application/javascript">
      function changeImageSesproduct(obj) {
        sesJqueryObject('.quickviewoverlay').html('');
        sesJqueryObject('.sesproduct_zoom_cnt').remove();
        if (sesJqueryObject(obj).hasClass('sesproduct_video_view')) {
            sesJqueryObject('#sesproduct_preview_video').show();
            sesJqueryObject('#sesproduct_preview_video').attr('src', sesJqueryObject(obj).data('url'));
            sesJqueryObject('#sesproduct_preview_image').hide();
            sesJqueryObject('.quickviewoverlay').hide();
        } else {
            sesJqueryObject('.quickviewoverlay').show();
            sesJqueryObject('#sesproduct_preview_video').attr('src', '');
            sesJqueryObject('#sesproduct_preview_video').hide();
            sesJqueryObject('#sesproduct_preview_image').show();
            sesJqueryObject('#sesproduct_preview_image').attr('src', sesJqueryObject(obj).find('img').attr('src'));
        }
      }
      </script>
      <?php if(count($this->paginator)){ ?>
      <div class="tab_left sesproduct_left_pnl">
        <div class="small_imgtab">
          <a href="javascript:;" onclick="changeImageSesproduct(this);">
            <img src="<?php echo $this->product->getPhotoUrl('thumb.normal'); ?>" class="img-responsive"/>
          </a>
          <?php foreach($this->paginator as $paginator){ ?>
          <?php $file = Engine_Api::_()->getItem('storage_file',$paginator->file_id);
            if($file){
            if($paginator->type == 1){
                preg_match('/src="([^"]+)"/', $paginator->code, $match);
                $url = $match[1];
            }
          ?>
          <a href="javascript:;" onclick="changeImageSesproduct(this);" <?php if($paginator->type == 0){ ?>  <?php }else{ ?> class="sesproduct_video_view" data-url="<?php echo $url; ?>" <?php } ?>>
            <img src="<?php echo $file->map(); ?>" class="img-responsive"/>
          </a>
          <?php } ?>
          <?php } ?>
        </div>
      </div>
      <?php } ?>
    </div>
    <div class="sesproduct_quickview_right">
      <div class="sesproduct_quickview_info">
        <div class="sesbasic_clearfix sesbasic_bxs">
          <div class="sesproduct_quickview_title floatL">
            <a href="<?php echo $this->product->getHref(); ?>"><?php echo $this->product->getTitle(); ?></a>
              <i class="sesproduct_label_verified sesbasic_verified_icon" title="Verified"></i>
          </div>
        </div>
        <div class="sesproduct_admin_stat sesbasic_clearfix sesbasic_bxs">
          <div class="sesproduct_product_stat sesbasic_text_light">
            <?php //$store = Engine_Api::_()->getItem('stores',$this->product->store_id); ?>
            <?php if($this->product->store_id){ ?>
            <?php $store = Engine_Api::_()->getItem('stores',$this->product->store_id); ?>
                <div class="sesproduct_store_name">
                    <div class="store_logo">
                        <img src="<?php echo $store->getPhotoUrl(); ?>"/>
                    </div>
                    <div class="store_name">
                        <a href="<?php echo $store->getHref(); ?>"><span><?php echo $store->getTitle(); ?></span></a>
                    </div>
                </div> 
            <?php } ?>
          </div>
          <?php $this->product = $this->product;
           include(APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'); ?>
          <?php if($this->product->category_id){
              $catgeory = Engine_Api::_()->getItem("sesproduct_category",$this->product->category_id);
          ?>
          <div class="sesproduct_product_stat sesbasic_text_light">
            <span>
              <i class="far fa-folder-open" title="<?php echo $catgeory->getTitle(); ?>"></i>
              <a href="<?php echo $catgeory->getHref(); ?>"><?php echo $catgeory->getTitle(); ?></a>
            </span>
          </div>
          <?php } ?>
          <?php if($this->product->location){ ?>
          <div class="sesproduct_product_stat sesbasic_text_light">
            <span title="<?php echo $this->product->location; ?>"> <i class="fa fa-map-marker-alt"></i>
              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $this->product->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $this->product->location;?>"><?php echo $this->product->location;?></a><?php } else { ?><?php echo $this->product->location;?><?php } ?>
            </span>
          </div>
          <?php } ?>
        </div>
            <div class="sesproduct_product_description">
                <p><?php echo $this->product->getDescription(); ?></p>
            </div>
            <div class="sesproduct_quick_middle">
              <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_rating.tpl';?>
              <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
            </div>
        <div class="sesproduct_add_cart sesbasic_clearfix">
          <div class="cart_only_text">
           <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$this->product)); ?>
            <a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $this->product->getIdentity(); ?>" title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="far fa-bookmark"></i><?php echo $this->translate('Add to Wishlist'); ?></a>
          </div>
        </div>
        <div class="sesproduct_product_compare sesbasic_clearfix">
          <?php $item = $this->product; ?>
          <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
        </div>
      </div>
    </div>
  </div>
</div>
