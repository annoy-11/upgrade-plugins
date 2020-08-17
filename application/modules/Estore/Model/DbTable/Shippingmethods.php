<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Shippingmethods.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Shippingmethods extends Engine_Db_Table {
  protected $_rowClass = 'Estore_Model_Shippingmethod';
  function getShippingmethods($params = array()){
      $select = $this->select();
      if(!empty($params['store_id'])){
          $select->where('store_id =?',$params['store_id']);
      }
      $select->order('shippingmethod_id DESC');
      return Zend_Paginator::factory($select);
  }

  //get product shipping methods
    function getCartProductShippingMethods($params = array()){
        $shippingMethodsReturn = array();
        $select = $this->select()
            ->where('store_id = ?', $params['store_id'])
            ->where('status =?','1')
            ->where("(country_id = 0 OR (country_id = ".$params['country_id']." AND (state_id = 0 OR state_id = ".$params['state_id'].")))")
            ->order('creation_date ASC');
        //check criteria for shipping method
        $counter = 0;
        $shippingMethods = $this->fetchAll($select);
        foreach($shippingMethods as $shippingMethod){
            if ($shippingMethod->types == 0) {
                if ($params['total_weight'] >= $shippingMethod['weight_min'] && (empty($shippingMethod['weight_max']) || $params['total_weight'] <= $shippingMethod['weight_max'])) {
                    if ($shippingMethod['types'] == 0) {
                        if ($params['total_price'] >= $shippingMethod['cost_min'] && (empty($shippingMethod['cost_max']) || $params['total_price'] <= $shippingMethod['cost_max'])) {
                            if ($shippingMethod['price_type'] == 0) {
                                $shippingMethodsReturn[$counter]['shippingmethod_id'] = $shippingMethod['shippingmethod_id'];
                                $shippingMethodsReturn[$counter]['title'] = $shippingMethod['title'];
                                $shippingMethodsReturn[$counter]['store_id'] = $shippingMethod['store_id'];
                                $shippingMethodsReturn[$counter]['price'] = @round($shippingMethod['price'], 2);
                                $shippingMethodsReturn[$counter]['delivery_time'] = $shippingMethod['delivery_time'];
                                $counter++;
                            } else {
                                $shippingMethodsReturn[$counter]['shippingmethod_id'] = $shippingMethod['shippingmethod_id'];
                                $shippingMethodsReturn[$counter]['delivery_time'] = $shippingMethod['delivery_time'];
                                $shippingMethodsReturn[$counter]['title'] = $shippingMethod['title'];
                                $shippingMethodsReturn[$counter]['store_id'] = $shippingMethod['store_id'];
                                $shippingMethodsReturn[$counter]['price'] = @round(($shippingMethod['price'] / 100) * $params['total_price'], 2);
                                $counter++;
                            }
                        }
                    } else {
                        if ($params['total_quantity'] >= $shippingMethod['product_min'] && (empty($shippingMethod['product_max']) || $params['total_quantity'] <= $shippingMethod['product_max'])) {
                            if ($shippingMethod['deduction_type'] == 1) {
                                $shippingMethodsReturn[$counter]['shippingmethod_id'] = $shippingMethod['shippingmethod_id'];
                                $shippingMethodsReturn[$counter]['delivery_time'] = $shippingMethod['delivery_time'];
                                $shippingMethodsReturn[$counter]['title'] = $shippingMethod['title'];
                                $shippingMethodsReturn[$counter]['store_id'] = $shippingMethod['store_id'];
                                $shippingMethodsReturn[$counter]['price'] = @round($shippingMethod['price'], 2);
                                $counter++;
                            } else {
                                if ($shippingMethod['price_type'] == 0) {
                                    $shippingMethodsReturn[$counter]['shippingmethod_id'] = $shippingMethod['shippingmethod_id'];
                                    $shippingMethodsReturn[$counter]['delivery_time'] = $shippingMethod['delivery_time'];
                                    $shippingMethodsReturn[$counter]['title'] = $shippingMethod['title'];
                                    $shippingMethodsReturn[$counter]['store_id'] = $shippingMethod['store_id'];
                                    $shippingMethodsReturn[$counter]['price'] = @round($shippingMethod['price'] * $params['total_quantity'], 2);
                                    $counter++;
                                } else {
                                    $shippingMethodsReturn[$counter]['shippingmethod_id'] = $shippingMethod['shippingmethod_id'];
                                    $shippingMethodsReturn[$counter]['delivery_time'] = $shippingMethod['delivery_time'];
                                    $shippingMethodsReturn[$counter]['title'] = $shippingMethod['title'];
                                    $shippingMethodsReturn[$counter]['store_id'] = $shippingMethod['store_id'];
                                    $shippingMethodsReturn[$counter]['price'] = @round(($shippingMethod['price'] / 100) * $params['total_price'], 2);
                                    $counter++;
                                }
                            }
                        }
                    }
                }
            }else {
                if ($params['total_weight'] >= $shippingMethod['weight_min'] && (empty($shippingMethod['weight_max']) || $params['total_weight'] <= $shippingMethod['weight_max'])) {
                    if ($shippingMethod['price_type'] != 2) {
                        if ($shippingMethod['price_type'] == 0) {
                            //fixed
                            $shippingMethodsReturn[$counter]['shippingmethod_id'] = $shippingMethod['shippingmethod_id'];
                            $shippingMethodsReturn[$counter]['title'] = $shippingMethod['title'];
                            $shippingMethodsReturn[$counter]['price'] = @round($shippingMethod['price'], 2);
                            $shippingMethodsReturn[$counter]['delivery_time'] = $shippingMethod['delivery_time'];
                            $counter++;
                        } else {
                            $shippingMethodsReturn[$counter]['shippingmethod_id'] = $shippingMethod['shippingmethod_id'];
                            $shippingMethodsReturn[$counter]['title'] = $shippingMethod['title'];
                            $shippingMethodsReturn[$counter]['delivery_time'] = $shippingMethod['delivery_time'];
                            $shippingMethodsReturn[$counter]['price'] = @round(($shippingMethod['price'] / 100) * $params['total_price'], 2);
                            $counter++;
                        }
                    } else {
                        //per unit weight
                        $shippingMethodsReturn[$counter]['shippingmethod_id'] = $shippingMethod['shippingmethod_id'];
                        $shippingMethodsReturn[$counter]['delivery_time'] = $shippingMethod['delivery_time'];
                        $shippingMethodsReturn[$counter]['title'] = $shippingMethod['title'];
                        $shippingMethodsReturn[$counter]['price'] = @round(ceil($params['total_weight']) * $shippingMethod['price'], 2);
                        $counter++;
                    }
                }
            }
        }
        return $shippingMethodsReturn;
    }
   /* function getShippingMethods($params = array()){

        $select = $this->select()
            ->where('store_id = ?', $params['store_id'])
            ->where('status =?','1')
            ->order('creation_date ASC');
        //check criteria for shipping method
        $Methods = $this->fetchAll($select);

        return $Methods;
    }*/

}
