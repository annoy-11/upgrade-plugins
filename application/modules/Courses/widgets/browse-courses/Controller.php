<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Widget_BrowseCoursesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
       $getParams = '';
        $searchArray = array();
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
        $defaultSearchParams = Engine_Api::_()->courses()->getSearchWidgetParams($widgetId); 
        $searchArray = !empty($searchArray) ? $searchArray : $defaultSearchParams;
        $searchParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
        $params = Engine_Api::_()->courses()->getWidgetParams($widgetId);
        $this->view->wishlist_id  = $params['wishlist_id'] = isset($searchParams['wishlist_id']) ? $searchParams['wishlist_id'] : $params['wishlist_id'];
        $this->view->view_type = $viewType = isset($_POST['type']) ? $_POST['type'] : (count($params['enableTabs']) > 1 ? $params['openViewType'] : $params['enableTabs'][0]);
        $limit_data = $params["limit_data_$viewType"];
        $courses_browse = Zend_Registry::isRegistered('courses_browse') ? Zend_Registry::get('courses_browse') : null;
        $this->view->optionsEnable = $optionsEnable = $params['enableTabs'];
        $text =  isset($searchArray['search']) ? $searchArray['search'] : (!empty($params['search']) ? $params['search'] : (isset($_GET['search']) && ($_GET['search'] != '') ? $_GET['search'] : ''));
        //search data
        if(empty($courses_browse)) 
          return $this->setNoRender();
        @$value['show'] = isset($searchArray['show']) ? $searchArray['show'] : (isset($_GET['show']) ? $_GET['show'] : (isset($params['show']) ? $params['show'] : $this->_getParam('show')));
        @$value['alphabet'] = isset($searchArray['alphabet']) ? $searchArray['alphabet'] : (isset($_GET['alphabet']) ? $_GET['alphabet'] : (isset($params['alphabet']) ? $params['alphabet'] : $this->_getParam('alphabet')));
        @$value['sort'] = isset($searchArray['sort']) ? $searchArray['sort'] : (isset($_GET['sort']) ? $_GET['sort'] : (isset($params['sort']) ? $params['sort'] : $this->_getParam('sort', 'mostSPliked')));
        @$value['category_id'] =  isset($searchArray['category_id']) ? $searchArray['category_id'] : (isset($_GET['category_id']) ? $_GET['category_id'] : (isset($params['category_id']) ? $params['category_id'] : $this->_getParam('category')));
        @$value['subcat_id'] = isset($searchArray['subcat_id']) ? $searchArray['subcat_id'] :  (isset($_GET['subcat_id']) ? $_GET['subcat_id'] : (isset($params['subcat_id']) ? $params['subcat_id'] : ''));
        @$value['subsubcat_id'] = isset($searchArray['subsubcat_id']) ? $searchArray['subsubcat_id'] : (isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : (isset($params['subsubcat_id']) ? $params['subsubcat_id'] : ''));
        @$value['price_min'] = isset($searchArray['price_min']) ? $searchArray['price_min'] : (isset($_GET['price_min']) ? $_GET['price_min'] : (isset($params['price_min']) ? $params['price_min'] : ''));
        @$value['price_max'] = isset($searchArray['price_max']) ? $searchArray['price_max'] : (isset($_GET['price_max']) ? $_GET['price_max'] : (isset($params['price_max']) ? $params['price_max'] : ''));
        @$value['discount'] = isset($searchArray['discount']) ? $searchArray['discount'] : (isset($_GET['discount']) ? $_GET['discount'] : (isset($params['discount']) ? $params['discount'] : ''));
        @$value['lecture'] = isset($searchArray['lecture']) ? $searchArray['lecture'] : (isset($_GET['lecture']) ? $_GET['lecture'] : (isset($params['lecture']) ? $params['lecture'] : ''));
        $this->view->text = @$value['text']  = @stripslashes($text);
        foreach ($params['show_criteria'] as $show_criteria)
            $this->view->{$show_criteria . 'Active'} = $show_criteria;
        if($params['wishlist_id']) {
          $this->view->addWishlistActive = null;
        }
        if (isset($_GET['category_id']))
            $params[category_id] = $_GET['category_id'];
       
        if(isset($searchArray['default_search_type']) && $searchArray['default_search_type'] != ''):
            $value['getParamSort'] = str_replace('SP', '_', $searchArray['default_search_type']);
        elseif (isset($value['sort']) && $value['sort'] != ''):
            $value['getParamSort'] = str_replace('SP', '_', $value['sort']);
        else :
            $value['getParamSort'] = 'creation_date';
        endif;
        if (isset($value['getParamSort'])) {
          switch ($value['getParamSort']) {
            case 'most_viewed':
              $value['popularCol'] = 'view_count';
              break;
            case 'most_liked':
              $value['popularCol'] = 'like_count';
              break;
            case 'most_commented':
              $value['popularCol'] = 'comment_count';
              break;
            case 'most_favourite':
              $value['popularCol'] = 'favourite_count';
              break;
            case 'sponsored':
              $value['popularCol'] = 'sponsored';
              $value['fixedData'] = 'sponsored';
              break;
            case 'verified':
              $value['popularCol'] = 'verified';
              $value['fixedData'] = 'verified';
            break;
            case 'featured':
              $value['popularCol'] = 'featured';
              $value['fixedData'] = 'featured';
              break;
            case 'most_rated':
              $value['popularCol'] = 'rating';
              break;
            case 'recently_created':
                    default:
              $value['popularCol'] = 'creation_date';
              break;
          }
        }
        unset($value['sort']);
        unset($params['sort']);
        $this->view->widgetName = 'browse-courses';
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $this->view->page = $page;
        $value['status'] = 1;
        $value['search'] = 1;
        $value['draft'] = "1"; 
        if (isset($params['search']))
            $params['text'] = addslashes($params['search']); 
        $params['tag'] = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';
        $params = array_merge($params, $value); 
        $this->view->params = $params;
        $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('courses', 'courses')
            ->getCoursePaginator($params);
        $paginator->setItemCountPerPage($limit_data); 
        $paginator->setCurrentPageNumber($page);
        if ($is_ajax) {
            $this->getElement()->removeDecorator('Container');
        }
    }
}
