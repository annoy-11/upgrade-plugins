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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl .'application/modules/Sesproduct/externals/styles/styles.css'); ?>

<?php
	$session = new Zend_Session_Namespace('sesproduct_product_quantity');
	$creditSession = new Zend_Session_Namespace('sescredit_redeem_purchase');
	$creditCheckout = new Zend_Session_Namespace('sescredit_points');
?>

<div class="sesproduct_my_cart_main sesbasic_clearfix sesbasic_bxs">
	<div class="sesproduct_shopping_bag">
	 <?php if(count($this->productsArray)){
	 	$storeArray = array();
	  ?>
	 <form method="post">
	 	<?php foreach($this->productsArray as $cart){
			  $totalPrice = 0;
	 	?>
			<div class="sesproduct_store_item">
			<?php if(count($cart['stores'])) { ?>
				<div class="store_wise_title">
					<a href="<?php echo $cart['stores']->getHref(); ?>"><h4><?php echo $cart['stores']->getTitle(); ?></h4></a>
				</div>
			<?php } ?>	
				<?php foreach($cart['cartproducts'] as $itemCart){
					$item = Engine_Api::_()->getItem('sesproduct',$itemCart['product_id']);
					if(!count($item))
            continue;
					$price = $cart['products_extra'][$itemCart['cartproduct_id']]['product_price'];
					$quantity = $cart['products_extra'][$itemCart['cartproduct_id']]['quantity'];
					$totalPrice += $price;
				?>
				<div class="sesproduct_cart_item">
					<div class="sesproduct_cart_img sesproduct_thumb">
						<a href="<?php echo $item->getHref(); ?>">
							<img src="<?php echo $item->getPhotoUrl('thumb.profile'); ?>" style="height: 60px;"/>
						</a>
					</div>
					<div class="sesproduct_cart_desc">
						<a href="<?php echo $item->getHref(); ?>"><h4><?php echo $item->getTitle(); ?></h4></a>
              <?php if(!empty($cart['products_extra'][$itemCart['cartproduct_id']]['variations'])){ ?>
					<div>
						<?php foreach($cart['products_extra'][$itemCart['cartproduct_id']]['variations'] as $key=>$value){
							if($key == 'purchasePriceProduct')
								continue;
						?>
						<div>
							<span style="font-weight: bold;"><?php echo $key ?>: </span><span><?php echo $value; ?></span>
						</div>
						<?php } ?>
					</div>
					<?php } ?>
					</div>
					<div class="sesproduct_carti_quantity">
							<span class="plus priceplus button"><i class="fa fa-plus"></i></span>
							<input type="text" value="<?php echo $quantity; ?>" name="quantity_<?php echo $itemCart['cartproduct_id']; ?>" class="quantity"/>
							<span class="min priceminus button"><i class="fa fa-minus"></i></span>
					</div>
					<?php
					if(!empty($session->cart_product_{$itemCart['cartproduct_id']})){
					?>
					<h6 style="color: red;"><?php echo $this->translate("%s",$session->cart_product_{$itemCart['cartproduct_id']}); ?></h6>
					<?php
					}
					?>
					<div class="sesproduct_cart_price">
						<h4>
							<?php if(!empty($price)){ ?>
							<?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($price,2)) ; ?>
							<?php } else { ?>
                <span style="font-weight: bold;">free </span>
							<?php } ?>
						</h4>
					</div>
					<div class="sesproduct_cart_action">
						<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1)): ?>
						<a data-rel="<?php echo $item->getIdentity(); ?>" title='<?php echo $this->translate('Add to Wishlist'); ?>' href="javascript:;" class="sesproduct_wishlist"><i class="fa fa-bookmark-o"></i><!-- <?php echo $this->translate('Add to Wishlist'); ?> --></a>
						<?php endif; ?>
						<a href="javascript:;" title='<?php echo $this->translate('Remove'); ?>' onclick="Smoothbox.open('<?php echo $this->url(array('action'=>'delete-cart','id'=>$itemCart["cartproduct_id"]),'sesproduct_cart',true); ?>')"><i class="fa fa-trash"></i><!-- <?php echo $this->translate("Remove"); ?> --></a>
					</div>
				</div>
				<?php } ?>
				<?php if(count($cart['stores'])) { ?>
            <?php $storeArray[$cart['stores']->getTitle()] = $totalPrice; ?>
				<?php } ?>
				<div class="sesproduct_cart_align_flex">
					<div class="sesproduct_cart_total" style="float: right;">
						<div>
							<span style="font-weight: bold"><?php echo $this->translate("Subtotal: ");  ?></span>
							<span><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($totalPrice,2)); ?></span>
						</div>
					</div>
				</div>
			</div>
			<?php if(@count($cart['stores'])) { ?>
        <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')): ?>
          <?php  echo $this->partial('have_coupon.tpl','ecoupon',array('id'=>$cart['stores']->getIdentity(),'params'=>json_encode(array('resource_type'=>$cart['stores']->getType(),'resource_id'=>$cart['stores']->store_id,'is_package'=>0,'item_amount'=>round($totalPrice,2))))); ?> 
        <?php endif; ?>
      <?php } ?>
		<?php } ?>
		<div class="sesbasic_cleafix">
			<a class="btn_left" href="<?php echo $this->url(array('action'=>'browse'),'sesproduct_general',true); ?>"><?php echo $this->translate("Continue Shopping"); ?></a>
			<?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sescredit')) { ?>
			<br />
			<br />
			<form method="post">
				<input type="text" value="<?php echo $creditCheckout->value; ?>" name="credit_value" onkeypress="return isNumberKey(event)">
				<button class="btn_left"><?php echo $this->translate("Apply Credit"); ?></button>
			</form>
			<?php

					if(!empty($creditSession->error)){
			?>
			<p class="credit_redeem_error"><?php echo $creditSession->error; ?></p>
			<?php } ?>

				<script type="application/javascript">
					function isNumberKey(evt){
						var charCode = (evt.which) ? evt.which : evt.keyCode;
						return !(charCode > 31 && (charCode < 48 || charCode > 57));
					}
				</script>
			<?php } ?>
			<div style="float: right;" class="sesbasic_cleafix">
				<a href="javascript:;" style="margin-right:10px;" class="btn_left" onclick="Smoothbox.open('<?php echo $this->url(array('action'=>'delete-cart'),'sesproduct_cart',true); ?>')"><?php echo $this->translate("Empty Cart"); ?></a>
				<button type="submit"><?php echo $this->translate("Update Cart"); ?></button>

			</div>
		</div>
	 </form>
		<div class="sesproduct_coupon_total">
			<div class="sesproduct_cart_total">
				<h5><?php echo $this->translate("Price Details"); ?></h5>
				<table>
					<tbody>
					<tr style="display: none;">
						<td><?php echo $this->translate("Coupon Discount"); ?></td>
						<td><?php echo $this->translate("- Rs. 1000"); ?></td>
					</tr>
					</tbody>
					<tfoot>
					<?php if(count($storeArray) > 1){ ?>
						<?php foreach($storeArray as $key=>$storePrice){ ?>
							<tr>
								<td><?php echo $this->translate("Net Amount Subtotal of %s store",$key); ?></td>
								<td><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($storePrice,2)); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>

					<?php if($creditCheckout->purchaseValue){ ?>
						<tr>
							<td><?php echo $this->translate("Credit Points Redeemed (%s)",$creditCheckout->value); ?></td>
							<td>-<?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($creditCheckout->purchaseValue,2)); ?></td>
							<?php $this->totalPrice = $this->totalPrice - $creditCheckout->purchaseValue ?>
						</tr>
					<?php } ?>

					<tr>
						<td><?php echo $this->translate("Order Total"); ?></td>
						<td><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($this->totalPrice,2)); ?></td>
					</tr>
					</tfoot>
				</table>
				<?php $setting = Engine_Api::_()->getApi('settings', 'core'); ?>
				<?php if($setting->getSetting('estore.fixedtext', null) && $setting->getSetting('estore.allow.fixedtext',0)) { ?>
				<div class="sesproduct_letushelp">
            <!--<span class="floatL">Do you have any questions?</span>
            <p><strong>Contact Us:</strong> 9898989898 </p>-->
            <?php echo $setting->getSetting('estore.fixedtext', null); ?>
        </div>
        <?php } ?>
				<a href="<?php echo $this->url(array('action'=>'checkout'),'sesproduct_cart',true); ?>" class="default_btn"><?php echo $this->translate("Proceed to Checkout"); ?></a>
			</div>
		</div>
	<?php }else{ ?>
	<div class="empty-cart-img">
		<span><img src="application/modules/Sesproduct/externals/images/empty-cart.png"><?php //echo $this->translate("You have not added any product in your cart yet."); ?></span>
	</div>
	<?php } ?>
	</div>
</div>
<?php
 //remove old session value
 $session->unsetAll();
$creditSession->unsetAll();
?>
<script type="text/javascript">
    sesJqueryObject(document).on('keydown','.quantity', function(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        return !(charCode > 31 && (charCode < 48 || charCode > 57));
    });
    sesJqueryObject(document).on('click','.priceplus', function(){
        var value = sesJqueryObject(this).parent().find('.quantity').val();
        console.log(isNaN(value));
        if(isNaN(value)){
            value = 1;
        }
        sesJqueryObject(this).parent().find('.quantity').val(++value);
    });
    sesJqueryObject(document).on('click','.priceminus', function(){
        var value = sesJqueryObject(this).parent().find('.quantity').val();
        if(!isNaN(value)) {
            if (value >= 1) {
                sesJqueryObject(this).parent().find('.quantity').val(--value);
            } else {
            }
        }else{
            sesJqueryObject(this).parent().find('.quantity').val(1);
        }
    });

</script>
