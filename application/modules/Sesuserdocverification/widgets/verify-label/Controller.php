<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserdocverification_Widget_VerifyLabelController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Don't render this if not authorized
    if( !Engine_Api::_()->core()->hasSubject())
      return $this->setNoRender();

    $this->view->distip = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesuserdocverification.distip', 1);

    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
    $sesuserdocverification_widget = Zend_Registry::isRegistered('sesuserdocverification_widget') ? Zend_Registry::get('sesuserdocverification_widget') : null;
    if(empty($sesuserdocverification_widget))
      return $this->setNoRender();
    $this->view->verifieddocuments = $verifieddocuments = Engine_Api::_()->getDbTable('documents', 'sesuserdocverification')->getAllUserDocuments(array('user_id' => $subject->getIdentity(), 'verified' => '1', 'fetchAll' => '1'));

    if(count($verifieddocuments) == 0)
        return $this->setNoRender();
  }
}
