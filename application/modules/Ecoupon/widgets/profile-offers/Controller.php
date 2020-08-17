<?php
 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Ecoupon_Widget_ProfileOffersController extends Engine_Content_Widget_Abstract { 
  public function indexAction() { 
    if (!Engine_Api::_()->core()->hasSubject()) {
        return $this->setNoRender();
    }
    $params = array();
    $values = array();
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $params = Engine_Api::_()->ecoupon()->getWidgetParams($widgetId);
    $this->view->resource_id = $values['resource_id'] = isset($_GET['resource_id']) ? $_GET['resource_id'] : (isset($params['resource_id']) ?  $params['resource_id'] : Engine_Api::_()->core()->getSubject()->getIdentity());
    $is_ajax = isset($_POST['is_ajax']) ? $_POST['is_ajax'] : 0;
    $this->view->resource_type = $values['resource_type'] = isset($_GET['resource_type']) ? $_GET['resource_type'] : (isset($params['resource_type']) ?  $params['resource_type'] : Engine_Api::_()->core()->getSubject()->getType());
    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->is_search = $is_search = !empty($_POST['is_search']) ? true : false;

    if(!empty($params['show_criteria'])){
      foreach (@$params['show_criteria'] as $show_criteria)
        $this->view->{$show_criteria . 'Active'} = $show_criteria;
      unset($params['show_criteria']);
    }
    $this->view->widgetName = 'profile-offers';
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;
    $limit_data = $this->_getParam('limit_data',10);
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('coupons', 'ecoupon')
            ->getCouponsPaginator($values);
    $paginator->setItemCountPerPage($limit_data); 
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax) {
        $this->getElement()->removeDecorator('Container');
    }
  }
}
