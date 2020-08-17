<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showProductLitGrid.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php  if(!$this->is_ajax): ?>
  <style>
    .displayFN{display:none !important;}
  </style>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); ?> 
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?> 
	<?php if(isset($this->optionsEnable) && in_array('pinboard',$this->optionsEnable)):?>
		<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
		<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');?>
		<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');?>
	<?php endif;?>
  <?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
    <?php $randonNumber = $this->identityForWidget;?>
  <?php else:?>
    <?php $randonNumber = $this->identity; ?>
  <?php endif;?>

  <?php if($this->profile_products == true):?>
    <?php $moduleName = 'sesproduct';?>
  <?php else:?>
    <?php $moduleName = 'sesproduct';?>
  <?php endif;?>

  <?php $counter = 0;?>
  <?php  if(isset($this->defaultOptions) && count($this->defaultOptions) == 1): ?>
    <script type="application/javascript">
      sesJqueryObject('#tab-widget-sesproduct-<?php echo $randonNumber; ?>').parent().css('display','none');
      sesJqueryObject('.sesproduct_container_tabbed<?php echo $randonNumber; ?>').css('border','none');
    </script>
  <?php endif;?>
	<div class="sesbasic_view_type_<?php echo $randonNumber;?> sesbasic_clearfix clear" style="display:<?php echo $this->bothViewEnable ? 'block' : 'none'; ?>;height:<?php echo $this->bothViewEnable ? '' : '0px'; ?>">
<?php endif;?>
		<?php if($this->show_item_count){ ?>
			<div class="sesbasic_clearfix sesbm sesproduct_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_sesproduct' : 'paginator_count_ajax_sesproduct' ?>"><span id="total_item_count_sesproduct" style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("product found.") : $this->translate("products found."); ?></div>
		<?php } ?> 
<?php if(!$this->is_ajax){ ?>
		<div class="sesbasic_view_type_options sesbasic_view_type_options_<?php echo $randonNumber; ?>">
			<?php if(is_array($this->optionsEnable) && in_array('list',$this->optionsEnable)){ ?>
				<a href="javascript:;" rel="list" id="sesproduct_list_view_<?php echo $randonNumber; ?>" class="listicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'list') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('List View') : '' ; ?>"></a>
			<?php } ?>
			<?php if(is_array($this->optionsEnable) && in_array('grid',$this->optionsEnable)){ ?>
				<a href="javascript:;" rel="grid" id="sesproduct_grid_view_<?php echo $randonNumber; ?>" class="a-gridicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'grid') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Grid View') : '' ; ?>"></a>
			<?php } ?>
			<?php if(is_array($this->optionsEnable) && in_array('pinboard',$this->optionsEnable)){ ?>
				<a href="javascript:;" rel="pinboard" id="sesproduct_pinboard_view_<?php echo $randonNumber; ?>" class="boardicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'pinboard') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Pinboard View') : '' ; ?>"></a>
			<?php } ?>
			<?php if(is_array($this->optionsEnable) && in_array('map',$this->optionsEnable) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct_enable_location', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)){ ?>
				<a title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Map View') : '' ; ?>" id="sesproduct_map_view_<?php echo $randonNumber; ?>" class="mapicon map_selectView_<?php echo $randonNumber;?> selectView_<?php echo $randonNumber;?> <?php if($this->view_type == 'map') { echo 'active'; } ?>" rel="map" href="javascript:;"></a>
			<?php } ?>
		</div>
	</div>
<?php } ?>
<?php $locationArray = array();?>
<?php if(!$this->is_ajax){ ?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">
    <ul class="sesproduct_products_listing sesbasic_clearfix clear <?php if($this->view_type == 'pinboard'):?>sesbasic_pinboard_<?php echo $randonNumber;?><?php endif;?>" id="tabbed-widget_<?php echo $randonNumber; ?>" style="min-height:50px;">
<?php } ?>
<?php foreach($this->paginator as $item): ?>
  <?php $href = $item->getHref();?>
  <?php $photoPath = $item->getPhotoUrl();?>
  <?php if($this->view_type == 'grid'){ ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_gridView.tpl';?>
  <?php }else if($this->view_type == 'supergrid'){ ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_supergridView.tpl';?>
  <?php }else if($this->view_type == 'advgrid'){ ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_advgridView.tpl';?>
  <?php }else if($this->view_type == 'list'){ ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_listView.tpl';?>
  <?php }else if(isset($this->view_type) && $this->view_type == 'pinboard'){ ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_pinboardView.tpl';?>
  <?php } elseif($this->view_type == 'map') {
  		$product = $item;
  		$this->item = $item;
   ?>
  	
  	<?php $location = '';?>
	<?php if($product->lat): ?>
		<?php $labels = '';?>
		<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)):?>
			<?php $labels .= "<div class=\"sesproduct_labels\">";?>
			<?php if(isset($this->featuredLabelActive) && $product->featured == 1):?>
				<?php $labels .= "<span class=\"sesproduct_label_featured\"><i class=\"fa fa-star\" title=\"FEATURED\"></i></span>";?>
			<?php endif;?>
			<?php if(isset($this->sponsoredLabelActive) && $product->sponsored == 1):?>
				<?php $labels .= "<span class=\"sesproduct_label_sponsored\"><i class=\"fa fa-star\" title=\"SPONSORED\"></i></span>";?>
			<?php endif;?>
			<?php $labels .= "</div>";?>
		<?php endif;?>
		<?php $vlabel = '';?>
		<?php if(isset($this->verifiedLabelActive) && $product->verified == 1) :?>
			<?php $vlabel = "<div class=\"sesproduct_verify\" title=\"VERIFIED\"><i class=\"sesproduct_label_verified sesbasic_verified_icon\"></i></div>";?>
		<?php endif;?>
		<?php if(isset($this->locationActive) && $product->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.location', 1)):?>
			<?php $locationText = $this->translate('Location');?>
			<?php $locationvalue = $product->location;?>
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
			<?php $location = "<div class=\"sesproduct_list_stats sesproduct_list_location sesbasic_text_light\">
			<span class=\"widthfull\">
			<i class=\"fa fa-map-marker\" title=\"$locationText\"></i>
			<span title=\"$locationvalue\"><a href='".$this->url(array('resource_id' => $product->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true)."' class=\"opensmoothboxurl\">$locationvalue</a></span>
			</span>
			</div>";?>
    <?php } else { ?>
      <?php $location = "<div class=\"sesproduct_list_stats sesproduct_list_location sesbasic_text_light\">
			<span class=\"widthfull\">
			<i class=\"fa fa-map-marker\" title=\"$locationText\"></i>
			<span title=\"$locationvalue\">$locationvalue</span>
			</span>
			</div>";?>
    <?php } ?>
		<?php endif;?>
		<?php $likeButton = '';?>
		<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->likeButtonActive)):?>
		<?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($product->product_id,$product->getType());?>
			<?php $likeClass = ($LikeStatus) ? ' button_active' : '' ;?>
			<?php $likeButton = '<a href="javascript:;" data-url="'.$product->getIdentity().'" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product_'. $product->product_id.' sesproduct_like_sesproduct_product '.$likeClass .'"> <i class="fa fa-thumbs-up"></i><span>'.$product->like_count.'</span></a>';?>
		<?php endif;?>
		<?php $favouriteButton = '';?>
		<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($product->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)){
			$favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$product->product_id));
			$favClass = ($favStatus)  ? 'button_active' : '';
			$favouriteButton = '<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn  sesproduct_favourite_sesproduct_product_'. $product->product_id.' sesproduct_favourite_sesproduct_product '.$favClass .'" data-url="'.$product->getIdentity().'"><i class="fa fa-heart"></i><span>'.$product->favourite_count.'</span></a>';
		}?>
   
   <?php $ratings = ''; ?>
    <?php if(isset($this->ratingActive)){ ?>
    <?php $rating = Engine_Api::_()->getDbTable('Sesproductreviews','sesproduct')->getRating($item->getIdentity()); ?>
        <?php $ratings .= '<div class="sesproduct_rating_review sesbasic_clearfix sesbasic_bxs">
            <div class="sesproduct_ratings">
                <span title="'.$this->translate(array('%s rating', '%s ratings', round($rating,1)), $this->locale()->toNumber(round($rating,1))).'">'.round($rating,1).'&nbsp;<i class="fa fa-star"></i></span>
            </div>'; 
        ?>
    <?php
        $totalReviewCount = (int)Engine_Api::_()->getDbTable('sesproductreviews','sesproduct')->getReviewCount(array('product_id'=>$item->getIdentity()))[0]; ?>
        <?php $ratings .= '<div class="sesproduct_rating_info" style="display:none;"><div class="review_left"><h3>'. $rating.'<i class="fa fa-star"></i></h3><p>'.$this->translate(array('%s Rating <br/>& Review', '%s Ratings <br/>& Reviews', round($totalReviewCount,1)), $this->locale()->toNumber(round($totalReviewCount,1))).'</p>
            </div><div class="review_right"><div class="progress_bar">';
        ?>
        <?php $fiveStar = count(Engine_Api::_()->getDbTable('sesproductreviews','sesproduct')->getUserReviewCount(array('rating'=>5,'product_id'=>$item->getIdentity()))); ?>
        <?php $ratings .= '<span class="numbering_review">5<i class="fa fa-star"></i></span>
            <span class="bar_bg animate"><span style="width:'.(int)($fiveStar/$totalReviewCount)*100 .'%" class="bar_width" data-percent="'.(int)($fiveStar/$totalReviewCount)*100 .'"></span></span></div><div class="progress_bar">';
        ?>
            <?php $fourStar =  count(Engine_Api::_()->getDbTable('sesproductreviews','sesproduct')->getUserReviewCount(array('rating'=>4,'product_id'=>$item->getIdentity()))); ?>
        <?php $ratings .= '<span class="numbering_review">4<i class="fa fa-star"></i></span>
            <span class="bar_bg animate"><span style="width:'. (int)($fourStar/$totalReviewCount)*100 .'%" class="bar_width" data-percent="'.(int)($fourStar/$totalReviewCount)*100 .'"></span></span></div><div class="progress_bar">';
        ?>
            <?php $threeStar =  count(Engine_Api::_()->getDbTable('sesproductreviews','sesproduct')->getUserReviewCount(array('rating'=>3,'product_id'=>$item->getIdentity()))); ?>
        <?php $ratings .= '<span class="numbering_review">3<i class="fa fa-star"></i></span>
            <span class="bar_bg animate"><span style="width:'.(int)($threeStar/$totalReviewCount)*100 .'%" class="bar_width" data-percent="'.(int)($threeStar/$totalReviewCount)*100 .'"></span></span>
        </div>
        <div class="progress_bar">';
        ?>
        <?php $twoStar =  count(Engine_Api::_()->getDbTable('sesproductreviews','sesproduct')->getUserReviewCount(array('rating'=>2,'product_id'=>$item->getIdentity()))); ?>
        <?php $ratings .= '<span class="numbering_review">2<i class="fa fa-star"></i></span>
            <span class="bar_bg animate"><span style="width:'.(int)($twoStar/$totalReviewCount)*100 .'%" class="bar_width" data-percent="'.(int)($twoStar/$totalReviewCount)*100 .'"></span></span>
        </div>
        <div class="progress_bar">';
        ?>
            <?php $oneStar =  count(Engine_Api::_()->getDbTable('sesproductreviews','sesproduct')->getUserReviewCount(array('rating'=>1,'product_id'=>$item->getIdentity()))); ?>
        <?php $ratings .= '<span class="numbering_review">1<i class="fa fa-star"></i></span>
            <span class="bar_bg animate"><span style="width:'.(int)($oneStar/$totalReviewCount)*100 .'%" class="bar_width" data-percent="'.(int)($oneStar/$totalReviewCount)*100 .'"></span></span>
        </div>
        </div>
    </div>
    <div class="sesproductreview">
        <a href="javascript:void(0);"><span class="no_of_reviews">&#40;'.(int)$totalReviewCount.' &#41;</span></a>
    </div>
    </div>';
    ?>
    <?php } else { 
            $ratings = '';
    
    }  ?>


		
		<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $product->getHref());?>
		<?php $stats = $ratings.'<div class="sesproduct_static_list_group sesbasic_clearfix sesbasic_bxs"><div class="sesproduct_desc_stats sesbasic_text_light">';
        if(isset($this->commentActive)){
        $stats .= '<span title="'.$this->translate(array('%s comment', '%s comments', $product->comment_count), $this->locale()->toNumber($product->comment_count)).'"><i class="fa fa-comment"></i>'.$product->comment_count.'</span>';
        }
        if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)){
        $stats .= '<span title="'.$this->translate(array('%s favourite', '%s favourites', $product->favourite_count), $this->locale()->toNumber($product->favourite_count)).'"><i class="fa fa-heart"></i>'. $product->favourite_count.'</span>';
        }
        if(isset($this->viewActive)){
        $stats .= '<span title="'. $this->translate(array('%s view', '%s views', $product->view_count), $this->locale()->toNumber($product->view_count)).'"><i class="fa fa-eye"></i>'.$product->view_count.'</span>';
        }
        if(isset($this->likeActive)){
        $stats .= '<span title="'.$this->translate(array('%s like', '%s likes', $product->like_count), $this->locale()->toNumber($product->like_count)).'"><i class="fa fa-thumbs-up"></i>'.$product->like_count.'</span> ';
        }
		?> 
	  <?php $stats .= '</div></div>';?>		
		  <?php $stock = ''; ?>
		 <?php if(isset($this->stockActive)){ 
		 
        $stock .='<div class="sesproduct_availability';
        if(empty($lightStock)) {
            $stock .= 'sesbasic_text_light';
        } 
           $stock .=' ">';
        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.purchasenote', 1)) { 
            if((empty($item->manage_stock) || $item->stock_quatity)){ 
                $stock .=' <span class="in_stock">
                    <i class="fa fa-circle"></i>&nbsp;'.$this->translate("In Stock").'&nbsp;</span>';
            }else{ 
                $stock .='<span class="out_stock">
                <i class="fa fa-circle"></i>&nbsp;'.$this->translate("Out of Stock").'&nbsp;</span>';
            } 
        }
        $stock .= '</div>';

     }  ?>
     <?php $addCart = ''; ?>
     <?php if(isset($this->addCartActive)){
        $memberAllowed = Engine_Api::_()->sesproduct()->memberAllowedToBuy($this->item);
        $sellerAllowed = Engine_Api::_()->sesproduct()->memberAllowedToSell($this->item);

        if($memberAllowed && $sellerAllowed){
        $productLink = Engine_Api::_()->sesproduct()->productPurchaseable($this->item);
        if(!empty($productLink['status'])){
              $addCart .=  '<a href='.$productLink['href'].' data-action='.$this->item->product_id.' class="add-cart'.$productLink['class'].'" title="'.$this->translate('Add to Cart').'">';
            if(!empty($this->icon)){
                $addCart .= '<i class="fa fa-shopping-cart"></i>';
            }else{ 
                $addCart .= '<span class="fa fa-shopping-cart"></span>';
            } 
                $addCart .= '</a>';
            }else{ 
                $addCart .= '<div class="tip"><span>'. $this->translate("No Shipping method created in this store.").'</span></div>';

            }
        }
     } ?>
     <?php $addCompare = ''; ?>
    <?php if(isset($this->addCompareActive)){
        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enablecomparision',1)) {  
        $addCompare .='<label>';
        $existsCompare = Engine_Api::_()->sesproduct()->checkAddToCompare($item);
            $compareData = Engine_Api::_()->sesproduct()->compareData($item); 
            $addCompare .='<input type="checkbox" class="sesproduct_compare_change sesproduct_compare_product_'.$item->getIdentity().'" name="compare" ';
            if($existsCompare) { 
                $addCompare .= 'checked';
                }else {
                $addCompare .= '';
                }
        $addCompare .=' value="1" data-attr='. $compareData.' /><span class=""></span><span class="checkmark"></span></label>';
     }
    }?>
    <?php $addWishlist = ''; ?>
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1) && isset($this->addWishlistActive)):
        $addWishlist .= '<a href="javascript:;" data-rel="'. $item->getIdentity().'" class="sesproduct_wishlist" data-rel="'.$item->getIdentity().'" title="'.$this->translate('Add to Wishlist').'"><i class="fa fa-bookmark-o"></i></a>';
    endif; 
    ?>
    <?php $productPrice = ''; ?>
     <?php if(isset($this->priceActive)){ 
       $productPrice .='<div class="sesproduct_price">';
        if($item->discount && $priceDiscount = Engine_Api::_()->sesproduct()->productDiscountPrice($item)){
            $productPrice .='<span class="current_value">'.Engine_Api::_()->sesproduct()->getCurrencyPrice($priceDiscount).'</span>
                <span class="old_value">'.Engine_Api::_()->sesproduct()->getCurrencySymbol(Engine_Api::_()->sesproduct()->getCurrentCurrency()).'<strike>'.$item->price.'</strike></span>';
            if(isset($this->discountActive)){ 
                $productPrice .= '<span class="discount">';
                if($item->discount_type == 0){ 
                    $productPrice .= $this->translate("%s%s OFF",str_replace('.00','',$item->percentage_discount_value),"%");
                }else{ 
                    $productPrice .= $this->translate("%s OFF",Engine_Api::_()->sesproduct()->getCurrencyPrice($item->fixed_discount_value));
                }   
                $productPrice .= '</span>';
            } 
        }else{ 
            $productPrice .=  '<span class="current_value">'.Engine_Api::_()->sesproduct()->getCurrencyPrice($item->price).'</span>';
     }  
        $productPrice .= '</div>';
     } 
     ?>
      <?php $category = ''; ?>
     <?php if(isset($this->categoryActive)){
        if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)):
            $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $item->category_id);
                if($categoryItem):
                    $category .='<div class="sesproduct_product_stat sesbasic_text_light">
                        <span> <i class="fa fa-folder-open" title="'.$this->translate('Category').'"></i> <a href="'.$categoryItem->getHref().'">'. $categoryItem->category_name.'</a> </span>
                        </div>';
                endif;
        endif;
    } ?>
        <?php $creationDate = ''; ?>
        <?php if(isset($this->creationDateActive)){ ?>
        <?php $creationDate .='<div class="sesproduct_product_stat sesbasic_text_light"> <span><i class="fa fa-calendar"></i>';
          if($item->publish_date):
           $creationDate .= date('M d, Y',strtotime($item->publish_date));
          else: 
            $creationDate .= date('M d, Y',strtotime($item->creation_date));
          endif; 
         $creationDate .= '</span>
				</div>'; ?>
        <?php } ?>
        <?php $brand = ''; ?>
         <?php if(isset($this->brandActive) && $item->brand != ''){ ?>
          <?php $brand .='<div class="sesproduct_product_brand sesbasic_text_light">
                <span> <i class="fa fa-cube" title=""></i> <span>'.$item->brand.'</span> </span>
            </div>';
            ?>
        <?php } ?>
        
    <?php $storeInfo = ''; ?>
    <?php  $store = Engine_Api::_()->getItem('stores',$item->store_id);  ?>
    <?php if(isset($this->storeNameActive) && count($store)){ 
            $store = Engine_Api::_()->getItem('stores',$item->store_id); 
            $storePhoto = $store->getPhotoUrl(); 
            $storeTitle ='<a href="<?php'.$store->getHref().'"><span>'.$store->title.'</span></a>';
            $storeInfo ='<div class="sesproduct_store_name"><div class="store_logo"><img src="'.$storePhoto.'"/></div><div class="store_name sesbasic_text_light">'.$storeTitle.'</div></div>'; 
             
     } ?>
     
    <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
    
    <?php $socialshareIcons = $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $product, 'socialshare_enable_plusicon' => $this->socialshare_enable_mapviewplusicon, 'socialshare_icon_limit' => $this->socialshare_icon_mapviewlimit, 'params' => 'feed')); ?>
     <?php  $socialshare = '<div class="sesproduct_list_grid_thumb_btns">'.$socialshareIcons.$likeButton.$favouriteButton.'</div>';?>
    <?php else:?>
			<?php $socialshare = $likeButton.$favouriteButton;?>
    <?php endif;?>
		<?php $owner = $product->getOwner();
			$owner =  '<div class="sesproduct_grid_date sesproduct_list_stats sesbasic_text_light"><span><i class="fa fa-user"></i>'.$this->translate("by ") .$this->htmlLink($owner->getHref(),$owner->getTitle() ).'</span></div>';
			$locationArray[$counter]['id'] = $product->getIdentity();
			$locationArray[$counter]['owner'] = $owner;
			$locationArray[$counter]['location'] = $location;
			$locationArray[$counter]['stats'] = $stats;
			$locationArray[$counter]['socialshare'] = $socialshare;
			$locationArray[$counter]['lat'] = $product->lat;
			$locationArray[$counter]['lng'] = $product->lng;
      $locationArray[$counter]['labels'] = $labels;
      $locationArray[$counter]['vlabel'] = $vlabel;
      $locationArray[$counter]['stock'] = $stock;
      $locationArray[$counter]['addCart'] = $addCart;
      $locationArray[$counter]['addCompare'] = $addCompare;
      $locationArray[$counter]['storeInfo'] = $storeInfo;
      $locationArray[$counter]['productPrice'] = $productPrice;
      $locationArray[$counter]['addWishlist'] = $addWishlist;
      $locationArray[$counter]['category'] = $category;
			$locationArray[$counter]['iframe_url'] = '';
			$locationArray[$counter]['rating'] = $rating;
			$locationArray[$counter]['brand'] = $brand;
      $locationArray[$counter]['creationDate'] = $creationDate;
			$locationArray[$counter]['image_url'] = $product->getPhotoUrl('thumb.thumb'); 
			$locationArray[$counter]['sponsored'] = $product->sponsored;
			$locationArray[$counter]['title'] = '<a href="'.$product->getHref().'">'.$product->getTitle().'</a>';  
			$counter++;?>
  <?php endif;?>
  
  
  <?php } ?>
<?php endforeach; ?>
<?php if($this->view_type == 'map'):?>
  <div id="map-data_<?php echo $randonNumber;?>" style="display:none;"><?php echo json_encode($locationArray,JSON_HEX_QUOT | JSON_HEX_TAG); ?></div>
  <?php if(!$this->view_more || $this->is_search):?>
    <ul id="sesproduct_map_view_<?php echo $randonNumber;?>" style="width:100%;">
      <div id="map-canvas-<?php echo $randonNumber;?>" class="map sesbasic_large_map sesbm sesbasic_bxs"></div>
    </ul>
  <?php endif;?>
<?php endif;?>
<?php  if(  $this->paginator->getTotalItemCount() == 0 &&  (empty($this->widgetType)) && $this->view_type != 'map'){  ?>
  <?php if( isset($this->category) || isset($this->tag) || isset($this->text) ):?>
    <div class="tip">
      <span>
	<?php echo $this->translate('Nobody has posted a product with that criteria.');?>
	<?php if ($this->can_create && empty($this->type)):?>
	  <?php echo $this->translate('Be the first to %1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sesproduct_general").'">', '</a>'); ?>
	<?php endif; ?>
      </span>
    </div>
  <?php else:?>
    <div class="tip">
      <span>
	<?php echo $this->translate('Nobody has created a product yet.');?>
	<?php if ($this->can_create && empty($this->type)):?>
	  <?php echo $this->translate('Be the first to %1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sesproduct_general").'">', '</a>'); ?>
	<?php endif; ?>
      </span>
    </div>
  <?php endif; ?>
<?php }else if( $this->paginator->getTotalItemCount() == 0 && isset($this->tabbed_widget) && $this->tabbed_widget){?>
  <div class="tip">
    <span>
      <?php $errorTip = ucwords(str_replace('SP',' ',$this->defaultOpenTab)); ?>
      <?php echo $this->translate("There are currently no %s",$errorTip);?>
      <?php if (isset($this->can_create) && $this->can_create && empty($this->type)):?>
	<?php echo $this->translate('%1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sesproduct_general").'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>
<?php } ?>
  
<?php if($this->loadOptionData == 'pagging' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')): ?>
  <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesproduct"),array('identityWidget'=>$randonNumber)); ?>
<?php endif;?>
  
<?php if(!$this->is_ajax){ ?>
  </ul>
  <?php if($this->loadOptionData != 'pagging' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')):?>
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore sesbasic_animation sesbasic_link_btn')); ?> </div>
    <div class="sesbasic_view_more_loading sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /> </div>
  <?php endif;?>
  </div>

  <script type="text/javascript">
    var requestTab_<?php echo $randonNumber; ?>;
    var valueTabData ;
    // globally define available tab array
    var requestTab_<?php echo $randonNumber; ?>;
		<?php if($this->loadOptionData == 'auto_load' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')){ ?>
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
    sesJqueryObject(document).on('click','.selectView_<?php echo $randonNumber; ?>',function(){
      if(sesJqueryObject(this).hasClass('active'))
      return;
      if($("view_more_<?php echo $randonNumber; ?>"))
      document.getElementById("view_more_<?php echo $randonNumber; ?>").style.display = 'none';
      document.getElementById("tabbed-widget_<?php echo $randonNumber; ?>").innerHTML = "<div class='clear sesbasic_loading_container'></div>";
      sesJqueryObject('#sesproduct_grid_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesproduct_grid2_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesproduct_supergrid_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesproduct_advgrid_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesproduct_list_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesproduct_simplelist_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesproduct_advlist_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesproduct_advlist2_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesproduct_map_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesproduct_pinboard_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display','none');
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').css('display','none');
      sesJqueryObject(this).addClass('active');
      if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {
				requestTab_<?php echo $randonNumber; ?>.cancel();
      }
      if (typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined') {
				requestViewMore_<?php echo $randonNumber; ?>.cancel();
      }
      requestTab_<?php echo $randonNumber; ?> = (new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
				'data': {
					format: 'html',
					page: 1,
					type:sesJqueryObject(this).attr('rel'),
					params : <?php echo json_encode($this->params); ?>, 
					is_ajax : 1,
					searchParams: searchParams<?php echo $randonNumber; ?>,
					identity : '<?php echo $randonNumber; ?>',
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
					var totalProducts = sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sesproduct");
          sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sesproduct').html(totalProducts.html());
          totalProducts.remove();
          
					if($("loading_image_<?php echo $randonNumber; ?>"))
					document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
					if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber;?>').find('.active').attr('rel') == 'map'){
						var mapData = sesJqueryObject.parseJSON(document.getElementById('map-data_<?php echo $randonNumber;?>').innerHTML);
						if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
							oldMapData_<?php echo $randonNumber; ?> = [];
							newMapData_<?php echo $randonNumber ?> = mapData;
							loadMap_<?php echo $randonNumber ?> = true;
							sesJqueryObject.merge(oldMapData_<?php echo $randonNumber; ?>, newMapData_<?php echo $randonNumber ?>);
							initialize_<?php echo $randonNumber?>();	
							mapFunction_<?php echo $randonNumber?>();
						}
						else {
							sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
							initialize_<?php echo $randonNumber?>();	
						}
					}
					pinboardLayout_<?php echo $randonNumber ?>('true');
				}
      })).send();
    });
  </script>
<?php } ?>
  
<?php if(!$this->is_ajax){ ?>
	<script type="application/javascript">
		var wookmark = undefined;
		//Code for Pinboard View
		var wookmark<?php echo $randonNumber ?>;
		function pinboardLayout_<?php echo $randonNumber ?>(force){
			if(sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel') != 'pinboard'){
				sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').removeClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
				sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').css('height','');
				return;
			}
			sesJqueryObject('.new_image_pinboard_<?php echo $randonNumber; ?>').css('display','none');
			var imgLoad = imagesLoaded('#tabbed-widget_<?php echo $randonNumber; ?>');
			imgLoad.on('progress',function(instance,image){
				sesJqueryObject(image.img).parent().parent().parent().parent().parent().show();
				sesJqueryObject(image.img).parent().parent().parent().parent().parent().removeClass('new_image_pinboard_<?php echo $randonNumber; ?>');
				imageLoadedAll<?php echo $randonNumber ?>(force);
			});
		}
		function imageLoadedAll<?php echo $randonNumber ?>(force){
			sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
			sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard');
			if (typeof wookmark<?php echo $randonNumber ?> == 'undefined' || typeof force != 'undefined') {
				(function() {
					function getWindowWidth() {
						return Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
					}				
					wookmark<?php echo $randonNumber ?> = new Wookmark('.sesbasic_pinboard_<?php echo $randonNumber; ?>', {
						itemWidth: <?php echo isset($this->width_pinboard) ? str_replace(array('px','%'),array(''),$this->width_pinboard) : '300'; ?>, // Optional min width of a grid item
						outerOffset: 0, // Optional the distance from grid to parent
						align:'left',
						flexibleWidth: function () {
							// Return a maximum width depending on the viewport
							return getWindowWidth() < 1024 ? '100%' : '40%';
						}
					});
				})();
			} else {
				wookmark<?php echo $randonNumber ?>.initItems();
				wookmark<?php echo $randonNumber ?>.layout(true);
			}
		}
     sesJqueryObject(window).resize(function(e){
      pinboardLayout_<?php echo $randonNumber ?>('',true);
     });
		<?php if($this->view_type == 'pinboard'):?>
			sesJqueryObject(document).ready(function(){
				pinboardLayout_<?php echo $randonNumber ?>();
			});
		<?php endif;?>
	</script>
<?php } ?>
<?php if(isset($this->optionsListGrid['paggindData']) || isset($this->loadJs)){ ?>
	<script type="text/javascript">
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var requestViewMore_<?php echo $randonNumber; ?>;
		var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
		var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
		var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
		var searchParams<?php echo $randonNumber; ?> ;
		var is_search_<?php echo $randonNumber;?> = 0;
		<?php if($this->loadOptionData != 'pagging'){ ?>
			viewMoreHide_<?php echo $randonNumber; ?>();	
			function viewMoreHide_<?php echo $randonNumber; ?>() {
				if ($('view_more_<?php echo $randonNumber; ?>'))
				$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
			}
			function viewMore_<?php echo $randonNumber; ?> (){
				sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
				sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
				//document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
				//document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
				requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: page<?php echo $randonNumber; ?>,    
						params : params<?php echo $randonNumber; ?>, 
						is_ajax : 1,
						is_search:is_search_<?php echo $randonNumber;?>,
						view_more:1,
						searchParams:searchParams<?php echo $randonNumber; ?> ,
						identity : '<?php echo $randonNumber; ?>',
						identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>'
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_images_browse_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
						if($('loadingimgsesproduct-wrapper'))
						sesJqueryObject('#loadingimgsesproduct-wrapper').hide();
						if(document.getElementById('map-data_<?php echo $randonNumber;?>') )
						sesJqueryObject('#map-data_<?php echo $randonNumber;?>').remove();
						if(!isSearch) {
							document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
						}
						else {
							document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
							oldMapData_<?php echo $randonNumber; ?> = [];
							isSearch = false;
						}
						var totalProducts = sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sesproduct");
            sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sesproduct').html(totalProducts.html());
            totalProducts.remove();
						if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel') == 'map') {
							if(document.getElementById('sesproduct_map_view_<?php echo $randonNumber;?>'))	
							document.getElementById('sesproduct_map_view_<?php echo $randonNumber;?>').style.display = 'block';
							var mapData = sesJqueryObject.parseJSON(sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find('#map-data_<?php echo $randonNumber; ?>').html());
							if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
								newMapData_<?php echo $randonNumber ?> = mapData;
								for(var i=0; i < mapData.length; i++) {
									var isInsert = 1;
									for(var j= 0;j < oldMapData_<?php echo $randonNumber; ?>.length; j++){
										if(oldMapData_<?php echo $randonNumber; ?>[j]['id'] == mapData[i]['id']){
											isInsert = 0;
											break;
										}
									}
									if(isInsert){
										oldMapData_<?php echo $randonNumber; ?>.push(mapData[i]);
									}
								}	
								loadMap_<?php echo $randonNumber;?> = true;
								mapFunction_<?php echo $randonNumber?>();
							}else{
								if(typeof  map_<?php echo $randonNumber;?> == 'undefined'){
									sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
									initialize_<?php echo $randonNumber?>();	
								}	
							}
						}
						else{
							oldMapData_<?php echo $randonNumber; ?> = [];	
						}
						document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
						pinboardLayout_<?php echo $randonNumber ?>();
					}
				});
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php }else{ ?>
			function paggingNumber<?php echo $randonNumber; ?>(pageNum){
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
				requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: pageNum,    
						params :params<?php echo $randonNumber; ?> , 
						is_ajax : 1,
						searchParams:searchParams<?php echo $randonNumber; ?>  ,
						identity : identity<?php echo $randonNumber; ?>,
						type:'<?php echo $this->view_type; ?>'
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_images_browse_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
						if($('loadingimgsesproduct-wrapper'))
						sesJqueryObject('#loadingimgsesproduct-wrapper').hide();
						sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
						document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
						if(isSearch){
							oldMapData_<?php echo $randonNumber; ?> = [];
							isSearch = false;
						}
						var totalProducts = sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sesproduct");
            sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sesproduct').html(totalProducts.html());
            totalProducts.remove();
            
						if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber;?>').find('.active').attr('rel') == 'map'){
							var mapData = sesJqueryObject.parseJSON(sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find('#map-data_<?php echo $randonNumber; ?>').html());
							if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
							oldMapData_<?php echo $randonNumber; ?> = [];
							newMapData_<?php echo $randonNumber ?> = mapData;
							loadMap_<?php echo $randonNumber ?> = true;
							sesJqueryObject.merge(oldMapData_<?php echo $randonNumber; ?>, newMapData_<?php echo $randonNumber ?>);
							mapFunction_<?php echo $randonNumber?>();
							}
							else{
								sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
								initialize_<?php echo $randonNumber?>();	
							}
						}
						else{
							oldMapData_<?php echo $randonNumber; ?> = [];	
						}
						pinboardLayout_<?php echo $randonNumber ?>();
					}
				}));
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php } ?>
	</script>
<?php } ?>

<!--Start Map Work on Page Load-->
<?php if(!$this->is_ajax && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)): ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/richMarker.js'); ?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/marker.js'); ?>
	<script type="application/javascript">
		sesJqueryObject(document).on('click',function(){
			sesJqueryObject('.sesproduct_list_option_toggle').removeClass('open');
		});
		var  loadMap_<?php echo $randonNumber;?> = false;
		var newMapData_<?php echo $randonNumber ?> = [];
		function mapFunction_<?php echo $randonNumber?>(){
			if(!map_<?php echo $randonNumber;?> || loadMap_<?php echo $randonNumber;?>){
			initialize_<?php echo $randonNumber?>();
			loadMap_<?php echo $randonNumber;?> = false;
			}
			if(sesJqueryObject('.map_selectView_<?php echo $randonNumber;?>').hasClass('active')) {
				if(!newMapData_<?php echo $randonNumber ?>)
				return false;
				<?php if($this->loadOptionData == 'pagging'){ ?>DeleteMarkers_<?php echo $randonNumber ?>();<?php }?>
				google.maps.event.trigger(map_<?php echo $randonNumber;?>, "resize");
				markerArrayData_<?php echo $randonNumber?> = newMapData_<?php echo $randonNumber ?>;
				if(markerArrayData_<?php echo $randonNumber?>.length)
				newMarkerLayout_<?php echo $randonNumber?>();
				newMapData_<?php echo $randonNumber ?> = '';
				sesJqueryObject('#map-data_<?php echo $randonNumber;?>').addClass('checked');
			}
		}
		var isSearch = false;
		var oldMapData_<?php echo $randonNumber; ?> = [];
		var markers_<?php echo $randonNumber;?>  = [];
		var map_<?php echo $randonNumber;?>;
		if('<?php echo $this->lat; ?>' == '') {
			var latitude_<?php echo $randonNumber;?> = '26.9110600';
			var longitude_<?php echo $randonNumber;?> = '75.7373560';
		}else{
			var latitude_<?php echo $randonNumber;?> = '<?php echo $this->lat; ?>';
			var longitude_<?php echo $randonNumber;?> = '<?php echo $this->lng; ?>';
		}
		function initialize_<?php echo $randonNumber?>() {
			var bounds_<?php echo $randonNumber;?> = new google.maps.LatLngBounds();
			map_<?php echo $randonNumber;?> = new google.maps.Map(document.getElementById('map-canvas-<?php echo $randonNumber;?>'), {
				zoom: 17,
				scrollwheel: true,
				center: new google.maps.LatLng(latitude_<?php echo $randonNumber;?>, longitude_<?php echo $randonNumber;?>),
			});
			oms_<?php echo $randonNumber;?> = new OverlappingMarkerSpiderfier(map_<?php echo $randonNumber;?>,
			{nearbyDistance:40,circleSpiralSwitchover:0 }
			);
		}
		var countMarker_<?php echo $randonNumber;?> = 0;
		function DeleteMarkers_<?php echo $randonNumber ?>(){
			//Loop through all the markers and remove
			for (var i = 0; i < markers_<?php echo $randonNumber;?>.length; i++) {
				markers_<?php echo $randonNumber;?>[i].setMap(null);
			}
			markers_<?php echo $randonNumber;?> = [];
			markerData_<?php echo $randonNumber ?> = [];
			markerArrayData_<?php echo $randonNumber?> = [];
		};
		var markerArrayData_<?php echo $randonNumber?> ;
		var markerData_<?php echo $randonNumber ?> =[];
		var bounds_<?php echo $randonNumber;?> = new google.maps.LatLngBounds();

		function newMarkerLayout_<?php echo $randonNumber?>(dataLenth){
			if(typeof dataLenth != 'undefined') {
				initialize_<?php echo $randonNumber?>();
				markerArrayData_<?php echo $randonNumber?> = sesJqueryObject.parseJSON(dataLenth);
			}
			if(!markerArrayData_<?php echo $randonNumber?>.length)
			return;
			
			DeleteMarkers_<?php echo $randonNumber ?>();
			markerArrayData_<?php echo $randonNumber?> = oldMapData_<?php echo $randonNumber; ?>;
			var bounds = new google.maps.LatLngBounds();
			for(i=0;i<markerArrayData_<?php echo $randonNumber?>.length;i++){
				var images = '<div class="image sesproduct_map_thumb_img"><img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'"  /></div>';		
				var owner = markerArrayData_<?php echo $randonNumber?>[i]['owner'];
				var location = markerArrayData_<?php echo $randonNumber?>[i]['location'];
				var socialshare = markerArrayData_<?php echo $randonNumber?>[i]['socialshare'];
				var sponsored = markerArrayData_<?php echo $randonNumber?>[i]['sponsored'];
				var vlabel = markerArrayData_<?php echo $randonNumber?>[i]['vlabel'];
				var labels = markerArrayData_<?php echo $randonNumber?>[i]['labels'];
				var title = markerArrayData_<?php echo $randonNumber?>[i]['title'];
				var stock = markerArrayData_<?php echo $randonNumber?>[i]['stock'];
				var addCart = markerArrayData_<?php echo $randonNumber?>[i]['addCart'];
				var addCompare = markerArrayData_<?php echo $randonNumber?>[i]['addCompare'];
				var addWishlist = markerArrayData_<?php echo $randonNumber?>[i]['addWishlist'];
				var storeInfo = markerArrayData_<?php echo $randonNumber?>[i]['storeInfo'];
				var productPrice = markerArrayData_<?php echo $randonNumber?>[i]['productPrice'];
				var category = markerArrayData_<?php echo $randonNumber?>[i]['category'];
				var image_url = markerArrayData_<?php echo $randonNumber?>[i]['image_url'];
				var stats = markerArrayData_<?php echo $randonNumber?>[i]['stats']; 
        var creationDate = markerArrayData_<?php echo $randonNumber?>[i]['creationDate'];
        var brand = markerArrayData_<?php echo $randonNumber?>[i]['brand'];
				var allowBlounce = <?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.bounce', 1); ?>; 
				if(sponsored == 1 && allowBlounce)
				var animateClass = 'animated bounce ';
				else
				var animateClass = '';
				
				//animate class "animated bounce"
				var marker_html = '<div class="'+animateClass+'pin public marker_'+countMarker_<?php echo $randonNumber;?>+'" data-lat="'+ markerArrayData_<?php echo $randonNumber?>[i]['lat']+'" data-lng="'+ markerArrayData_<?php echo $randonNumber?>[i]['lng']+'">' +
				'<div class="wrapper">' +
				'<div class="small">' +
				'<img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'" style="height:48px;width:48px;" alt="" />' +
				'</div>' +
				'<div class="large map_large_marker"><div class="sesproduct_map_thumb sesproduct_grid_btns_wrap">'+socialshare+labels+
	'<div class="sesproduct_map_thumb_img"><img src='+image_url+' alt=""/></div></div><div class="sesproduct_map_info_blk sesbasic_clearfix"><div class="sesproduct_map_info_title"><h3>'+title+'</h3>'+vlabel+'</div><div class="sesbasic_clearfix sesproduct_map_info_blk_fields">'+storeInfo+creationDate+brand+'<div class="sesproduct_availability">'+stock+'</div>'+category+'</div>'+productPrice+'<div class="sesbasic_clearfix clear sesproduct_map_info_blk_footer">'+stats+'</div><div class="sesproduct_product_compare sesbasic_clearfix">'+addCompare+'</div><div class="sesproduct_add_cart sesbasic_clearfix"> '+addCart+' '+addWishlist+'</div></div></div><a class="icn close" href="javascript:;" title="Close"><i class="fa fa-close"></i></a>' +
				'</div>' +
				'</div>' +
				'<span class="sesbasic_largemap_pointer"></span>' +
				'</div>';
				markerData = new RichMarker({
					position: new google.maps.LatLng(markerArrayData_<?php echo $randonNumber?>[i]['lat'], markerArrayData_<?php echo $randonNumber?>[i]['lng']),
					map: map_<?php echo $randonNumber;?>,
					flat: true,
					draggable: false,
					scrollwheel: false,
					id:countMarker_<?php echo $randonNumber;?>,
					anchor: RichMarkerPosition.BOTTOM,
					content: marker_html,
				});
				oms_<?php echo $randonNumber;?>.addListener('click', function(marker) {
					var id = marker.markerid;
					previousIndex = sesJqueryObject('.marker_'+ id).parent().parent().css('z-index');
					sesJqueryObject('.marker_'+ id).parent().parent().css('z-index','9999');
					sesJqueryObject('.pin').removeClass('active').css('z-index', 10);
					sesJqueryObject('.marker_'+ id).addClass('active').css('z-index', 200);
					sesJqueryObject('.marker_'+ id+' .large .close').click(function(){
					sesJqueryObject(this).parent().parent().parent().parent().parent().css('z-index',previousIndex);
						sesJqueryObject('.pin').removeClass('active');
						return false;
					});
				});
				markers_<?php echo $randonNumber;?> .push( markerData);
				markerData.setMap(map_<?php echo $randonNumber;?>);
				bounds.extend(markerData.getPosition());
				markerData.markerid = countMarker_<?php echo $randonNumber;?>;
				oms_<?php echo $randonNumber;?>.addMarker(markerData);
				countMarker_<?php echo $randonNumber;?>++;
		  }
			map_<?php echo $randonNumber;?>.fitBounds(bounds);
		}
		<?php if($this->view_type == 'map'){?>
			window.addEvent('domready', function() {
				var mapData = sesJqueryObject.parseJSON(document.getElementById('map-data_<?php echo $randonNumber;?>').innerHTML);
				if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
					newMapData_<?php echo $randonNumber ?> = mapData;
					sesJqueryObject.merge(oldMapData_<?php echo $randonNumber; ?>, newMapData_<?php echo $randonNumber ?>);
					mapFunction_<?php echo $randonNumber?>();
					sesJqueryObject('#map-data_<?php echo $randonNumber;?>').addClass('checked')
				}
				else{
					if(typeof  map_<?php echo $randonNumber;?> == 'undefined') {
						sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
						initialize_<?php echo $randonNumber?>();	
					}
				}
			});
		<?php } ?>
	</script> 
<?php endif;?>
<!--End Map Work-->
