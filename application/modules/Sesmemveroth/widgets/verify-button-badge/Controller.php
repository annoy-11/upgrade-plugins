<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmemveroth_Widget_VerifyButtonBadgeController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->allParams = $allParams = $this->_getAllParams();

    // Don't render this if not authorized
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return $this->setNoRender();
    }
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->type = 'user';

    // Get subject and check auth
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('user');
    if( !$subject->authorization()->isAllowed($viewer, 'view') ) {
      return $this->setNoRender();
    }
    $this->view->subject_id = $subject_id = $subject->getIdentity();

//     $sesmemveroth_verification = Zend_Registry::isRegistered('sesmemveroth_verification') ? Zend_Registry::get('sesmemveroth_verification') : null;
//     if(empty($sesmemveroth_verification)) {
//       return $this->setNoRender();
//     }

    $this->view->enableverification = $enableverification = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmemveroth.enableverification', 1);

    $this->view->verifybadge = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmemveroth.verifybadge', '');

    $this->view->isVerify = $isVerify = Engine_Api::_()->getDbTable('verifications', 'sesmemveroth')->isVerify(array('resource_id' => $subject_id));
    if($isVerify) {
      $this->view->verification = Engine_Api::_()->getItem('sesmemveroth_verification', $isVerify);
    }

    $this->view->allow = $allow = Engine_Api::_()->authorization()->isAllowed('sesmemveroth', null, 'allow');

    $this->view->edit = $edit = Engine_Api::_()->authorization()->isAllowed('sesmemveroth', null, 'edit');

    $this->view->cancel = Engine_Api::_()->authorization()->isAllowed('sesmemveroth', null, 'cancel');

    $this->view->enbeveriftion = $enbeveriftion = Engine_Api::_()->authorization()->getPermission($subject->level_id, 'sesmemveroth', 'enbeveriftion');

    $this->view->vifitionlmt = Engine_Api::_()->authorization()->getPermission($subject->level_id, 'sesmemveroth', 'vifitionlmt');

    $this->view->allRequests = Engine_Api::_()->getDbTable('verifications', 'sesmemveroth')->getAllUserVerificationRequests($subject_id);

    $this->view->allViewerRequests = Engine_Api::_()->getDbTable('verifications', 'sesmemveroth')->getAllUserVerificationRequests($viewer_id);
    $this->view->verificationViewerlimit = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesmemveroth', 'vifitionlmt');

    if(empty($viewer_id)) {
      if(count($this->view->allRequests) < $this->view->vifitionlmt) {
        return $this->setNoRender();
      }
    } else if($viewer_id) {
      if(count($this->view->allRequests) < $this->view->vifitionlmt && empty($enbeveriftion)) {
        return $this->setNoRender();
      }
    }

  }
}
