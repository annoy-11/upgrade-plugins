<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesquote_AdminManageController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesquote_admin_main', array(), 'sesquote_admin_main_manage');
      
    $this->view->formFilter = $formFilter = new Sesquote_Form_Admin_Filter();

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $quote = Engine_Api::_()->getItem('sesquote_quote', $value);
          if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
            $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
            $dbGetInsert->query("DELETE FROM engine4_sesadvancedactivity_hashtags WHERE action_id = '".$quote->action_id."'");
          }
          $quote->delete();
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
    
    $quoteTable = Engine_Api::_()->getDbTable('quotes', 'sesquote');
    $quoteTableName = $quoteTable->info('name');
    
    $select = $quoteTable->select()
              ->setIntegrityCheck(false)
              ->from($quoteTableName)
              ->joinLeft($tableUserName, "$quoteTableName.owner_id = $tableUserName.user_id", 'username')
              ->order((!empty($_GET['order']) ? $_GET['order'] : 'quote_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    
    if (!empty($_GET['name']))
      $select->where($quoteTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');
      
    if (!empty($_GET['source']))
      $select->where($quoteTableName . '.source LIKE ?', '%' . $_GET['source'] . '%');
    
    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    
     if (!empty($_GET['category_id']))
      $select->where($quoteTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($quoteTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($quoteTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);
      
    if (!empty($_GET['creation_date']))
    $select->where($quoteTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
    
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
    $this->view->form = $form = new Sesquote_Form_Admin_Oftheday();
    if ($type == 'quote') {
      $item = Engine_Api::_()->getItem('sesquote_quote', $id);
      $form->setTitle("Quote of the Day");
      $form->setDescription('Here, choose the start date and end date for this quote to be displayed as "Quote of the Day".');
      if (!$param)
        $form->remove->setLabel("Remove as Quote of the Day");
      $table = 'engine4_sesquote_quotes';
      $item_id = 'quote_id';
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
    $this->view->quote_id=$id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try
      {
        $quote = Engine_Api::_()->getItem('sesquote_quote', $id);
        if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
          // delete the quote entry into the database
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          $dbGetInsert->query("DELETE FROM engine4_sesadvancedactivity_hashtags WHERE action_id = '".$quote->action_id."'");
        }
        $quote->delete();
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