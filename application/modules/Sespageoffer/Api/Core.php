<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageoffer_Api_Core extends Core_Api_Abstract {

  public function deleteOffer($offer) {

    //Delete views entries
    Engine_Api::_()->getDbtable('recentlyviewitems', 'sespage')->delete(array('resource_id = ?' => $offer->getIdentity(), 'resource_type = ?' => $offer->getType()));

    // delete activity feed and its comments/likes
    $item = Engine_Api::_()->getItem('pageoffer', $offer->getIdentity());
    if ($item) {
      $item->delete();
    }
  }
}
