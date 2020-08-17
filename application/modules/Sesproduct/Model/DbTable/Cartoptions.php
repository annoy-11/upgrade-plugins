<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Cartoptions.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Cartoptions extends Engine_Db_Table {
   protected $_rowClass = "Sesproduct_Model_Cartoption";
   function checkProduct($product){
       if($product){
           $product_id = $product->product_id;
           $select = $this->select()->where('product_id =?',$product_id);
           $attribute = $this->fetchRow($select);
           if(!$attribute){
               $row = $this->createRow();
               $row->product_id = $product_id;
               $row->creation_date = date('Y-m-d H:i:s');
               //insert in attribute options table
               $db = Engine_Db_Table::getDefaultAdapter();
               $db->query("INSERT INTO `engine4_sesproduct_cartproducts_fields_options`(`field_id`, `label`, `order`, `quantity`, `price`, `type`)
              VALUES (1,'".$product->getTitle()."',999,0,0,0)");
               $lastInsertId = $db->lastInsertId();
               $row->option_id = $lastInsertId;
               $row->save();
               return $row;
           }else{
               return $attribute;
           }
       }
   }
   function getAttribute($product){
       return $this->fetchRow($this->select()->where('product_id =?',$product->getIdentity()));
   }
}
