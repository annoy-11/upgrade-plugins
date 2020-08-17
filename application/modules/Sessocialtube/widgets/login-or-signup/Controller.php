<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sessocialtube_Widget_LoginOrSignupController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Do not show if logged in
    if (Engine_Api::_()->user()->getViewer()->getIdentity()) {
      $this->setNoRender();
      return;
    }

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $controllerName = $request->getControllerName();
    $actionName = $request->getActionName();

    // Display form
    $form = $this->view->form = new Sesbasic_Form_Login(array(
        'mode' => 'column',
    ));
    ;
    $form->setTitle(null)->setDescription(null);
    //$form->removeElement('forgot');
    // Facebook login
    if ('none' == Engine_Api::_()->getApi('settings', 'core')->core_facebook_enable) {
      $form->removeElement('facebook');
    }

    // Check for recaptcha - it's too fat
    $this->view->noForm = false;
//     if (($captcha = $form->getElement('captcha')) instanceof Zend_Form_Element_Captcha &&
//             $captcha->getCaptcha() instanceof Zend_Captcha_ReCaptcha) {
//       $this->view->noForm = true;
//       $form->removeElement('email');
//       $form->removeElement('password');
//       $form->removeElement('captcha');
//       $form->removeElement('submit');
//       $form->removeElement('remember');
// //      $form->removeElement('facebook');
// //      $form->removeElement('twitter');
//       $form->removeDisplayGroup('buttons');
//     }
  }

  public function getCacheKey() {
    return false;
  }

}
