<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Rating.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Model_Rating extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;
  public function getTable() {

    if( is_null($this->_table) )
    {
      $this->_table = Engine_Api::_()->getDbtable('ratings', 'sescrowdfunding');
    }

    return $this->_table;
  }

  public function getOwner($recurseType = null)
  {
    return parent::getOwner($recurseType);
  }
}
