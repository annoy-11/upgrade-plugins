<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EblogController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_EblogController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // Get viewer
    $viewer = Engine_Api::_()->user()->getViewer();
    
    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('eblog', $viewer, 'view')->isValid() ) {
      return;
    }

    // Get subject
    if( ($eblog_id = $this->_getParam('blog_id',  $this->_getParam('id'))) &&
        ($eblog = Engine_Api::_()->getItem('eblog')) instanceof Eblog_Model_Eblog ) {
      Engine_Api::_()->core()->setSubject($eblog);
    } else {
      $eblog = null;
    }

    // Must have a subject
    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }

    // Must be allowed to view this eblog
    if( !$this->_helper->requireAuth()->setAuthParams($eblog, $viewer, 'view')->isValid() ) {
      return;
    }
  }
}