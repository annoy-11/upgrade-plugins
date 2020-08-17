<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seswishe_AdminManageController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('seswishe_admin_main', array(), 'seswishe_admin_main_manage');
      
    $this->view->formFilter = $formFilter = new Seswishe_Form_Admin_Filter();

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $wishe = Engine_Api::_()->getItem('seswishe_wishe', $value);
          if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
            $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
            $dbGetInsert->query("DELETE FROM engine4_sesadvancedactivity_hashtags WHERE action_id = '".$wishe->action_id."'");
          }
          $wishe->delete();
        }
      }
    }
    
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();
      
    $values = array_merge(array('order' => isset($_GET['order']) ? $_GET['order'] :'', 'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : ''), $values);
    $this->view->assign($values);

    $page = $this->_getParam('page',1);
    
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    
    $wisheTable = Engine_Api::_()->getDbTable('wishes', 'seswishe');
    $wisheTableName = $wisheTable->info('name');
    
    $select = $wisheTable->select()
              ->setIntegrityCheck(false)
              ->from($wisheTableName)
              ->joinLeft($tableUserName, "$wisheTableName.owner_id = $tableUserName.user_id", 'username')
              ->order((!empty($_GET['order']) ? $_GET['order'] : 'wishe_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    
    if (!empty($_GET['name']))
      $select->where($wisheTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');
      
    if (!empty($_GET['source']))
      $select->where($wisheTableName . '.source LIKE ?', '%' . $_GET['source'] . '%');
    
    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    
     if (!empty($_GET['category_id']))
      $select->where($wisheTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($wisheTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($wisheTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);
      
    if (!empty($_GET['creation_date']))
    $select->where($wisheTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
    
		if (isset($_GET['subcat_id'])) {
			$formFilter->subcat_id->setValue($_GET['subcat_id']);
			$this->view->category_id = $_GET['category_id'];
		}

    if (isset($_GET['subsubcat_id'])) {
			$formFilter->subsubcat_id->setValue($_GET['subsubcat_id']);
			$this->view->subcat_id = $_GET['subcat_id'];
    }
    
    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
      if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
      continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
  
  //make item off the day
  public function ofthedayAction() {
  
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $type = $this->_getParam('type');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Seswishe_Form_Admin_Oftheday();
    if ($type == 'wishe') {
      $item = Engine_Api::_()->getItem('seswishe_wishe', $id);
      $form->setTitle("Wishe of the Day");
      $form->setDescription('Here, choose the start date and end date for this wishe to be displayed as "Wishe of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Wishe of the Day");
      $table = 'engine4_seswishe_wishes';
      $item_id = 'wishe_id';
    }

    if (!empty($id))
      $form->populate($item->toArray());
      
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d', strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));
      $db->update($table, array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("$item_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update($table, array('offtheday' => 0), array("$item_id = ?" => $id));
      } else {
        $db->update($table, array('offtheday' => 1), array("$item_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Successfully updated the item.')
      ));
    }
  }
  
  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->wishe_id=$id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try
      {
        $wishe = Engine_Api::_()->getItem('seswishe_wishe', $id);
        if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
          // delete the wishe entry into the database
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          $dbGetInsert->query("DELETE FROM engine4_sesadvancedactivity_hashtags WHERE action_id = '".$wishe->action_id."'");
        }
        $wishe->delete();
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
          'messages' => array('')
      ));
    }

    // Output
    $this->renderScript('admin-manage/delete.tpl');
  }
}