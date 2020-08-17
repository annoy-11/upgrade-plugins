<?php

class Sesmembersubscription_Widget_ManageSubscribersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
  
    $value = array();
    $this->view->resource_id = $user_id = $value['resource_id'] = $viewer->getIdentity();
    $this->view->resource_type = $value['resource_type'] = $viewer->getType();
    if (!$user_id)
      return $this->setNoRender();
      
    $this->view->is_search_ajax = $is_search_ajax = isset($_POST['is_search_ajax']) ? $_POST['is_search_ajax'] : false;
    if (!$is_search_ajax)
      $this->view->searchForm = $searchForm = new Sesmembersubscription_Form_SearchSubscriber();

    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

		$value['subscriber_email'] = isset($searchArray['subscriber_email']) ? $searchArray['subscriber_email'] : '';
    $value['subscriber_name'] = isset($searchArray['subscriber_name']) ? $searchArray['subscriber_name'] : '';

    $orders = Engine_Api::_()->getDbtable('transactions', 'sespaymentapi')->manageSubscribers($value);
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($orders);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(15);
  }
}