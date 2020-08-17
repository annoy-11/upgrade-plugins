<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SesarticleController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_SesarticleController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // Get viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    
    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('sesarticle', $viewer, 'view')->isValid() ) {
      return;
    }

    // Get subject
    if( ($sesarticle_id = $this->_getParam('article_id',  $this->_getParam('id'))) &&
        ($sesarticle = Engine_Api::_()->getItem('sesarticle')) instanceof Sesarticle_Model_Sesarticle ) {
      Engine_Api::_()->core()->setSubject($sesarticle);
    } else {
      $sesarticle = null;
    }

    // Must have a subject
    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }

    // Must be allowed to view this sesarticle
    if( !$this->_helper->requireAuth()->setAuthParams($sesarticle, $viewer, 'view')->isValid() ) {
      return;
    }
  }
}