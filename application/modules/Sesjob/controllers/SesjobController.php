<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SesjobController.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_SesjobController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // Get viewer
    $viewer = Engine_Api::_()->user()->getViewer();

    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('sesjob', $viewer, 'view')->isValid() ) {
      return;
    }

    // Get subject
    if( ($sesjob_id = $this->_getParam('job_id',  $this->_getParam('id'))) &&
        ($sesjob = Engine_Api::_()->getItem('sesjob')) instanceof Sesjob_Model_Sesjob ) {
      Engine_Api::_()->core()->setSubject($sesjob);
    } else {
      $sesjob = null;
    }

    // Must have a subject
    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }

    // Must be allowed to view this sesjob
    if( !$this->_helper->requireAuth()->setAuthParams($sesjob, $viewer, 'view')->isValid() ) {
      return;
    }
  }
}
