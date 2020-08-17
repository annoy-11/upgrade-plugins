<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminScheduledController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbrowserpush_AdminScheduledController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesbrowserpush_admin_main', array(), 'sesbrowserpush_admin_main_scheduled');
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $item = Engine_Api::_()->getItem('sesbrowserpush_scheduled', $value);
          if($item){
            $item->delete();
          }
        }
      }
    }
    $this->view->paginator = Engine_Api::_()->getDbTable('scheduleds','sesbrowserpush')->getScheduled();
  }
  public function duplicateAction(){
    $id = $this->_getParam('id',false);
   $db = Engine_Db_Table::getDefaultAdapter();
   $db->query("CREATE TEMPORARY TABLE tmptable_2 SELECT * FROM `engine4_sesbrowserpush_scheduleds` WHERE scheduled_id = ".$id);
   $db->query("UPDATE tmptable_2 SET scheduled_id = NULL;");
   $db->query("INSERT INTO `engine4_sesbrowserpush_scheduleds` SELECT * FROM tmptable_2;");
   $notification_id = $db->lastInsertId();
   $db->query("DROP TEMPORARY TABLE IF EXISTS tmptable_2;");
   if(!$notification_id)
      return;
   $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('Notification Duplicated successfully.')
      ));
  }

  public function reportAction() {

    $id = $this->_getParam('scheduled_id',false);
    $this->view->scheduled = Engine_Api::_()->getItem('sesbrowserpush_scheduled',$id);

    $table = Engine_Api::_()->getDbTable('notifications','sesbrowserpush');
    $tableName = $table->info('name');

    $selectReceivers = $table->select()->from($tableName,'*')->where('param =?', '1')->where('scheduled_id =?', $id);
    $this->view->receivers = $table->fetchAll($selectReceivers);

    $selectClickeds = $table->select()->from($tableName,'*')->where('param =?', '2')->where('scheduled_id =?', $id);
    $this->view->clicked = $table->fetchAll($selectClickeds);
  }

  public function resendAction() {

    $id = $this->_getParam('id',false);

    $item = $scheduled = Engine_Api::_()->getItem('sesbrowserpush_scheduled',$id);

    // In smoothbox
    //$this->_helper->layout->setLayout('default-simple');
    $this->view->form = $form = new Sesbrowserpush_Form_Admin_Settings_Notification();
    $form->setTitle('Resend Notification?');
    $form->setDescription('Are you sure that you want to re-send this push notification?');
    $form->submit->setLabel('Send');
    //$form->submit->setLabel('Save Changes');
    $form->populate($item->toArray());
    if($item->criteria == 'memberlevel' && $form->memberlevel){
        $form->memberlevel->setValue($item->param);
    }else if($item->criteria == 'network' && $form->network){
        $form->network->setValue($item->param);
    }else if($item->criteria == 'user' && $form->toValues){
        $form->toValues->setValue($item->param);
        $users = explode(',',$item->param);
        $users = array_values(array_unique($users));
        $this->view->usersMulti = Engine_Api::_()->getItemMulti('user', $users);
    }
    $form->scheduled_time->setValue(date("Y-d-m H:i:s"));
    //$this->view->scheduled = true;

    if (!$item) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Resend Notification doesn't exists to delete");
      return;
    }
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
     $values = $form->getValues();

     $scheduledTable = Engine_Api::_()->getDbtable('scheduleds', 'sesbrowserpush');
     $db = $scheduledTable->getAdapter();
     $db->beginTransaction();
      try {
        //if(empty($scheduled))
        //$scheduled = $scheduledTable->createRow();
        if($values['criteria'] == 'all'){
            $values['param'] = '';
        }else if($values['criteria'] == 'memberlevel'){
            $values['param'] =$values['memberlevel'];
        }else if($values['criteria'] == 'network'){
            $values['param'] =$values['network'];
        }else if($values['criteria'] == 'user'){
            $values['param'] =$values['toValues'];
        }else{
            $values['param'] = $values['criteria'];
        }

        $scheduled = $scheduled->setFromArray($values);
        $scheduled->save();
        if(!empty($values['remove_icon_icon']))
          $scheduled->file_id = 0;
        $scheduled->save();
        if(!empty($_FILES['icon']['name'])){
          $file_ext = pathinfo($_FILES['icon']['name']);
          $file_ext = $file_ext['extension'];
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $storageObject = $storage->createFile($form->icon, array(
            'parent_id' => $scheduled->getIdentity(),
            'parent_type' => $scheduled->getType(),
            'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          if($storageObject->getIdentity()){
            $scheduled->file_id = $storageObject->getIdentity();
            $scheduled->save();
          }
        }
        //$db->commit();
      } catch(Exception $e) {
        //throw $e;
      }
    }
    $item = Engine_Api::_()->getItem('sesbrowserpush_scheduled',$id);

    $db = $item->getTable()->getAdapter();
    $db->beginTransaction();
    try {
     $values = $item;
     Engine_Api::_()->sesbrowserpush()->sendNotification($values);
     $id = $item->getIdentity();
     $db = Engine_Db_Table::getDefaultAdapter();
     $db->query("CREATE TEMPORARY TABLE tmptable_3 SELECT * FROM `engine4_sesbrowserpush_scheduleds` WHERE scheduled_id = ".$id);
     $db->query("UPDATE tmptable_3 SET scheduled_id = NULL;");
     $db->query("INSERT INTO `engine4_sesbrowserpush_scheduleds` SELECT * FROM tmptable_3;");
     $notification_id = $db->lastInsertId();
     $db->query("DROP TEMPORARY TABLE IF EXISTS tmptable_3;");
     $db->commit();
    } catch (Exception $e) {
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Notification Resend successfully.');
    return $this->_forward('success', 'utility', 'core', array(
                 'smoothboxClose' => 10,
          'parentRefresh'=> 10,
                'messages' => Array($this->view->message)
    ));
  }
  public function sentAction(){
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesbrowserpush_admin_main', array(), 'sesbrowserpush_admin_main_sentscheduled');

    $this->view->formFilter = $formFilter = new Sesbrowserpush_Form_Admin_Settings_Sent();
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

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $item = Engine_Api::_()->getItem('sesbrowserpush_scheduled', $value);
          if($item){
            $item->delete();
          }
        }
      }
    }

    $scheduleTable = Engine_Api::_()->getDbTable('scheduleds','sesbrowserpush');

    $select = $scheduleTable->select();
    $select->order('scheduled_id DESC');
    $select->where('sent =?',1);

    if (!empty($values['title']))
      $select->where('title LIKE ?', '%' . $values['title'] . '%');

    if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
        $startTime = date('Y-m-d', strtotime($_GET['from_date']));
        $endTime = date('Y-m-d', strtotime($_GET['to_date']));
        $select->where("DATE(creation_date) between ('$startTime') and ('$endTime')");
    }

    $this->view->paginator = $scheduleTable->fetchAll($select);

  }

  public function createAction(){
    $id = $this->_getParam('id',false);
    if($id)
      $scheduled = Engine_Api::_()->getItem('sesbrowserpush_scheduled',$id);
    $this->view->form = $form = new Sesbrowserpush_Form_Admin_Settings_Notification();
    $form->setTitle('Schedule Push Notifications');
    $form->setDescription('Here, you can configure and schedule the push notifications to be sent on later dates of your choice. You can also duplicate a notification to schedule the same message to be sent again. You can also edit or delete notifications. Use "Schedule New Notification" link to schedule a new notification.');
    $form->scheduled_time->setLabel('Choose Date & Time');
    if(empty($scheduled)) {
        $form->scheduled_time->setValue(date('Y-m-d H:i:s'));
        $form->submit->setLabel('Save Changes');
    } else {
      $form->submit->setLabel('Save Changes');
      $form->populate($scheduled->toArray());
      if($scheduled->criteria == 'memberlevel' && $form->memberlevel){
        $form->memberlevel->setValue($scheduled->param);
      }else if($scheduled->criteria == 'network' && $form->network){
        $form->network->setValue($scheduled->param);
      }else if($scheduled->criteria == 'user' && $form->toValues){
        $form->toValues->setValue($scheduled->param);
        $users = explode(',',$scheduled->param);
        $users = array_values(array_unique($users));
        $this->view->usersMulti = Engine_Api::_()->getItemMulti('user', $users);
      }
    }
    $form->scheduled_time->setValue(date("Y-d-m H:i:s"));
    $this->view->scheduled = true;

    if(!$this->getRequest()->isPost())
      return;

    if(!$form->isValid($this->getRequest()->getPost()))
      return;

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();

     $scheduledTable = Engine_Api::_()->getDbtable('scheduleds', 'sesbrowserpush');
     $db = $scheduledTable->getAdapter();
     $db->beginTransaction();
      try {
        if(empty($scheduled))
        $scheduled = $scheduledTable->createRow();
        if($values['criteria'] == 'all'){
            $values['param'] = '';
        }else if($values['criteria'] == 'memberlevel'){
            $values['param'] =$values['memberlevel'];
        }else if($values['criteria'] == 'network'){
            $values['param'] =$values['network'];
        }else if($values['criteria'] == 'user'){
            $values['param'] =$values['toValues'];
        }else{
            $values['param'] = $values['criteria'];
        }
        $scheduled = $scheduled->setFromArray($values);
        $scheduled->save();
        if(!empty($values['remove_icon_icon']))
          $scheduled->file_id = 0;
        $scheduled->save();
        if(!empty($_FILES['icon']['name'])){
          $file_ext = pathinfo($_FILES['icon']['name']);
          $file_ext = $file_ext['extension'];
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $storageObject = $storage->createFile($form->icon, array(
            'parent_id' => $scheduled->getIdentity(),
            'parent_type' => $scheduled->getType(),
            'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          if($storageObject->getIdentity()){
            $scheduled->file_id = $storageObject->getIdentity();
            $scheduled->save();
          }
        }
        $db->commit();
        $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('Notification Scheduled successfully.')
      ));
      } catch(Exception $e) {
        throw $e;
      }
    }
  }
  public function deleteAction(){
    $viewer = Engine_Api::_()->user()->getViewer();
    $id = $this->_getParam('id',false);
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesbrowserpush_Form_Delete();
    $form->setTitle('Delete Scheduled Notification?');
    $form->setDescription('Are you sure that you want to delete this scheduled notification? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    $item = Engine_Api::_()->getItem('sesbrowserpush_scheduled',$id);
    if (!$item) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Scheduled Notification doesn't exists to delete");
      return;
    }
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    $db = $item->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $item->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Scheduled Notification has been deleted.');
    return $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh'=> 10,
                'messages' => Array($this->view->message)
    ));
  }
}
