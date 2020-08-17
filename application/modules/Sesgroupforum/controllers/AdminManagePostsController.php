<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManagePostsController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_AdminManagePostsController extends Core_Controller_Action_Admin {

  public function indexAction() {
    
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroup_admin_main', array(), 'sesgroup_admin_main_sesgroupforum');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroupforum_admin_main', array(), 'sesgroupforum_admin_main_manageposts');
    
    $this->view->formFilter = $formFilter = new Sesgroupforum_Form_Admin_FilterPost();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sesgroupforum = Engine_Api::_()->getItem('sesgroupforum_post', $value);
          $sesgroupforum->delete();
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
    $postTable = Engine_Api::_()->getDbTable('posts', 'sesgroupforum');
    $postTableName = $postTable->info('name');
    $select = $postTable->select()
    ->setIntegrityCheck(false)
    ->from($postTableName)
    ->joinLeft($tableUserName, "$postTableName.user_id = $tableUserName.user_id", 'username')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'post_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
    $select->where($postTableName . '.body LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (!empty($_GET['creation_date']))
    $select->where($postTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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
    $this->view->post_id=$id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try
      {
        $sesgroupforum = Engine_Api::_()->getItem('sesgroupforum_post', $id);
        // delete the sesgroupforum entry into the database
        $sesgroupforum->delete();
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
    $this->renderScript('admin-manage-posts/delete.tpl');
  }
}
