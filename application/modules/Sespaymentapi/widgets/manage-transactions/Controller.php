<?php

class Sespaymentapi_Widget_ManageTransactionsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
  
    $value = array();
    $this->view->user_id = $user_id = $value['user_id'] = $viewer->getIdentity();
    //$this->view->resource_type = $value['resource_type'] = $viewer->getType();
    if (!$user_id)
      return $this->setNoRender();
      
    $this->view->is_search_ajax = $is_search_ajax = isset($_POST['is_search_ajax']) ? $_POST['is_search_ajax'] : false;
    if (!$is_search_ajax)
      $this->view->searchForm = $searchForm = new Sespaymentapi_Form_Searchtransaction();

    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $value['transaction_id'] = isset($searchArray['transaction_id']) ? $searchArray['transaction_id'] : '';
		$value['email'] = isset($searchArray['email']) ? $searchArray['email'] : '';
    $value['buyer_name'] = isset($searchArray['buyer_name']) ? $searchArray['buyer_name'] : '';
    $value['date_from'] = isset($searchArray['date']['date_from']) ? $searchArray['date']['date_from'] : '';
    $value['date_to'] = isset($searchArray['date']['date_to']) ? $searchArray['date']['date_to'] : '';
    $value['order_min'] = isset($searchArray['order']['order_min']) ? $searchArray['order']['order_min'] : '';
    $value['order_max'] = isset($searchArray['order']['order_max']) ? $searchArray['order']['order_max'] : '';

    $orders = Engine_Api::_()->getDbtable('transactions', 'sespaymentapi')->manageTransactions($value);
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($orders);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(15);
  }
}