<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seschristmas_Plugin_Menus {

  public function canViewMyfriend() {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    if (empty($viewer_id)) {
      return false;
    }

    return true;
  }

}