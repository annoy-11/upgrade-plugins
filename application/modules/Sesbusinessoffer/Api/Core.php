<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessoffer_Api_Core extends Core_Api_Abstract {

  public function deleteOffer($offer) {

    //Delete views entries
    Engine_Api::_()->getDbtable('recentlyviewitems', 'sesbusiness')->delete(array('resource_id = ?' => $offer->getIdentity(), 'resource_type = ?' => $offer->getType()));

    // delete activity feed and its comments/likes
    $item = Engine_Api::_()->getItem('businessoffer', $offer->getIdentity());
    if ($item) {
      $item->delete();
    }
  }
}
