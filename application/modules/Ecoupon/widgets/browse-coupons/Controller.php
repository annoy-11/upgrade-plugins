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
class Ecoupon_Widget_BrowseCouponsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
       $getParams = '';
        $searchArray = array();
        $defaultSearchParams = array();
        if (isset($_POST['searchParams']) && $_POST['searchParams'])
          parse_str($_POST['searchParams'], $searchArray);
        else {
          $getParams = !empty($_POST['getParams']) ? $_POST['getParams'] : $_SERVER['QUERY_STRING'];
          parse_str($getParams, $get_array);
        }
        $value = array();
        $this->view->getParams = $getParams;
        $this->view->view_more = isset($_POST['view_more']) ? true : false;
        $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
        $this->view->is_search = $is_search = !empty($_POST['is_search']) ? true : false;
        $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
        $searchArray = !empty($searchArray) ? $searchArray : $defaultSearchParams;
        $searchParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
        $params = Engine_Api::_()->ecoupon()->getWidgetParams($widgetId);
        $limit_data =  $this->_getParam('limit_data',1);
        $text =  isset($searchArray['search']) ? $searchArray['search'] : (!empty($params['search']) ? $params['search'] : (isset($_GET['search']) && ($_GET['search'] != '') ? $_GET['search'] : ''));
        @$value['alphabet'] = isset($searchArray['alphabet']) ? $searchArray['alphabet'] : (isset($_GET['alphabet']) ? $_GET['alphabet'] : (isset($params['alphabet']) ? $params['alphabet'] : $this->_getParam('alphabet')));
        $this->view->text = @$value['text']  = @stripslashes($text);
        if(!empty($params['show_criteria'])){
        foreach (@$params['show_criteria'] as $show_criteria)
            $this->view->{$show_criteria . 'Active'} = $show_criteria;
        }
        $this->view->widgetName = 'browse-coupons';
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $this->view->page = $page;
        if (isset($params['search']))
            $params['text'] = addslashes($params['search']); 
        $params = array_merge($params, $value); 
        $this->view->params = $params;
        $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('coupons', 'ecoupon')
            ->getCouponsPaginator($params);
        $paginator->setItemCountPerPage($limit_data); 
        $paginator->setCurrentPageNumber($page);
        if ($is_ajax) {
            $this->getElement()->removeDecorator('Container');
        }
    }
}
