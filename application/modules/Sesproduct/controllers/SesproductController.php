<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SesproductController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_SesproductController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // Get viewer
    $viewer = Engine_Api::_()->user()->getViewer();

    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('sesproduct', $viewer, 'view')->isValid() ) {
      return;
    }

    // Get subject
    if( ($sesproduct_id = $this->_getParam('product_id',  $this->_getParam('id'))) &&
        ($sesproduct = Engine_Api::_()->getItem('sesproduct')) instanceof Sesproduct_Model_Sesproduct ) {
      Engine_Api::_()->core()->setSubject($sesproduct);
    } else {
      $sesproduct = null;
    }

    // Must have a subject
    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }

    // Must be allowed to view this sesproduct
    if( !$this->_helper->requireAuth()->setAuthParams($sesproduct, $viewer, 'view')->isValid() ) {
      return;
    }
  }
}
