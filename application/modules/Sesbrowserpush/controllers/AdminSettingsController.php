<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbrowserpush_admin_main', array(), 'sesbrowserpush_admin_main_settings');
    
    $table_exist = $db->query('SHOW TABLES LIKE \'engine4_sesbrowserpush_notifications\'')->fetch();
    if($table_exist) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbrowserpush.pluginactivated', 1);
    }

    $this->view->form = $form = new Sesbrowserpush_Form_Admin_Settings_General();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
        $values = $form->getValues();
        include_once APPLICATION_PATH . "/application/modules/Sesbrowserpush/controllers/License.php";
        if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.pluginactivated')) {
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
  
  public function supportAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbrowserpush_admin_main', array(), 'sesbrowserpush_admin_main_support');

  }

  public function reportsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesbrowserpush_admin_main', array(), 'sesbrowserpush_admin_main_reports');

    $this->view->formFilter = $formFilter = new Sesbrowserpush_Form_Admin_Settings_Reports();

     // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array(
        'order' => 'notification_id',
        'order_direction' => 'DESC',
            ), $values);
    $this->view->assign($values);
    
    $table = Engine_Api::_()->getDbTable('notifications','sesbrowserpush');
    $tableName = $table->info('name');
     
    $tablesch = Engine_Api::_()->getDbTable('scheduleds','sesbrowserpush');
    $selectSent = $tablesch->select()->from($tablesch->info('name'),'*')->where('sent =?', '1');
    if (!empty($values['from_date']) && !empty($values['to_date'])) {
        $startTime = date('Y-m-d', strtotime($values['from_date']));
        $endTime = date('Y-m-d', strtotime($values['to_date']));
        $selectSent->where("DATE(creation_date) between ('$startTime') and ('$endTime')");
    }
    $this->view->sent = $tablesch->fetchAll($selectSent);
     
    $selectReceivers = $table->select()->from($table->info('name'),'*')->where('param =?', '1');
    if (!empty($values['from_date']) && !empty($values['to_date'])) {
        $startTime = date('Y-m-d', strtotime($values['from_date']));
        $endTime = date('Y-m-d', strtotime($values['to_date']));
        $selectReceivers->where("DATE(creation_date) between ('$startTime') and ('$endTime')");
    }
    $this->view->receivers = $table->fetchAll($selectReceivers);
    
    
    $selectClickeds = $table->select()->from($table->info('name'),'*')->where('param =?', '2');
    if (!empty($values['from_date']) && !empty($values['to_date'])) {
        $startTime = date('Y-m-d', strtotime($values['from_date']));
        $endTime = date('Y-m-d', strtotime($values['to_date']));
        $selectClickeds->where("DATE(creation_date) between ('$startTime') and ('$endTime')");
    }
    $this->view->clicked = $table->fetchAll($selectClickeds);
  }

  public function subscriberAction(){
     $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesbrowserpush_admin_main', array(), 'sesbrowserpush_admin_main_managesubscriber');

     $this->view->formFilter = $formFilter = new Sesbrowserpush_Form_Admin_Settings_Filter();

     // Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($values as $key => $value) {
      if (null === $value) {
        unset($values[$key]);
      }
    }

    $values = array_merge(array(
        'order' => 'user_id',
        'order_direction' => 'DESC',
            ), $values);
    $this->view->assign($values);

     $table = Engine_Api::_()->getDbTable('tokens','sesbrowserpush');
     $tableName = $table->info('name');
     $user = Engine_Api::_()->getDbTable('users','user');
     $userName = $user->info('name');
     $select = $user->select()->from($userName,array('user_id','email','username','displayname'))
              ->setIntegrityCheck(false)
              ->joinRight($tableName,$tableName.'.user_id = '.$userName.'.user_id',array('ip_address','creation_date','access_token','test_user', 'user_agent','token_id','browser'=>new Zend_Db_Expr('GROUP_CONCAT(browser)')))
              ->group("$tableName.user_id")
              ->group("access_token");
     if (!empty($values['ip_address']))
      $select->where('ip_address LIKE ?', '%' . $values['ip_address'] . '%');
    if (!empty($values['user_agent']))
      $select->where('user_agent LIKE ?', '%' . $values['user_agent'] . '%');
     if (!empty($values['displayname']))
      $select->where('displayname LIKE ?', '%' . $values['displayname'] . '%');
    if (!empty($values['browser']))
      $select->where('browser LIKE ?', '%' . $values['browser'] . '%');
    if (!empty($values['username']))
      $select->where('username LIKE ?', '%' . $values['username'] . '%');

    if (!empty($values['email']))
      $select->where('email LIKE ?', '%' . $values['email'] . '%');
    $select->order($tableName.'.token_id DESC');

     //Make paginator
     $page = $this->_getParam('page', 1);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(50);
  }
  public function testUserAction(){
    $token_id = $this->_getParam('token_id',false);
    $id = $this->_getParam('id',false);
    $action = $this->_getParam('act',false);
    $db = Engine_Db_Table::getDefaultAdapter();
    /*if($id)
      $where = 'user_id = '.$id;
    else*/
      $where = 'token_id = '.$token_id;
    if($action == 'remove')
      $condition = 0;
    else
      $condition = 1;
    $db->query("UPDATE engine4_sesbrowserpush_tokens SET test_user = ".$condition." WHERE ".$where);
    header("Location:".$_SERVER['HTTP_REFERER']);
    die;
  }
  public function fbSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesbrowserpush_admin_main', array(), 'sesbrowserpush_admin_main_fbsettings');
    $this->view->form = $form = new Sesbrowserpush_Form_Admin_Settings_Fbsettings();
    if( _ENGINE_ADMIN_NEUTER ) {
      $form->populate(array(
          'sesbrowserpush_serverkey' => '******',
          'sesbrowserpush_snippet' => '******',
      ));
    }
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
        foreach ($values as $key => $value) {
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
    }
  }

  public function welcomeAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesbrowserpush_admin_main', array(), 'sesbrowserpush_admin_main_welcome');
    $this->view->form = $form = new Sesbrowserpush_Form_Admin_Settings_Welcome();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        $values = $form->getValues();
        $image = '';
        if(!empty($values['remove_icon_icon']))
          Engine_Api::_()->getApi('settings', 'core')->setSetting('sesbrowserpush_welcomeicon', 0);
        foreach ($values as $key => $value) {
          if($key == 'icon' && $form->icon->getValue() != ''){
            $key = 'sesbrowserpush_welcomeicon';
            $file_ext = pathinfo($form->icon);
            $file_ext = $file_ext['extension'];
            $storage = Engine_Api::_()->getItemTable('storage_file');
            $storageObject = $storage->createFile($form->icon, array(
              'parent_id' => '1',
              'parent_type' => 'sesbrowserpush_token',
              'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
            ));
            // Remove temporary file
            @unlink($file['tmp_name']);
            if($storageObject->getIdentity()){
              $file = Engine_Api::_()->getItemTable('storage_file')->getFile($storageObject->getIdentity());
                if( $file ) {
                  $image =  $file->map();
                  $baseURL =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : 'http://';
                  $baseURL = $baseURL. $_SERVER['HTTP_HOST'];
                  if(strpos($image,'http') === false)
                    $image = $baseURL.$image;
                }
            }
            $value = $image;
          }
          if( Engine_Api::_()->getApi('settings', 'core')->hasSetting($key))
            Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
          if(!$value && !strlen($value))
            continue;
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function removesubscriberAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->token_id = $token_id = $this->_getParam('token_id');

    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try
      {
        $token = Engine_Api::_()->getItem('sesbrowserpush_token', $token_id);
        $token->delete();
        $db->commit();
      }

      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('You have Successfully removed subscriber from list.')
      ));
    }

    // Output
    $this->renderScript('admin-settings/removesubscriber.tpl');
  }

  public function notificationAction() {

    $this->view->user_id = $user_id = $this->_getParam('token_id',false);
    if(!$user_id)
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesbrowserpush_admin_main', array(), 'sesbrowserpush_admin_main_sendnoti');
    $this->view->form = $form = new Sesbrowserpush_Form_Admin_Settings_Notification();
    if($user_id){
      $this->view->isPopulated = true;
      $this->view->toObject = Engine_Api::_()->getItem('user',$user_id);
      $form->criteria->setAttrib('disabled',true);
      $form->token_id->setValue($user_id);
      $form->getElement('criteria')->addMultiOption($user_id,'Token Id');
      $form->criteria->setValue($user_id);
      //$form->toValues->setValue($user_id);
      $_POST['criteria'] = $user_id;
    }

    if ($this->getRequest()->isPost() && $form->isValid($_POST)) {

      $values = $form->getValues();
      $title = $values['title'];
      $body = $values['description'];
      $href = $values['link'];
      $image = '';
      if(!empty($_FILES['icon']['name'])){
        $file_ext = pathinfo($_FILES['icon']['name']);
        $file_ext = $file_ext['extension'];
        $storage = Engine_Api::_()->getItemTable('storage_file');
        $storageObject = $storage->createFile($form->icon, array(
          'parent_id' => '1',
          'parent_type' => 'sesbrowserpush_token',
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        ));
        // Remove temporary file
        @unlink($file['tmp_name']);
        if($storageObject->getIdentity()){
          $file = Engine_Api::_()->getItemTable('storage_file')->getFile($storageObject->getIdentity());
            if( $file ) {
              $image =  $file->map();
              $baseURL =(!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : 'http://';
              $baseURL = $baseURL. $_SERVER['HTTP_HOST'];
              if(strpos($image,'http') === false)
                $image = $baseURL.$image;
            }
        }
      }
      $params = '';
      if(!empty($_POST['test_user'])){
        $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('test_user'=>true));
      }else if(!empty($_POST['token_id'])){
        $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('token_id'=>$_POST['token_id']));
      }else if($values['criteria'] == 'all'){
        $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens();
      }else if($values['criteria'] == 'memberlevel'){
        $params = $level = $values['memberlevel'];
         $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('level'=>$level));
      }else if($values['criteria'] == 'network'){
         $params = $network = $values['network'];
          $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('network'=>$network));
      }else if($values['criteria'] == 'user'){
         $params = $user_ids = $values['toValues'];
          $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('user_ids'=>$user_ids));
      }else
          $tokens = Engine_Api::_()->getDbTable('tokens','sesbrowserpush')->getTokens(array('browser'=>$values['criteria']));
      
     if(empty($_POST['test_user'])) {
     
      
      $scheduleds = Engine_Api::_()->getDbTable('scheduleds','sesbrowserpush');
      
      $row = $scheduleds->createRow();
      $row->title = $title;
      $row->description = $body;
      $row->file_id = (!empty($storageObject) ? $storageObject->getIdentity() : 0);
      $row->criteria = $values['criteria'];
      $row->param = $params;
      $row->link = $href;
      $row->scheduled_time = '';
      $row->sent = '1';
      $row->creation_date = date('Y-m-d H:i:s');
      $row->save();
     
      Engine_Api::_()->sesbrowserpush()->sendPush(array('title'=>strip_tags($title),'body'=>$body,'icon'=>$image,'click_action'=>$href, 'scheduled_id' => $row->getIdentity()),$tokens);
      //$db = Engine_Db_Table::getDefaultAdapter();
      //$db->query("INSERT INTO `engine4_sesbrowserpush_scheduleds`(`title`, `description`, `file_id`, `criteria`, `param`, `link`, `scheduled_time`, `sent`, `creation_date`) VALUES ('".$title."','".$body."','".(!empty($storageObject) ? $storageObject->getIdentity() : 0)."','".$values['criteria']."','".$params."','".$href."','','1','".date('Y-m-d H:i:s')."')");
     }else{
        Engine_Api::_()->sesbrowserpush()->sendPush(array('title'=>strip_tags($title),'body'=>$body,'icon'=>$image,'click_action'=>$href),$tokens);
        echo "1";die;
     }
      if($user_id)
        $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => false,
          'messages' => array('Notification Sent Successfully.')
      ));
      $form->reset();
      $form->addNotice('Browser Notification Sent Successfully.');
    }
  }
}
