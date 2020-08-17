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
<script type="text/javascript">
  function loadMoreContent() {
    if ($('load_more'))
      $('load_more').style.display = "<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() || $this->count == 0 ? 'none' : '' ) ?>";

    if(document.getElementById('load_more'))
      document.getElementById('load_more').style.display = 'none';
    
    if(document.getElementById('underloading_image'))
      document.getElementById('underloading_image').style.display = '';

    en4.core.request.send(new Request.HTML({
      method: 'post',              
      'url': en4.core.baseUrl + 'widget/index/mod/sesproduct/name/browse-wishlists',
      'data': {
        format: 'html',
        page: "<?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>",
        viewmore: 1,
        params: '<?php echo json_encode($this->all_params); ?>',        
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('results_data').innerHTML = document.getElementById('results_data').innerHTML + responseHTML;
        
        if(document.getElementById('load_more'))
          document.getElementById('load_more').destroy();
        
        if(document.getElementById('underloading_image'))
         document.getElementById('underloading_image').destroy();
       
        if(document.getElementById('loadmore_list'))
         document.getElementById('loadmore_list').destroy();
      }
    }));
    return false;
  }
</script>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); ?>
<?php if(count($this->paginator) > 0): ?>
  <?php if (empty($this->viewmore)): ?>
		<h4><?php echo $this->translate(array('%s wishlist found.', '%s wishlists found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())); ?></h4>
<div class="sesproduct_wishlist_browse sesbasic_clearfix sesbasic_bxs" id="results_data">
    <?php endif; ?>
    <?php foreach ($this->paginator as $item){  ?>
        <div class="sesproduct_wishlist_gridB">    
    <div class="wishlist_product_images sesproduct_thumb">
      <a href="javascript:void(0);">
        <img src="<?php echo $item->getPhotoUrl(); ?>" class="lg_img"/>
      </a>
      <?php if(!empty($this->information) && in_array('featuredLabel', $this->information) || in_array('sponsoredLabel', $this->information)){ ?>
        <p class="sesproduct_labels">
        <?php if(in_array('featuredLabel', $this->information) && $item->is_featured ){ ?>
          <span class="sesproduct_label_featured"> <i class="fa fa-star"></i> </span>
        <?php } ?>
        <?php if(in_array('sponsoredLabel', $this->information) && $item->is_sponsored ){ ?>
          <span class="sesproduct_label_sponsored"> <i class="fa fa-star"></i> </span>
        <?php } ?>
        </p>
     <?php } ?>
     
     <?php if(in_array('showProductList', $this->information)){ ?>
     <?php $products = $item->getProducts(array('limit'=>3)); ?>
      <?php foreach($products as $product){ ?>
      <?php $product = Engine_Api::_()->getItem('sesproduct', $product->file_id); ?>
      
      <?php } ?>
    <?php } ?>
      <div class="sesproduct_img_thumb_over"> 
        <a href="<?php echo $item->getHref(); ?>" data-url="sesproduct"></a>
        <div class="sesproduct_grid_btns">
          	<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
        
          <?php if(!empty($this->information) && in_array('socialSharing', $this->information)){ ?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_icon_limit' => $this->socialshare_icon_limit, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon)); ?>

				<?php } ?> 
        <?php 
          if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ){
            $itemtype = 'sesproduct_wishlist';
            $getId = 'wishlist_id';                                
            $canComment =  true;
            if(!empty($this->information) && in_array('likeButton', $this->information) && $canComment){
          ?>
          <?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatusProduct($item->$getId,$item->getType()); ?>
              <a href="javascript:;"data-url="<?php echo $item->$getId ; ?>"  class="sesbasic_icon_btn sesbasic_icon_btn_count sesproduct_like_<?php echo $itemtype; ?><?php echo ($LikeStatus) ? ' button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
           <?php } ?>
           <?php if(!empty($this->information) && in_array('favouriteButton', $this->information) && isset($item->favourite_count)){ ?>
            
          <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>$itemtype,'resource_id'=>$item->$getId)); ?>  
            <a href="javascript:;" class="sesbasic_icon_btn sesproduct_favourite_<?php echo $itemtype; ?> <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->$getId ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
         <?php } ?>
         <?php } ?>
         </div>
        </div>
    </div>
    <div class="sesproduct_browsewishlist_info">
      <div class="browse-wishlist-title">
       <?php if(!empty($this->information) && in_array('title', $this->information) ){ ?>
            <a href="<?php echo $item->getHref(); ?>"><h3><?php echo $item->getTitle(); ?></h3></a>
        <?php } ?>
        <div class="sesproduct_list_stats sesbasic_text_light">
          <?php if(!empty($this->information) && in_array('date', $this->information) ){ ?>
            <span class="date"><i class="fa fa-calendar"></i><?php echo date('dS D, Y',strtotime($item->creation_date)); ?></span>
          <?php } ?>
        </div>        
        <div class="sesproduct_list_date sesproduct_list_stats sesbasic_text_light"> 
          <?php if(!empty($this->information) && in_array('viewCount', $this->information)): ?>
            <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
          <?php endif; ?>
          <?php if(!empty($this->information) && in_array('favouriteCount', $this->information)): ?>
            <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
          <?php endif; ?>
          <?php if(!empty($this->information) && in_array('likeCount', $this->information)): ?>
            <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
          <?php endif; ?>
           <?php $productCount = Engine_Api::_()->getDbtable('playlistproducts', 'sesproduct')->playlistProductsCount(array('wishlist_id' => $item->wishlist_id));  ?>
          <span title="<?php echo $this->translate(array('%s product', '%s products', $productCount), $this->locale()->toNumber($productCount)); ?>"><i class="fa fa-shopping-bag"></i><?php echo $productCount; ?></span>
        </div>
          <?php if(in_array('showProductList', $this->information)){ ?>
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_productImg.tpl';?>
         <?php } ?>
      </div>
    </div>
  </div>
 <?php } ?>
<?php if (!empty($this->paginator) && $this->paginator->count() > 1): ?>
  <?php if ($this->paginator->getCurrentPageNumber() < $this->paginator->count()): ?>
    <div class="clr" id="loadmore_list"></div>
    <div class="sesbasic_view_more sesbasic_load_btn" id="load_more" onclick="loadMoreContent();" style="display: block;">
      <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => 'feed_viewmore_link', 'class' => 'sesbasic_animation estore_link_btn fa fa-repeat')); ?>
    </div>
    <div class="sesbasic_view_more_loading" id="underloading_image" style="display: none;">
   <span class="estore_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
      <?php echo $this->translate("Loading ...") ?>
    </div>
  <?php endif; ?>
 <?php endif; ?> 
<?php if (empty($this->viewmore)): ?>
</div>
<?php endif; ?>
<?php else: ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('There are currently no Wishlists created yet.') ?>
    </span>
  </div>
<?php endif; ?>
<?php if($this->paginationType == 1): ?>
<script type="text/javascript">
en4.core.runonce.add(function() {
  var paginatorCount = '<?php echo $this->paginator->count(); ?>';
  var paginatorCurrentPageNumber = '<?php echo $this->paginator->getCurrentPageNumber(); ?>';
  function ScrollLoader() { 
    var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    if($('loadmore_list')) {
      if (scrollTop > 40)
        loadMoreContent();
    }
  }
  window.addEvent('scroll', function() { 
    ScrollLoader(); 
  });
});    
</script>
<?php endif; ?>
