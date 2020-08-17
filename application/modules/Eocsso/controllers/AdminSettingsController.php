<?php
class Eocsso_AdminSettingsController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('eocsso_admin_main', array(), 'eocsso_admin_main_index');
    $this->view->form = $form = new Eocsso_Form_Admin_Global();
  }

  public function manageAction()
  {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('eocsso_admin_main', array(), 'eocsso_admin_main_manage');
    $table = Engine_Api::_()->getDbTable('clients', 'eocsso');
    $this->view->paginator = $paginator = $table->fetchAll($table->select());
  }

  function addAction()
  {
    $db = Engine_Db_Table::getDefaultAdapter();
    $client_id = $this->_getParam('client_id');
    $this->view->form = $form = new Eocsso_Form_Admin_Add();
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

    if ($client_id) {
      $client = Engine_Api::_()->getItem('eocsso_client', $client_id);
      $valueArray = $client->toArray();
      $uns = unserialize($client->params);

      if ($uns)
        $valueArray = array_merge($valueArray, $uns);
      $form->populate($valueArray);
      $form->submit->setLabel('Save Changes');
    }
    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    $values = $form->getValues();

    $table = Engine_Api::_()->getDbTable('clients', 'eocsso');

    if (!$client)
      $client = $table->createRow();
    $client->setFromArray($values);
    $client->save();
    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'format' => 'smoothbox',
      'messages' => array('Your changes have been saved.')
    ));
  }
  public function deleteAction()
  {
    $this->_helper->layout->setLayout('admin-simple');
    $content_type = $this->_getParam('content_type');
    if ($this->getRequest()->isPost()) {
      $client = Engine_Api::_()->getItem('eocsso_client', $this->_getParam('id'));
      $client->delete();
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 10,
        'parentRefresh' => 10,
        'messages' => array('You have successfully delete client.')
      ));
    }
  }
  //Enable / Disable Clients
  public function enabledAction()
  {
    $client_id = $this->_getParam('id');
    $content = Engine_Api::_()->getItem('eocsso_client', $client_id);
    $content->active = !$content->active;
    $content->save();
    header('Location:' . $_SERVER['HTTP_REFERER']);
    exit();
  }
}
