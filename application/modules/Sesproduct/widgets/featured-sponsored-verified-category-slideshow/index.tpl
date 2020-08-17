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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/slideshow.css'); ?>
<div class="sesproduct_slideshow_product_wrapper sesbasic_clearfix sesbasic_bxs <?php if($this->navigation != 'nextprev'){ echo " isbulletnav " ; } echo $this->isfullwidth ? 'isfull_width' : '' ; ?>" style="height:<?php echo $this->height ?>px;">
	<div class="sesproduct_slideshow_product_container" style="height:<?php echo $this->height ?>px;">
  	<div class="sesproduct_product_slideshow">
    	<div class="sesproduct_slideshow_product" id="sesproduct_slideshow_<?php echo $this->identity; ?>">
      <ul class="bjqs">
        <?php foreach( $this->paginator as $item): ?>
        <li class="sesproduct_slideshow_inner_view sesbasic_clearfix " style="height:<?php echo $this->height ?>px;">
          <div class="sesproduct_slideshow_slides">
            <div class="sesproduct_slideshow_inside">
              <div class="sesproduct_slideshow_thumb sesproduct_thumb" style="height:<?php echo $this->height ?>px;">       
                <?php
                $href = $item->getHref();
                $imageURL = $item->getPhotoUrl('');
                ?>
                <div class="sesproduct_slideshow_thumb_img">
                  <?php if(Engine_Api::_()->sesproduct()->saleRunning($item,$this->viewer()->getIdentity())){ ?>
                  <div class="sesproduct_sale">
                    <p class="sale_label"><?php echo $this->translate("Sale"); ?></p>
                  </div>
                  <?php } ?>
                  <a href="<?php echo $href; ?>" class="slide_thumb">
                   <?php if(isset($this->brandActive)){ ?>
                    <span style="background-image:url(<?php echo $imageURL; ?>);"></span>
                    <?php } else {?>
                    <span style="background-image:url('');"></span>
                    <?php } ?>
                  </a>
                  <div class="sesproduct_list_grid_thumb_btns"> 
                    <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
                    
                    <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                    <?php endif;?>
                    <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                    <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                    <?php if(isset($this->likeButtonActive) && $canComment):?>                      
                      <?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatus($item->product_id,$item->getType()); ?>
                      <a href="javascript:;" data-url="<?php echo $item->product_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product_<?php echo $item->product_id ?> sesproduct_like_sesproduct_product <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
                    <?php endif;?>
                    <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)): ?>
                      <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$item->product_id)); ?>
                      <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesproduct_favourite_sesproduct_product_<?php echo $item->product_id ;?>  sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                    <?php endif;?>
                  <?php endif;?>
                </div>            
                <?php if(isset($this->titleActive) ){ ?>
                    <div class="sesproduct_quick_view">
                        <a href="javascript:;" data-url="<?php echo "sesproduct/index/quick-view/product_id/". $item->product_id; ?>" class="quick_vbtn sessmoothbox">Quick View</a>
                    </div>
                <?php } ?>
                <div class="sesproduct_labels">
                  <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
                    <span class="sesproduct_label_featured"> <i class="fa fa-star"></i> </span>
                  <?php endif;?>
                  <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
                    <span class="sesproduct_label_sponsored"> <i class="fa fa-star"></i> </span>
                  <?php endif;?>
                </div>
              </div>
            		<?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
                <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
              	<?php endif;?> 
              </div>
            </div>
            <div class="sesproduct_slideshow_inside_contant">
              <div class="sesproduct_slideshow_info sesbasic_clearfix ">
                <?php if(isset($this->titleActive) ){ ?>
                  <span class="sesproduct_slideshow_info_title">
                    <?php if(strlen($item->getTitle()) > $this->title_truncation){ 
                      $title = mb_substr($item->getTitle(),0,$this->title_truncation).'...';
                      echo $this->htmlLink($item->getHref(),$title) ?>
                    <?php }else{ ?>
                      <?php echo $this->htmlLink($item->getHref(),$item->getTitle() ) ?>
                    <?php } ?>
                    <?php // if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)):?>                
                      <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
                        <div class="sesproduct_verify">
                          <i class="sesproduct_label_verified sesbasic_verified_icon" title="Verified"></i>
                        </div>
                      <?php endif;?>
                  </span>
                <?php } ?>
            <div class="sesbasic_clearfix clear">
              <div class="sesproduct_admin_stat">
               <?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
               <?php if(isset($this->storeNamePhotoActive) && count($store)){ ?>
                    <div class="sesproduct_product_stat sesbasic_text_light">
                        <div class="sesproduct_store_name">
                            <div class="store_logo">
                                <img src="<?php echo $store->getPhotoUrl(); ?>"/>
                            </div>
                            <div class="store_name sesbasic_text_light">
                                <span><?php echo $store->title; ?></span>
                            </div>
                        </div> 
                    </div>
                    <?php } ?>
                
                <?php if(isset($this->creationDateActive)){ ?>
                <div class="sesproduct_product_stat sesbasic_text_light"> <span><i class="fa fa-calendar"></i>
                  <?php if($item->publish_date): ?>
                  <?php echo date('M d, Y',strtotime($item->publish_date));?>
                  <?php else: ?>
                  <?php echo date('M d, Y',strtotime($item->creation_date));?>
                  <?php endif; ?>
                  </span>
                </div>
                <?php } ?>
                 <?php if(isset($this->brandActive)){ ?>
                    <div class="sesproduct_product_brand sesbasic_text_light">
                        <span> <i class="fa fa-cube" title=""></i><?php echo $item->brand ?></span>
                    </div>
                 <?php } ?>
                 <?php if(isset($this->stockActive)){ ?>
                  <?php  include APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'; ?>
                <?php } ?>
                 <?php if(isset($this->categoryActive)){ ?>
                    <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
                    <?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
                        <?php if($categoryItem):?>
                            <div class="sesproduct_product_stat sesbasic_text_light">
                            <span> <i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a> </span>
                            </div>
                        <?php endif;?>
                    <?php endif;?>
                  <?php } ?>
              
                    <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1)){ ?>
                    <div class="sesproduct_product_stat sesbasic_text_light">
                        <span> <i class="fa fa-map-marker"></i> <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a><?php } else { ?><?php echo $item->location;?><?php } ?> </span>
                    </div>
                    <?php } ?>
              </div>
            </div>
    			 		<?php if(isset($this->ratingActive)){ ?>
              <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_rating.tpl';?>    
               <?php } ?>
            <?php if(isset($this->likeActive) || isset($this->favouriteActive) || isset($this->commentActive) || isset($this->viewActive)){ ?>
              <div class="sesproduct_static_list_group">
                <div class="sesproduct_desc_stats sesbasic_text_light">
                 <?php if(isset($this->likeActive)){ ?>
                    <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
                  <?php } ?>
                 <?php if(isset($this->commentActive)){ ?>
                    <span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>"><i class="fa fa-comment"></i><?php echo $item->comment_count; ?></span>
                  <?php } ?>
                   <?php if(isset($this->favouriteActive)){ ?>
                    <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count; ?></span>
                  <?php } ?>
                <?php if(isset($this->viewActive)){ ?>
                    <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa- eye"></i><?php echo $item->view_count; ?></span>
                  <?php } ?>
                </div>
              </div>   
             <?php } ?>
              <?php if(isset($this->priceActive)) { ?>
                <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
               <?php } ?>
                <?php if(isset($this->productDescActive)) { ?>
                    <div class="sesproduct_slideshow_des sesbasic_text_light">
                        <?php echo $this->string()->truncate($this->string()->stripTags($item->body), $this->description_truncation) ?>
                    </div>
                <?php } ?>
              <div class="sesproduct_add_cart sesbasic_clearfix">
                <div class="cart_only_text">
                 <?php if(isset($this->addCartActive)) { ?>
                    <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item)); ?>
                <?php } ?>
                <?php if(isset($this->addWishlistActive)) { ?>
                  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1)): ?>
                    <a href="javascript:;" class="sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>" title="<?php echo $this->translate('Add to Wishlist'); ?>"><?php echo $this->translate('Add to Wishlist'); ?></a>
                  <?php endif; ?>
                <?php } ?>
                </div>
              </div>
              <?php if(isset($this->addCompareActive)) { ?>
                <div class="sesproduct_product_compare sesbasic_clearfix">
                    <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </li>
        <?php endforeach; ?>
    </ul>
  </div>
  </div>
  </div>
</div>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/scripts/slideshow/bjqs-1.3.min.js');
?>
<script type="text/javascript">
  window.addEvent('domready', function () {
		<?php if($this->isfullwidth){ ?>
			var htmlElement = document.getElementsByTagName("body")[0];
			htmlElement.addClass('sesproduct_category_slideshow');
		<?php } ?>
		<?php if($this->autoplay){ ?>
			var autoplay_<?php echo $this->identity; ?> = true;
		<?php }else{ ?>
			var autoplay_<?php echo $this->identity; ?> = false;
		<?php } ?>
		<?php if($this->navigation == 'nextprev'){ ?>
			var navigation_<?php echo $this->identity; ?> = true;
			var markers_<?php echo $this->identity; ?> = false;
		<?php }else{ ?>
			var navigation_<?php echo $this->identity; ?> = false;
			markers_<?php echo $this->identity; ?> = true;
		<?php } ?>
		
			var	width = sesJqueryObject('#sesproduct_slideshow_<?php echo $this->identity; ?>').outerWidth();
			var	heigth = '<?php echo $this->height ?>';
			sesJqueryObject('#sesproduct_slideshow_<?php echo $this->identity; ?>').bjqs({
				responsive  : true,// enable responsive capabilities (beta)
				automatic: autoplay_<?php echo $this->identity; ?>,// automatic
				animspeed:<?php echo $this->speed; ?>,// the delay between each slide
				animtype:"<?php echo $this->type; ?>", // accepts 'fade' or 'slide'
				showmarkers:markers_<?php echo $this->identity; ?>,
				showcontrols: navigation_<?php echo $this->identity; ?>,/// center controls verically
				// if responsive is set to true, these values act as maximum dimensions
				width : width,
				height : heigth,
				slidecount: <?php echo count($this->paginator) ?>
			});
  });
// On before slide change
sesBasicAutoScroll('.productslide_<?php echo $this->identity; ?>').on('init', function(event, slick, currentSlide, nextSlide){
  sesBasicAutoScroll('#sesproduct_carousel_<?php echo $this->identity; ?>').show();
});
</script>
