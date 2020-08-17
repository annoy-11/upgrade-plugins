<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Taxes.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Model_DbTable_Taxes extends Engine_Db_Table {
  protected $_rowClass = 'Estore_Model_Tax';
  function getTaxes($params = array()){
      $select = $this->select();
      if(!empty($params['is_admin'])){
          $select->where('is_admin =?',$params['is_admin']);
      }
      if(!empty($params['store_id'])){
          $select->where('store_id =?',$params['store_id']);
      }
      $select->order('tax_id DESC');
      return Zend_Paginator::factory($select);
  }

}