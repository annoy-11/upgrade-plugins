<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvsitenotification
 * @package    Sesadvsitenotification
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-01-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvsitenotification_Widget_NotificationController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if(!Engine_Api::_()->user()->getViewer()->getIdentity())
      $this->setNoRender();
    $this->view->enable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvsitenotification.notification',1);
    $this->view->position = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvsitenotification.position','sesadvnotification-bottom-left');
    $this->view->autohide = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvsitenotification.autohide',1);
    $this->view->autohideduration = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvsitenotification.autohideduration','10000');
    if(!$this->view->enable)
      $this->setNoRender();
    $sesadvsitenotification_widget = Zend_Registry::isRegistered('sesadvsitenotification_widget') ? Zend_Registry::get('sesadvsitenotification_widget') : null;
    if(empty($sesadvsitenotification_widget)) {
      return $this->setNoRender();
    }
  }
}
