<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: order-review.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesproduct_checkout_body" style="display: none;">
  <?php $storeArray = array();
    $grandTotalPrice = 0;
  ?>
  <?php foreach($this->productsArray as $cart){
  $totalPrice = 0;?>
  <div class="sesproduct_store_item">
    <div class="store_wise_title">
      <a target="_blank" href="<?php echo $cart['stores']->getHref(); ?>"><h4><?php echo $cart['stores']->getTitle(); ?></h4></a>
    </div>
    <?php foreach($cart['cartproducts'] as $itemCart){
$item = Engine_Api::_()->getItem('sesproduct',$itemCart['product_id']);
    $price = $cart['products_extra'][$itemCart['cartproduct_id']]['product_price'];
    $quantity = $cart['products_extra'][$itemCart['cartproduct_id']]['quantity'];
    $totalPrice += $price;
    ?>
    <div class="sesproduct_cart_item">
      <div class="sesproduct_cart_img sesproduct_thumb">
        <a target="_blank" href="<?php echo $item->getHref(); ?>">
          <img src="<?php echo $item->getPhotoUrl('thumb.profile'); ?>" style="height: 60px;"/>
        </a>
      </div>
      <div class="sesproduct_cart_desc">
        <a target="_blank" href="<?php echo $item->getHref(); ?>"><h4><?php echo $item->getTitle(); ?></h4></a>
      </div>
      <div class="sesproduct_carti_quantity">
        <span class="bold"><?php echo $this->translate("Quantity");?>: </span>
        <span><?php echo $quantity; ?></span>
      </div>
      <?php
        if(!empty($session->cart_product_{$itemCart['cartproduct_id']})){
      ?>
      <h6 style="color: red;"><?php echo $this->translate("%s",$session->cart_product_{$itemCart['cartproduct_id']}); ?></h6>
      <?php } ?>
      <?php if(!empty($cart['products_extra'][$itemCart['cartproduct_id']]['variations'])){ ?>
        <div class="sesproduct_attributes">
          <?php foreach($cart['products_extra'][$itemCart['cartproduct_id']]['variations'] as $key=>$value){
          if($key == 'purchasePriceProduct')
          continue;
          ?>
            <div><span class="bold"><?php echo $key ?>: </span><span><?php echo $value; ?></span></div>
          <?php } ?>
        </div>
      <?php } ?>
      <div class="sesproduct_cart_action" style="margin-top:20px;display: none;">
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1)): ?>
        <a data-rel="<?php echo $item->getIdentity(); ?>" title='<?php echo $this->translate('Add to Wishlist'); ?>' href="javascript:;" class="sesproduct_wishlist"><i class="fa fa-plus"></i><?php echo $this->translate('Add to Wishlist'); ?></a>
        <?php endif; ?>
        <a href="javascript:;" title='<?php echo $this->translate("Remove"); ?>' onclick="Smoothbox.open('<?php echo $this->url(array('action'=>'delete-cart','id'=>$itemCart["cartproduct_id"]),'sesproduct_cart',true); ?>')"><i class="fa fa-close"></i><?php echo $this->translate("Remove"); ?></a>
      </div>
    <div class="sesproduct_cart_price">
      <h4>
        <?php if(!empty($price)){ ?>
        <?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($price,2)); ?>
        <?php } ?>
      </h4>
    </div>
  </div>
  <?php } ?>
  <?php $storeArray[$cart['stores']->getTitle()] = $totalPrice; ?>
  <div class="sesproduct_store_details">
      <div class="sesproduct_store_purchase_terms">
        <div>
          <?php echo $this->translate("Terms and Conditions"); ?><span style="color: red;">*</span>
        </div>
        <input type="checkbox" class="accept_term_conditions" name="termaccept_<?php echo $cart['stores']->getIdentity(); ?>">
        <?php echo $this->translate("I agree with the"); ?> <a href="<?php echo $this->url(array('action'=>'store-policy','store_id'=>$item->store_id),'estore_dashboard',true);?>" target="_blank"><?php echo $this->translate("Terms and Conditions");?></a>.
        <div class="sesproduct_order_note_cnt">
          <a href="javascript:;" class="sesproduct_order_note"><i class="sesbasic_icon_edit"></i> <?php echo $this->translate("Write a note for your order from this Store."); ?></a>
          <textarea style="display: none;" name="order_note[<?php echo $cart['stores']->getIdentity(); ?>]"></textarea>
        </div>
      </div>
      <div class="sesproduct_store_purchase_details">
        <?php $shippingPrice = 0; ?>
        <?php if(!empty($this->shippings[$cart['stores']->getIdentity()]['title'])){ ?>
        <div>
          <span><?php echo $this->shippings[$cart['stores']->getIdentity()]['title'] ?>: </span>
          <span><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($this->shippings[$cart['stores']->getIdentity()]['price'],2)); ?></span>
          <?php $shippingPrice = round($this->shippings[$cart['stores']->getIdentity()]['price'],2); ?>
        </div>
        <?php } ?>
        <?php $taxAmount = 0; ?>
        <?php if(!empty($this->store_taxes[$cart['stores']->getIdentity()])){
          foreach($this->store_taxes[$cart['stores']->getIdentity()] as $taxData){
        ?>
        <div>
          <span><?php echo $taxData['tax_title'] ?>: </span>
          <span><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($taxData['price'],2)); ?></span>
          <?php $taxAmount += round($taxData['price'],2); ?>
        </div>
        <?php } ?>
        <?php } ?>
        <?php if(!empty($this->store_admin_taxes[$cart['stores']->getIdentity()])){
        foreach($this->store_admin_taxes[$cart['stores']->getIdentity()] as $taxData){
        ?>
        <div>
          <span><?php echo $taxData['tax_title'] ?>: </span>
          <span><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($taxData['price'],2)); ?></span>
          <?php $taxAmount += round($taxData['price'],2); ?>
        </div>
        <?php } ?>
        <?php } ?>
        <div>
          <span><?php echo $this->translate("Total Products (net):"); ?> </span>
          <span><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($totalPrice,2)); ?></span>
        </div>
        <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('ecoupon')): ?>
          <?php 
            // For Coupon 
            $couponSessionCode = '-'.'-'.$cart['stores']->getType().'-'.$cart['stores']->store_id.'-0';
          ?>
          <?php if(isset($_SESSION[$couponSessionCode])) { ?> 
          <?php $totalPrice = @isset($_SESSION[$couponSessionCode]) ? round($totalPrice - $_SESSION[$couponSessionCode]['discount_amount']) : $totalPrice; ?>
            <div>
              <span><?php echo $this->translate("Coupon Applied"); ?> </span>
              <span><?php echo "-".Engine_Api::_()->sesproduct()->getCurrencyPrice(round($_SESSION[$couponSessionCode]['discount_amount'],2)); ?></span>
            </div>
          <?php } ?>
        <?php endif; ?>
        
        <div>
          <span class="bold"><?php echo $this->translate("Subtotal: ");  ?></span>
          <?php $storeTotalPrice = $totalPrice + $shippingPrice + $taxAmount;
              $grandTotalPrice += $storeTotalPrice ;
          ?>
          <span><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($storeTotalPrice,2)); ?></span>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="sesproduct_checkout_cart">
    <table>
      <tbody>
      <?php  $totalPrice = $grandTotalPrice + $adminTaxesPrice;
	$creditCheckout = new Zend_Session_Namespace('sescredit_points');
?>


      <?php if($creditCheckout->purchaseValue){ ?>
      <tr>
        <td class="bold"><?php echo $this->translate("Credit Points Redeemed (%s)",$creditCheckout->value); ?></td>
        <td class="bold">-<?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($creditCheckout->purchaseValue,2)); ?></td>
        <?php $totalPrice = $totalPrice - $creditCheckout->purchaseValue ?>
      </tr>
      <?php } ?>

      <tr>
        <td class="bold"><?php echo $this->translate("Grand Total"); ?></td>
        <td class="bold"><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice(round($totalPrice,2)); ?></td>
      </tr>
      </tbody>
    </table>
  </div>
  <div class="submit">
    <a href="javascript:;" class="back_check">
      <i class="fa fa-angle-left"></i>&nbsp;
      <span><span><?php echo $this->translate('Back'); ?></span>
    </a>
    <img src="application/modules/Core/externals/images/loading.gif" style="display: none;" class="sesproduct_place_order_loading">
    <a href="javascript:;" class="info_btn sesproduct_place_order"><span><?php echo $this->translate('Place Order'); ?></a>
  </div>
<?php die; ?>
