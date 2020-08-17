<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Quicksignup_Widget_LoginOrSignupPopupController extends Engine_Content_Widget_Abstract
{

  public function indexAction()
  {
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $this->view->pageIdentity = join('-', array(
      $request->getModuleName(),
      $request->getControllerName(),
      $request->getActionName()
    ));
    $quicksignup_widget = Zend_Registry::isRegistered('quicksignup_widget') ? Zend_Registry::get('quicksignup_widget') : null;
    if(empty($quicksignup_widget)) {
      return $this->setNoRender();
    }
    $notRenderPages = array('user-signup-index', 'user-auth-login','quicksignup-signup-index');
    if( Engine_Api::_()->user()->getViewer()->getIdentity() || in_array($this->view->pageIdentity, $notRenderPages) ) {
      $this->setNoRender();
      return;
    }
  }

  public function getCacheKey()
  {
    return false;
  }
}
