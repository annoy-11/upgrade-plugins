<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _productImg.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php if(!empty($item)){ ?>
    <?php $products = Engine_Api::_()->getDbtable('playlistproducts', 'sesproduct')->getWishedProducts(array('wishlist_id' => $item->wishlist_id)); 
     $hrefItem = $item;
?>
<?php } elseif(!empty($store)) { ?>
     <?php $products = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getSesproductsSelect(array('store_id' => $store->store_id,'user_id' => $store->owner_id, 'fetchAll' => 1, 'rss' => 1));
     $hrefItem = $store;
     ?>
<?php } ?>
<?php if(count($products))  { ?>
<div class="estore_products_imgs">
  <h4><?php $totalProduct = count($products); $counter =0; ?> <?php echo $this->translate(array('%s Product', '%s Products', $totalProduct), $this->locale()->toNumber($totalProduct))?> </h4>
  <div class="estore_product_group sesbasic_clearfix">
  <?php foreach($products as $product) {if($counter == 3){ break; } ?>
   <?php $count =false; ?>
  <?php if($counter == 2 && $totalProduct > 3 ) { ?>
    <?php $count =true;?>
  <?php } ?>
    <div class="estore_product_item <?php echo $count ? 'last_img' : ''; ?>">
        <a href="<?php echo $count ? $hrefItem->getHref() : $product->getHref(); ?>">
            <?php if($count ) { ?>
                <span class="_text"><?php echo ($totalProduct - 3) ?> +</span>
            <?php } ?>
            <img src="<?php echo $product->getPhotoUrl(); ?>" alt=""/>
        </a>
    </div>
  <?php $counter++; } ?>
  </div>
</div>
<?php } ?>
