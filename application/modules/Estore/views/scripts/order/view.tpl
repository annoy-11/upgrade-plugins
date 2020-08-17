<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_estore
 * @package    estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: view.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/estore/externals/styles/styles.css'); ?>
<?php if($this->format == 'smoothbox' && empty($_GET['order'])){ ?>
<link href="<?php $this->layout()->staticBaseUrl ?>application/modules/Estore/externals/styles/print.css" rel="stylesheet" media="print" type="text/css" />
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/estore/externals/styles/print.css'); ?>
<?php } ?>
<a href="javascript:;" onclick= "javascript:parent.Smoothbox.close();" class="fa fa-close estore_orderview_popup_close"></a>
<div class="layout_middle">
  <div class="estore_ticket_order_view_page generic_layout_container layout_core_content">

    <div class="estore_order_container estore_invoice_container sesbasic_bxs sesbasic_clearfix">
      <div class="estore_invoice_header sesbasic_clearfix">
       <?php $addressTable =   Engine_Api::_()->getDbtable('orderaddresses', 'sesproduct'); ?>
        <?php $shippingAddress  = $addressTable->getAddress(array('type'=>1,'order_id'=>$this->order->order_id,'view'=>1)); ?>
        <?php $billingAddress =  $addressTable->getAddress(array('order_id'=>$this->order->order_id,'type'=>0 ,'view'=>1)); ?>
         <?php $shipping = $shippingAddress; ?>
       <?php  $billing = $billingAddress; ?>
        <div>
        <h3><?php echo $this->translate("Name & Billing Address"); ?></h3>
            <ul class="_billingdetails">
                <li style="display: block;"> <?php  echo $billing->first_name.' '.$billing->last_name; ?></li>
                <li><?php echo $billing->address; ?></li>
                  <?php if(isset($billing->country)) { ?>
                    <?php $billingCountry =   Engine_Api::_()->getItem('estore_country', $billing->country);?>
                    <li><?php echo $billingCountry->name; ?></li>
                    <li><?php echo $billingCountry->phonecode; ?></li>
                 <?php } ?>
                <?php if(isset($billing->state)) { ?>
                    <?php $billingState =   Engine_Api::_()->getItem('estore_state', $billing->state);?>
                    <li><?php echo $billingState->name; ?></li>
                <?php } ?>
                <li><?php echo $billing->city; ?></li>
                <li>Ph. <?php echo $billing->phone_number; ?></li>
                <li><?php echo $billing->email; ?></li>
            </ul>
        </div>
       <div>
        <h3><?php echo $this->translate("Name & shipping Address"); ?></h3>
            <ul class="_shippingdetails">
                <li style="display: block;"> <?php  echo $shipping->first_name.' '.$shipping->last_name; ?></li>
                <li><?php echo $shipping->address; ?></li>
                  <?php if(isset($shipping->country)) { ?>
                    <?php $shippingCountry =   Engine_Api::_()->getItem('estore_country', $shipping->country);?>
                    <li><?php echo $shippingCountry->name; ?></li>
                    <li><?php echo $shippingCountry->phonecode; ?></li>
                 <?php } ?>
                <?php if(isset($shipping->state)) { ?>
                    <?php $shippingState =   Engine_Api::_()->getItem('estore_state', $shipping->state);?>
                    <li><?php echo $shippingState->name; ?></li>
                <?php } ?>
                <li><?php echo $shipping->city; ?></li>
                <li>Ph. <?php echo $shipping->phone_number; ?></li>
                <li><?php echo $shipping->email; ?></li>
            </ul>
        </div>
        <br/>
        <div class="floatL">
         <?php echo $this->translate("Order Id:#%s",$this->order->order_id); ?>
        </div>
        <div class="floatR">
          <?php $totalAmount = $this->order->total; ?>
            <?php if($this->order->credit_value){
                $totalAmount = $totalAmount - $this->order->credit_value;
            } ?>

          [<?php echo $this->translate('Total:'); ?><?php echo $totalAmount <= 0 ? $this->translate("FREE") : Engine_Api::_()->estore()->getCurrencyPrice($totalAmount,$this->order->currency_symbol,$this->order->change_rate); ?>]
        </div>
      </div>
      <div class="estore_invoice_content_wrap sesbm sesbasic_clearfix clear">
        <div class="estore_invoice_content_left sesbm">
          <div class="estore_invoice_content_box sesbm">
            <b class="bold"><?php echo $this->translate("Store Details"); ?></b>
            <div class="estore_invoice_content_detail">
              <span><?php echo $this->htmlLink($this->store->getHref(),$this->store->getTitle()); ?></span>
            </div>
          </div>
          <div class="estore_invoice_content_box sesbm">
            <b class="bold"><?php echo $this->translate("Ordered By"); ?></b>
            <div class="estore_invoice_content_detail">
                <span><?php echo $this->htmlLink($this->viewer->getOwner()->getHref(),$this->viewer->getOwner()->getTitle()); ?></span>
            </div>
          </div>

         <div class="estore_invoice_content_box sesbm">
            <b class="bold"><?php echo $this->translate("Payment Information"); ?></b>
            <div class="estore_invoice_content_detail">
              <span><?php echo $this->translate("Payment method: %s",$this->order->gateway_type); ?></span>
              <?php if($this->order->cheque_id > 0) { ?>
                   <?php $cheque =   Engine_Api::_()->getItem('sesproduct_ordercheques', $this->order->cheque_id); ?>
                      <span><?php echo $this->translate("Cheque No : %s",$cheque->cheque_number); ?></span>
                        <span><?php echo $this->translate("Account Holder Name : %s",$cheque->name); ?></span>
                        <span><?php echo $this->translate("Account Number : %s",$cheque->account_number); ?></span>
                        <span><?php echo $this->translate("Account Routing No : %s",$cheque->routing_number); ?></span>
                  <?php } ?>
            </div>
          </div>
        </div>
        <div class="estore_invoice_content_right">
          <div class="estore_invoice_content_box sesbm">
            <b class="bold"><?php echo $this->translate("Order Information"); ?></b>
            <div class="estore_invoice_content_detail">
              <span><?php echo $this->translate("Ordered Date :"); ?> <?php echo Engine_Api::_()->sesproduct()->dateFormat($this->order->creation_date); ?></span>
               <?php $orderproduct =   Engine_Api::_()->getItem('sesproduct_orderproduct', $this->order->order_id);?>
                <?php if($this->order->total_admintax_cost > 0){ ?>
                    <span><?php echo $this->translate("Admin Tax Amount :"); ?><?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice($this->order->total_admintax_cost,$this->order->currency_symbol,$this->order->change_rate); ?></span>
                <?php } ?>
              <?php if($this->order->total_shippingtax_cost > 0){ ?>
              <span><?php echo $this->translate("Shipping Amount :"); ?> <?php echo Engine_Api::_()->sesproduct()->getCurrencyPrice($this->order->total_shippingtax_cost,$this->order->currency_symbol,$this->order->change_rate); ?></span>
              <?php } ?>
							<?php if($this->order->total_billingtax_cost > 0){ ?>
								<span><?php echo $this->translate("Store Tax Amount:"); ?>
								<?php echo $this->order->total_billingtax_cost > 0 ? Engine_Api::_()->estore()->getCurrencyPrice($this->order->total_billingtax_cost,$this->order->currency_symbol,$this->order->change_rate) : "-"; ?>
								</span>
							<?php } ?>
               <span><?php echo $this->translate("Delivery time :"); ?> <?php echo $this->order->shipping_delivery_tile; ?></span>
							 <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.displayips','1')){ ?>
                <span><?php echo $this->translate("IP Address :"); ?> <?php echo $this->order->ip_address; ?></span>
							 <?php } ?>
            </div>
          </div>
            <div class="estore_invoice_content_box sesbm">
                <b class="bold"><?php echo $this->translate("Order Status"); ?></b>
                <div class="estore_invoice_content_detail">
                    <?php echo ucwords($this->order->state); ?>
                </div>
            </div>
           </div>


        </div>
      <div class="estore_table estore_invoice_order_table">
        <h3><?php echo $this->translate("Order Details"); ?></h3>
        <div class="estore_invoice_total_price_box sesbm">
         <?php $orderedProduct =   Engine_Api::_()->getDbTable('orderproducts','sesproduct')->orderProducts(array('order_id'=>$this->order->order_id));?>
         <?php $totalTaxAmount = 0 ?>
            <?php $totalProductcost = 0 ?>
         <table>
          <thead>
            <th><?php echo $this->translate("Product"); ?></th>
            <th><?php echo $this->translate("SKU"); ?></th>
            <th><?php echo $this->translate("Price"); ?></th>
            <th><?php echo $this->translate("Quantity"); ?></th>
            <th><?php echo $this->translate("Subtotal"); ?></th>
          </thead>
          <tbody>
            <?php foreach($orderedProduct as $product) { ?>
            <tr>
              <td><?php echo $product->getTitle(); ?></td>
              <td><?php echo $product->sku; ?></td>
              <td><?php echo Engine_Api::_()->estore()->getCurrencyPrice($product->price/$product->quantity,$this->order->currency_symbol,$this->order->change_rate); ?></td>
              <td><?php echo $product->quantity; ?></td>
              <td><?php echo Engine_Api::_()->estore()->getCurrencyPrice($product->price,$this->order->currency_symbol,$this->order->change_rate); ?></td>
            </tr>
           <?php } ?>
          </tbody>
        </table>
             <?php $totalProductcost = $product->total; ?>


          <?php if($this->order->total_shippingtax_cost > 0){ ?>
          <div>
            <span><?php echo $this->translate("Shipping cost :"); ?></span>
            <span><?php echo $this->order->total_shippingtax_cost > 0 ? Engine_Api::_()->estore()->getCurrencyPrice($this->order->total_shippingtax_cost,$this->order->currency_symbol,$this->order->change_rate) : "-"; ?></span>
          </div>
          <?php } ?>
          <?php if($totalTaxAmount > 0){ ?>
          <div>
            <span><?php echo $this->translate("Total Tax :"); ?></span>
            <span><?php echo $totalTaxAmount > 0 ? Engine_Api::_()->estore()->getCurrencyPrice($totalTaxAmount,$this->order->currency_symbol,$this->order->change_rate) : "-"; ?></span>
          </div>
         <?php } ?>
            <?php $groundTotal = $totalProductcost; ?>
            <?php if($this->order->credit_value){ ?>
            <div class="estore_invoice_total_price_box_total">
                <span><?php echo $this->translate("Total :"); ?></span>
                <?php $groundTotal = $totalProductcost; ?>
                <span><?php echo $groundTotal <= 0  ? $this->translate("FREE") : Engine_Api::_()->estore()->getCurrencyPrice($groundTotal,$this->order->currency_symbol,$this->order->change_rate); ?></span>
            </div>

            <div class="estore_invoice_total_price_box_total">
                <span><?php echo $this->translate("Credit Point Redeem (%s) :",$this->order->credit_point); ?></span>
                <span>-<?php echo  Engine_Api::_()->estore()->getCurrencyPrice($this->order->credit_value,$this->order->currency_symbol,$this->order->change_rate); ?></span>
            </div>
            <?php $groundTotal = $groundTotal - $this->order->credit_value; ?>
          <?php } ?>
          <div class="estore_invoice_total_price_box_total">
            <span><?php echo $this->translate("Grand Total :"); ?></span>
            <span><?php echo $groundTotal <= 0  ? $this->translate("FREE") : Engine_Api::_()->estore()->getCurrencyPrice($groundTotal,$this->order->currency_symbol,$this->order->change_rate); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if(empty($_GET['order'])){ ?>
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
<script type="application/javascript">
sesJqueryObject(document).ready(function(e){
    window.print();
});
</script>
<?php } ?>
<style>#global_header,#global_footer{display:none}
</style>
