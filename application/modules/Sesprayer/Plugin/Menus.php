<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprayer_Plugin_Menus
{
  public function canCreatePrayers()
  {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) {
      return false;
    }

    // Must be able to create prayers
    if( !Engine_Api::_()->authorization()->isAllowed('sesprayer_prayer', $viewer, 'create') ) {
      return false;
    }

    return true;
  }

  public function canViewPrayers()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    return true;
  }
}