<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesemailverification_Widget_EmailVerificationController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $rowExists = Engine_Api::_()->getDbTable('verifications', 'sesemailverification')->rowExists($viewer_id);

    if(!empty($rowExists))
      return $this->setNoRender();

    if(empty($viewer_id))
      return $this->setNoRender();

    $this->view->token = Engine_Api::_()->user()->getVerifyToken($viewer_id);

    $this->view->tipmessage = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesemailverification.tipmessage', 'We’re almost there! We just need you to verify and confirm your email address by clicking the link we sent. Go to Your inbox or %s.');

    $this->view->tipmessage1 = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesemailverification.tipmessage1', 'Resend the Verification Link.');
  }
}
