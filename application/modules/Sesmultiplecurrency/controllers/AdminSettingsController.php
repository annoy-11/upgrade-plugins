<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmultiplecurrency
 * @package    Sesmultiplecurrency
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-09-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */



class Sesmultiplecurrency_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmultiplecurrency_admin_main', array(), 'sesmultiplecurrency_admin_main_settings');
    
    $this->view->form = $form = new Sesmultiplecurrency_Form_Admin_Settings_General();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesmultiplecurrency/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmultiplecurrency.pluginactivated')) {
        foreach ($values as $key => $value) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
  
	public function currencyAction() {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesmultiplecurrency_admin_main', array(), 'sesmultiplecurrency_admin_main_currency');
    // Populate currency options
    $fullySupportedCurrencies = Engine_Api::_()->sesmultiplecurrency()->getSupportedCurrency();
    $this->view->fullySupportedCurrencies = $fullySupportedCurrencies;
  }
  
   //Enable Action
  public function activeAction() {
		$settings = Engine_Api::_()->getApi('settings', 'core');
    $id = $this->_getParam('id');
    if (!empty($id)) {
      $active = !$settings->getSetting('sesmultiplecurrency.'.$id.'active','0');
      $settings->setSetting('sesmultiplecurrency.'.$id.'active',$active);
    }
    $this->_redirect($_SERVER['HTTP_REFERER']);
  }
  public function editCurrencyAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->currency_symbol = $currency_symbol = $id;
    $this->view->form = $form = new Sesmultiplecurrency_Form_Admin_Settings_EditCurrency();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $getSetting = $settings->getSetting('sesmultiplecurrency.' . $currency_symbol);
    $form->getElement('currency_rate')->setValue($getSetting);
    $form->getElement('currency_symbol')->setValue($id);
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $settings->setSetting('sesmultiplecurrency.' . $_POST['currency_symbol'], $_POST['currency_rate']);
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array(Zend_Registry::get('Zend_Translate')->_('You have successfully edit currency.'))
      ));
    }
  }
  public function updateCurrencyAction(){
		ini_set('max_execution_time', 0);
		Engine_Api::_()->sesmultiplecurrency()->updateCurrencyValues();
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}
}