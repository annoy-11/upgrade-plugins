<?php
class Ecoupon_AdminSettingsController extends Core_Controller_Action_Admin {
  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('ecoupon_admin_main', array(), 'ecoupon_admin_main_setting');
    $this->view->form = $form = new Ecoupon_Form_Admin_Global();
    include_once APPLICATION_PATH . "/application/modules/Ecoupon/controllers/defaultsettings.php";
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
        $settings = Engine_Api::_()->getApi('settings', 'core');
        foreach ($values as $key => $value) {
          if($settings->hasSetting($key, $value))
              $settings->removeSetting($key);
          if(is_null($value)) {
            $value = 0;
          }
          $settings->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }
  }
  public function createAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('ecoupon_admin_main', array(), 'ecoupon_admin_main_creation');
    $this->view->form = $form = new Ecoupon_Form_Admin_Create();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      $settings = Engine_Api::_()->getApi('settings', 'core');
        foreach ($values as $key => $value) {
          if($settings->hasSetting($key, $value))
          $settings->removeSetting($key);
          if(!$value && strlen($value) == 0)
          continue;
          $settings->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if (@$error)
          $this->_helper->redirector->gotoRoute(array());
    }
  }
  public function levelAction() {
  
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('ecoupon_admin_main', array(), 'ecoupon_admin_main_level');
    // Get level id
    if( null !== ($id = $this->_getParam('id')) ) {
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }
    if(!$level instanceof Authorization_Model_Level)
      throw new Engine_Exception('missing level');

    $id = $level->level_id;
    // Make form
    $this->view->form = $form = new Ecoupon_Form_Admin_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($id);

    // Populate values
    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    $form->populate($permissionsTable->getAllowed('coupon', $id, array_keys($form->getValues())));
    // Check post
    if( !$this->getRequest()->isPost())
      return;
    // Check validitiy
    if( !$form->isValid($this->getRequest()->getPost()))
      return;
    // Process
    $values = $form->getValues();
    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      // Set permissions
      $permissionsTable->setAllowed('coupon', $id, $values);
      $claimValue = array('create' => $values['allow_claim']);
      $permissionsTable->setAllowed('coupon_claim', $id, $claimValue);
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
    
  }
  public function couponFaqsAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('ecoupon_admin_main', array(), 'ecoupon_admin_main_faqs');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->form = $form = new Ecoupon_Form_Admin_CouponFaqs();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        $values = $form->getValues();
        foreach ($values as $key => $value) {
          $settings->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
    }
  }
  public function supportAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('ecoupon_admin_main', array(), 'ecoupon_admin_main_support');
  }
}

?>
