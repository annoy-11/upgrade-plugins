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

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity;?>
<?php endif;?>

<?php if(!$this->is_ajax):?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber;?>" class="sesbasic_bxs"> 
		<div id="category-product-widget_<?php echo $randonNumber; ?>" class="sesbasic_clearfix">
<?php endif;?>
  <?php foreach( $this->paginatorCategory as $item): ?>
  	<div class="sesproduct_category_product sesbasic_clearfix">
      <div class="sesproduct_category_header sesbasic_clearfix">
        <p class="floatL"><a href="<?php echo $item->getBrowseProductHref(); ?>?category_id=<?php echo $item->category_id ?>" title="<?php echo $this->translate($item->category_name); ?>"><?php echo $this->translate($item->category_name); ?></a></p>
				<?php if(isset($this->seemore_text) && $this->seemore_text != ''): ?>
					<span <?php echo $this->allignment_seeall == 'right' ?  'class="floatR"' : ''; ?>><a class="buttonlink" href="<?php echo $item->getBrowseProductHref(); ?>?category_id=<?php echo $item->category_id ?>"><?php $seemoreTranslate = $this->translate($this->seemore_text); ?>
					<?php echo str_replace('[category_name]',$this->translate($item->category_name),$seemoreTranslate); ?></a></span>
				<?php endif;?>
      </div>
			<div class="sesproduct_grid sesbasic_bxs <?php if((isset($this->my_products) && $this->my_products)){ ?>isoptions<?php } ?>" style="width:<?php echo is_numeric($this->width_grid) ? $this->width_grid.'px' : $this->width_grid ?>;">
			  <article>
			    <div class="sesproduct_thumb">
			      <?php // if(Engine_Api::_()->sesproduct()->saleRunning($item,$this->viewer()->getIdentity()) && $this->show_sale){ ?>
			     <!-- <div class="sesproduct_sale">
			        <p class="sale_label"><?php //echo $this->translate("Sale"); ?></p>
			      </div>-->
			      <?php  //} ?>
			      <div class="sesproduct_grid_thumb" style="height:<?php echo is_numeric($this->height_grid) ? $this->height_grid.'px' : $this->height_grid ?>;">
			        <?php $href = $item->getHref();$imageURL = $photoPath;?>
			        	<a href="<?php echo $href; ?>" data-url="<?php echo $item->getType() ?>" class="sesproduct_thumb_img"> 
			            <span style="background-image:url(<?php echo $imageURL; ?>);"></span> 
			          </a>
			        <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)):?>
			          <div class="sesproduct_labels">
			            <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
			            <span class="sesproduct_label_featured"> <i class="fa fa-star"></i> </span>
			            <?php endif;?>
			            <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
			            <span class="sesproduct_label_sponsored"> <i class="fa fa-star"></i> </span>
			            <?php endif;?>
			          </div>
			        <?php endif;?>
			        <?php if(isset($this->categoryActive)){ ?>
			        	<?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
			        	<?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
			        	<?php if($categoryItem):?>
			            <div class="sesproduct_grid_memta_title">
			              <?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
			              <?php if($categoryItem):?>
			              <span><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></span>
			              <?php endif;?>
			            </div>
			        	<?php endif;?>
			        <?php endif;?>
			        <?php } ?>
			        <div class="sesproduct_img_thumb_over"> 
			  				<a href="<?php echo $href; ?>" data-url="<?php echo $item->getType() ?>"></a>
			          <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) ||             isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
			          <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
			          <div class="sesproduct_list_grid_thumb_btns">
			            <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
			            <?php if($this->socialshare_icon_limit): ?>
			            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
			            <?php else: ?>
			            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_gridview1plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_gridview1limit)); ?>
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
			            <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product_<?php echo $item->product_id ?> sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>" data-url="<?php echo $item->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
			            <?php endif;?>
			            <?php endif;?>
			          </div>
			          <?php endif;?>
			          <div class="sesproduct_quick_view">
			            <a href="javascript:;" data-url="<?php echo "sesproduct/index/quick-view/product_id/". $item->product_id; ?>" class="quick_vbtn sessmoothbox">Quick View</a>
			          </div>
			        </div>
			      </div>
			      <div class="sesproduct_grid_info sesbasic_clearfix sesbm">
			        <?php if(Engine_Api::_()->getApi('core', 'sesproduct')->allowReviewRating() && isset($this->ratingStarActive)):?>
			        <?php echo $this->partial('_productRating.tpl', 'sesproduct', array('rating' => $item->rating, 'class' => 'sesproduct_list_rating sesproduct_list_view_ratting floatR', 'style' => ''));?>
			        <?php endif;?>
			        <?php if(isset($this->productTitleActive) ){ ?>
			        <div class="sesproduct_grid_heading">
			          <div class="sesproduct_grid_info_title">
			            <?php if(strlen($item->getTitle()) > $this->title_truncation_grid):?>
			            <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_grid).'...';?>
			            <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()) ) ?>
			            <?php else: ?>
			            <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
			            <?php endif; ?>
			            <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
			            <div class="sesproduct_verify">
			              <i class="sesproduct_label_verified sesbasic_verified_icon" title="Verified"></i>
			            </div>
			            <?php endif;?>
			          </div>
			        </div>
			        <?php } ?>
			        <div class="sesproduct_grid_meta_block">
			          <?php if(isset($this->storeNameActive)){ ?>
			          <div class="sesproduct_product_stat sesbasic_text_light"> <span>
			            <?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
			            <div class="sesproduct_store_name">
			                <div class="store_logo">
			                    <img src="<?php echo $store->getPhotoUrl(); ?>"/>
			                </div>
			                <div class="store_name">
			                    <span><?php echo $store->title; ?></span>
			                </div>
			            </div> 
			          </div>
			          <?php } ?>
			          <?php if(isset($this->creationDateActive)): ?>
			          <div class="sesproduct_product_stat sesbasic_text_light"> <span><i class="fa fa-calendar"></i>
			            <?php if($item->publish_date): ?>
			            <?php echo date('M d, Y',strtotime($item->publish_date));?>
			            <?php else: ?>
			            <?php echo date('M d, Y',strtotime($item->creation_date));?>
			            <?php endif; ?>
			            </span> 
			  				</div>
			          <?php endif;?>
			            <?php if(isset($this->brandActive)): ?>
                    <div class="sesproduct_product_brand sesbasic_text_light">
                        <span> <i class="fa fa-cube" title=""></i><?php echo $item->brand ?></span>
                    </div>
			          <?php endif; ?>
			          <?php if(isset($this->stockActive)){ ?>
                    <?php  include(APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'); ?>
                 <?php } ?>
			          <?php if(isset($this->categoryActive)){ ?>
			          <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):?>
			          <?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);?>
			          <?php if($categoryItem):?>
			          <div class="sesproduct_product_stat sesbasic_text_light"> 
			            <span> <i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> 
			              <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
			            </span> 
			          </div>
			          <?php endif;?>
			          <?php endif;?>
			          <?php } ?>
			          <?php if(isset($this->locationActive) && isset($item->location) && $item->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1)){ ?>
			          <div class="sesproduct_product_stat sesbasic_text_light"> 
			            <span> <i class="fa fa-map-marker"></i> 
			              <a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a>
			            </span> 
			          </div>
			          <?php } ?>
			        </div>
			        <div class="sesproduct_listing_item_des">
			          <?php if(isset($this->productDescActive)){ ?>
			          <p class="sesproduct_product_description"> <?php echo $this->string()->truncate($this->string()->stripTags($item->body), $this->description_truncation_list) ?> </p>
			          <?php } ?>
			        </div>
			        <div class="sesbasic_clearfix sesbasic_bxs clear">
                <?php if(isset($this->priceActive)){ ?>
                    <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
			          <?php } ?>
			          <?php if(isset($this->ratingActive)){ ?>
                    <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_productRatingStat.tpl';?>
			           <?php } ?>
			        </div>
			        <?php if(isset($this->offerActive)){ ?>
			        <!-- <div class="sesproduct_product_offers sesbasic_clearfix"> <span class="offer">Offer</span> <span>No Cost EMI</span> </div> -->
			        <?php } ?>
			        <div class="sesproduct_align_width">
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
                    <?php if(isset($this->addCartActive)){ ?>
                        <?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item,'icon'=>true)); ?>
                    <?php } ?>
			              <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1) && isset($this->addWishlistActive)): ?>
			              <a href="javascript:;" class="add-cart sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>"  title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="fa fa-plus"></i></a>
			              <?php endif; ?>  
			            </div>
			          </div>
			           <?php if(isset($this->addCompareActive)){ ?>
                    <div class="sesproduct_product_compare sesbasic_clearfix">
                        <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
                    </div>
                <?php } ?>
			        </div>
			      </div>
			    </div>
			  </article>
			</div>

		</div>
  <?php endforeach;?>
	<?php if($this->paginatorCategory->getTotalItemCount() == 0 && !$this->is_ajax):?>
		<div class="tip">
			<span>
				<?php echo $this->translate('Nobody has created an product yet.');?>
				<?php if ($this->can_create):?>
					<?php echo $this->translate('Be the first to %1$screate%2$s one!', '<a href="'.$this->url(array('action' => 'create','module'=>'sesproduct'), "sesproduct_general",true).'">', '</a>'); ?>
				<?php endif; ?>
			</span>
		</div>
	<?php endif; ?> 
	<?php if($this->loadOptionData == 'pagging'): ?>
		<?php echo $this->paginationControl($this->paginatorCategory, null, array("_pagging.tpl", "sesproduct"),array('identityWidget'=>$randonNumber)); ?>
	<?php endif; ?>
<?php if(!$this->is_ajax){ ?>
		</div>
	</div>
	<?php if($this->loadOptionData != 'pagging') { ?>
		<div class="sesbasic_view_more" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore')); ?> </div>
		<div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
	<?php  } ?>
<?php } ?>

<script type="text/javascript">
	<?php if($this->loadOptionData == 'auto_load'){ ?>
		window.addEvent('load', function() {
			sesJqueryObject(window).scroll( function() {
				var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
				var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
				if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
					document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
				}
			});
		});
	<?php } ?>
	viewMoreHide_<?php echo $randonNumber; ?>();
	function viewMoreHide_<?php echo $randonNumber; ?>() {
		if ($('view_more_<?php echo $randonNumber; ?>'))
		$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginatorCategory->count() == 0 ? 'none' : ($this->paginatorCategory->count() == $this->paginatorCategory->getCurrentPageNumber() ? 'none' : '' )) ?>";
	}
	function viewMore_<?php echo $randonNumber; ?> (){
		document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
		document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
		en4.core.request.send(new Request.HTML({
			method: 'post',
			'url': en4.core.baseUrl + "widget/index/mod/sesproduct/name/<?php echo $this->widgetName; ?>",
			'data': {
			format: 'html',
			page: <?php echo $this->page + 1; ?>,    
			params :'<?php echo json_encode($this->params); ?>', 
			is_ajax : 1,
			identity : '<?php echo $randonNumber; ?>',
			},
			onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				document.getElementById('category-product-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('category-product-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
        jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({
          theme:"minimal-dark"
          });
        
			}
		}));
		return false;
	}
	<?php if(!$this->is_ajax){ ?>
		function paggingNumber<?php echo $randonNumber; ?>(pageNum){
			sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
			en4.core.request.send(new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/sesproduct/name/<?php echo $this->widgetName; ?>",
				'data': {
					format: 'html',
					page: pageNum,    
					params :'<?php echo json_encode($this->params); ?>', 
					is_ajax : 1,
					identity : '<?php echo $randonNumber; ?>',
					type:'<?php echo $this->view_type; ?>'
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
					document.getElementById('category-product-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
          jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({
          theme:"minimal-dark"
          });
					dynamicWidth();
				}
			}));
			return false;
		}
	<?php } ?>
</script>
