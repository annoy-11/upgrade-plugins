<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageTopicsController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_AdminManageTopicsController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesforum_admin_main', array(), 'sesforum_admin_main_managetopics');

    $this->view->formFilter = $formFilter = new Sesforum_Form_Admin_FilterTopic();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sesforum = Engine_Api::_()->getItem('sesforum_topic', $value);
          $sesforum->delete();
        }
      }
    }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
        $values = $formFilter->getValues();
    $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] :'',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);

    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $topicTable = Engine_Api::_()->getDbTable('topics', 'sesforum');
    $topicTableName = $topicTable->info('name');
    $select = $topicTable->select()
    ->setIntegrityCheck(false)
    ->from($topicTableName)
    ->joinLeft($tableUserName, "$topicTableName.user_id = $tableUserName.user_id", 'username')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'topic_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
    $select->where($topicTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
      $select->where($topicTableName . '.rating <> ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
      $select->where($topicTableName . '.rating = ?', $_GET['rating']);
      endif;
    }

    if (!empty($_GET['creation_date']))
    $select->where($topicTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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

  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->topic_id=$id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try
      {
        $sesforum = Engine_Api::_()->getItem('sesforum_topic', $id);
        // delete the sesforum entry into the database
        $sesforum->delete();
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
    $this->renderScript('admin-manage-topics/delete.tpl');
  }
}
