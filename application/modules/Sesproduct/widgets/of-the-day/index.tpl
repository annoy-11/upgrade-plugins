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
    <?php if($this->type == 'grid1'):?>
    <div class="sesproduct_product_of_the_day">
        <ul class="sesproduct_products_listing sesbasic_bxs">
            <?php $limit = 0;?>
            <?php $itemProduct = $item = Engine_Api::_()->getItem('sesproduct',$this->product_id);?>
            <?php if($itemProduct):?>
            <li class="sesproduct_grid sesproduct_list_grid_thumb sesproduct_list_grid" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
                <div class="sesproduct_grid_inner sesproduct_thumb">
                    <div class="sesproduct_grid_thumb sesproduct_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> <a class="sesproduct_thumb_img" href="<?php echo $itemProduct->getHref(); ?>"> <span class="main_image_container" style="background-image: url(<?php echo $itemProduct->getPhotoUrl('thumb.normal'); ?>);"></span> </a>
                        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabelActive)){ ?>
                        <div class="sesproduct_labels">
                            <?php if(isset($this->featuredLabelActive) && $itemProduct->featured == 1){ ?>
                            	<span class="sesproduct_label_featured" title='<?php echo $this->translate("Featured");?>'> <?php echo $this->translate("Featured");?></span>
                            <?php } ?>
                            <?php if(isset($this->sponsoredLabelActive)  && $itemProduct->sponsored == 1){ ?>
                            	<span class="sesproduct_label_sponsored" title='<?php echo $this->translate("Sponsored");?>'> <?php echo $this->translate("Sponsored");?></span>
                            <?php } ?>
                        </div>
                        <?php } ?>
                      <div class="sesproduct_img_thumb_over"><a href="<?php echo $itemProduct->getHref(); ?>"></a>
                        <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
                        <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemProduct->getHref()); ?>
                          <div class="sesproduct_list_grid_thumb_btns">
                              <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
                              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemProduct, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                              <?php endif;?>
                              <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                              <?php $canComment =  $itemProduct->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                              <?php if(isset($this->likeButtonActive) && $canComment):?>
                              <!--Like Button-->
                              <?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatus($itemProduct->product_id,$itemProduct->getType()); ?>
                              <a href="javascript:;" data-url="<?php echo $itemProduct->product_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product_<?php echo $itemProduct->product_id ?> sesproduct_like_sesproduct_product <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemProduct->like_count; ?></span></a>
                              <?php endif;?>
                              <?php if(isset($this->favouriteButtonActive) && isset($itemProduct->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)): ?>
                              <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$itemProduct->product_id)); ?>
                              <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product_<?php echo $itemProduct->product_id ?> sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>" data-url="<?php echo $itemProduct->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemProduct->favourite_count; ?></span></a>
                              <?php endif;?>
                              <?php endif;?>
                          </div>
                        <?php endif;?>
                         <?php if(isset($this->quickViewActive)) { ?>
                            <div class="sesproduct_quick_view">
                                <a href="javascript:;" data-url="<?php echo "sesproduct/index/quick-view/product_id/". $itemProduct->product_id; ?>" class="quick_vbtn sessmoothbox">Quick View</a>
                            </div>
                        <?php } ?>
                      </div>
                    </div>

                    <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive)){ ?>
                    <div class="sesproduct_grid_info sesbasic_clearfix sesbm">
                        <?php if(isset($this->titleActive)) { ?>
                        <div class="sesproduct_grid_info_title">
                            <?php echo $this->htmlLink($itemProduct, $this->string()->truncate($itemProduct->getTitle(), $this->title_truncation),array('title'=>$itemProduct->getTitle())) ; ?> 
                            <?php if(isset($this->verifiedLabelActive) && $itemProduct->verified == 1):?>
                            <div class="sesproduct_verify">
                              <i class="sesproduct_label_verified sesbasic_verified_icon" title="Verified"></i>
                            </div>
                            <?php endif;?>
                        </div>
                        <?php } ?>
                        <?php if(isset($this->ratingActive)) { ?>
                            <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_rating.tpl';?>
                        <?php } ?>
                        <div class="sesproduct_list_grid_info sesbasic_clearfix">
                        	<?php if(isset($this->storeNameActive)) { ?>
                            	<div class="sesproduct_product_stat  sesbasic_text_light">
	                                <?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
                                  <span><i class="fa fa-store"></i><?php echo $store->title; ?></span>
                              </div>
                            <?php }?>
                            <?php  $item = $itemProduct; ?>
                            <div class="sesproduct_product_stat sesbasic_text_light"> <span> <i class="fa fa-map-marker-alt"></i><?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $itemProduct->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $itemProduct->location;?>"><?php echo $itemProduct->location;?></a><?php } else { ?><?php echo $itemProduct->location;?><?php } ?></span> </div>
                            
                        </div>
                        <?php if(isset($this->productDescActive)) { ?>
                            <div class="sesproduct_listing_item_des">
                                <?php echo $this->string()->truncate($this->string()->stripTags($itemProduct->body), $this->description_truncation) ?>
                            </div>
                    	 <?php } ?>
                    	 <?php if(isset($this->priceActive)) { ?>
                            <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
                        <?php } ?>
                        <div class="sesproduct_add_cart sesbasic_clearfix">
                          <div class="cart_only_text hidden">
                            <?php if(isset($this->addCartActive)) { ?>
                                <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item)); ?>
                            <?php }?>
                            <?php if(isset($this->addWishlistActive)) { ?>
                                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1)): ?>
                                    <a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><?php echo $this->translate('Add to Wishlist'); ?></a>
                                <?php endif; ?>
                            <?php } ?>
                           </div>
                            <div class="cart_only_icon">
                            <?php if(isset($this->addCartActive)) { ?>
                                <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item,'icon'=>true)); ?>
                            <?php } ?>
                            <?php if(isset($this->addWishlistActive)) { ?>
                                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1)): ?>
                                    <a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="far fa-bookmark"></i></a>
                                <?php endif; ?>  
                             <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </li>
            <?php endif;?>
            <?php $limit++;?>
        </ul>
    </div>
    <?php elseif($this->type == 'grid2'):?>
    <div class="sesproduct_product_second_of_the_day">
        <ul class="sesproduct_products_listing sesbasic_bxs">
            <?php $limit = 0;?>
            <?php $itemProduct = $item =  Engine_Api::_()->getItem('sesproduct',$this->product_id);?>
            <?php if($itemProduct):?>
            <li class="sesproduct_grid sesproduct_list_grid_thumb sesproduct_list_grid sesa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sesa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
                <div class="sesproduct_grid_inner sesproduct_thumb">
                    <div class="sesproduct_grid_thumb sesproduct_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"> <a class="sesproduct_thumb_img" href="<?php echo $itemProduct->getHref(); ?>"> <span class="main_image_container" style="background-image: url(<?php echo $itemProduct->getPhotoUrl('thumb.main'); ?>);"></span> </a>
                        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
                        <div class="sesproduct_labels">
                            <?php if(isset($this->featuredLabelActive) && $itemProduct->featured == 1){ ?>
                            <p class="sesproduct_label_featured">
                                <?php echo $this->translate("Featured"); ?>
                            </p>
                            <?php } ?>
                            <?php if(isset($this->sponsored)  && $itemProduct->sponsoredLabelActive == 1){ ?>
                            <p class="sesproduct_label_sponsored">
                                <?php echo $this->translate("Sponsored"); ?>
                            </p>
                            <?php } ?>
                        </div>
                        <?php if(isset($this->verifiedLabelActive) && $itemProduct->verified == 1):?>
                        <div class="sesproduct_verified_label" title="<?php echo $this->translate('Verified');?>"><i class="fa fa-check"></i></div>
                        <?php endif;?>
                        <?php } ?>
                    </div>
                    <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
                    <div class="sesproduct_grid_info clear sesbasic_clearfix sesbm">
                        <?php if(isset($this->titleActive)) { ?>
                        <div class="sesproduct_category_grid_info_title">
                            <?php echo $this->htmlLink($itemProduct, $this->string()->truncate($itemProduct->getTitle(), $this->title_truncation),array('title'=>$itemProduct->getTitle())) ; ?> </div>
                        <?php } ?>
                        <div class="sesproduct_list_grid_info sesbasic_clearfix">
                            <div class="sesproduct_product_stat">
                                <?php if(isset($this->byActive)) { ?>
                                <span class="sesproduct_list_grid_owner"> <a href="<?php echo $itemProduct->getOwner()->getHref();?>">
                                <?php echo $this->itemPhoto($itemProduct->getOwner(), 'thumb.icon');?></a> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemProduct->getOwner()->getHref(), $itemProduct->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> </span>
                                <?php }?>
                            </div>
                            <div class="sesproduct_product_stat sesproduct_list_location sesbasic_text_light"> <span> <i class="fa fa-map-marker"></i> <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $itemProduct->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $itemProduct->location;?>"><?php echo $itemProduct->location;?></a><?php } else { ?><?php echo $itemProduct->location;?><?php } ?> </span> </div>
                        </div>
                        <?php } ?>
                        <div class="sesproduct_product_stat sesbasic_text_light">
                            <?php if(isset($this->likeActive)) { ?>
                            <span class="sesproduct_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $itemProduct->like_count), $this->locale()->toNumber($itemProduct->like_count))?>"> <i class="fa fa-thumbs-up"></i> <?php echo $itemProduct->like_count;?> </span>
                            <?php } ?>
                            <?php if(isset($this->commentActive)) { ?>
                            <span class="sesproduct_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $itemProduct->comment_count), $this->locale()->toNumber($itemProduct->comment_count))?>"> <i class="fa fa-comment"></i> <?php echo $itemProduct->comment_count;?> </span>
                            <?php } ?>
                            <?php if(isset($this->viewActive)) { ?>
                            <span class="sesproduct_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $itemProduct->view_count), $this->locale()->toNumber($itemProduct->view_count))?>"> <i class="fa fa-eye"></i> <?php echo $itemProduct->view_count;?> </span>
                            <?php } ?>
                            <?php if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)) { ?>
                            <span class="sesproduct_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $itemProduct->favourite_count), $this->locale()->toNumber($itemProduct->favourite_count))?>"> <i class="fa fa-heart"></i> <?php echo $itemProduct->favourite_count;?> </span>
                            <?php } ?>
                            <?php if(Engine_Api::_()->sesbasic()->getViewerPrivacy('sesproductreview', 'view') && isset($this->ratingActive) && isset($itemProduct->rating)): ?>
                            <span title="<?php echo $this->translate(array('%s rating', '%s ratings', round($itemProduct->rating,1)), $this->locale()->toNumber(round($itemProduct->rating,1)))?>"><i class="fa fa-star"></i><?php echo round($itemProduct->rating,1).'/5';?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="sesproduct_img_thumb_over">
                        <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
                        <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemProduct->getHref()); ?>
                        <div class="sesproduct_list_grid_thumb_btns">
                            <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
                            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemProduct, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                            <?php endif;?>
                            <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                            <?php $canComment =  $itemProduct->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                            <?php if(isset($this->likeButtonActive) && $canComment):?>
                            <!--Like Button-->
                            <?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatus($itemProduct->product_id,$itemProduct->getType()); ?>
                            <a href="javascript:;" data-url="<?php echo $itemProduct->product_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product_<?php echo $itemProduct->product_id ?> sesproduct_like_sesproduct_product <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemProduct->like_count; ?></span></a>
                            <?php endif;?>
                            <?php if(isset($this->favouriteButtonActive) && isset($itemProduct->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)): ?>
                            <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$itemProduct->product_id)); ?>
                            <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product_<?php echo $itemProduct->product_id ?> sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>" data-url="<?php echo $itemProduct->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemProduct->favourite_count; ?></span></a>
                            <?php endif;?>
                            <?php endif;?>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </li>
            <?php endif;?>
            <?php $limit++;
		?>
        </ul>
    </div>
    <?php elseif($this->type == 'grid3'):?>
    <div class="sesproduct_product_three_of_the_day">
        <?php $limit = 0;?>
        <?php $itemProduct = $item =Engine_Api::_()->getItem('sesproduct',$this->product_id);?>
        <?php if($itemProduct):?>
        <div class="sesproduct_last_grid_block sesbasic_bxs " style="width:140px;">
            <div class="sesproduct_grid_inner">
                <div class="sesproduct_grid_thumb sesproduct_thumb" style="height:160px;">
                    <a class="sesproduct_thumb_img" href="<?php echo $itemProduct->getHref(); ?>">
                        <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->titleActive) || isset($this->favouriteActive) || isset($this->byActive)){ ?>
                        <span class="main_image_container" style="background-image: url(<?php echo $itemProduct->getPhotoUrl('thumb.main'); ?>);"></span> </a>
                    <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
                    <div class="sesproduct_labels">
                        <?php if(isset($this->featuredLabelActive) && $itemProduct->featured == 1){ ?>
                        <p class="sesproduct_label_featured">
                          <?php echo $this->translate("Featured"); ?>
                        </p>
                        <?php } ?>
                        <?php if(isset($this->sponsoredLabelActive)  && $itemProduct->sponsored == 1){ ?>
                        <p class="sesproduct_label_sponsored">
                            <?php echo $this->translate("Sponsored"); ?>
                        </p>
                        <?php } ?>
                    </div>
                    <?php } ?>
										<div class="sesproduct_grid_three_info_title">
											<a href="#" class=""><?php echo $this->translate("eCraftIndia White Dial Wooden 35.56 cm Handcrafted Analogue Wall Clock"); ?></a>
                    	<?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
                      <div class="sesproduct_verify">
                        <div class="sesproduct_verified_label" title="<?php echo $this->translate('Verified');?>"><i class="fa fa-check"></i></div>
                      </div>
                      <?php endif;?>
										</div>									
                    <div class="sesproduct_grid_thumb_over">
                        <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
                        <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $itemProduct->getHref()); ?>
                        <div class="sesproduct_list_grid_thumb_btns">
                            <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
                            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $itemProduct, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                            <?php endif;?>
                            <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                            <?php $canComment =  $itemProduct->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                            <?php if(isset($this->likeButtonActive) && $canComment):?>
                            <!--Like Button-->
                            <?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatus($itemProduct->product_id,$itemProduct->getType()); ?>
                            <a href="javascript:;" data-url="<?php echo $itemProduct->product_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product_<?php echo $itemProduct->product_id ?> sesproduct_like_sesproduct_product <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $itemProduct->like_count; ?></span></a>
                            <?php endif;?>
                            <?php if(isset($this->favouriteButtonActive) && isset($itemProduct->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)): ?>
                            <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$itemProduct->product_id)); ?>
                            <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product_<?php echo $itemProduct->product_id ?> sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>" data-url="<?php echo $itemProduct->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $itemProduct->favourite_count; ?></span></a>
                            <?php endif;?>
                            <?php endif;?>
                        </div>
                        <?php endif;?>
                       <?php  if(isset($this->quickViewActive)) { ?>
                            <div class="sesproduct_quick_view">
                                <a href="javascript:;" data-url="<?php echo "sesproduct/index/quick-view/product_id/". $itemProduct->product_id; ?>" class="quick_vbtn sessmoothbox"><?php echo $this->translate("Quick View"); ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="sesproduct_grid_info clear clearfix sesbm">
                    <div class="sesproduct_grid_meta_block">
                        <div class="sesproduct_product_stat sesbasic_text_light">
                          <?php if(isset($this->byActive)) { ?>
                            <span class="sesproduct_list_grid_owner"> 
															<a href="<?php $itemProduct->getOwner()->getHref();?>"><?php echo $this->itemPhoto($itemProduct->getOwner(), 'thumb.icon');?>
															</a> <?php echo $this->translate('By');?> <?php echo $this->htmlLink($itemProduct->getOwner()->getHref(), $itemProduct->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?> 
														</span><?php }?> | 
												</div>
                        <?php $item = $itemProduct;
                        if(isset($this->stockActive)) {
                         include(APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'); 
                         } 
                        ?>
												<div class="sesproduct_product_stat sesbasic_text_light">
													<span><i class="fa fa-map-marker"></i>&nbsp;
														<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $itemProduct->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $itemProduct->location;?>"><?php echo $itemProduct->location;?></a><?php } else { ?><?php echo $itemProduct->location;?><?php } ?>
													</span>
												</div>                      
                    </div>
                     <?php if(isset($this->ratingStarActive)) { ?>
                        <div class="sesproduct_grid_aligned">
                            <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_productRatingStat.tpl';?>				
                        </div>
                    <?php } ?>
                    <div class="sesproduct_listing_item_des">
                        <?php echo $this->string()->truncate($this->string()->stripTags($itemProduct->body), $this->description_truncation) ?>
                    </div>
                    <?php if(isset($this->priceActive)) { ?>
                        <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
                    <?php } ?> |
                    <?php if(isset($this->offerActive)) { ?>
                        <div class="sesproduct_product_offers sesbasic_clearfix"> <span class="offer"><?php echo $this->translate('Offer');?></span> <span><?php echo $this->translate('No Cost EMI');?></span> </div>	
                    <?php } ?> |
                    <div class="sesproduct_add_cart sesbasic_clearfix">
                    <div class="cart_only_text">
                    <?php if(isset($this->addCartActive)) { ?>
                        <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$itemProduct)); ?>
                    <?php } ?>
                        <?php if(isset($this->addWishlistActive)) { ?>
                            <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1)): ?>
                                <a href="javascript:;" class=" sesproduct_wishlist" data-rel="<?php echo $itemProduct->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="fa fa-plus"></i></a>
                            <?php endif; ?>
                        <?php } ?> |
                    </div>
                  </div>
                  <div class="sesproduct_product_compare sesbasic_clearfix">
                      <?php $item = $itemProduct; ?>
                      <?php if(isset($this->addCompareActive)) { ?>
                        <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
                      <?php } ?>
                  </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php endif;?>
        <?php $limit++;
   ?>
    </div>
    <?php endif;?>
