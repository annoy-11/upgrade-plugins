<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesloginpopup
 * @package    Sesloginpopup
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesloginpopup_Widget_LoginOrSignupController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Do not show if logged in
    if (Engine_Api::_()->user()->getViewer()->getIdentity()) {
      return $this->setNoRender();
    }

    // Display form
    $form = $this->view->form = new Sesloginpopup_Form_Login(array(
                'mode' => 'column',
            ));
    ;
    $form->setTitle(null)->setDescription(null);
    //$form->removeElement('forgot');

    // Facebook login
    if ('none' == Engine_Api::_()->getApi('settings', 'core')->core_facebook_enable) {
      $form->removeElement('facebook');
    }
    $sesloginpopup_widget = Zend_Registry::isRegistered('sesloginpopup_widget') ? Zend_Registry::get('sesloginpopup_widget') : null;
    if(empty($sesloginpopup_widget))
      return $this->setNoRender();
    // Check for recaptcha - it's too fat
    $this->view->noForm = false;
    if (($captcha = $form->getElement('captcha')) instanceof Zend_Form_Element_Captcha &&
            $captcha->getCaptcha() instanceof Zend_Captcha_ReCaptcha) {
      $this->view->noForm = true;
      $form->removeElement('email');
      $form->removeElement('password');
      $form->removeElement('captcha');
      $form->removeElement('submit');
      $form->removeElement('remember');
//      $form->removeElement('facebook');
//      $form->removeElement('twitter');
      $form->removeDisplayGroup('buttons');
    }
  }

  public function getCacheKey() {
    return false;
  }

}
