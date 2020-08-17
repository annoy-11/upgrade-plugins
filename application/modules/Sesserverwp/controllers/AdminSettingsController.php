<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesserverwp
 * @package    Sesserverwp
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2019-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesserverwp_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesserverwp_admin_main', array(), 'sesserverwp_admin_main_index');

    $this->view->form = $form = new Sesserverwp_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
        $values = $form->getValues();
        include_once APPLICATION_PATH . "/application/modules/Sesserverwp/controllers/License.php";
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesserverwp.pluginactivated')) {
            foreach ($values as $key => $value) {
            if($value != '')
              Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
            }
            $form->addNotice('Your changes have been saved.');
            if($error)
              $this->_helper->redirector->gotoRoute(array());
        }
    }
  }

  public function manageAction()
  {
  $db = Engine_Db_Table::getDefaultAdapter();
  $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesserverwp_admin_main', array(), 'sesserverwp_admin_main_manage');
     $table = Engine_Api::_()->getDbTable('clients','sesserverwp');
     $this->view->paginator = $paginator = $table->fetchAll($table->select());
  }

  function addAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $client_id = $this->_getParam('client_id');
    $this->view->form = $form = new Sesserverwp_Form_Admin_Add();
    $form->addElement('Button', 'submit', array(
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
      ));
  
      $form->addElement('Cancel', 'cancel', array(
          'label' => 'Cancel',
          'link' => true,
          'prependText' => ' or ',
          'onclick' => 'javascript:parent.Smoothbox.close()',
          'decorators' => array(
              'ViewHelper',
          ),
      ));
      $form->addDisplayGroup(array('submit', 'cancel'), 'buttons');

    if($client_id){
      $client = Engine_Api::_()->getItem('sesserverwp_clients',$client_id);
      $valueArray = $client->toArray();
      $uns = unserialize($client->params);

      if($uns)
      $valueArray = array_merge($valueArray,$uns);
      $form->populate($valueArray);
      $form->submit->setLabel('Save Changes');
    }
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $values = $form->getValues();

    $table = Engine_Api::_()->getDbTable('clients','sesserverwp');

    if(!$client)
      $client = $table->createRow();
    $client->setFromArray($values);
    $client->save();
    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'format'=> 'smoothbox',
      'messages' => array('Your changes have been saved.')
    ));
  }
  public function deleteAction()
  {
    $this->_helper->layout->setLayout('admin-simple');
    $content_type = $this->_getParam('content_type');
     if ($this->getRequest()->isPost()) {
      $client = Engine_Api::_()->getItem('sesserverwp_clients', $this->_getParam('id'));
      $client->delete();
      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully delete client.')
      ));
    }
  }
  //Enable / Disable Clients
  public function enabledAction() {
    $client_id = $this->_getParam('id');
    $content = Engine_Api::_()->getItem('sesserverwp_clients',$client_id);
    $content->active = !$content->active;
    $content->save();
    header('Location:'.$_SERVER['HTTP_REFERER']);
    exit();
  }
}
