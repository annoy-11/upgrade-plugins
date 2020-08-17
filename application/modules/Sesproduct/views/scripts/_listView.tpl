<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<!--List View-->

<li class="sesproduct_list_product_view sesbasic_clearfix sesbasic_bxs">
  <div class="sesproduct_list_thumb sesproduct_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;width:<?php echo is_numeric($this->width_list) ? $this->width_list.'px' : $this->width_list ?>;">
  <?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
      <?php if(Engine_Api::_()->sesproduct()->saleRunning($item,$this->viewer()->getIdentity()) && $this->show_sale && $settings->getSetting('sesproduct.enable.sale', 1)){ ?>
      <div class="sesproduct_sale">
        <p class="sale_label"><?php echo $this->translate("Sale"); ?></p>
      </div>
      <?php } ?>
    <?php $href = $item->getHref();$imageURL = $photoPath;?>
    	<a href="<?php echo $href; ?>" data-url="<?php echo $item->getType() ?>" class="sesproduct_thumb_img">
				<span style="background-image:url(<?php echo $imageURL; ?>);"></span>
			</a>
    <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)):?>
    	<div class="sesproduct_labels ">
      	<?php  if(isset($this->featuredLabelActive) && $item->featured == 1):?>
      		<span class="sesproduct_label_featured"><?php echo $this->translate('Featured');?></span>
      	<?php endif;?>
        <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
        	<span class="sesproduct_label_sponsored"><?php echo $this->translate('Sponsored');?></span>
        <?php endif;?>
    	</div>
    <?php endif;?>
    <?php if(isset($this->quickViewActive)) { ?>
        <div class="sesproduct_quick_view">
            <a href="javascript:;" data-url="<?php echo "sesproduct/index/quick-view/product_id/". $itemProduct->product_id; ?>" class="quick_vbtn sessmoothbox">Quick View</a>
        </div>
     <?php } ?>
    <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)): ?>
    	<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
    		<div class="sesproduct_img_thumb_over"> <a href="<?php echo $href; ?>" data-url="<?php echo $item->getType() ?>"></a>
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
      	<?php  if(isset($this->quickViewActive)): ?>
      	<div class="sesproduct_quick_view">
          <a href="javascript:;" data-url="<?php echo "sesproduct/index/quick-view/product_id/". $item->product_id; ?>" class="quick_vbtn sessmoothbox"><?php echo $this->translate("Quick View"); ?></a>
        </div>
     	<?php endif;?>
    </div>
    <?php endif;?>
  </div>
  <div class="sesproduct_list_info">
    <div class="sesbasic_clearfix clear">
       <?php if(isset($this->priceActive)){  ?>
        <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
      <?php } ?>
      <?php if(isset($this->stockActive)){ ?>
        <?php  include APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'; ?>
      <?php } ?>
      <?php if(isset($this->titleActive)): ?>
      <div class="sesproduct_list_info_title floatL">
        <?php if(strlen($item->getTitle()) > $this->title_truncation_list):?>
        <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_list).'...';?>
        <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
        <?php else: ?>
        <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
        <?php endif;?>
        <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
            <div class="sesproduct_verify">
            <i class="sesproduct_label_verified sesbasic_verified_icon" title="Verified"></i>
            </div>
        <?php endif; ?>
      </div>
      <?php endif;?>
    </div>
    <?php if(isset($this->ratingActive)){ ?>
        <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_rating.tpl';?> 
    <?php } ?>
    <div class="sesbasic_clearfix clear">
      <div class="sesproduct_admin_stat">
        <?php if(isset($this->storeNameActive)){ ?>
        <?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
          <?php if(count($store)) { ?>
           <div class="sesproduct_product_stat sesbasic_text_light">
                  <span><i class="fas fa-store"></i><a href="<?php echo $store->getHref(); ?>"><?php echo $store->getTitle(); ?></a></span>
          </div>
        <?php } ?>
        <?php } ?>
        <?php if(isset($this->creationDateActive)){ ?>
        <div class="sesproduct_product_stat sesbasic_text_light"> <span><i class="far fa-calendar"></i>
          <?php if($item->publish_date): ?>
          <?php echo date('M d, Y',strtotime($item->publish_date));?>
          <?php else: ?>
          <?php echo date('M d, Y',strtotime($item->creation_date));?>
          <?php endif; ?>
          </span>
				</div>
        <?php } ?>
        <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1)){ ?>
        	<div class="sesproduct_product_stat sesbasic_text_light">
						<span> <i class="fa fa-map-marker-alt"></i><?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a><?php } else { ?><?php echo $item->location;?><?php } ?> </span>
					</div>
        <?php } ?>
         <div class="sesproduct_listview_category">
        <?php if(isset($this->categoryActive)){ ?>
        <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
        <?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
        <?php if($categoryItem):?>
          <div class="sesproduct_product_stat sesbasic_text_light">
            <span> <i class="far fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a> </span>
          </div>
        <?php endif;?>
        <?php endif;?>
        <?php } ?>
      </div>
      </div>
    </div>
    <?php if(isset($this->descriptionActive)){ ?>
    <div class="sesproduct_listing_item_des">
      <?php echo $this->string()->truncate($this->string()->stripTags($item->body), $this->description_truncation_list) ?>
    </div>
    <?php } ?>
    <div class="sesproduct_list_footer">
    <div class="sesproduct_add_cart sesbasic_clearfix">
      <div class="cart_only_text">
       <?php if(isset($this->addCartActive)){ ?>
          <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item)); ?>
      <?php } ?>
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1) && isset($this->addWishlistActive)): ?>
          <a href="javascript:;" class="sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>" title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="far fa-bookmark"></i><?php echo $this->translate('Add to Wishlist'); ?></a>
        <?php endif; ?>
      </div>
    </div>
  <?php if(isset($this->addCompareActive)){ ?>
      <div class="sesproduct_product_compare sesbasic_clearfix">
          <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
      </div>
  <?php } ?>
  </div>
    <?php if(isset($this->my_products) && $this->my_products){ ?>
    <div class="sesproduct_options_buttons sesproduct_list_options sesbasic_clearfix">
      <?php if($this->can_edit){ ?>
      <a href="<?php echo $this->url(array('action' => 'edit', 'product_id' => $item->product_id), 'sesproduct_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Edit Product'); ?>"> <i class="fa fa-pencil-alt"></i> </a>
      <?php } ?>
      <?php if ($this->can_delete){ ?>
      <a href="<?php echo $this->url(array('action' => 'delete', 'product_id' => $item->product_id), 'sesproduct_specific', true); ?>" class="sesbasic_icon_btn" title="<?php echo $this->translate('Delete Product'); ?>" onclick='opensmoothboxurl(this.href);return false;'> <i class="far fa-trash-alt"></i> </a>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</li>
