<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: view.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php //if(!$this->is_ajax){ ?>
<?php  if($this->cartData['cartProductsCount']) { ?>
  <div class="sesbasic_header_pulldown_inner">  
    <div class="sesbasic_header_pulldown_head">
      <div class="_title">
        <?php echo $this->translate("PRODUCT CART"); ?>
      </div>
      <div class="_right">
        <span class="_items"> <?php echo $this->translate(array('%s Product', '%s Products', ($this->cartData['cartProductsCount'])),($this->cartData['cartProductsCount'])); ?></span>
      </div>
    </div>
    <div class="sesbasic_header_pulldown_body">
      <?php foreach($this->productsArray as $cart) {
           $totalPrice = 0;
      ?>
      <?php foreach($cart['cartproducts'] as $itemCart){
         if(empty($itemCart['product_id']))
            continue;
        $item = Engine_Api::_()->getItem('sesproduct',$itemCart['product_id']);
        if(!count($item))
            continue;
        $price = $cart['products_extra'][$itemCart['cartproduct_id']]['product_price'];
        $quantity = $cart['products_extra'][$itemCart['cartproduct_id']]['quantity'];
        $totalPrice += $price;
        ?>
          <div class="sesbasic_cart_pulldown_item">
            <div class="_thumb">
              <a href="javascrip:;"><img src="<?php echo $item->getPhotoUrl('thumb.icon'); ?>"/></a>
            </div>
            <div class="_info">
              <div class="_title">  
                <a href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a>
              </div>
              <div class="_amt">
                  <span class="_quan"><b><?php echo $this->translate("Quantity : "); ?><?php echo $quantity; ?></b></span>
                  <span class="_amount">
                    <?php if(!empty($price)){ ?>
                      <?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($price,2)) ; ?>
                    <?php } else { ?>
                      <span style="font-weight: bold;"><?php echo $this->translate("Free "); ?></span>
                    <?php } ?>
                  </span>
                </div>
                <div class="_close" id="close<?php echo $itemCart["cartproduct_id"]; ?>">
                  <a href="javascript:void(0);" class="fa fa-times" onclick="getDeleteProduct('<?php echo $itemCart["cartproduct_id"]; ?>')"></a>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
      <div class="sesbasic_header_pulldown_footer sesbasic_clearfix">
        <div class="_total">  
          <div class="_label">
              <span><?php echo $this->translate("Grand Total:"); ?> </span>
          </div>      
          <div class="_value">
            <span class=_value><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($this->totalPrice,2)) ; ?></span>
          </div>
        </div>
        <div class="_footer">
          <div id="Cart<?php echo $itemCart["cartproduct_id"]; ?>">
            <a href="javascript:void(0);" class="btn_border" onclick="getDeleteCart('<?php echo $itemCart["cart_id"]; ?>')"><?php echo $this->translate("Clear All"); ?></a>
          </div>
          <div>
            <a href="<?php echo $this->url(array('action'=>'index'),'sesproduct_cart',true); ?>" class="btn_full" ><?php echo $this->translate("Checkout"); ?></a>
        </div>
      </div>
    </div>
  </div>    
<?php } else { ?>
  <div class="sesbasic_header_pulldown_inner">
    <div class="sesbasic_header_pulldown_tip">
      <?php echo $this->translate("You have not added product yet in your cart.");  ?>
    </div>
  </div>
<?php } ?>

<script>
var ajaxDeleteRequest;
function getDeleteProduct(cartId)
{
var confirmDelete = confirm("<?php echo $this->translate('Are you sure you want to delete?'); ?>");
if(confirmDelete){
    sesJqueryObject("#close"+cartId).removeClass();
    sesJqueryObject("#close"+cartId).html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading" />');
    ajaxDeleteRequest = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'sesproduct/cart/view',
	  'data': {
        id: cartId,
        isAjax : 1,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
        sesJqueryObject('.sesproduct_cart_dropdown').html(responseHTML);
          if(sesJqueryObject('.sesproduct_cart_count').length){
              var count = parseInt(sesJqueryObject('.sesproduct_cart_count').html());
              sesJqueryObject('.sesproduct_cart_count').html(count-1);
              if(count-1 <= 0){
                  sesJqueryObject('.sesproduct_cart_count').hide();
              }
          }
	  }
	})).send();
}
}  

function getDeleteCart(cartId)
{
var confirmDelete = confirm('Are you sure you want to delete?');
if(confirmDelete){
    sesJqueryObject("#Cart"+cartId).html('<img src="application/modules/Core/externals/images/loading.gif" alt="Loading" />');
    ajaxDeleteRequest = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'sesproduct/cart/view',
	  'data': {
        is_Ajax_Delete : 1,
        isAjax : 1,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
        sesJqueryObject('.sesproduct_cart_dropdown').html(responseHTML);
        sesJqueryObject('.sesproduct_cart_count').hide();
        sesJqueryObject('.sesproduct_cart_count').html(0);

	  }
	})).send();
}
} 
</script>
<?php die; ?>
