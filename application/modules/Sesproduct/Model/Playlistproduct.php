<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Playlistproduct.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Model_Playlistproduct extends Core_Model_Item_Abstract {

  public function getParent($recurseType = NULL) {
    return Engine_Api::_()->getItem('sesproduct_wishlist', $this->wishlist_id);
  }

}
