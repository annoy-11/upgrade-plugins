<?php
class Seshtmlbackground_Widget_LoginOrSignupController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
		$this->view->idI = $this->_getParam('id');
		$this->view->registerActive = $this->_getParam('registerActive');
		
    // Do not show if logged in
    if( Engine_Api::_()->user()->getViewer()->getIdentity() ) {
      $this->setNoRender();
      return;
    }
    
    // Display form
    $form = $this->view->form = new Seshtmlbackground_Form_Login(array(
      'mode' => 'column',
    ));;
    $form->setTitle(null)->setDescription(null);
    $form->removeElement('forgot');

    // Facebook login
    if( 'none' == Engine_Api::_()->getApi('settings', 'core')->core_facebook_enable ) {
      $form->removeElement('facebook');
    }
    
    // Check for recaptcha - it's too fat
    $this->view->noForm = false;
    if( ($captcha = $form->getElement('captcha')) instanceof Zend_Form_Element_Captcha && 
        $captcha->getCaptcha() instanceof Zend_Captcha_ReCaptcha ) {
      $this->view->noForm = true;
      $emailFieldName = $form->getEmailElementFieldName();
      $form->removeElement($emailFieldName);
      $form->removeElement('password');
      $form->removeElement('captcha');
      $form->removeElement('submit');
      $form->removeElement('remember');
      $form->removeDisplayGroup('buttons');
    }
  }
  
  public function getCacheKey()
  {
    return false;
  }
}