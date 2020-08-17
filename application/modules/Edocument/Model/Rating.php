<?php

class Edocument_Model_Rating extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;
  public function getTable()
  {
    if( is_null($this->_table) )
    {
      $this->_table = Engine_Api::_()->getDbtable('ratings', 'edocument');
    }
    return $this->_table;
  }

  public function getOwner($recurseType = null)
  {
    return parent::getOwner($recurseType);
  }
}
