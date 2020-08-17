<?php
class Ecoupon_AdminManageController extends Core_Controller_Action_Admin {
  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
          ->getNavigation('ecoupon_admin_main', array(), 'ecoupon_admin_main_manage');    
    $this->view->formFilter = $formFilter = new Ecoupon_Form_Admin_Filter(array('resourseType' => 'course'));
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
            $coupon = Engine_Api::_()->getItem('ecoupon_coupon', $value);
            if(!empty($coupon)) {
              $coupon->delete();
            }
        }
      }
    }
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] : '',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
            ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $couponTable = Engine_Api::_()->getDbTable('coupons', 'ecoupon');
    $couponTableName = $couponTable->info('name');
    $select = $couponTable->select()
       ->setIntegrityCheck(false)
            ->from($couponTableName,array('*'))
          ->joinLeft($tableUserName, "$couponTableName.owner_id = $tableUserName.user_id", 'username');
    if (!empty($_GET['title']))
      $select->where($couponTableName . '.title LIKE ?', '%' . $_GET['title'] . '%');
    if (!empty($_GET['owner_name']))
      $select->where($tableUserName.'.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    if (isset($_GET['item_type']) && $_GET['item_type'] != '')
      $select->where($couponTableName . '.item_type = ?', $_GET['item_type']);
    if (isset($_GET['approved']) && $_GET['approved'] != '')
      $select->where($couponTableName . '.is_approved = ?', $_GET['approved']);
    if (isset($_GET['enabled']) && $_GET['enabled'] != '')
      $select->where($couponTableName . '.is_approved = ?', $_GET['enabled']);
    if (isset($_GET['discount_type']) && $_GET['discount_type'] != '') {
      $select->where($couponTableName . '.discount_type = ?', $_GET['discount_type']);
      if (!empty($_GET['discount_max']) && $_GET['discount_max'] != '')
          $select->having($couponTableName.".fixed_discount_value <=?", $_GET['discount_max']);
      if (!empty($_GET['discount_min']) && $_GET['discount_min'] != '')
          $select->having($couponTableName.".fixed_discount_value >=?", $_GET['discount_min']);
    } else {
        if (!empty($_GET['discount_max']) && $_GET['discount_max'] != '')
          $select->having($couponTableName.".percentage_discount_value <=?", $_GET['discount_max']);
        if (!empty($_GET['discount_min']) && $_GET['discount_min'] != '')
          $select->having($couponTableName.".percentage_discount_value >=?", $_GET['discount_min']);
    }
    if(isset($_GET['validity']) && $_GET['validity'] != 0)
      $select->where("timestamp(".$couponTableName .".discount_end_time) > NOW()");
    elseif(isset($_GET['validity']) && $_GET['validity'] != 1)
      $select->where("timestamp(".$couponTableName .".discount_end_time) < NOW()");
    if (!empty($_GET['date']['date_from']))
        $select->having($couponTableName . '.creation_date <=?', $_GET['date']['date_from']);
    if (!empty($_GET['date']['date_to']))
        $select->having($couponTableName . '.creation_date >=?', $_GET['date']['date_to']);

    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey => $urlParamsVal) {
      if ($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
        continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select); 
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
  public function approvedAction() {
    $coupon_id = $this->_getParam('coupon_id',false);
    if(!$coupon_id)
        return;
    $item = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
    $item->is_approved = !$item->is_approved;
    $viewer = Engine_Api::_()->user()->getViewer();
    $item->save();
    $this->_redirect('admin/ecoupon/manage/');
  }
  public function verifyAction() {
    $coupon_id = $this->_getParam('coupon_id',false);
    if(!$coupon_id)
        return;
    $item = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
    $item->verified = !$item->verified;
    $viewer = Engine_Api::_()->user()->getViewer();
    $item->save();
    $this->_redirect('admin/ecoupon/manage/');
  }
  public function featuredAction() {
    $coupon_id = $this->_getParam('coupon_id',false);
    if(!$coupon_id)
        return;
    $item = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
    $item->featured = !$item->featured;
    $viewer = Engine_Api::_()->user()->getViewer();
    $item->save();
    $this->_redirect('admin/ecoupon/manage/');
  }
  
  public function sponsoredAction() {
    $coupon_id = $this->_getParam('coupon_id',false);
    if(!$coupon_id)
        return;
    $item = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
    $item->sponsored = !$item->sponsored;
    $viewer = Engine_Api::_()->user()->getViewer();
    $item->save();
    $this->_redirect('admin/ecoupon/manage/');
  }
  public function hotAction() {
    $coupon_id = $this->_getParam('coupon_id',false);
    if(!$coupon_id)
        return;
    $item = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
    $item->hot = !$item->hot;
    $viewer = Engine_Api::_()->user()->getViewer();
    $item->save();
    $this->_redirect('admin/ecoupon/manage/');
  }
  public function viewAction() {
    $coupon_id = $this->_getParam('coupon_id',false);
    if(!$coupon_id)
        return;
    $this->view->item = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
  }
  public function deleteAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $coupon_id = $this->_getParam('coupon_id',false);
    $item = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Coupon?');
    $form->setDescription('Are you sure that you want to delete this Coupon? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    //Check post
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $item->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('You have successfully deleted this entry.')
      ));
    }
  }
  
  public function ofthedayAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $coupon_id = $this->_getParam('coupon_id',false);
    if ($coupon_id) {
      $item = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
      $id = $coupon_id;
      $dbTable = 'engine4_ecoupon_coupons';
      $item_id = 'coupon_id';
    }
    $this->view->form = $form = new Ecoupon_Form_Admin_Oftheday();
    if (!empty($coupon_id)) {
        $form->setTitle("Coupon of the Day");
        $form->setDescription('Here, choose the start date and end date for this coupon to be displayed as "Coupon of the Day".');
    }
    $form->populate($item->toArray());
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost())) {
        return;
      }
      $values = $form->getValues();
      $start = strtotime($values['startdate']);
      $end = strtotime($values['enddate']);
      $values['startdate'] = date('Y-m-d', $start);
      $values['enddate'] = date('Y-m-d', $end);
      $db->update($dbTable, array('startdate' => $values['startdate'], 'enddate' => $values['enddate']), array("$item_id = ?" => $id));
      if (@$values['remove']) {
        $db->update($dbTable, array('offtheday' => 0), array("$item_id = ?" => $id));
      } else {
        $db->update($dbTable, array('offtheday' => 1), array("$item_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
  }
}
?>
