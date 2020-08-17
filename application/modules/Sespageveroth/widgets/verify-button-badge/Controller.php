<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageveroth
 * @package    Sespageveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageveroth_Widget_VerifyButtonBadgeController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->allParams = $allParams = $this->_getAllParams();

    // Don't render this if not authorized
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return $this->setNoRender();
    }
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();


    $this->view->type = 'sespage_page';

    // Get subject and check auth
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('sespage_page');
    if( !$subject->authorization()->isAllowed($viewer, 'view') ) {
      return $this->setNoRender();
    }
    $this->view->subject_id = $subject_id = $subject->getIdentity();
    $subjectOwner = $subject->getOwner();

    $this->view->enableverification = $enableverification = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageveroth.enableverification', 1);

    $this->view->verifybadge = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageveroth.verifybadge', '');

    $this->view->isVerify = $isVerify = Engine_Api::_()->getDbTable('verifications', 'sespageveroth')->isVerify(array('resource_id' => $subject_id));
    if($isVerify) {
      $this->view->verification = Engine_Api::_()->getItem('sespageveroth_verification', $isVerify);
    }

    $this->view->allow = $allow = Engine_Api::_()->authorization()->isAllowed('sespageveroth', null, 'allow');

    $this->view->edit = $edit = Engine_Api::_()->authorization()->isAllowed('sespageveroth', null, 'edit');

    $this->view->cancel = Engine_Api::_()->authorization()->isAllowed('sespageveroth', null, 'cancel');

    if($viewer->getIdentity()) {
        $this->view->enbeveriftion = $enbeveriftion = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sespageveroth', 'enbeveriftion');
        $this->view->vifitionlmt = $vifitionlmt = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sespageveroth', 'vifitionlmt');
        $this->view->verificationViewerlimit = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sespageveroth', 'vifitionlmt');
    } else {
        $this->view->enbeveriftion = $enbeveriftion = 0;
        $this->view->vifitionlmt = $vifitionlmt = 0;
        $this->view->verificationViewerlimit = 0;
    }

    $this->view->allRequests = Engine_Api::_()->getDbTable('verifications', 'sespageveroth')->getAllUserVerificationRequests($subject_id);

    $this->view->allViewerRequests = Engine_Api::_()->getDbTable('verifications', 'sespageveroth')->getAllUserVerificationRequests($viewer_id);


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
