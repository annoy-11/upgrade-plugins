<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Api_Core extends Core_Api_Abstract {

    function orderComplete($item,$products = array(),$isAdmin = false){

        //check product variations
        $orderTableName = Engine_Api::_()->getDbTable('orders', 'sesproduct');
        $select = $orderTableName->select();
            if(!$isAdmin)
            $select->where('parent_order_id =?', $item->getIdentity());
            else
                $select->where('order_id =?',$item->getIdentity());
        $orders = $orderTableName->fetchAll($select);

        $orderIds = array();
        $totalPrice = 0;
        foreach ($orders as $order) {
            $orderIds[] = $order->getIdentity();
            $totalPrice += $order->total;
        }

        if(!count($products)) {
            //get all order products
            $productTableName = Engine_Api::_()->getDbTable('orderproducts', 'sesproduct');
            $select = $productTableName->select()->where('order_id IN (?)', $orderIds);
            $products = $productTableName->fetchAll($select);

        }
        $item->onOrderComplete();
        foreach($products as $product){
          if($product['product_id']){
            $productItem = Engine_Api::_()->getItem('sesproduct',$product['product_id']);
            if($productItem->type == 'simpleProduct'){
              $productItem->stock_quatity = $productItem->stock_quatity - $product->quantity;
              $productItem->save();
            }
                    if($productItem->type == 'configurableProduct'){
                        $productItem->stock_quatity = $productItem->stock_quatity - $product->quantity;
                        $productItem->save();
                    }
          }
          if($product['params']){
              $data = unserialize($product['params']);
              if(!empty($data['combination_ids'])){
                  foreach($data['combination_ids'] as $combinations){
                      $quantity = $combinations['quantity'];
                      $id = $combinations['combination_id'];
                      $combinations = Engine_Api::_()->getItem('sesproduct_combination',$id);
                      if($combinations){
                          $availableQuantity = $combinations->quantity - $quantity;
                          if($availableQuantity < 0){
                              $availableQuantity = 0;
                          }
                          $combinations->quantity = $availableQuantity;
                          $combinations->save();
                      }
                  }
              }
          }
        }
        foreach ($orders as $order) {
            $store = Engine_Api::_()->getItem('stores',$order->store_id);
            $storeOwner = $store->getOwner();
            $price = $order->total - $order->total_admintax_cost;
            $commissionAmount = $price - $order->total_shippingtax_cost - $order->total_billingtax_cost;
            $orderAmount = round($price, 2);

            $viewer = Engine_Api::_()->user()->getViewer();
            $commissionType = Engine_Api::_()->authorization()->getPermission($storeOwner,'stores','estore_admincomn');
            $commissionTypeValue = Engine_Api::_()->authorization()->getPermission($storeOwner,'stores','estore_comission');
            $orderCommissionAmount = round($commissionAmount, 2);
            $total_price = round($orderAmount,2);
            //%age wise
            $currentCurrency = Engine_Api::_()->estore()->getCurrentCurrency();
            $defaultCurrency = Engine_Api::_()->estore()->defaultCurrency();
            $settings = Engine_Api::_()->getApi('settings', 'core');
            $currencyValue = 1;
            if($currentCurrency != $defaultCurrency){
                $currencyValue = $settings->getSetting('sesmultiplecurrency.'.$currentCurrency);
            }
            if($commissionType == 1 && $commissionTypeValue > 0){
                $order->commission_amount = round(($orderCommissionAmount/$currencyValue) * ($commissionTypeValue/100),2);
            }else if($commissionType == 0 && $commissionTypeValue > 0){
                $order->commission_amount = $commissionTypeValue;
            }

            $commissionValue = round($order->commission_amount, 2);
            if (isset($commissionValue) && $orderAmount > $commissionValue) {
                $orderAmount = $orderAmount - $commissionValue;
            } else {
                $order->commission_amount = 0;
            }
            $order->save();
            //update credit points
            if($order->credit_point){
                    $userCreditDetailTable = Engine_Api::_()->getDbTable('details', 'sescredit');
                    $userCreditDetailTable->update(array('total_credit' => new Zend_Db_Expr('total_credit - ' . $order->credit_point)), array('owner_id =?' => $order->user_id));

                    $table = Engine_Api::_()->getDbTable('credits', 'sescredit');
                    $creditRow = $table->createRow();
                    $creditValues = array('type' => 'sesproduct_order', 'owner_id' => $order->user_id, 'action_id' => 0, 'object_id' => $order->getIdentity(), 'point_type' => 'po',  'credit' => $order->credit_point);

                   $creditRow->setFromArray($creditValues);
                   $creditRow->save();
            }
            //update STORE OWNER REMAINING amount
            $tableRemaining = Engine_Api::_()->getDbtable('remainingpayments', 'estore');
            $tableName = $tableRemaining->info('name');
            $select = $tableRemaining->select()->from($tableName)->where('store_id =?', $order->store_id);
            $select = $tableRemaining->fetchAll($select);
            if (count($select)) {
                $tableRemaining->update(array('remaining_payment' => new Zend_Db_Expr("remaining_payment + $orderAmount")), array('store_id =?' => $order->store_id));
            } else {
                $tableRemaining->insert(array(
                    'remaining_payment' => $orderAmount,
                    'store_id' => $order->store_id,
                ));
            }
        }
        return true;
    }
    public function memberAllowedToBuy() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();

        //GET USER LEVEL ID
        if (!empty($viewer_id)) {
            $level_id = $viewer->level_id;
        } else {
            $level_id = Engine_Api::_()->getDbtable('levels', 'authorization')->fetchRow(array('type = ?' => "public"))->level_id;
        }
        return Engine_Api::_()->authorization()->getPermission($level_id, 'stores', "allow_buying");
    }
    function checkPaymentGatewayEnable(){
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $estoreType = $settings->getSetting('estore.estore.type',1);
        $estorePaymentType = $settings->getSetting('estore.estore.type',1);
        $paymentMethods = array();
        $noPaymentGatewayEnableByAdmin = false;
        $check_details = "";
        if($estorePaymentType == 0){
            //direct payment to seller

        }else{
            //payment to site admin
            $paymentMethods = $settings->getSetting('estore_payment_siteadmin',array('0','1'));
            $table = Engine_Api::_()->getDbTable('gateways','payment');
            $select = $table->select()->where('plugin =?','Payment_Plugin_Gateway_PayPal')->where('enabled =?',1);
            $paypal = $table->fetchRow($select);
            $select = $table->select()->where('plugin =?','Sesadvpmnt_Plugin_Gateway_Stripe')->where('enabled =?',1);
            $stripe = $table->fetchRow($select);
            $select = $table->select()->where('plugin =?','Epaytm_Plugin_Gateway_Paytm')->where('enabled =?',1);
            $paytm = $table->fetchRow($select);
            $givenSymbol = Engine_Api::_()->sesproduct()->getCurrentCurrency();
            if($paypal){
                $paymentMethods['paypal'] = 'paypal';
            }
            if($stripe){
                $gatewayObject = $stripe->getGateway();
                $stripeSupportedCurrencies = $gatewayObject->getSupportedCurrencies();
                if(in_array($givenSymbol,$stripeSupportedCurrencies))
                  $paymentMethods['stripe'] = 'stripe';
            } 
            if($paytm){
              $gatewayObject = $paytm->getGateway();
              $paytmSupportedCurrencies = $gatewayObject->getSupportedCurrencies();
              if(in_array($givenSymbol,$paytmSupportedCurrencies))
                $paymentMethods['paytm'] = 'paytm';
            }
            if(!count($paymentMethods)){
                $noPaymentGatewayEnableByAdmin = true;
            }
            $check_details = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.payment.checkinfo', null);
        }
        return array('methods'=>$paymentMethods,'noPaymentGatewayEnableByAdmin'=>$noPaymentGatewayEnableByAdmin,'paypal'=>$paypal,'check_details'=>$check_details);
    }
    function cartTotalPrice(){
        $cartId = Engine_Api::_()->sesproduct()->getCartId();
        $productTable = Engine_Api::_()->getDbTable('cartproducts','sesproduct');
        $productTableName = $productTable->info('name');
        $select = $productTable->select()->from($productTableName,'*');
        $select->where("cart_id =?",$cartId->getIdentity());
        $cartProducts = $productTable->fetchAll($select);

        $productsArray = array();
        $counter = 0;
        $totalPrice = 0;

        foreach($cartProducts as $cartProduct){
            $product = Engine_Api::_()->getItem('sesproduct',$cartProduct->product_id);
            $productsArray[$product->store_id]['store_id'] = $product->store_id;
            $store = Engine_Api::_()->getItem('stores',$product->store_id);
            $variations = $this->getAllVariations($cartProduct->cartproduct_id,$product);
            if($variations){
                $totalPrice += $variations['purchasePriceProduct']*$cartProduct->quantity;
                $productsArray[$product->store_id]['products_extra'][$cartProduct->cartproduct_id]['product_price'] = $cartProduct->quantity*$variations['purchasePriceProduct'];
                $productsArray[$product->store_id]['products_extra'][$cartProduct->cartproduct_id]['variations'] = $variations;
            }else{
                $price = Engine_Api::_()->sesproduct()->productDiscountPrice($product);
                $totalPrice += $price*$cartProduct->quantity;
                $productsArray[$product->store_id]['products_extra'][$cartProduct->cartproduct_id]['product_price'] = $cartProduct->quantity*$price;
            }
            $productsArray[$product->store_id]['products_extra'][$cartProduct->cartproduct_id]['quantity'] = $cartProduct->quantity;
            $productsArray[$product->store_id]['stores'] = $store;
            $productsArray[$product->store_id]['cartproducts'][$counter] = $cartProduct;
            $counter++;
        }

        return array('cartProductsCount'=>count($cartProducts),'productsArray'=>$productsArray,'totalPrice'=>$totalPrice,'cartProducts'=>$cartProducts);
    }
    public function getAllVariations($product_id = 0,$product){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $select = "SELECT GROUP_CONCAT(value) as `values`,`type`,`config`,label,engine4_sesproduct_cartproducts_fields_values.field_id FROM engine4_sesproduct_cartproducts_fields_values LEFT JOIN engine4_sesproduct_cartproducts_fields_meta on engine4_sesproduct_cartproducts_fields_meta.field_id = engine4_sesproduct_cartproducts_fields_values.field_id WHERE item_id = ".$product_id." GROUP BY engine4_sesproduct_cartproducts_fields_values.field_id ORDER BY `is_select_type` DESC";
        $variations =  $db->query($select)->fetchAll();
        $customFields = array();
        if(count($variations)){
            $price = Engine_Api::_()->sesproduct()->productDiscountPrice($product);
            foreach($variations as $variation){
                $type = $variation['type'];
                $values = $variation['values'];
                $config = $variation['config'];
                $configValues = json_decode($config,true);
                if($type == "text" || $type == "textarea" || $type == "checkbox"){
                    //get field values
                    if(!empty($variation['values'])) {
                        if($type != "checkbox")
                            $customFields[$variation['label']] = $variation['values'];
                        else
                            $customFields[$variation['label']] = 'Yes';
                        if (!empty($configValues['price'])) {
                            $price += (!empty($configValues['price_type']) ? "+" : "-").$configValues['price'];
                        }
                    }
                }else{
                    $explodedValues = explode(',',$values);
                    if(count($explodedValues) > 1){
                        $optionString = "";
                        foreach ($explodedValues as $option_id){
                            $option = Engine_Api::_()->getDbTable('cartproductsoptions','sesproduct')->getOption($option_id);
                            if (!empty($option['price'])) {
                                $price += (!empty($option['type']) ? "+" : "-").$option['price'];
                            }
                            $optionString .= $option['label'].', ';
                        }
                        $customFields[$variation['label']] = trim($optionString,', ');
                    }else{
                        $option = Engine_Api::_()->getDbTable('cartproductsoptions','sesproduct')->getOption($explodedValues[0]);
                        if (!empty($option['price'])) {
                            $price += (!empty($option['type']) ? "+" : "-").$option['price'];
                        }
                        $customFields[$variation['label']] = trim($option['label']);
                    }
                }
            }
            $customFields['purchasePriceProduct'] = $price;
            return $customFields;
        }
        return false;
    }
    function getVariationSelectedOptions($product,$params = array()){
        $combinationTable = Engine_Api::_()->getDbTable('combinations','sesproduct');
        $combinationTableName = $combinationTable->info('name');
        $combinationMapTable = Engine_Api::_()->getDbTable('combinationmaps','sesproduct');
        $combinationMapTableName = $combinationMapTable->info('name');
        $select = $combinationTable->select()->from($combinationTableName,array('*'))
            ->where('product_id =?',$product->getIdentity())
            ->setIntegrityCheck(false)
            ->join($combinationMapTableName,$combinationTableName.'.combination_id ='.$combinationMapTableName.'.combination_id')
            ->where('status =?',1)
            ->where('quantity > 0')
            ->order("$combinationMapTableName.order ASC");
        if(count($params)){
            $select->where($combinationMapTableName.'.combination_id IN (SELECT Distinct(combination_id) FROM (SELECT GROUP_CONCAT(option_id) as options,combination_id FROM `engine4_sesproduct_cartproducts_combinationmaps` GROUP BY combination_id Having '.$params['option_id_conditions'].') as t)');
        }
        $combinationOptions = $combinationTable->fetchAll($select);
        if(count($combinationOptions)){
            $results = array();
            foreach ($combinationOptions as $option){
                $optionData = $data = Engine_Api::_()->getDbTable('cartproductsoptions','sesproduct')->getOption($option['option_id']);
                $results[$option['field_id']]['field_label'] = Engine_Api::_()->getDbTable('cartproductsmetas', 'sesproduct')->getLabel($option['field_id']);
                $results[$option['field_id']]['multioptions'][0] = Zend_Registry::get('Zend_Translate')->translate('-- Please Select --');
                if (!empty($optionData['type']))
                    $price = $optionData['label'] . '   ' . '(+' . Engine_Api::_()->sesproduct()->getCurrencyPrice($optionData['price']) . ')';
                else
                    $price = $optionData['label'] . '   ' . '(-' . Engine_Api::_()->sesproduct()->getCurrencyPrice($optionData['price']) . ')';
                $results[$option['field_id']]['multioptions'][$option['option_id']] = $price;
            }
            return $results;
        }
        return array();
    }
    function getVariationOptions($product,$getAll = 0){
        $combinationTable = Engine_Api::_()->getDbTable('combinations','sesproduct');
        $combinationTableName = $combinationTable->info('name');
        $combinationMapTable = Engine_Api::_()->getDbTable('combinationmaps','sesproduct');
        $combinationMapTableName = $combinationMapTable->info('name');
        $select = $combinationTable->select()->from($combinationTableName,array('*'))
            ->where('product_id =?',$product->getIdentity())
            ->setIntegrityCheck(false)
            ->join($combinationMapTableName,$combinationTableName.'.combination_id ='.$combinationMapTableName.'.combination_id')
            ->where('status =?',1)
            ->where('quantity > 0')
            ->order("$combinationMapTableName.order ASC");
        $combinationOptions = $combinationTable->fetchAll($select);
        if(count($combinationOptions)){
            $results = array();
            foreach ($combinationOptions as $option){
                $optionData = $data = Engine_Api::_()->getDbTable('cartproductsoptions','sesproduct')->getOption($option['option_id']);
                $results[$option['field_id']]['field_label'] = Engine_Api::_()->getDbTable('cartproductsmetas', 'sesproduct')->getLabel($option['field_id']);
                $results[$option['field_id']]['multioptions'][0] = Zend_Registry::get('Zend_Translate')->translate('-- Please Select --');
                if (!empty($optionData['type']))
                    $price = $optionData->label . '   ' . '(+' . Engine_Api::_()->sesproduct()->getCurrencyPrice($optionData['price']) . ')';
                else
                    $price = $optionData->label . '   ' . '(-' . Engine_Api::_()->sesproduct()->getCurrencyPrice($optionData['price']) . ')';
                $results[$option['field_id']]['multioptions'][$option['option_id']] = $price;
            }
            return $results;
        }
        return array();
    }
    public function getProductVariations($product){
        $combinationTable = Engine_Api::_()->getDbTable('combinations','sesproduct');
        $combinationTableName = $combinationTable->info('name');
        $combinationMapTable = Engine_Api::_()->getDbTable('combinationmaps','sesproduct');
        $combinationMapTableName = $combinationMapTable->info('name');
        $select = $combinationTable->select()->from($combinationTableName,array('*','option_ids'=>new Zend_Db_Expr('GROUP_CONCAT(option_id)')))
                                    ->where('product_id =?',$product->getIdentity())
                                    ->setIntegrityCheck(false)
                                    ->joinLeft($combinationMapTableName,$combinationTableName.'.combination_id ='.$combinationMapTableName.'.combination_id')
                                    ->group($combinationTableName.'.combination_id')
                                    ->where('status =?',1)
                                    ->where('quantity > 0');
        return $combinationTable->fetchAll($select);
    }
    public function getLoggedoutUserCart(){
        $table = Engine_Api::_()->getDbTable('carts','sesproduct');
        $select = $table->select();
        $phpSessionId = session_id();
        $select->where('phpsessionid =?',$phpSessionId);
        return $table->fetchRow($select);
    }
    function getCartProductStores($cart_id){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $storeTableName = Engine_Api::_()->getDbTable('stores','estore');
        $select = $storeTableName->select()->where("store_id IN (SELECT store_id FROM engine4_sesproduct_products WHERE product_id IN (SELECT product_id FROM engine4_sesproduct_cartproducts WHERE cart_id = ".$cart_id."))");
        return $storeTableName->fetchAll($select);
    }
    function getCartProducts($store_id){
        $cartId = Engine_Api::_()->sesproduct()->getCartId();
        $cart_id = $cartId->getIdentity();
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $productTableName = Engine_Api::_()->getDbTable('sesproducts','sesproduct')->info('name');
        $cartProductTable = Engine_Api::_()->getDbTable('cartproducts','sesproduct');
        $cartProductTableName = $cartProductTable->info('name');
        $select = $cartProductTable->select()->from($cartProductTableName,'*')
                    ->joinLeft($productTableName,$cartProductTableName.'.product_id = '.$productTableName.'.product_id',null)
                    ->where($cartProductTableName.'.cart_id =?',$cart_id)
                    ->where($productTableName.'.store_id =?',$store_id);
        return $cartProductTable->fetchAll($select);
    }
    function checkVariations($product,$returnObject = false){
        if($product){
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            $result = $db->query("SELECT group_concat(value) as value FROM engine4_sesproduct_cartproducts_fields_values WHERE item_id =".$product->getIdentity().' AND is_select_type = 1')->fetchAll();
            if(!empty($result[0]['value'])){
                $value = $result[0]['value'];
                $havingCondition = "";
                foreach (explode(',',$value) as $value){
                    $havingCondition .= 'FIND_IN_SET('.$value.',options) AND ';
                }
                $havingCondition = trim($havingCondition,'AND ');
                $availableQuantity = $db->query("SELECT quantity,combination_id from engine4_sesproduct_cartproducts_combinations WHERE status =1 AND combination_id = (SELECT combination_id FROM (SELECT GROUP_CONCAT(option_id) as options,combination_id FROM `engine4_sesproduct_cartproducts_combinationmaps` GROUP BY combination_id HAVING ".$havingCondition.") as t)")->fetchAll();
                if(count($availableQuantity)){
                    if($returnObject){
                        return $availableQuantity[0];
                    }
                    if(!empty($availableQuantity[0]['quantity'])){
                        $products = Engine_Api::_()->getItem('sesproduct',$product->product_id);
                        $cartProductQuantity = $this->checkCartProductVariationQuantity($havingCondition,$products,0,true,$product);
                        return $availableQuantity[0]['quantity'] - $cartProductQuantity;
                    }
                }
            }
        }
        return 0;
    }
    function checkCartProductVariationQuantity($option_id_conditions = "",$product,$quantity = 0,$return = false,$cartProduct = null){
        $cartId = Engine_Api::_()->sesproduct()->getCartId();
        $cartProductTable = Engine_Api::_()->getDbTable('cartproducts','sesproduct');
        $productTableName = Engine_Api::_()->getDbTable('sesproducts','sesproduct')->info('name');
        $productValuesTableName = "engine4_sesproduct_cartproducts_fields_values";
        $select = $cartProductTable->select($cartProductTable->info('name','*'))->where('cart_id =?',$cartId->getIdentity());
        $select->setIntegrityCheck(false)->joinLeft($productTableName,$productTableName.'.product_id ='.$cartProductTable->info('name').'.product_id',null)->where('type =?','configurableProduct');
        $select->joinLeft($productValuesTableName,$productValuesTableName.'.item_id ='.$cartProductTable->info('name').'.cartproduct_id AND is_select_type = 1',array('options'=>new Zend_Db_Expr('GROUP_CONCAT(value)')));
        $select->having( $option_id_conditions);
        $select->group('cartproduct_id');
        if($cartProduct)
            $select->where('cartproduct_id !=?',$cartProduct->getIdentity());

        $cartProducts = $cartProductTable->fetchAll($select);
        if(count($cartProducts)){
            $variationProductQuantity = 0;
            foreach ($cartProducts as $productQuantity){
                $variationProductQuantity += $productQuantity['quantity'];
            }
            if($return) {
                return $variationProductQuantity;
            }
            if($variationProductQuantity + $product->min_quantity > $quantity){
               return false;
            }
        }
        return true;
    }
    public  function getCartId(){
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        $table = Engine_Api::_()->getDbTable('carts', 'sesproduct');
        $select = $table->select();
        if (!$viewer_id) {
            $phpSessionId = session_id();
            $select->where('phpsessionid =?', $phpSessionId);
        } else {
            $select->where('owner_id =?', $viewer_id);
        }
        $cart =  $table->fetchRow($select);
        if(!$cart){
            $cart = $table->createRow();
            $cart->owner_id = $viewer_id;
            $cart->phpsessionid = session_id();
            $cart->save();
        }
        return $cart;
    }
    function productDiscountPrice($item){
        $viewer_discount_id =  Engine_Api::_()->user()->getViewer()->getIdentity();
        $priceDiscount = 0;
        if($item->discount == 1 && (empty($item->allowed_discount_type) || ($viewer_discount_id && $item->allowed_discount_type == 2) || ($viewer_discount_id && $item->allowed_discount_type == 1))) {
            //discount_type = 0 (percentage) else fixed
            //allowed_discount_type = 0(everyone), 1 - (public) else registered
            $startDate = strtotime($item->discount_start_date);
            if($item->discount_end_type){
                $endDate = strtotime($item->discount_end_date);
            }
            if($startDate < time() && (empty($endDate) || $endDate > time() )) {
                if ($item->discount_type == 0) {
                    $priceDiscount = round($item->price - ($item->price / 100) * $item->percentage_discount_value, 2);
                } else {
                    $priceDiscount = round($item->price - $item->fixed_discount_value, 2);
                }
                return $priceDiscount;
            }
        }else{
            return $item->price;
        }
       return $item->price;
    }
    public function memberAllowedToSell($product) {
        $owner = $product->getOwner();
        $owner_id = $owner->getIdentity();
        //GET USER LEVEL ID
        if (!empty($owner_id)) {
            $level_id = $owner->level_id;
        } else {
            return false;
        }
        return Engine_Api::_()->authorization()->getPermission($level_id, 'stores', "allow_selling");
    }
    function getFieldType($options_id = 0){

    }
    public function productPurchaseable($product){
        $status = 0;
        $class = '';
        $href = "javascript:;";
        $noShippingMethodDefine = false;
        $shippingmethod = Engine_Api::_()->getDbTable('shippingmethods','estore')->getShippingmethods(array('store_id'=>$product->store_id));
        if(!count($shippingmethod)){
            $noShippingMethodDefine = true;
        }
        switch($product->type){
            case "simpleProduct":
                if ((empty($product->manage_stock) || $product->stock_quatity >= $product->min_quantity) && count($shippingmethod) > 0){
                    $status = 1;
                    $class = " sesproduct_addtocart";
                }
                break;
            case "groupedProduct":
                if (empty($product->manage_stock) || $product->stock_quatity >= $product->min_quantity){
                    $status = 1;
                    $class = " sesproduct_addtocart";
                }
                break;
            case "bundledProduct":
                if (empty($product->manage_stock) || $product->stock_quatity >= $product->min_quantity){
                    $status = 1;
                    $class = " sesproduct_addtocart";
                }
                break;
            case "virtualProduct":
            case "downloadableProduct":
            case "externalProduct":
            case "configurableProduct":
                $status = 1;
                $class = "";
                $href = $product->getHref();
                break;
        }
        return array('href'=>$href,'class'=>$class,'status'=>$status,'noShippingMethodDefine'=>$noShippingMethodDefine);
    }
    public  function getAttributedSelelct($product){
        $option_id = Engine_Api::_()->getDbTable('cartoptions','sesproduct')->checkProduct($product)->option_id;
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        return $db->query("SELECT engine4_sesproduct_cartproducts_fields_meta.* FROM engine4_sesproduct_cartproducts_fields_maps LEFT JOIN engine4_sesproduct_cartproducts_fields_meta
                  ON engine4_sesproduct_cartproducts_fields_meta.field_id = engine4_sesproduct_cartproducts_fields_maps.child_id
                  WHERE type = 'select' AND option_id = '$option_id' ")->fetchAll();
    }
    function saleRunning($item,$viewer_discount_id){
        if($item->discount == 1 && (empty($item->allowed_discount_type) || ($viewer_discount_id && $item->allowed_discount_type == 2) || ($viewer_discount_id && $item->allowed_discount_type == 1))) {
			if($this->productDiscountPrice($item))
				return true;
        }
        return false;
    }
  public  function checkAddToCompare($product){
      $products = !empty($_SESSION['sesproduct_add_to_compare']) ? $_SESSION['sesproduct_add_to_compare'] : false;
      if($products){
        if(isset($products[$product["category_id"]])){
            $catgeory = $products[$product["category_id"]];
            if(!empty($products[$product["category_id"]][$product["product_id"]])){
                return 1;
            }
        }
      }
      return 0;
  }
  function addProductToCompare($product){
      if(empty($_SESSION['sesproduct_add_to_compare'][$product['category_id']][$product["product_id"]])) {
          $_SESSION['sesproduct_add_to_compare'][$product['category_id']][$product["product_id"]] = $product["product_id"];
          return true;
      }
      return true;
  }
  function compareData($product){
        $array["product_id"] = $product["product_id"];
        $array["category_id"] = $product["category_id"];
        $category = Engine_Api::_()->getItem('sesproduct_category',$product->category_id);
        if($category)
            $category_title = $category->category_name;
        else
            $category_title = "Untitled";

        $array["image"] = $product->getPhotoUrl();

        $array["category_title"] = $category_title;
        return json_encode($array);
  }
  public function createProduct($store = null){
	  $viewer = Engine_Api::_()->user()->getViewer();
     if(!$store)
        return false;
     if( !Engine_Api::_()->authorization()->isAllowed('sesproduct', $viewer, 'create') )
        return false;
      return true;
  }
  public function checkPrivacySetting($product_id) {

    $product = Engine_Api::_()->getItem('sesproduct', $product_id);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    if ($viewerId)
      $level_id = $viewer->level_id;
    else
      $level_id = 5;

    $levels = $product->levels;
    $member_level = explode(",",$product->levels);
    if(($level_id == 1 || $level_id == 2) && !$product->draft){
      return 1;
    }
    if (!empty($member_level)  && !empty($product->levels)) {
      if (!in_array($level_id, $member_level))
        return false;
    } else
      return true;
    if ($viewerId) {
      $network_table = Engine_Api::_()->getDbtable('membership', 'network');
      $network_select = $network_table->select('resource_id')->where('user_id = ?', $viewerId);
      $network_id_query = $network_table->fetchAll($network_select);
      $network_id_query_count = count($network_id_query);
      $network_id_array = array();
      for ($i = 0; $i < $network_id_query_count; $i++) {
        $network_id_array[$i] = $network_id_query[$i]['resource_id'];
      }
      if (!empty($network_id_array)) {
        $networks = explode(",",$product->networks);
        if (!empty($networks)) {
          if (!array_intersect($network_id_array, $networks))
            return false;
        } else
          return true;
      }
    }
    return true;
  }

  /* get other module compatibility code as per module name given */
  public function getPluginItem($moduleName) {
		//initialize module item array
    $moduleType = array();
    $filePath =  APPLICATION_PATH . "/application/modules/" . ucfirst($moduleName) . "/settings/manifest.php";
		//check file exists or not
    if (is_file($filePath)) {
			//now include the file
      $manafestFile = include $filePath;
			$resultsArray =  Engine_Api::_()->getDbtable('integrateothermodules', 'sesbasic')->getResults(array('module_name'=>$moduleName));
      if (is_array($manafestFile) && isset($manafestFile['items'])) {
        foreach ($manafestFile['items'] as $item)
          if (!in_array($item, $resultsArray))
            $moduleType[$item] = $item.' ';
      }
    }
    return $moduleType;
  }

  public function getWidgetPageId($widgetId) {

    $db = Engine_Db_Table::getDefaultAdapter();
    $params = $db->select()
            ->from('engine4_core_content', 'page_id')
            ->where('`content_id` = ?', $widgetId)
            ->query()
            ->fetchColumn();
    return json_decode($params, true);
  }

  function multiCurrencyActive(){
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->multiCurrencyActive();
    }else{
      return false;
    }
  }
  function isMultiCurrencyAvailable(){
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->isMultiCurrencyAvailable();
    }else{
      return false;
    }
  }
    public function getCurrencySymbol($currency = ''){
        if(!$currency)
            $currency = Engine_Api::_()->getApi('settings', 'core')->getSetting('payment.currency', 'USD');
        $curArr = Zend_Locale::getTranslationList('CurrencySymbol');
        return $curArr[$currency];
    }
  function getCurrencyPrice($price = 0, $givenSymbol = '', $change_rate = '',$returnValue = false){
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $precisionValue = $settings->getSetting('sesmultiplecurrency.precision', 2);
    $defaultParams['precision'] = $precisionValue;
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->getCurrencyPrice($price, $givenSymbol, $change_rate,$returnValue);
    }else{
        return Zend_Registry::get('Zend_View')->locale()->toCurrency($price, $this->getCurrentCurrency(), $defaultParams);
    }
  }
  function getCurrentCurrency(){
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->getCurrentCurrency();
    }else{
      return $settings->getSetting('payment.currency', 'USD');
    }
  }
  function defaultCurrency(){
    if(!empty($_SESSION['ses_multiple_currency']['multipleCurrencyPluginActivated'])){
      return Engine_Api::_()->sesmultiplecurrency()->defaultCurrency();
    }else{
      $settings = Engine_Api::_()->getApi('settings', 'core');
      return $settings->getSetting('payment.currency', 'USD');
    }
  }

  /* people like item widget paginator */
  public function likeItemCore($params = array()) {

    $parentTable = Engine_Api::_()->getItemTable('core_like');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', $params['type'])
            ->order('like_id DESC');
    if (isset($params['id']))
      $select = $select->where('resource_id = ?', $params['id']);
    if (isset($params['poster_id']))
      $select = $select->where('poster_id =?', $params['poster_id']);
    return Zend_Paginator::factory($select);
  }

  function truncate($text, $length = 100, $options = array()) {
    $default = array(
        'ending' => '...', 'exact' => true, 'html' => false
    );
    $options = array_merge($default, $options);
    extract($options);

    if ($html) {
        if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        $totalLength = mb_strlen(strip_tags($ending));
        $openTags = array();
        $truncate = '';

        preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
        foreach ($tags as $tag) {
            if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                    array_unshift($openTags, $tag[2]);
                } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                    $pos = array_search($closeTag[1], $openTags);
                    if ($pos !== false) {
                        array_splice($openTags, $pos, 1);
                    }
                }
            }
            $truncate .= $tag[1];

            $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
            if ($contentLength + $totalLength > $length) {
                $left = $length - $totalLength;
                $entitiesLength = 0;
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entitiesLength <= $left) {
                            $left--;
                            $entitiesLength += mb_strlen($entity[0]);
                        } else {
                            break;
                        }
                    }
                }

                $truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
                break;
            } else {
                $truncate .= $tag[3];
                $totalLength += $contentLength;
            }
            if ($totalLength >= $length) {
                break;
            }
        }
    } else {
        if (mb_strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
        }
    }
    if (!$exact) {
        $spacepos = mb_strrpos($truncate, ' ');
        if (isset($spacepos)) {
            if ($html) {
                $bits = mb_substr($truncate, $spacepos);
                preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                if (!empty($droppedTags)) {
                    foreach ($droppedTags as $closingTag) {
                        if (!in_array($closingTag[1], $openTags)) {
                            array_unshift($openTags, $closingTag[1]);
                        }
                    }
                }
            }
            $truncate = mb_substr($truncate, 0, $spacepos);
        }
    }
    $truncate .= $ending;

    if ($html) {
        foreach ($openTags as $tag) {
            $truncate .= '</'.$tag.'>';
        }
    }

    return $truncate;
}
   public function getCustomFieldMapDataProduct($product) {
    if ($product) {
      $db = Engine_Db_Table::getDefaultAdapter();
      return $db->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_sesproduct_fields_options.label) SEPARATOR ', ')),engine4_sesproduct_fields_values.value) AS `value`, `engine4_sesproduct_fields_meta`.`label`, `engine4_sesproduct_fields_meta`.`type` FROM `engine4_sesproduct_fields_values` LEFT JOIN `engine4_sesproduct_fields_meta` ON engine4_sesproduct_fields_meta.field_id = engine4_sesproduct_fields_values.field_id LEFT JOIN `engine4_sesproduct_fields_options` ON engine4_sesproduct_fields_values.value = engine4_sesproduct_fields_options.option_id AND (`engine4_sesproduct_fields_meta`.`type` = 'multi_checkbox' || `engine4_sesproduct_fields_meta`.`type` = 'radio') WHERE (engine4_sesproduct_fields_values.item_id = ".$product->product_id.") AND (engine4_sesproduct_fields_values.field_id != 1) GROUP BY `engine4_sesproduct_fields_meta`.`field_id`,`engine4_sesproduct_fields_options`.`field_id`")->fetchAll();
    }
    return array();
  }

  public function getwidgetizePage($params = array()) {

    $corePages = Engine_Api::_()->getDbtable('pages', 'core');
    $corePagesName = $corePages->info('name');
    $select = $corePages->select()
            ->from($corePagesName, array('*'))
            ->where('name = ?', $params['name'])
            ->limit(1);
    return $corePages->fetchRow($select);
  }

     /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
  */
  public function getHref($albumId = '', $slug = '') {
//     if (is_numeric($albumId)) {
//       $slug = $this->getSlug(Engine_Api::_()->getItem('sesproduct_album', $albumId)->getTitle());
//     }
    $params = array_merge(array(
        'route' => 'sesproduct_specific_album',
        'reset' => true,
        'album_id' => $albumId,
       // 'slug' => $slug,
    ));
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble($params, $route, $reset);
  }
      //get album photo
  function getAlbumPhoto($albumId = '', $photoId = '', $limit = 4) {
    if ($albumId != '') {
      $albums = Engine_Api::_()->getItemTable('sesproduct_album');
      $albumTableName = $albums->info('name');
      $photos = Engine_Api::_()->getItemTable('sesproduct_photo');
      $photoTableName = $photos->info('name');
      $select = $photos->select()
              ->from($photoTableName)
              ->limit($limit)
              ->where($albumTableName . '.album_id = ?', $albumId)
              ->where($photoTableName . '.photo_id != ?', $photoId)
              ->setIntegrityCheck(false)
              ->joinLeft($albumTableName, $albumTableName . '.album_id = ' . $photoTableName . '.album_id', null);
      if ($limit == 3)
        $select = $select->order('rand()');
      return $photos->fetchAll($select);
    }
  }
       //get photo URL
  public function photoUrlGet($photo_id, $type = null) {
    if (empty($photo_id)) {
      $photoTable = Engine_Api::_()->getItemTable('sesproduct_photo');
      $photoInfo = $photoTable->select()
              ->from($photoTable, array('photo_id', 'file_id'))
              ->where('album_id = ?', $this->album_id)
              ->order('order ASC')
              ->limit(1)
              ->query()
              ->fetch();
      if (!empty($photoInfo)) {
        $this->photo_id = $photo_id = $photoInfo['photo_id'];
        $this->save();
        $file_id = $photoInfo['file_id'];
      } else {
        return;
      }
    } else {
      $photoTable = Engine_Api::_()->getItemTable('sesproduct_photo');
      $file_id = $photoTable->select()
              ->from($photoTable, 'file_id')
              ->where('photo_id = ?', $photo_id)
              ->query()
              ->fetchColumn();
    }
    if (!$file_id) {
      return;
    }
    $file = Engine_Api::_()->getItemTable('storage_file')->getFile($file_id, $type);
    if (!$file) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($file_id, '');
    }
    return $file->map();
  }


    public function getPreviousPhoto($album_id = '', $order = '') {
    $table = Engine_Api::_()->getDbTable('photos', 'sesproduct');
    $select = $table->select()
            ->where('album_id = ?', $album_id)
            ->where('`order` < ?', $order)
            ->order('order DESC')
            ->limit(1);
    $photo = $table->fetchRow($select);
    if (!$photo) {
      // Get last photo instead
      $select = $table->select()
              ->where('album_id = ?', $album_id)
              ->order('order DESC')
              ->limit(1);
      $photo = $table->fetchRow($select);
    }
    return $photo;
  }

  	public function getNextPhoto($album_id = '', $order = '') {
    $table = Engine_Api::_()->getDbTable('photos', 'sesproduct');
    $select = $table->select()
            ->where('album_id = ?', $album_id)
            ->where('`order` > ?', $order)
            ->order('order ASC')
            ->limit(1);
    $photo = $table->fetchRow($select);
    if (!$photo) {
      // Get first photo instead
      $select = $table->select()
              ->where('album_id = ?', $album_id)
              ->order('order ASC')
              ->limit(1);
      $photo = $table->fetchRow($select);
    }
    return $photo;
  }

    //Get Event like status
  public function getLikeStatusProduct($product_id = '', $moduleName = '') {
    if ($moduleName == '')
      $moduleName = 'sesproduct';
    if ($product_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()
              ->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))
              ->where('resource_type =?', $moduleName)
              ->where('poster_id =?', $userId)
              ->where('poster_type =?', 'user')
              ->where('	resource_id =?', $product_id)
              ->query()
              ->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }
  public function dateFormat($date = null,$changetimezone = '',$object = '',$formate = 'M d, Y h:m A') {
		if($changetimezone != '' && $date){
			$date = strtotime($date);
			$oldTz = date_default_timezone_get();
			date_default_timezone_set($object->timezone);
			if($formate == '')
				$dateChange = date('Y-m-d h:i:s',$date);
			else{
				$dateChange = date('M d, Y h:i A',$date);
			}
			date_default_timezone_set($oldTz);
			return $dateChange.' ('.$object->timezone.')';
		}
    if($date){
      return date('M d, Y h:i A', strtotime($date));
    }
  }

  /**
   * Get Widget Identity
   *
   * @return $identity
  */
  public function getIdentityWidget($name, $type, $corePages) {

    $widgetTable = Engine_Api::_()->getDbTable('content', 'core');
    $widgetPages = Engine_Api::_()->getDbTable('pages', 'core')->info('name');
    $identity = $widgetTable->select()
            ->setIntegrityCheck(false)
            ->from($widgetTable, 'content_id')
            ->where($widgetTable->info('name') . '.type = ?', $type)
            ->where($widgetTable->info('name') . '.name = ?', $name)
            ->where($widgetPages . '.name = ?', $corePages)
            ->joinLeft($widgetPages, $widgetPages . '.page_id = ' . $widgetTable->info('name') . '.page_id')
            ->query()
            ->fetchColumn();
    return $identity;
  }

  function tagCloudItemCore($fetchtype = '', $product_id = '') {

    $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbtable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->where('resource_type =?', 'sesproduct')
            ->where('tag_type =?', 'core_tag')
            ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
            ->group($tableTagName . '.tag_id');
    if($product_id) {
      $selecttagged_photo->where($tableTagName.'.resource_id =?', $product_id);
    }
    $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
    if ($fetchtype == '')
      return Zend_Paginator::factory($selecttagged_photo);
    else
      return $tableTagmap->fetchAll($selecttagged_photo);
  }

  function getProductgers() {
    $userTable = Engine_Api::_()->getItemTable('user');
    $userTableName = $userTable->info('name');
    $productTable = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct');
    $productTableName = $productTable->info('name');
    $select = $userTable->select()
			->from($userTable, array('COUNT(*) AS product_count', 'user_id', 'displayname'))
			->setIntegrityCheck(false)
			->join($productTableName, $productTableName . '.owner_id=' . $userTableName . '.user_id')
			->group($userTableName . '.user_id')->order('product_count DESC');
    return Zend_Paginator::factory($select);
  }

    // get item like status
  public function getLikeStatus($product_id = '', $resource_type = '') {

    if ($product_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $resource_type)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('resource_id =?', $product_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }

  public function getCustomFieldMapData($item) {
    if ($item) {
      $db = Engine_Db_Table::getDefaultAdapter();
      return $db->query("SELECT GROUP_CONCAT(value) AS `valuesMeta`,IFNULL(TRIM(TRAILING ', ' FROM GROUP_CONCAT(DISTINCT(engine4_sesproduct_review_fields_options.label) SEPARATOR ', ')),engine4_sesproduct_review_fields_values.value) AS `value`, `engine4_sesproduct_review_fields_meta`.`label`, `engine4_sesproduct_review_fields_meta`.`type` FROM `engine4_sesproduct_review_fields_values` LEFT JOIN `engine4_sesproduct_review_fields_meta` ON engine4_sesproduct_review_fields_meta.field_id = engine4_sesproduct_review_fields_values.field_id LEFT JOIN `engine4_sesproduct_review_fields_options` ON engine4_sesproduct_review_fields_values.value = engine4_sesproduct_review_fields_options.option_id AND `engine4_sesproduct_review_fields_meta`.`type` = 'multi_checkbox' WHERE (engine4_sesproduct_review_fields_values.item_id = ".$item->getIdentity().") AND (engine4_sesproduct_review_fields_values.field_id != 1) GROUP BY `engine4_sesproduct_review_fields_meta`.`field_id`,`engine4_sesproduct_review_fields_options`.`field_id`")->fetchAll();
    }
    return array();
  }

  public function getSpecialAlbum(User_Model_User $user, $type = 'sesproduct') {
    $table = Engine_Api::_()->getItemTable('album');
    $select = $table->select()
        ->where('owner_type = ?', $user->getType())
        ->where('owner_id = ?', $user->getIdentity())
        ->where('type = ?', $type)
        ->order('album_id ASC')
        ->limit(1);
    $album = $table->fetchRow($select);
    // Create wall photos album if it doesn't exist yet
    if( null === $album ) {
      $translate = Zend_Registry::get('Zend_Translate');
      $album = $table->createRow();
      $album->owner_type = 'user';
      $album->owner_id = $user->getIdentity();
      $album->title = $translate->_(ucfirst($type) . ' Photos');
      $album->type = $type;
      $album->search = 1;
      $album->save();
      // Authorizations
			$auth = Engine_Api::_()->authorization()->context;
			$auth->setAllowed($album, 'everyone', 'view',    true);
			$auth->setAllowed($album, 'everyone', 'comment', true);
    }
    return $album;
  }

	public function allowReviewRating() {
		if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.allow.review', 1))
		return true;

		return false;
	}

	public function isProductAdmin($product = null, $privacy = null) {
	  $viewer = Engine_Api::_()->user()->getViewer();
	  $viewer->getIdentity();
	  if($viewer->getIdentity()) {
      if($viewer->level_id == 1 || $viewer->level_id == 2)
      return 1;
	  }
	  if(!isset($product->owner_id))
	  return 0;
	  $level_id = Engine_Api::_()->getItem('user', $product->owner_id)->level_id;
	  if($privacy == 'create') {
	   if($product->authorization()->isAllowed(null, 'video'))
	   return 1;
	   elseif($this->checkProductAdmin($product))
	   return 1;
	   else
	   return 0;
	  }
	  elseif($privacy == 'music_create') {
	   if(Engine_Api::_()->authorization()->isAllowed('sesmusic_album', 'create'))
	   return 1;
	   elseif($this->checkProductAdmin($product))
	   return 1;
	   else
	   return 0;
	  }
	  else {
			if(!Engine_Api::_()->authorization()->getPermission($level_id, 'sesproduct', $privacy))
			return 0;
			else {
				$productAdmin = $this->checkProductAdmin($product);
				if($productAdmin)
				return 1;
				else
				return 0;
			}
	  }
	}
	public function checkProductAdmin($product = null) {
	   $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
	   $roleTable = Engine_Api::_()->getDbTable('roles', 'sesproduct');
	   return $roleTable->select()->from($roleTable->info('name'), 'role_id')
	                    ->where('product_id = ?', $product->product_id)
	                    ->where('user_id =?', $viewerId)
	                    ->query()
	                    ->fetchColumn();

	}
	public function deleteProduct($sesproduct = null){
		if(!$sesproduct)
			return false;

		$owner_id = $sesproduct->owner_id;
		$product_id = $sesproduct->product_id;
		//Delete album
		$sesproductAlbumTable = Engine_Api::_()->getDbtable('albums', 'sesproduct');
		$sesproductAlbumTable->delete(array(
			'product_id = ?' => $product_id,
		));

		//Delete Photos
		$sesproductPhotosTable = Engine_Api::_()->getDbtable('photos', 'sesproduct');
		$sesproductPhotosTable->delete(array(
			'product_id = ?' => $product_id,
		));

		//Delete Reviews
		$sesproductPhotosTable = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct');
		$sesproductPhotosTable->delete(array(
			'product_id = ?' => $product_id,
		));

		//Delete Favourites
		$sesproductFavouritesTable = Engine_Api::_()->getDbtable('favourites', 'sesproduct');
		$sesproductFavouritesTable->delete(array(
			'resource_id = ?' => $product_id,
		));


        //deletes order
		$orderTable = Engine_Api::_()->getDbtable('orderproducts', 'sesproduct');
		$orderTable->delete(array(
			'product_id = ?' => $product_id,
		));

        //deletes wishlist
		$orderTable = Engine_Api::_()->getDbtable('Wishlists', 'sesproduct');
		$orderTable->delete(array(
			'product_id = ?' => $product_id,
		));

		//deletes Playlistproducts
		$orderTable = Engine_Api::_()->getDbtable('Playlistproducts', 'sesproduct');
		$orderTable->delete(array(
			'file_id = ?' => $product_id,
		));
		//Product Count Decrease
        $store = Engine_Api::_()->getItem('stores', $sesproduct->store_id);

        $store->product_count--;
        $store->save();
		$sesproduct->delete();
	}

	public function checkProductStatus() {
		$table = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct');
		$select = $table->select()
		->where('publish_date is NOT NULL AND publish_date <= "'.date('Y-m-d H:i:s').'"')
		->where('draft =?', 0)
		->where('is_publish =?', 0);
		$products = $table->fetchAll($select);
		if(count($products) > 0) {
			foreach($products as $product) {
			  $sesproduct = Engine_Api::_()->getItem('sesproduct', $product->product_id);
				$action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($sesproduct);
				if(count($action->toArray()) <= 0) {
					$viewer = Engine_Api::_()->getItem('user', $product->owner_id);
					$action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesproduct, 'sesproduct_new');
					// make sure action exists before attaching the sesproduct to the activity
					if( $action ) {
						Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesproduct);
					}
					Engine_Api::_()->getItemTable('sesproduct')->update(array('is_publish' => 1,'publish_date'=>date('Y-m-d H:i:s')), array('product_id = ?' => $product->product_id));
				}
			}
		}
	}
    public function getWidgetParams($widgetId) {
        $db = Engine_Db_Table::getDefaultAdapter();
        $params = $db->select()
            ->from('engine4_core_content', 'params')
            ->where('`content_id` = ?', $widgetId)
            ->query()
            ->fetchColumn();
        return json_decode($params, true);
    }
	public function getTotalReviews($productId = null) {
	  $reviewTable = Engine_Api::_()->getDbTable('sesproductreviews', 'sesproduct');
	  return $reviewTable->select()
	  ->from($reviewTable->info('name'), new Zend_Db_Expr('COUNT(review_id)'))
	  ->where('product_id =?', $productId)
	  ->query()
	  ->fetchColumn();
	}
	public function outOfStock($item){
        if(empty($item))
            return false;
        if((empty($item->manage_stock) || $item->stock_quatity) && empty($this->outofstock)){
            return true;
        } else {
         $viewer = Engine_Api::_()->user()->getViewer();
           if($item->store_id){
                $store = Engine_Api::_()->getItem('stores',$item->store_id);
                $storeOwner = Engine_Api::_()->getItem('user', $store->owner_id);
                $productname = '<a href="'.$item->getHref().'">'.$item->getTitle().'</a>';
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($store->getOwner(), $viewer, $item, 'sesproduct_product_outOfStock', array('productname' => $productname));

                Engine_Api::_()->getApi('mail', 'core')->sendSystem($storeOwner->email, 'sesproduct_product_outOfStock', array('host' => $_SERVER['HTTP_HOST'],'product_name' => $item->getTitle(), 'queue' => false));

                $wishlists = Engine_Api::_()->getDbtable('wishlists', 'sesproduct')->getWishlistsProduct(array('product_id'=>$item->product_id));
                 $sesproduct = Engine_Api::_()->getItem('sesproduct', $item->product_id);
                foreach($wishlists as $wishlist){
                        $owner = Engine_Api::_()->getItem('user', $wishlist['owner_id']);
                         Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $item, $store, 'sesproduct_wishlist_product');

                          Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner->email, 'sesproduct_product_outOfStock', array('host' => $_SERVER['HTTP_HOST'],'product_name' => $item->getTitle(), 'queue' => false));
                }
            }
       }
     }
    public function getAdminnSuperAdmins() {
        $userTable = Engine_Api::_()->getDbTable('users', 'user');
        $select = $userTable->select()->from($userTable->info('name'), 'user_id')->where('level_id IN (?)', array(1,2));
        $results = $select->query()->fetchAll();
        return $results;
    }
}
