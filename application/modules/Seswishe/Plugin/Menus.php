<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seswishe_Plugin_Menus
{
  public function canCreateWishes()
  {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) {
      return false;
    }

    // Must be able to create wishes
    if( !Engine_Api::_()->authorization()->isAllowed('seswishe_wishe', $viewer, 'create') ) {
      return false;
    }

    return true;
  }

  public function canViewWishes()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    return true;
  }
}