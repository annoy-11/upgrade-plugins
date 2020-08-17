<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Rating.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessvideo_Model_Rating extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;
  public function getTable() {
    if (is_null($this->_table)) {
      $this->_table = Engine_Api::_()->getDbtable('ratings', 'sesbusinessvideo');
    }

    return $this->_table;
  }

  public function getOwner($recurseType = NULL) {
    return parent::getOwner();
  }

}
