<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Combinations.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Combinations extends Engine_Db_Table {

  protected $_rowClass = 'Sesproduct_Model_Combination';
  protected $_name = 'sesproduct_cartproducts_combinations';

  function getCombinations($params = array()){
      $select = $this->select()->from($this->info('name'),'*');
      $select->where('product_id =?',$params['product_id']);
      $combinationTableName = "engine4_sesproduct_cartproducts_combinationmaps";
      $optionTableName = "engine4_sesproduct_cartproducts_fields_options";
      $db = Engine_Db_Table::getDefaultAdapter();

      $result = $db->query("SELECT engine4_sesproduct_cartproducts_combinations.*,GROUP_CONCAT(option_id) as options 
      FROM `engine4_sesproduct_cartproducts_combinations` LEFT JOIN engine4_sesproduct_cartproducts_combinationmaps 
      ON engine4_sesproduct_cartproducts_combinationmaps.combination_id = engine4_sesproduct_cartproducts_combinations.combination_id
       WHERE product_id = ".$params['product_id']." GROUP BY engine4_sesproduct_cartproducts_combinations.combination_id")->fetchAll();

      return $result;
  }
    function getTotalQuantity($product){
        $db = Engine_Db_Table::getDefaultAdapter();
        $result = $db->query("SELECT SUM(quantity) as quantity 
        FROM `engine4_sesproduct_cartproducts_combinations` LEFT JOIN engine4_sesproduct_cartproducts_combinationmaps 
        ON engine4_sesproduct_cartproducts_combinationmaps.combination_id = engine4_sesproduct_cartproducts_combinations.combination_id 
        WHERE product_id = ".$product->getIdentity()." GROUP BY engine4_sesproduct_cartproducts_combinations.combination_id
")->fetchAll();
        if(count($result)){
            return $result[0]['quantity'];
        }
        return 0;
   }
}
