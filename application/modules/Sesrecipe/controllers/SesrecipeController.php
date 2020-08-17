<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SesrecipeController.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_SesrecipeController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // Get viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    
    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('sesrecipe', $viewer, 'view')->isValid() ) {
      return;
    }

    // Get subject
    if( ($sesrecipe_id = $this->_getParam('recipe_id',  $this->_getParam('id'))) &&
        ($sesrecipe = Engine_Api::_()->getItem('sesrecipe')) instanceof Sesrecipe_Model_Sesrecipe ) {
      Engine_Api::_()->core()->setSubject($sesrecipe);
    } else {
      $sesrecipe = null;
    }

    // Must have a subject
    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }

    // Must be allowed to view this sesrecipe
    if( !$this->_helper->requireAuth()->setAuthParams($sesrecipe, $viewer, 'view')->isValid() ) {
      return;
    }
  }
}