<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seslinkedin_Widget_LoginOrSignupController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Do not show if logged in
    if (Engine_Api::_()->user()->getViewer()->getIdentity()) {
      return $this->setNoRender();
    }

    // Display form
    $form = $this->view->form = new Sesbasic_Form_Login(array(
                'mode' => 'column',
            ));
    ;
    $form->setTitle(null)->setDescription(null);
    //$form->removeElement('forgot');

    // FB login
    if ('none' == Engine_Api::_()->getApi('settings', 'core')->core_facebook_enable) {
      $form->removeElement('facebook');
    }

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
      $form->removeDisplayGroup('buttons');
    }

  }

  public function getCacheKey() {
    return false;
  }

}
