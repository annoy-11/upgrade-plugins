<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SeslistingController.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_SeslistingController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // Get viewer
    $viewer = Engine_Api::_()->user()->getViewer();

    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('seslisting', $viewer, 'view')->isValid() ) {
      return;
    }

    // Get subject
    if( ($seslisting_id = $this->_getParam('listing_id',  $this->_getParam('id'))) &&
        ($seslisting = Engine_Api::_()->getItem('seslisting')) instanceof Seslisting_Model_Seslisting ) {
      Engine_Api::_()->core()->setSubject($seslisting);
    } else {
      $seslisting = null;
    }

    // Must have a subject
    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }

    // Must be allowed to view this seslisting
    if( !$this->_helper->requireAuth()->setAuthParams($seslisting, $viewer, 'view')->isValid() ) {
      return;
    }
  }
}
