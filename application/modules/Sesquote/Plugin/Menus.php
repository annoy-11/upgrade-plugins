<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesquote_Plugin_Menus
{
  public function canCreateQuotes()
  {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) {
      return false;
    }

    // Must be able to create quotes
    if( !Engine_Api::_()->authorization()->isAllowed('sesquote_quote', $viewer, 'create') ) {
      return false;
    }

    return true;
  }

  public function canViewQuotes()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    return true;
  }
}