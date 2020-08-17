<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupveroth
 * @package    Sesgroupveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupveroth_Widget_VerifyButtonBadgeController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->allParams = $allParams = $this->_getAllParams();

    // Don't render this if not authorized
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return $this->setNoRender();
    }
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();


    $this->view->type = 'sesgroup_group';

    // Get subject and check auth
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('sesgroup_group');
    if( !$subject->authorization()->isAllowed($viewer, 'view') ) {
      return $this->setNoRender();
    }
    $this->view->subject_id = $subject_id = $subject->getIdentity();
    $subjectOwner = $subject->getOwner();

    $this->view->enableverification = $enableverification = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupveroth.enableverification', 1);

    $this->view->verifybadge = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupveroth.verifybadge', '');

    $this->view->isVerify = $isVerify = Engine_Api::_()->getDbTable('verifications', 'sesgroupveroth')->isVerify(array('resource_id' => $subject_id));
    if($isVerify) {
      $this->view->verification = Engine_Api::_()->getItem('sesgroupveroth_verification', $isVerify);
    }

    $this->view->allow = $allow = Engine_Api::_()->authorization()->isAllowed('sesgroupveroth', null, 'allow');

    $this->view->edit = $edit = Engine_Api::_()->authorization()->isAllowed('sesgroupveroth', null, 'edit');

    $this->view->cancel = Engine_Api::_()->authorization()->isAllowed('sesgroupveroth', null, 'cancel');

    if($viewer_id) {
        $this->view->enbeveriftion = $enbeveriftion = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesgroupveroth', 'enbeveriftion');
        $this->view->vifitionlmt = $vifitionlmt = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesgroupveroth', 'vifitionlmt');
        $this->view->verificationViewerlimit = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesgroupveroth', 'vifitionlmt');
    } else {
        $this->view->enbeveriftion = $enbeveriftion = 0;
        $this->view->vifitionlmt = $vifitionlmt = 0;
        $this->view->verificationViewerlimit = 0;
    }

    $this->view->allRequests = Engine_Api::_()->getDbTable('verifications', 'sesgroupveroth')->getAllUserVerificationRequests($subject_id);

    $this->view->allViewerRequests = Engine_Api::_()->getDbTable('verifications', 'sesgroupveroth')->getAllUserVerificationRequests($viewer_id);


    if(empty($viewer_id)) {
      if(count($this->view->allRequests) < $this->view->vifitionlmt) {
        return $this->setNoRender();
      }
    } else if($viewer_id) {
      if($viewer_id == $subjectOwner->getIdentity()) {
        if(count($this->view->allRequests) == 0)
            return $this->setNoRender();
      }
      if(count($this->view->allRequests) < $this->view->vifitionlmt && empty($enbeveriftion)) {
        return $this->setNoRender();
      }
    }

  }
}
