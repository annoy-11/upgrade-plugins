<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoserver
 * @package    Sesssoserver
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesssoserver_AdminSettingsController extends Core_Controller_Action_Admin {

    public function globalsettingsAction() {

        $db = Engine_Db_Table::getDefaultAdapter();

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesssoserver_admin_main', array(), 'sesssoserver_admin_main_generalsettings');

        $this->view->form = $form = new Sesssoserver_Form_Admin_Global();

        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

            $values = $form->getValues();

            include_once APPLICATION_PATH . "/application/modules/Sesssoserver/controllers/License.php";
            if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesssoserver.pluginactivated')) {
                foreach ($values as $key => $value) {
                    if (Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
                        Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
                    if (!$value && strlen($value) == 0)
                        continue;
                    Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
                }
                $form->addNotice('Your changes have been saved.');
                if ($error)
                    $this->_helper->redirector->gotoRoute(array());
            }
        }
    }

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesssoserver_admin_main', array(), 'sesssoserver_admin_main_settings');
    $table = Engine_Api::_()->getDbTable('clients','sesssoserver');
    $this->view->paginator = $paginator = $table->fetchAll($table->select());
  }

  function addAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $client_id = $this->_getParam('client_id');
    $this->view->form = $form = new Sesssoserver_Form_Admin_Add();
    $profiles = $db->query("SELECT * FROM engine4_user_fields_options WHERE field_id = 1")->fetchAll();
    if(count($profiles)){
      foreach($profiles as $profile)
      $form->addElement('Text','profile_'.$profile['option_id'],array('label'=>$profile['label']));
    }
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
      $client = Engine_Api::_()->getItem('sesssoserver_clients',$client_id);
      $valueArray = $client->toArray();
      $uns = unserialize($client->params);

      if($uns)
      $valueArray = array_merge($valueArray,$uns);
      $form->populate($valueArray);
      $form->submit->setLabel('Save Changes');
    }

    // Check method/valid
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $values = $form->getValues();

    $table = Engine_Api::_()->getDbTable('clients','sesssoserver');

    if(!$client)
      $client = $table->createRow();

    $profileTypes = array();
    foreach($values as $key=>$value){
      if(strpos($key,'profile_') !== false){
        $profileTypes[$key] = $value;
      }
    }
    $values['params'] = serialize($profileTypes);
    $client->setFromArray($values);
    $client->save();
    // Forward
    return $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'format'=> 'smoothbox',
      'messages' => array('Your changes have been saved.')
    ));

  }
  //Delete entry
  public function deleteAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $content_type = $this->_getParam('content_type');
    if ($this->getRequest()->isPost()) {
      $client = Engine_Api::_()->getItem('sesssoserver_clients', $this->_getParam('id'));
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
    $content = Engine_Api::_()->getItem('sesssoserver_clients',$client_id);
    $content->active = !$content->active;
    $content->save();
    header('Location:'.$_SERVER['HTTP_REFERER']);
    exit();
  }
}
