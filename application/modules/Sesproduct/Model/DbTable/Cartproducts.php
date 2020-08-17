<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Cartproducts.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Cartproducts extends Engine_Db_Table {
   protected $_rowClass = "Sesproduct_Model_Cartproduct";
   protected $_type = 'sesproduct_cartproducts';
   function checkproductadded($params = array()){
        $productTable = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct');
        $productTableName =$productTable->info('name');
        $cartTable = $this->info('name');
        $select = $this->select()
        ->setIntegrityCheck(false)
        ->from($cartTable);
        if(!empty($params['cart_id'])){
            $select->where('cart_id =?',$params['cart_id']);
        }
        if(!empty($params['product_id'])){
           $select->where('product_id =?',$params['product_id']);
        }
        if($params['limit']){
            $select->joinLeft($productTableName, $productTableName . '.product_id = ' . $cartTable . '.product_id')
            ->query();
            return $this->fetchAll($select);
        }
        $select->limit(1);
        return $this->fetchRow($select);
   }
}
