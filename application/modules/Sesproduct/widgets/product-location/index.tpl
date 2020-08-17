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

<?php if(!$this->is_ajax): ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/richMarker.js');?>
<?php endif;?>

<?php $randonNumber = "location_widget_sesproduct"; ?>
<?php $locationArray = array();$counter = 0;?>
<?php foreach( $this->paginator as $product ): ?>
<?php  $item = $product;
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
			<?php $location = "<div class=\"sesproduct_list_stats sesproduct_list_location sesbasic_text_light\">
			<span class=\"widthfull\">
			<i class=\"fa fa-map-marker\" title=\"$locationText\"></i>
			<span title=\"$locationvalue\"><a href='".$this->url(array('resource_id' => $product->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true)."' class=\"opensmoothboxurl\">$locationvalue</a></span>
			</span>
			</div>";?>
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
        <?php  $fiveStar = count(Engine_Api::_()->getDbTable('sesproductreviews','sesproduct')->getUserReviewCount(array('rating'=>5,'product_id'=>$item->getIdentity()))); ?>
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
        $stats .= '<span title="'.$this->translate(array('%s comment', '%s comments', $product->comment_count), $this->locale()->toNumber($product->comment_count)).'"><i class="far fa-comment"></i>'.$product->comment_count.'</span>';
        }
        if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)){
        $stats .= '<span title="'.$this->translate(array('%s favourite', '%s favourites', $product->favourite_count), $this->locale()->toNumber($product->favourite_count)).'"><i class="far fa-heart"></i>'. $product->favourite_count.'</span>';
        }
        if(isset($this->viewActive)){
        $stats .= '<span title="'. $this->translate(array('%s view', '%s views', $product->view_count), $this->locale()->toNumber($product->view_count)).'"><i class="fa fa-eye"></i>'.$product->view_count.'</span>';
        }
        if(isset($this->likeActive)){
        $stats .= '<span title="'.$this->translate(array('%s like', '%s likes', $product->like_count), $this->locale()->toNumber($product->like_count)).'"><i class="far fa-thumbs-up"></i>'.$product->like_count.'</span> ';
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
        $addWishlist .= '<a href="javascript:;" data-rel="'. $item->getIdentity().'" class="sesproduct_wishlist" data-rel="'.$item->getIdentity().'" title="'.$this->translate('Add to Wishlist').'"><i class="far fa-bookmark"></i></a>';
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
             $storeTitle .='<a href="<?php'.$store->getHref().'"><span>'.$store->title.'</span></a>';
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
      $locationArray[$counter]['brand'] = $brand;
      $locationArray[$counter]['creationDate'] = $creationDate;
			$locationArray[$counter]['iframe_url'] = '';
			$locationArray[$counter]['rating'] = $rating;
			$locationArray[$counter]['image_url'] = $product->getPhotoUrl('thumb.thumb');
			$locationArray[$counter]['sponsored'] = $product->sponsored;
			$locationArray[$counter]['title'] = '<a href="'.$product->getHref().'">'.$product->getTitle().'</a>';  
			$counter++;?>
  <?php endif;?>
<?php endforeach; ?>

<?php if(!$this->is_ajax){ ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/richMarker.js'); ?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/marker.js'); ?>
  <script type="text/javascript">
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
        var creationDate = markerArrayData_<?php echo $randonNumber?>[i]['creationDate'];
        var brand = markerArrayData_<?php echo $randonNumber?>[i]['brand'];
				var stats = markerArrayData_<?php echo $randonNumber?>[i]['stats'];
				var allowBlounce = <?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.bounce', 1); ?>;
				if(sponsored == 1 && allowBlounce)
				var animateClass = 'animated bounce ';
				else
				var animateClass = '';
	
    var marker_html = '<div class="'+animateClass+'pin public marker_'+countMarker_<?php echo $randonNumber;?>+'" data-lat="'+ markerArrayData_<?php echo $randonNumber?>[i]['lat']+'" data-lng="'+ markerArrayData_<?php echo $randonNumber?>[i]['lng']+'">' +
            '<div class="wrapper">' +
            '<div class="small">' +
            '<img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'" style="height:48px;width:48px;" alt="" />' +
            '</div>' +
            '<div class="large map_large_marker"><div class="sesproduct_map_thumb sesproduct_grid_btns_wrap">'+socialshare+labels+
	'<div class="sesproduct_map_thumb_img"><img src='+image_url+' alt=""/></div></div><div class="sesproduct_map_info_blk sesbasic_clearfix"><div class="sesproduct_map_info_title"><h3>'+title+'</h3>'+vlabel+'</div><div class="sesbasic_clearfix sesproduct_map_info_blk_fields">'+storeInfo+creationDate+brand+'<div class="sesproduct_availability">'+stock+'</div>'+category+'</div>'+productPrice+'<div class="sesbasic_clearfix clear sesproduct_map_info_blk_footer">'+stats+'</div><div class="sesproduct_product_compare sesbasic_clearfix">'+addCompare+'</div><div class="sesproduct_add_cart sesbasic_clearfix"> '+addCart+' '+addWishlist+'</div></div></div><a class="icn close" href="javascript:;" title="Close"><i class="fa fa-times"></i></a>' +
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
	  content: marker_html
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
		sesJqueryObject('.marker_'+ id+' .close').click(function(){
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
    var searchParams;
    var markerArrayData ;
    function callNewMarkersAjax(){
      (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sesproduct/name/<?php echo $this->widgetName; ?>",
      'data': {
	format: 'html',
	is_ajax : 1,
	searchParams:searchParams,
	show_criterias : '<?php echo json_encode($this->show_criterias); ?>'
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	if($('loadingimgsesproduct-wrapper'))
	sesJqueryObject ('#loadingimgsesproduct-wrapper').hide();
	DeleteMarkers_<?php echo $randonNumber ?>();
	if(responseHTML){
	  var mapData = sesJqueryObject.parseJSON(responseHTML);
	  if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
	    newMapData_<?php echo $randonNumber ?> = mapData;
	    mapFunction_<?php echo $randonNumber?>();
	  }
	}
	sesJqueryObject('#loadingimgsesproduct-wrapper').hide();
      }
      })).send();	
    }
    var newMapData_<?php echo $randonNumber ?> = [];		 
    function mapFunction_<?php echo $randonNumber?>(){
      if(!map_<?php echo $randonNumber;?> || loadMap_<?php echo $randonNumber;?>){
	initialize_<?php echo $randonNumber?>();
	loadMap_<?php echo $randonNumber;?> = false;
      }
      if(!newMapData_<?php echo $randonNumber ?>){
	return false;
      }
      google.maps.event.trigger(map_<?php echo $randonNumber;?>, "resize");
      markerArrayData_<?php echo $randonNumber?> = newMapData_<?php echo $randonNumber ?>;
      if(markerArrayData_<?php echo $randonNumber?>.length)
      newMarkerLayout_<?php echo $randonNumber?>();
      newMapData_<?php echo $randonNumber ?> = '';
      sesJqueryObject('#map-data_<?php echo $randonNumber;?>').addClass('checked');
    }
    window.addEvent('domready', function() {
      var mapData = sesJqueryObject.parseJSON(document.getElementById('map-data_<?php echo $randonNumber;?>').innerHTML);
      if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
					newMapData_<?php echo $randonNumber ?> = mapData;
					mapFunction_<?php echo $randonNumber?>();
      }else{
					initialize_<?php echo $randonNumber?>();
			}
      sesJqueryObject('#locationSesList').val('<?php echo $this->location; ?>');
      sesJqueryObject('#latSesList').val('<?php echo $this->lat; ?>');
      sesJqueryObject('#lngSesList').val('<?php echo $this->lng; ?>');
    });
  </script>
<?php } ?>
<?php if(!$this->is_ajax){ ?>
	<script type="application/javascript">
		var tabId_loc = <?php echo $this->identity; ?>;
			window.addEvent('domready', function() {
			tabContainerHrefSesbasic(tabId_loc);	
		});
	</script>
	<div id="map-data_location_widget_sesproduct" style="display:none;"><?php echo json_encode($locationArray,JSON_HEX_QUOT | JSON_HEX_TAG); ?></div>
	<div id="map-canvas-location_widget_sesproduct" class="map sesbasic_large_map sesbm sesbasic_bxs sesproduct_browse_map"></div>
	<?php }else{ echo json_encode($locationArray,JSON_HEX_QUOT | JSON_HEX_TAG); ; die;} ?>
