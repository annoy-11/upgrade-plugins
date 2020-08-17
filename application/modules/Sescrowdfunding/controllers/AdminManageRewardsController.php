<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageRewardsController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_AdminManageRewardsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_managerewards');

    $this->view->formFilter = $formFilter = new Sescrowdfunding_Form_Admin_Filterrewards();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $reward = Engine_Api::_()->getItem('sescrowdfunding_reward', $value);
          $reward->delete();
        }
      }
    }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    $values = array_merge(array('order' => isset($_GET['order']) ? $_GET['order'] :'', 'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : ''), $values);

    $this->view->assign($values);

    $crowdfundingTableName = Engine_Api::_()->getItemTable('crowdfunding')->info('name');

    $rewardsTable = Engine_Api::_()->getDbTable('rewards', 'sescrowdfunding');
    $rewardsTableName = $rewardsTable->info('name');

    $select = $rewardsTable->select()
                              ->setIntegrityCheck(false)
                              ->from($rewardsTableName)
                              ->joinLeft($crowdfundingTableName, "$rewardsTableName.crowdfunding_id = $crowdfundingTableName.crowdfunding_id",null)
                              ->order((!empty($_GET['order']) ? $_GET['order'] : 'reward_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['title']))
        $select->where($rewardsTableName . '.title LIKE ?', '%' . $_GET['title'] . '%');

    if (!empty($_GET['name']))
        $select->where($crowdfundingTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

     if (!empty($_GET['category_id']))
      $select->where($crowdfundingTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['creation_date']))
    $select->where($rewardsTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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

  public function deleteAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->reward_id = $id;
    if( $this->getRequest()->isPost() ) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $reward = Engine_Api::_()->getItem('sescrowdfunding_reward', $id);
        $reward->delete();
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('')
      ));
    }
    $this->renderScript('admin-manage/delete.tpl');
  }

  //view item function
  public function viewAction() {
    $id = $this->_getParam('id', 1);
    $item = Engine_Api::_()->getItem('sescrowdfunding_reward', $id);
    $this->view->item = $item;
  }

}
