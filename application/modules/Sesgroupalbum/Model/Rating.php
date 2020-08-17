<?php

class Sesgroupalbum_Model_Rating extends Core_Model_Item_Abstract
{
  public function getTable()
  {
    if( is_null($this->_table) )
    {
      $this->_table = Engine_Api::_()->getDbtable('ratings', 'sesgroupalbum');
    }

    return $this->_table;
  }

  public function getOwner()
  {
    return parent::getOwner();
  }
}
