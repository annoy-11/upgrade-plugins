<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Cartproductsoptions.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Cartproductsoptions extends Engine_Db_Table {

  protected $_rowClass = 'Sesproduct_Model_Cartproductsoption';
  protected $_name = 'sesproduct_cartproducts_fields_options';

  public function getOptionsLabel($option_id) {
    return $this->select()
                    ->from($this->info('name'), array('label'))
                    ->where('option_id = ?', $option_id)
                    ->query()
                    ->fetchColumn();
  }
    public function getOption($option_id) {
        return $this->fetchRow($this->select()
            ->from($this->info('name'), '*')
            ->where('option_id = ?', $option_id));
    }
    function getOptionFields($field_id = 0){
        return $this->fetchAll($this->select()
            ->from($this->info('name'), '*')->where('field_id =?',$field_id));
    }
	public function getAllOptions() {
    return $this->fetchAll($this->select()
                    ->from($this->info('name'), '*'));

  }
}
