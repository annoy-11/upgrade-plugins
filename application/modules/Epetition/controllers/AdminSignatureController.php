<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminSignatureController.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Epetition_AdminSignatureController extends Core_Controller_Action_Admin
{

//  public function browseAction() {
//    $this->_helper->content->setEnabled();
//  }

  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('epetition_admin_main', array(), 'epetition_admin_main_signature');

    $this->view->formFilter = $formFilter = new Epetition_Form_Admin_Filtersignature();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      $formFilter->populate($values);
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $signature = Engine_Api::_()->getItem('epetition_signature', $value);
          $signature->delete();
        }
      }
    }
    if (isset($_GET)) {
      $formFilter->populate($_GET);
    }
    $page = $this->_getParam('page', 1);
    $this->view->paginator = $data = Engine_Api::_()->getDbtable('signatures', 'epetition')->getSignaturesPaginator(array(
      'name' => isset($_GET['name']) && !empty($_GET['name']) ? trim($_GET['name']) : null,
      'user_type' => isset($_GET['user_type']) && !empty($_GET['user_type']) ? trim($_GET['user_type']) : null,
      'from_date' => isset($_GET['from_date']) && !empty($_GET['from_date']) ? date("Y-m-d", strtotime(trim($_GET['from_date']))) : null,
      'to_date' => isset($_GET['to_date']) && !empty($_GET['to_date']) ? date("Y-m-d", strtotime(trim($_GET['to_date']))) : null,
      'epetition_id' => isset($_GET['epetition_id']) && !empty($_GET['epetition_id']) ? trim($_GET['epetition_id']) : null,
      'orderby' => 'signature_id',
    ));
    $this->view->paginator->setItemCountPerPage(10);
    $this->view->paginator->setCurrentPageNumber($page);
  }

  public function deleteDashboardSignatureAction()
  {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($_POST['id'])) {
      $array = array();
      $epetitionSignatureTable = Engine_Api::_()->getDbtable('signatures', 'epetition');
      if ($epetitionSignatureTable->delete(array('signature_id = ?' => $_POST['id']))) {
        $array['status'] = 1;
        $array['msg'] = "This Signature deleted successfully";
      } else {
        $array['status'] = 0;
        $array['msg'] = "This Signature can not be deleted";
      }
      echo json_encode($array);
      exit();
    }
  }

  public function viewDashboardSignatureAction()
  {
    $id = $this->_getParam('id', null);
    $this->view->data = Engine_Api::_()->getItem('epetition_signature', $id);
  }

}
