<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CartController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_CartController extends Core_Controller_Action_Standard
{
    function checkOrderProducts($checkout = false){
        $cartId = Engine_Api::_()->sesproduct()->getCartId();
        $productTable = Engine_Api::_()->getDbTable('cartproducts','sesproduct');
        $select = $productTable->select()->where('cart_id =?',$cartId->getIdentity());
        $products = $productTable->fetchAll($select);
        $error = false;
        if(!count($products) && $checkout)
            return $this->_helper->redirector->gotoRoute(array( 'action' => 'index'), 'sesproduct_cart', true);

        if(count($products)){
            $session = new Zend_Session_Namespace('sesproduct_product_quantity');
            $session->unsetAll();
            foreach ($products as $cartProduct){
                $id = $cartProduct->getIdentity();
                $quantity = $cartProduct->quantity;
                $product = Engine_Api::_()->getItem('sesproduct',$cartProduct->product_id);
                 $productAvailableQuantity = Engine_Api::_()->sesproduct()->checkVariations($cartProduct,true);
                if($product && $product->type == "configurableProduct" && !empty($productAvailableQuantity)) {
                    if ($quantity > $productAvailableQuantity['quantity']) {
                        if($productAvailableQuantity['quantity'] == 0){
                            $session->cart_product_{$id} = $this->view->translate("This product out of stock, Please remove from your cart.");
                        }else if($cartProduct->quantity == $productAvailableQuantity['quantity'] ||  $productAvailableQuantity['quantity'] - $cartProduct->quantity < 0){
                            $session->cart_product_{$id} = $this->view->translate("No more quantity available for this product.");
                        }else {
                            $session->cart_product_{$id} = $this->view->translate("Only %s quantity left for this product.", $productAvailableQuantity);
                        }
                    } else {
                        $cartProduct->quantity = $quantity;
                        $cartProduct->save();
                    }
                }else{
                    if(!empty($product->manage_stock)){
                        if($product->max_quatity < $quantity) {
                            $session->cart_product_{$id} = $this->view->translate("Only %s quantities of this product are available in stock. Please enter the quantity less than or equal to %s", $product->max_quatity,$product->max_quatity);
                             return $error = true;
                        }
                        $cartProduct->quantity = $quantity;
                        $cartProduct->save();
                    }else{
                        $cartProduct->quantity = $quantity;
                        $cartProduct->save();
                    }
                }
            }
        }


        $sessionCredit = new Zend_Session_Namespace('sescredit_points');
        if($sessionCredit->value){
            $value = $sessionCredit->value;
            $cartTotalPrice = Engine_Api::_()->sesproduct()->cartTotalPrice();
            $cartTotalPrice = $cartTotalPrice['totalPrice'];
            if($cartTotalPrice > 0){
                $response = Engine_Api::_()->sescredit()->validateCreditPurchase('estore',$cartTotalPrice,$value);
                if($response['status']){
                    $sessionCredit->value = $value;
                    //get purchase value of redeem points
                    $creditvalue = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescredit.creditvalue',0);
                    if($creditvalue){
                        $purchaseValueOfPoints = (1/$creditvalue) * $value;
                        $sessionCredit->purchaseValue = $purchaseValueOfPoints;
                    }else{
                        $sessionCredit->unsetAll();
                        $error = true;
                    }
                }else{
                    $sessionCredit->unsetAll();
                    $error = true;
                }
            }
        }

        return $error;
    }
    function placeOrderAction(){
        $error = $this->checkOrderProducts();
        if($error){
            echo "return_to_cart";die;
        }
        //shipping method details
        $formType = $this->_getParam('order',0);
        $viewer = $this->view->viewer();
        $viewer_id = $viewer->getIdentity();
        $shippingValues = $this->_getParam('shippingAddress','');
        $billingValues = $this->_getParam('billingAddress','');
        $sameBilling = $this->_getParam('checkbox',0);
        parse_str($billingValues, $billingValue);
        $credit_value = 0;
        $shippingValue = array();
        if(!$sameBilling){
            parse_str($shippingValues, $shippingValue);
            foreach ($shippingValue as $key=>$value){
                $shippingOrgValue[str_replace('shipping_','',$key)] = $value;
            }
        }else{
            $shippingOrgValue = $billingValue;
        }

        if($formType == 1){
            //shipping
            $shippingCountryId = $billingCountryId = $billingStateId = $shippingStateId = 0;
            $addressTable = Engine_Api::_()->getDbTable('addresses','sesproduct');
            if(!empty($viewer_id)){
                $billingAddress = $addressTable->getAddress(array('user_id'=>$viewer_id,'type'=>0));
                if(count($billingAddress)){
                    $billing = $billingAddress[0];
                    $billingValue['user_id'] = $viewer_id;
                    $billingValue['type'] = 0;
                    $billing->setFromArray($billingValue);
                }else{
                    $billing = $addressTable->createRow();
                    $billingValue['user_id'] = $viewer_id;
                    $billingValue['type'] = 0;
                    $billing->setFromArray($billingValue);
                }
                $billingCountryId = $billing->country;
                $billingStateId = $billing->state;
                $billing->save();
                if($sameBilling){
                    //same shipping address
                    $shipingAddress = $addressTable->getAddress(array('user_id'=>$viewer_id,'type'=>1));
                    if(count($shipingAddress)){
                        $shiping = $shipingAddress[0];
                        $billingValue['user_id'] = $viewer_id;
                        $billingValue['type'] = 1;
                        $shiping->setFromArray($billingValue);
                    }else{
                        $shiping = $addressTable->createRow();
                        $billingValue['user_id'] = $viewer_id;
                        $billingValue['type'] = 1;
                        $shiping->setFromArray($billingValue);
                    }
                    $shiping->save();
                    $shippingCountryId = $shiping->country;
                    $shippingStateId = $shiping->state;
                }else{
                    //same shipping address
                    $shipingAddress = $addressTable->getAddress(array('user_id'=>$viewer_id,'type'=>1));
                    $shippingValueArray = array();
                    foreach ($shippingValue as $key=>$value){
                        $shippingValueArray[str_replace('shipping_','',$key)] = $value;
                    }
                    if(count($shipingAddress)){
                        $shiping = $shipingAddress[0];
                        $shippingValueArray['user_id'] = $viewer_id;
                        $shippingValueArray['type'] = 1;
                        $shiping->setFromArray($shippingValueArray);
                    }else{
                        $shiping = $addressTable->createRow();
                        $shippingValueArray['user_id'] = $viewer_id;
                        $shippingValueArray['type'] = 1;
                        $shiping->setFromArray($shippingValueArray);
                    }
                    $shiping->save();
                    $shippingCountryId = $shiping->country;
                    $shippingStateId = $shiping->state;
                }
            }
        }else if($formType == 2){
            //payment methods
            $shipping = $this->_getParam('shipping','');
            parse_str($shipping, $shippingArray);
            $paymentGateways = Engine_Api::_()->sesproduct()->checkPaymentGatewayEnable();
            if(!empty($paymentGateways['noPaymentGatewayEnableByAdmin'])){
                $this->view->noPaymentGatewayEnableByAdmin = true;
            }
            $this->view->paymentMethods = $paymentGateways['methods'];
            $this->view->paypal = $paymentGateways['paypal'];
            $this->view->checkDetails = $paymentGateways['check_details'];
        }

        //all store from cart products
        $cartId = Engine_Api::_()->sesproduct()->getCartId();
        $stores = Engine_Api::_()->sesproduct()->getCartProductStores($cartId->getIdentity());
        $cartData = Engine_Api::_()->sesproduct()->cartTotalPrice();
        //shipping methods
        if(empty($shippingCountryId) && !empty($viewer_id)){
            $shippingAddress = Engine_Api::_()->getDbTable('addresses','sesproduct')->getAddress(array('type'=>1,'user_id'=>$viewer_id));
            if(count($shippingAddress)){
                $shippingCountryId = $shippingAddress[0]['country'];
                $shippingStateId = $shippingAddress[0]['state'];
            }
        }

        if(!$viewer_id && count($shippingOrgValue)){
            $shippingCountryId = $shippingOrgValue['country'];
            $shippingStateId = $shippingOrgValue['state'];
        }

        $storesShippingMethods = array();
        foreach ($stores as $store){
            $params['store_id'] = $store->getIdentity();
            $params['country_id'] = $shippingCountryId;
            $params['state_id'] = $shippingStateId;
            $products = Engine_Api::_()->sesproduct()->getCartProducts($params['store_id']);
            $storesShippingMethods[$store->getIdentity()]['store_title'] = $store->getTitle();
            $storesShippingMethods[$store->getIdentity()]['shipping_methods'] = array();
            if(count($products)){
                $product_count = 0;
                $product_price = 0;
                $total_weight = 0;
                foreach($products as $product){
                    $product_count += $product->quantity;
                    $item = Engine_Api::_()->getItem('sesproduct',$product->product_id);
                    $price = Engine_Api::_()->sesproduct()->productDiscountPrice($item);
                    $product_price += $product->quantity*$price;
                    $total_weight += $product->quantity*$item->weight;
                }
                $params['total_quantity'] = $product_count;
                $params['total_price'] = round($product_price,2);
                $params['total_weight'] = $total_weight;
                $shippingMethods = Engine_Api::_()->getDbTable('shippingmethods','estore')->getCartProductShippingMethods($params);
                if(count($shippingMethods)){
                    $storesShippingMethods[$store->getIdentity()]['shipping_methods'] = $shippingMethods;
                }
            }
        }
        $this->view->shippingMethods = $storesShippingMethods;
        if($formType == 1){
            $this->renderScript('cart/shipping-method.tpl');
            return;
        }

        if(!empty($viewer_id)) {
            //get user shipping and billing address taxes
            $params = array();
            $billingAddress = Engine_Api::_()->getDbTable('addresses', 'sesproduct')->getAddress(array('user_id' => $viewer_id, 'type' => 0));
            $shippingAddress = Engine_Api::_()->getDbTable('addresses', 'sesproduct')->getAddress(array('user_id' => $viewer_id, 'type' => 1));
            if (count($billingAddress)) {
                $params['user_billing_country'] = $billingAddress[0]['country'];
                $params['user_billing_state'] = $billingAddress[0]['state'];
            }
            if (count($shippingAddress)) {
                $params['user_shipping_country'] = $shippingAddress[0]['country'];
                $params['user_shipping_state'] = $shippingAddress[0]['state'];
            }
        }else{
            $params['user_billing_country'] = $billingValue['country'];
            $params['user_billing_state'] = $billingValue['state'];;
            $params['user_shipping_country'] = $shippingOrgValue['country'];;
            $params['user_shipping_state'] = $shippingOrgValue['state'];;
        }

        //get store product total prices
        $store_price = array();
        foreach($cartData['productsArray'] as $cart){
            foreach($cart['cartproducts'] as $itemCart){
                $store_price[$cart['stores']->getIdentity()] += $cart['products_extra'][$itemCart['cartproduct_id']]['product_price'];
            }
        }
        $totalTaxPrice = 0;
        $store_taxes = array();
        foreach ($stores as $store){
            $params['store_id'] = $store->getIdentity();
            $params['total_price'] = $store_price[$store->getIdentity()];
            $taxes = Engine_Api::_()->getDbTable('taxstates','estore')->getOrderTaxes($params);
            $store_taxes[$store->getIdentity()] = $taxes['taxes'];
            $totalTaxPrice += $taxes['total_tax'];
        }

        //get admin taxes
        $totalAdminTaxPrice = 0;
        $store_admin_taxes = array();

        foreach ($stores as $store){
            $params['store_id'] = $store->getIdentity();
            $params['total_price'] = $store_price[$store->getIdentity()];
            $taxes = Engine_Api::_()->getDbTable('taxstates','estore')->getOrderAdminTaxes($params);
            $store_admin_taxes[$store->getIdentity()] = $taxes['taxes'];
            $totalAdminTaxPrice += $taxes['total_tax'];
        }


        if ($formType == 2){
            $storeArray = true;
            $addShippingPrice = 0;
            $removedProductOfStore = array();
            if(!empty($_POST['no_shipping'])){
                $no_shipping = trim($_POST['no_shipping'],',');
                $removedProductOfStore = explode(',',$no_shipping);
            }
            foreach($shippingArray as $key=>$shippingMethodId){
                $store_id = str_replace('shipping_method_','',$key);
                if(!empty($storesShippingMethods[$store_id])){
                    foreach ($storesShippingMethods[$store_id]['shipping_methods'] as $shippingMethod){
                        if($shippingMethod['shippingmethod_id'] == $shippingMethodId){
                            $addShippingPrice += $shippingMethod['price'];
                        }
                    }
                }
            }
            if(count($removedProductOfStore)) {
                $db = Zend_Db_Table_Abstract::getDefaultAdapter();
                $db->query("DELETE FROM engine4_sesproduct_cartproducts WHERE cart_id = " . $cartId->getIdentity() . ' AND product_id IN (SELECT product_id FROM engine4_sesproduct_products WHERE store_id IN (' . implode(',', $removedProductOfStore) . '))');
                $cartId = Engine_Api::_()->sesproduct()->getCartId();
                $productTable = Engine_Api::_()->getDbTable('cartproducts','sesproduct');
                $select = $productTable->select()->where('cart_id =?',$cartId->getIdentity());
                $products = $productTable->fetchAll($select);
                if(!count($products)){
                    echo "return_to_cart";die;
                }
            }
            $this->view->totalPrice = round($cartData['totalPrice'] + $addShippingPrice + $totalTaxPrice + $totalAdminTaxPrice,2);
            $this->renderScript('cart/payment-methods.tpl');
        }
        if ($formType == 3){
            $this->view->productsArray = $cartData['productsArray'];
            $this->view->totalPrice = round($cartData['totalPrice'],2);
            //shipping details
            $shipping = $this->_getParam('shipping','');
            parse_str($shipping, $shippingArray);
            foreach($shippingArray as $key=>$shippingMethodId){
                $store_id = str_replace('shipping_method_','',$key);
                if(!empty($storesShippingMethods[$store_id])){
                    foreach ($storesShippingMethods[$store_id]['shipping_methods'] as $shippingMethod){
                        if($shippingMethod['shippingmethod_id'] == $shippingMethodId){
                            $shippingMethodsArray[$store_id] = $shippingMethod;
                        }
                    }
                }
            }
            $this->view->shippings = $shippingMethodsArray;
            $this->view->store_taxes = $store_taxes;
            $this->view->store_admin_taxes = $store_admin_taxes;
            $this->renderScript('cart/order-review.tpl');
        }

        //all good now save the order and send user to respective gateway

        //create order
        $orderArray['ip_address'] = $_SERVER["REMOTE_ADDR"];

        if($_POST['payment_type'] == "cod"){
            //cash on delivery
            $orderArray['gateway_id'] = 21;
            $orderArray['gateway_type'] = "Cash On Delivery";
        }else if ($_POST['payment_type'] == "cheque"){
            //check
            $orderArray['gateway_id'] = 20;
            $orderArray['gateway_type'] = "cheque";
            $checkOrder = Engine_Api::_()->getDbTable('ordercheques','sesproduct')->createRow();
            $checkOrder->cheque_number = $_POST['check_number'];
            $checkOrder->name = $_POST['account_name'];
            $checkOrder->account_number = $_POST['account_number'];
            $checkOrder->routing_number = $_POST['bank_routing_number'];
            $checkOrder->save();
            $orderArray['cheque_id'] = $checkOrder->getIdentity();

        }else if($_POST['payment_type'] == "stripe"){
            $table = Engine_Api::_()->getDbTable('gateways','payment');
            $select = $table->select()->where('plugin =?','Sesadvpmnt_Plugin_Gateway_Stripe')->where('enabled =?',1);
            $stripe = $table->fetchRow($select);
            $orderArray['gateway_id'] = $stripe->getIdentity();
            $orderArray['gateway_type'] = "Stripe";
        }else if($_POST['payment_type'] == "paytm"){
            $table = Engine_Api::_()->getDbTable('gateways','payment');
            $select = $table->select()->where('plugin =?','Epaytm_Plugin_Gateway_Paytm')->where('enabled =?',1);
            $stripe = $table->fetchRow($select);
            $orderArray['gateway_id'] = $stripe->getIdentity();
            $orderArray['gateway_type'] = "Paytm";
        } else {
            //paypal
            $table = Engine_Api::_()->getDbTable('gateways','payment');
            $select = $table->select()->where('plugin =?','Payment_Plugin_Gateway_PayPal')->where('enabled =?',1);
            $paypal = $table->fetchRow($select);
            $orderArray['gateway_id'] = $paypal->getIdentity();
            $orderArray['gateway_type'] = "Paypal";
        }
        $orderArray['creation_date'] = date('Y-m-d H:i:s');
        $orderArray['modified_date'] = date('Y-m-d H:i:s');
        $orderArray['user_id'] = $this->view->viewer()->getIdentity();
        if(!empty($checkOrder)){
            $orderArray['cheque_id'] = $checkOrder->getIdentity();
        }

        $productTable = Engine_Api::_()->getDbTable('orderproducts','sesproduct');
        $orderaddressTable = Engine_Api::_()->getDbTable('orderaddresses','sesproduct');
        $orderTable = Engine_Api::_()->getDbTable('orders','sesproduct');
        $parent_order_id = 0;

        $sessionCredit = new Zend_Session_Namespace('sescredit_points');
        if($sessionCredit->value) {
            //points redeem from credit plugin
            $credit_point = $sessionCredit->value;
            $credit_value = $sessionCredit->purchaseValue;
            $totalStore = count($stores);
            $creditPoint = $credit_point/$totalStore;
            $creditValue = $credit_value/$totalStore;
            $sessionCredit->unsetAll();
        }

        foreach($stores as $store){
            $order = $orderTable->createRow();
            $shippingMethod = !empty($_POST['shipping_method_'.$store->getIdentity()]) ? $_POST['shipping_method_'.$store->getIdentity()] : 0;
            $orderParams = $orderArray;
            $orderParams['store_id'] = $store->getIdentity();
            if($orderArray['gateway_id'] == 21 || $orderArray['gateway_id'] == 20){
                $orderParams['state'] = "processing";
            }else {
                $orderParams['state'] = 'initial';
            }
            $orderParams['order_note'] = !empty($_POST['order_note'][$store->getIdentity()]) ? $_POST['order_note'][$store->getIdentity()] : 0;
            $currentCurrency = Engine_Api::_()->estore()->getCurrentCurrency();
            $defaultCurrency = Engine_Api::_()->estore()->defaultCurrency();
            $settings = Engine_Api::_()->getApi('settings', 'core');
            $currencyValue = 1;
            if($currentCurrency != $defaultCurrency){
                $currencyValue = $settings->getSetting('sesmultiplecurrency.'.$currentCurrency);
            }
            $orderParams['currency_symbol'] = Engine_Api::_()->estore()->getCurrentCurrency();
            $orderParams['change_rate'] = $currencyValue;
            $products = Engine_Api::_()->sesproduct()->getCartProducts($store['store_id']);
            $orderTotalPrice = $store_price[$store->getIdentity()];
            
             // For Coupon 
            $couponSessionCode = '-'.'-'.$store->getType().'-'.$store->store_id.'-0';
            $orderTotalPrice = @isset($_SESSION[$couponSessionCode]) ? round($orderTotalPrice - $_SESSION[$couponSessionCode]['discount_amount']) : $orderTotalPrice;
            
            $order->setFromArray($orderParams);
            $order->save();
            if(empty($parent_order_id)){
                $parent_order_id = $order->getIdentity();
            }
            if($creditPoint) {
                $order->credit_point = $creditPoint;
                $order->credit_value = $creditValue;
                $order->save();
            }

            $orderParams['parent_order_id'] = $parent_order_id;
            $totalItemCount = 0;
            //insert order  billing address
            if(!empty($viewer_id)) {
                $orderAddressItem = $orderaddressTable->createRow();
                $billingArray['user_id'] = $billingAddress[0]['user_id'];
                $billingArray['type'] = $billingAddress[0]['type'];
                $billingArray['first_name'] = $billingAddress[0]['first_name'];
                $billingArray['last_name'] = $billingAddress[0]['last_name'];
                $billingArray['email'] = $billingAddress[0]['email'];
                $billingArray['phone_number'] = $billingAddress[0]['phone_number'];
                $billingArray['address'] = $billingAddress[0]['address'];
                $billingArray['country'] = $billingAddress[0]['country'];
                $billingArray['state'] = $billingAddress[0]['state'];
                $billingArray['city'] = $billingAddress[0]['city'];
                $billingArray['order_id'] = $order->getIdentity();
                $orderAddressItem->setFromArray($billingArray);
                $orderAddressItem->save();
                //insert order shipping address
                $shippingItemArray = $orderaddressTable->createRow();
                $shippingArray['user_id'] = $shippingAddress[0]['user_id'];
                $shippingArray['type'] = $shippingAddress[0]['type'];
                $shippingArray['first_name'] = $shippingAddress[0]['first_name'];
                $shippingArray['last_name'] = $shippingAddress[0]['last_name'];
                $shippingArray['email'] = $shippingAddress[0]['email'];
                $shippingArray['phone_number'] = $shippingAddress[0]['phone_number'];
                $shippingArray['address'] = $shippingAddress[0]['address'];
                $shippingArray['country'] = $shippingAddress[0]['country'];
                $shippingArray['state'] = $shippingAddress[0]['state'];
                $shippingArray['city'] = $shippingAddress[0]['city'];
                $shippingArray['order_id'] = $order->getIdentity();
                $shippingItemArray->setFromArray($shippingArray);
                $shippingItemArray->save();
            }else{
                $orderAddressItem = $orderaddressTable->createRow();
                $orderAddressItem->setFromArray($billingValue);
                $orderAddressItem->save();
                $shippingItemArray = $orderaddressTable->createRow();
                $shippingItemArray->setFromArray($shippingOrgValue);
                $shippingItemArray->save();
            }
            //shipping code
            $shipping = $this->_getParam('shipping_method_'.$store->getIdentity());
            if($shipping){
                if(!empty($storesShippingMethods[$store->getIdentity()])){
                    foreach ($storesShippingMethods[$store->getIdentity()]['shipping_methods'] as $shippingMethod){
                        if($shippingMethod['shippingmethod_id'] == $shipping){
                            $shippingItem = $shippingMethod;
                        }
                    }
                }
            }
            if(!empty($shippingItem)){
                $orderParams['shipping_taxes'] = $shippingItem['title'];
                $orderParams['total_shippingtax_cost'] = $shippingItem['price'];
                $orderParams['shipping_delivery_tile'] = $shippingItem['delivery_time'];
                $orderTotalPrice += $shippingItem['price'];
            }
            //billing tax
            $billingAddressArray = array();
            $counter = 0;
            $billingCostPrice = 0;
            if(!empty($store_taxes[$store->getIdentity()])){
                foreach($store_taxes[$store->getIdentity()] as $billingItem) {
                    $billingAddressArray[$counter]['title'] = $billingItem['title'];
                    $billingAddressArray[$counter]['price'] = $billingItem['price'];
                    $billingCostPrice += $billingItem['price'];
                    $orderTotalPrice += $billingItem['price'];
                }
                $orderParams['billing_taxes'] = serialize($billingAddressArray);
                $orderParams["total_billingtax_cost"] = $billingCostPrice;
            }
            //admin tax
            $adminAddressArray = array();
            $counter = 0;
            $adminTaxCostPrice = 0;
            if(!empty($store_admin_taxes[$store->getIdentity()])){
                foreach($store_admin_taxes[$store->getIdentity()] as $adminTaxItem) {
                    $adminAddressArray[$counter]['title'] = $adminTaxItem['title'];
                    $adminAddressArray[$counter]['price'] = $adminTaxItem['price'];
                    $adminTaxCostPrice += $adminTaxItem['price'];
                    $orderTotalPrice += $adminTaxItem['price'];
                }
                $orderParams['admin_taxes'] = serialize($adminAddressArray);
                $orderParams["total_admintax_cost"] = $adminTaxCostPrice;
            }
            $variations = array();

            foreach($products as $cartproduct){
                $product = Engine_Api::_()->getItem('sesproduct',$cartproduct->product_id);
                if(!$product){
                    continue;
                }
                $extraParams = array();
                $orderproduct = $productTable->createRow();
                $orderProductArray['user_id'] = $viewer_id;
                $orderProductArray['store_id'] = $store->getIdentity();
                $orderProductArray['product_id'] = $product->getIdentity();
                $orderProductArray['title'] = $product->getTitle();
                $orderProductArray['sku'] = $product->sku;

                if(!empty($cartData['productsArray'][$store->getIdentity()]['products_extra'][$cartproduct['cartproduct_id']]['product_price'])){
                    $orderProductArray['price'] = $cartData['productsArray'][$store->getIdentity()]['products_extra'][$cartproduct['cartproduct_id']]['product_price'];
                }else {
                    $orderProductArray['price'] = Engine_Api::_()->sesproduct()->productDiscountPrice($product);
                }
                $orderProductArray['quantity'] = $cartproduct->quantity;
                $orderProductArray['order_id'] = $order->getIdentity();
                if(!empty($cartData['productsArray'][$store->getIdentity()]['products_extra'][$cartproduct['cartproduct_id']]['variations'])){
                    $variationArray = array();
                    $variationData = $cartData['productsArray'][$store->getIdentity()]['products_extra'][$cartproduct['cartproduct_id']]['variations'];
                    foreach ($variationData as $key=>$value){
                        if($key == 'purchasePriceProduct')
                            continue;
                        $variationArray[$key] = $value;
                    }
                    $extraParams['variation'] = ($variationArray);
                }

                $productVariation = Engine_Api::_()->sesproduct()->checkVariations($cartproduct,true);
                if(!empty($productVariation)) {
                    $variations[$product->getIdentity()]['combination_id'] = $productVariation['combination_id'];
                    $variations[$product->getIdentity()]['quantity'] = $cartproduct->quantity;
                    $extraParams['combination_ids'] = $variations;
                }
                $orderProductArray['params'] = serialize($extraParams);
                $orderProductArray['creation_date'] = date('Y-m-d H:i:s');
                $orderProductArray['modified_date'] = date('Y-m-d H:i:s');
                $orderproduct->setFromArray($orderProductArray);
                $orderproduct->save();
                $totalItemCount++;
            }
            if($credit_value) {
              $orderParams['total'] = $orderTotalPrice - $credit_value;
            } else {
              $orderParams['total'] = $orderTotalPrice;
            }
            $orderParams['item_count'] = $totalItemCount;
            $order->setFromArray($orderParams);
            $order->save();
        }
        if($orderArray['gateway_type'] == "Stripe") {
            echo json_encode(array('url'=>$this->view->url(array('module'=>'sesadvpmnt','controller'=>'payment','action'=>'index','order_id'=>$parent_order_id,'gateway_id'=>$orderArray['gateway_id'],'type'=>'product'),'default',true)));die;
        } else if($orderArray['gateway_type'] == 'Paytm'){
          echo json_encode(array('url'=>$this->view->url(array('module' => 'epaytm', 'controller' => 'payment', 'action' => 'index','order_id'=>$parent_order_id,'type'=>'product','gateway_id'=>$orderArray['gateway_id']),'default',true)));die;
        } else {
            echo json_encode(array('url'=>$this->view->url(array('module'=>'sesproduct','controller'=>'payment','action'=>'index','order_id'=>$parent_order_id,'gateway_id'=>$orderArray['gateway_id']),'default',true)));die;
        }
    }
    function getStateAction(){
        $country_id = $this->_getParam('country_id');
        $selectedState = $this->_getParam('selected',0);
        if(!$country_id)
        {
            echo "";die;
        }

        $states = Engine_Api::_()->getDbTable('states','estore')->getStates(array('country_id'=>$country_id));
        $statesString = "<option value=''>".$this->view->translate("Select State")."</option>";
        foreach($states as $state){
            $selected = "";
            if($selectedState == $state['state_id']){
                $selected = "selected='selected'";
            }
            $statesString .= "<option value='".$state['state_id']."' ".$selected.">".$state['name'].'</option>';
        }
        echo $statesString;die;
    }
    function checkoutAction(){
        //check products availability in cart
        $error = $this->checkOrderProducts(true);
        if($error)
            return $this->_helper->redirector->gotoRoute(array( 'action' => 'index'), 'sesproduct_cart', true);

        $this->_helper->content->setEnabled();
    }
  function indexAction(){
      $this->checkOrderProducts();
      $this->_helper->content->setEnabled();
      //update cart values
      $sessionCredit = new Zend_Session_Namespace('sescredit_points');
      $session = new Zend_Session_Namespace('sesproduct_product_quantity');
      //$session->unsetAll();
      if(count($_POST)){
          $sessionCredit->unsetAll();
          foreach ($_POST as $key=>$quantity){
            $id = str_replace('quantity_','',$key);
            if($id){
                $cartProduct = Engine_Api::_()->getItem('sesproduct_cartproducts',$id);
                if($cartProduct){
                    $product = Engine_Api::_()->getItem('sesproduct',$cartProduct->product_id);
                    $productAvailableQuantity = Engine_Api::_()->sesproduct()->checkVariations($cartProduct,true);
                    if($product && $product->type == "configurableProduct" && !empty($productAvailableQuantity)) {
                        //Check Product Order quantity And add product to cart
                        if ($quantity > $productAvailableQuantity['quantity']) {
                            if($cartProduct->quantity == $productAvailableQuantity['quantity'] ||  $productAvailableQuantity['quantity'] - $cartProduct->quantity < 0){
                                $session->cart_product_{$id} = $this->view->translate("No more quantity available for this product.");
                            }else {
                                $session->cart_product_{$id} = $this->view->translate("Only %s quantity left for this product.", $productAvailableQuantity);
                            }
                        } else {
                            $cartProduct->quantity = $quantity;
                            $cartProduct->save();
                        }
                    }else{
                        if(!empty($product->manage_stock)){
                            if((!empty($product->manage_stock) && $product->stock_quatity < $product->min_quantity) || $product->max_quatity < $quantity){
                                if ($product->stock_quatity == 1)
                                    $session->cart_product_{$id} = $this->view->translate("Only 1 quantity of this product is available in stock.");
                                else if($product->max_quatity < $quantity)
                                    $session->cart_product_{$id} = $this->view->translate("Only %s quantities of this product are available in stock. Please enter the quantity less than or equal to %s", $product->max_quatity,$product->max_quatity);
                                else
                                    $session->cart_product_{$id} = $this->view->translate("Only %s quantities of this product are available in stock. Please enter the quantity less than or equal to %s.", $product->stock_quatity, $product->stock_quatity);
                                return;
                            }
                            $cartProduct->quantity = $quantity;
                            $cartProduct->save();
                        }else{
                            $cartProduct->quantity = $quantity;
                            $cartProduct->save();
                        }
                    }
                }
            }
          }

          if(!empty($_POST['credit_value'])){
              $value = $_POST['credit_value'];
              $cartTotalPrice = Engine_Api::_()->sesproduct()->cartTotalPrice();
              $cartTotalPrice = $cartTotalPrice['totalPrice'];
              if($cartTotalPrice > 0){
                    $response = Engine_Api::_()->sescredit()->validateCreditPurchase('estore',$cartTotalPrice,$value);
                    if($response['status']){
                        $sessionCredit->value = $value;
                        //get purchase value of redeem points
                        $creditvalue = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescredit.creditvalue',0);
                        if($creditvalue){
                            $purchaseValueOfPoints = (1/$creditvalue) * $value;
                            $sessionCredit->purchaseValue = $purchaseValueOfPoints;
                        }
                    }
              }
          }
      }
  }
  function viewAction(){

   $cartId = Engine_Api::_()->sesproduct()->getCartId();
    $productTable = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct');
    $this->view->isAdded = $isAdded = Engine_Api::_()->getDbTable('cartproducts','sesproduct')->checkproductadded(array('cart_id'=>$cartId->getIdentity(),'limit'=>true));
    $this->view->is_Ajax_Delete = $is_Ajax_Delete =  $this->_getParam('is_Ajax_Delete',null);

    if($this->_getParam('isAjax')){
        $id = $this->_getParam('id');
        $cartProductTable = Engine_Api::_()->getDbTable('cartproducts','sesproduct');
        $db = $cartProductTable->getAdapter();
        $db->beginTransaction();
        try {
            $cartId = Engine_Api::_()->sesproduct()->getCartId();
            if($id) {
                $cartProductTable->delete(array('cartproduct_id =?' => $id, 'cart_id =?' => $cartId->getIdentity()));
                Engine_Api::_()->getDbtable('cartproductsvalues', 'sesproduct')->delete(array('item_id = ?' => $id));
                Engine_Api::_()->getDbtable('cartproductssearch', 'sesproduct')->delete(array('item_id = ?' => $id));
            }else if($is_Ajax_Delete){
                $cartProductTable = Engine_Api::_()->getDbTable('cartproducts','sesproduct');
                $select = $cartProductTable->select()->where('cart_id =?',$cartId->getIdentity());
                $products = $cartProductTable->fetchAll($select);
                foreach ($products as $product) {
                    Engine_Api::_()->getDbtable('cartproductsvalues', 'sesproduct')->delete(array('item_id = ?' => $product->getIdentity()));
                    Engine_Api::_()->getDbtable('cartproductssearch', 'sesproduct')->delete(array('item_id = ?' => $product->getIdentity()));
                    $product->delete();
                }
            }
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
    $this->view->cartData = $cartData = Engine_Api::_()->sesproduct()->cartTotalPrice();
    $this->view->productsArray = $cartData['productsArray'];
    $this->view->totalPrice = round($cartData['totalPrice'],2);

  }

  function productVariationAction(){
      $field_id = $this->_getParam('field_id');
      $product_id = $this->_getParam('product_id');
      $next_field_id = $this->_getParam('next_field_id');
      $option_id = $this->_getParam('option_id');
      $previousSelectIds = trim($this->_getParam('previousSelectIds',''),',');
      if(!$field_id || !$product_id || !$next_field_id || !$option_id){
          echo "";die;
      }
      if(!$this->getRequest()->isPost())
      {
          echo "";die;
      }

      $product = Engine_Api::_()->getItem('sesproduct',$this->_getParam('product_id'));
      $params['product_id'] = $product_id;
      $params['field_id'] = $field_id;
      $params['next_field_id'] = $next_field_id;
      $params['option_id'] = $option_id;
      $params['previousSelectIds'] = $previousSelectIds.','.$option_id;
      $params['option_id_conditions'] = "";

      $option_ids = trim( $params['previousSelectIds'],',');

      $optionString = "";
      foreach (explode(',',$option_ids) as $id){
          $optionString .= "FIND_IN_SET($id,options) AND ";
      }
      $params['option_id_conditions'] = trim($optionString,'AND ');
      $variations = Engine_Api::_()->sesproduct()->getVariationSelectedOptions($product,$params);
      if(empty($variations[$next_field_id])){
         echo "";die;
      }
      $string = "";
      $options = $variations[$next_field_id]["multioptions"];
      foreach ($options as $key=>$option)
          $string .= "<option value='".$key."'>".$option."</option>";
      echo $string;die;
  }
  function addtocartConfigurationProductAction()
  {
      $product = Engine_Api::_()->getItem('sesproduct', $this->_getParam('product_id'));
      $form = new Sesproduct_Form_Customform(array('cartProduct' => $product));
      $form->populate($_POST);
      $formValues = $form->getValues();
      $formValues = $formValues['addtocart'];
      $quantity = !empty($_POST['quantity']) ? $_POST['quantity'] : 1;
      if (!$this->getRequest()->isPost())
          return;
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      if ($this->getRequest()->isPost() && ($form->isValid($_POST))) {
          try {
              //insert item in cart
              $selectedVariation = array();
              unset($_POST['product_id']);
              foreach ($_POST as $key=>$select_id) {
                  $parts = explode('_', $key);
                  if (count($parts) == 2) {
                      if(!empty($select_id)) {
                          //check selected variation availability
                          $selectedVariation[] = $select_id;
                      }
                  }
              }

              if(count($selectedVariation)){
                  $db = Zend_Db_Table_Abstract::getDefaultAdapter();
                  $combinationMapTable = Engine_Api::_()->getDbTable('combinationmaps','sesproduct');
                  $combinationMapTableName = $combinationMapTable->info('name');
                  $optionString = "";
                  foreach ($selectedVariation as $id){
                      $optionString .= "FIND_IN_SET($id,options) AND ";
                  }
                  $option_id_conditions = trim($optionString,'AND ');

                  $quantity = $db->query('SELECT quantity FROM engine4_sesproduct_cartproducts_combinations WHERE engine4_sesproduct_cartproducts_combinations.combination_id IN (SELECT Distinct(combination_id) FROM (SELECT GROUP_CONCAT(option_id) as options,combination_id FROM `engine4_sesproduct_cartproducts_combinationmaps` GROUP BY combination_id Having '.$option_id_conditions.') as t) AND quantity > 0 LIMIT 1')->fetchAll();

                  if(count($quantity)){
                      $quantity = $quantity[0]['quantity'];
                      if($quantity < $product->min_quantity) {
                          echo json_encode(array('status' => 0, 'message' => $this->view->translate("Selected variation is not available."), 'variation' => 0));
                          die;
                      }
                  }else{
                      echo json_encode(array('status'=>0,'message'=>$this->view->translate("Selected variation is not available."),'variation'=>0));die;
                  }
                  $cartProducts = Engine_Api::_()->sesproduct()->checkCartProductVariationQuantity($option_id_conditions,$product,$quantity);
                  if(!$cartProducts){
                     echo json_encode(array('status'=>0,'message'=>$this->view->translate("Selected variation is not available."),'variation'=>0));die;
                  }
              }

              //check member level allowed to buy product
//               if(!Engine_Api::_()->sesproduct()->memberAllowedToBuy($product) || !Engine_Api::_()->sesproduct()->memberAllowedToSell($product)) {
//                   $this->view->errorMessage = $this->view->translate("Product is not allowed to purchase right now, please try again later.");
//                   echo json_encode(array('status'=>0,'message'=>$this->view->errorMessage));die;
//               }

              if((empty($product['closed']) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.openclose',1)) &&  $product['draft'] != 0 && $product['is_approved'] != 1 && $product['enable_product'] != 1 && (!$product->starttime || strtotime($product->starttime) <= time())) {
                  $this->view->errorMessage = $this->view->translate("Product is not allowed to purchase right now, please try again later.");
                  echo json_encode(array('status'=>0,'message'=>$this->view->errorMessage));die;
              }
              //insert item in cart
              $cartId = Engine_Api::_()->sesproduct()->getCartId();
              $productTable = Engine_Api::_()->getDbTable('cartproducts','sesproduct');
              $cartProduct = $productTable->createRow();
              $cartProduct->cart_id = $cartId->getIdentity();
              $cartProduct->product_id = $product->getIdentity();
              $cartProduct->quantity = $product->min_quantity;
              $cartProduct->save();
              $customfieldform = $form->getSubForm('addtocart');
              if (!is_null($customfieldform)) {
                  $customfieldform->setItem($cartProduct);
                  $customfieldform->saveValues();
              }

              $db->commit();

             echo json_encode(array('status'=>1,'message'=>$this->view->translate("This Product has been successfully added to your cart."),'href'=>$this->view->url(array('action'=>'index'),'sesproduct_cart',true))); die;

          }catch(Exception $e){
              echo json_encode(array('status'=>0,'message'=>$this->view->translate($e->getMessage())));die;
          }
      }else{
          echo json_encode(array('status'=>0,'message'=>$this->view->translate("Please select all required fields.")));die;
      }
      echo json_encode(array('status'=>0,'message'=>$this->view->translate('Invalid request.')));die;
  }
  function deleteCartAction(){
      $id = $this->_getParam('id');

      //In smoothbox
      $this->_helper->layout->setLayout('default-simple');

      $this->view->form = $form = new Sesbasic_Form_Delete();
      if($id) {
          $form->setTitle($this->view->translate("Delete Product from Shopping Cart?"));
          $form->setDescription($this->view->translate('Are you sure that you want to delete this product from your shopping cart? Product will not be recoverable after being deleted.'));
      }else{
          $form->setTitle($this->view->translate('Delete Products from Shopping Cart?'));
          $form->setDescription($this->view->translate('Are you sure that you want to clear your shopping cart? Product’s will not be recoverable after being deleted.'));
      }
      $form->submit->setLabel('Delete');

      if (!$this->getRequest()->isPost()) {
          $this->view->status = false;
          $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
          return;
      }

      $cartProductTable = Engine_Api::_()->getDbTable('cartproducts','sesproduct');
      $db = $cartProductTable->getAdapter();
      $db->beginTransaction();
      try {
          $cartId = Engine_Api::_()->sesproduct()->getCartId();
          if($id) {
              $cartProductTable->delete(array('cartproduct_id =?' => $id, 'cart_id =?' => $cartId->getIdentity()));
              Engine_Api::_()->getDbtable('cartproductsvalues', 'sesproduct')->delete(array('item_id = ?' => $id));
              Engine_Api::_()->getDbtable('cartproductssearch', 'sesproduct')->delete(array('item_id = ?' => $id));
          }else{
              $cartProductTable = Engine_Api::_()->getDbTable('cartproducts','sesproduct');
              $select = $cartProductTable->select()->where('cart_id =?',$cartId->getIdentity());
              $products = $cartProductTable->fetchAll($select);
              foreach ($products as $product) {
                  Engine_Api::_()->getDbtable('cartproductsvalues', 'sesproduct')->delete(array('item_id = ?' => $product->getIdentity()));
                  Engine_Api::_()->getDbtable('cartproductssearch', 'sesproduct')->delete(array('item_id = ?' => $product->getIdentity()));
                  $product->delete();
              }
          }
          $db->commit();
      } catch (Exception $e) {
          $db->rollBack();
          throw $e;
      }
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('All Product removed from your cart.');
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 200,
          'parentRefresh' => 200,
          'messages' => array($this->view->message)
      ));
  }
  function getConfigurationProductPriceAction(){
      $sesproduct = Engine_Api::_()->getItem('sesproduct',$this->_getParam('product_id'));
      $form = new Sesproduct_Form_Customform(array('cartProduct'=>$sesproduct));
      $form->populate($_POST);
      $formValues = $form->getValues();
      $formValues = $formValues['addtocart'];
      $quantity = !empty($_POST['quantity']) ? $_POST['quantity'] : 1;
      if (!$this->getRequest()->isPost())
          return;
      $db = Zend_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      if ($this->getRequest()->isPost() && (empty($_POST['getPrice']) ||  ($form->isValid($_POST)))) {
          try {
              //insert item in cart
              $selectedVariation = array();
              unset($_POST['product_id']);
              foreach ($_POST as $key=>$select_id) {
                  $parts = explode('_', $key);
                  if (count($parts) == 2) {
                      if(!empty($select_id)) {
                          //check selected variation availability
                          $selectedVariation[] = $select_id;
                      }
                  }
              }
               if(count($selectedVariation)){
                   $db = Zend_Db_Table_Abstract::getDefaultAdapter();
                   $combinationMapTable = Engine_Api::_()->getDbTable('combinationmaps','sesproduct');
                   $combinationMapTableName = $combinationMapTable->info('name');
                   $optionString = "";
                   foreach ($selectedVariation as $id){
                       $optionString .= "FIND_IN_SET($id,options) AND ";
                   }
                   $option_id_conditions = trim($optionString,'AND ');
                   $quantity = $db->query('SELECT quantity FROM engine4_sesproduct_cartproducts_combinations WHERE engine4_sesproduct_cartproducts_combinations.combination_id IN (SELECT Distinct(combination_id) FROM (SELECT GROUP_CONCAT(option_id) as options,combination_id FROM `engine4_sesproduct_cartproducts_combinationmaps` GROUP BY combination_id Having '.$option_id_conditions.') as t) AND quantity > 0 LIMIT 1')->fetchAll();
                   if(!count($quantity)){
                       echo json_encode(array('status'=>0,'message'=>$this->view->translate("Selected variation is not available."),'variation'=>0));die;
                   }
               }
                $price = Engine_Api::_()->sesproduct()->productDiscountPrice($sesproduct);
                foreach ($formValues as $key=>$formValue){
                    $parts = explode('_', $key);
                    if(count($parts) == 2){
                        //select type
                        $select_id = $formValue;
                        if(!$select_id)
                            continue;
                        $data = Engine_Api::_()->getDbTable('cartproductsoptions','sesproduct')->getOption($select_id);
                        if ($data->price != '0.00') {
                            if (!empty($data->type)) {
                                $price += "+".$data->price;
                            } else {
                                $price += "-".$data->price;
                            }
                        }
                        continue;
                    }
                    //rest of all field types
                    list($parent_id, $option_id, $field_id) = $parts;
                    $table = Engine_Api::_()->fields()->getTable('sesproduct_cartproducts', 'meta');
                    $select = $table->select();
                    $select
                        ->from($table->info('name'), array('type','config'))
                        ->where('field_id = ?', $field_id);
                    $fields = $table->fetchRow($select);
                    if($fields){
                        $type = $fields->type;
                        if($type == "text" || $type == "textarea" || $type == "checkbox") {
                            $config = $fields->config;
                            if (!empty($formValue)) {
                                if ($config['price'] != '0.00') {
                                    if (!empty($config['price_type'])) {
                                        $price += "+" . $config['price'];
                                    } else {
                                        $price += "-" . $config['price'];
                                    }
                                }
                            }
                        }else{
                            if(is_array($formValue)){
                                foreach($formValue as $fieldVal){
                                    $data = Engine_Api::_()->getDbTable('cartproductsoptions','sesproduct')->getOption($fieldVal);
                                    if ($data->price != '0.00') {
                                        if (!empty($data->type)) {
                                            $price += "+".$data->price;
                                        } else {
                                            $price += "-".$data->price;
                                        }
                                    }
                                }
                            }else{
                                if (!empty($formValue)) {
                                    $data = Engine_Api::_()->getDbTable('cartproductsoptions', 'sesproduct')->getOption($formValue);
                                    if ($data->price != '0.00') {
                                        if (!empty($data->type)) {
                                            $price += "+" . $data->price;
                                        } else {
                                            $price += "-" . $data->price;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
              $price = Engine_Api::_()->sesproduct()->getCurrencyPrice($price);
              echo json_encode(array('price'=>$price,'status'=>1));die;
          }catch (Exception $e){ throw $e;
              echo json_encode(array('message'=>$this->view->translate("Something went wrong, please try again later."),'status'=>0));die;
          }
      }
      echo json_encode(array('message'=>$this->view->translate("Something went wrong, please try again later."),'status'=>0));die;
  }
  function addtocartAction(){
      if( !$this->getRequest()->isPost() ) return;
      $product_id = $this->_getParam('product_id','');
      $product = Engine_Api::_()->getItem('sesproduct',$product_id);
      //check member level allowed to buy product
      $this->view->status = false;
      if(!Engine_Api::_()->sesproduct()->memberAllowedToBuy($product) || !Engine_Api::_()->sesproduct()->memberAllowedToSell($product)) {
        $this->view->status = false;
        $this->view->message = $this->view->translate("Product is not allowed to purchase right now, please try again later.");
        return;
      }
      if((empty($product['closed']) || !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.openclose',1)) &&  $product['draft'] != 1 && $product['is_approved'] != 1 && $product['enable_product'] != 1 && (!$product->starttime || strtotime($product->starttime) <= time())) {
          $this->view->status = false;
          $this->view->message = $this->view->translate("Product is not allowed to purchase right now, please try again later.");
          return;
      }
      //insert item in cart
      $cartId = Engine_Api::_()->sesproduct()->getCartId();
      $productTable = Engine_Api::_()->getDbTable('cartproducts','sesproduct');
      //check product already added to cart
      $isAlreadyAdded = Engine_Api::_()->getDbTable('cartproducts','sesproduct')->checkproductadded(array('product_id'=>$product_id,'cart_id'=>$cartId->getIdentity()));
     if(!$isAlreadyAdded) {
        if($product->manage_stock) {
         if((!empty($product->manage_stock) && $product->stock_quatity < $product->min_quantity) || $product->max_quatity < $quantity){
             if ($product->stock_quatity == 1)
                 $this->view->message = $this->view->translate("Only 1 quantity of this product is available in stock.");
            else if($product->max_quatity < $quantity)
                $this->view->message = $this->view->translate("Only %s quantities of this product are available in stock. Please enter the quantity less than or equal to %s", $product->max_quatity,$product->max_quatity);
             else
                 $this->view->message = $this->view->translate("Only %s quantities of this product are available in stock. Please enter the quantity less than or equal to %s.", $product->stock_quatity, $product->stock_quatity);
             return;
         }
        }
         $productTable->insert(array('cart_id' => $cartId->getIdentity(), 'product_id' => $product_id, 'quantity' => $product->min_quantity));
     }else{
        $quantity = $isAlreadyAdded['quantity'] + 1;
        if($product->manage_stock) {
            if(!empty($product->manage_stock) && empty($product->stock_quatity)) {
                $this->view->message = $this->view->translate("Product not available right now.");
                return;
            }else if((!empty($product->manage_stock) && $product->stock_quatity < $quantity) || $product->max_quatity < $quantity){
                if ($product->stock_quatity == 1)
                    $this->view->message = $this->view->translate("Only 1 quantity of this product is available in stock.");
                else if($product->max_quatity < $quantity)
                    $this->view->message = $this->view->translate("Only %s quantities of this product are available in stock. Please enter the quantity less than or equal to %s", $product->max_quatity,$product->max_quatity);
                else
                    $this->view->message = $this->view->translate("Only %s quantities of this product are available in stock. Please enter the quantity less than or equal to %s.", $product->stock_quatity, $product->stock_quatity);
                return;
            }
         }
         $isAlreadyAdded->quantity = $quantity;
         $isAlreadyAdded->save();
     }
      $this->view->status = true;
      $this->view->message = $this->view->translate("This Product has been successfully added to your cart.");
  }
  function productCartAction(){
      $totalProduct = Engine_Api::_()->sesproduct()->cartTotalPrice();
      if($totalProduct['cartProductsCount']){
          echo ($totalProduct['cartProductsCount']);die;
      }
      echo 0;die;

  }
}
