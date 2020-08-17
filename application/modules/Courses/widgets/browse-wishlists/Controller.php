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
class Courses_Widget_BrowseWishlistsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $getParams = '';
    $searchArray = array();
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);
    $this->view->getParams = $getParams;
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->viewmore = $this->_getParam('viewMore', 0);
    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->is_search = $is_search = !empty($_POST['is_search']) ? true : false;
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $params = Engine_Api::_()->courses()->getWidgetParams($widgetId);
    $this->view->paginationType = $paginationType = $this->_getParam('paginationType', 1);
    $this->view->width = $width = isset($params['width']) ? $params['width'] : $this->_getParam('width', 200);
    $this->view->popularity = $popularity = isset($params['popularity']) ? $params['popularity'] : $this->_getParam('popularity', 'creation_date');
    $this->view->height = $height = isset($params['height']) ? $params['height'] : $this->_getParam('height', 200);
    $this->view->socialshare_enable_plusicon = $socialshare_enable_plusicon = isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $socialshare_icon_limit = isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);
    $this->view->description_truncation = $description_truncation = isset($params['description_truncation']) ? $params['description_truncation'] : $this->_getParam('description_truncation', 60);
    $this->view->information = $information = isset($params['information']) ? $params['information'] : $this->_getParam('information', array('viewCount', 'title', 'postedby', 'share', 'watchLater', 'favouriteButton', 'showVideosList', 'playlist','description','favouriteCount','featuredLabel', 'sponsoredLabel','likeButton','socialSharing','likeCount'));
    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');
    $alphabet = isset($_GET['alphabet']) ? $_GET['alphabet'] : (isset($searchArray['alphabet']) ? $searchArray['alphabet'] : '');
    $itemCount = isset($params['itemCount']) ? $params['itemCount'] : $this->_getParam('itemCount', 10);
    $popularity = isset($_GET['popularity']) ? $_GET['popularity'] : (isset($searchArray['popularity']) ? $searchArray['popularity'] : '');
    $title = isset($_GET['title_name']) ? $_GET['title_name'] : (isset($searchArray['title_name']) ? $searchArray['title_name'] : '');
    $show = isset($_GET['show']) ? $_GET['show'] : (isset($searchArray['show']) ? $searchArray['show'] : 1);
		$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : (isset($searchArray['category_id']) ? $searchArray['category_id'] : '');
    $users = array();
    if (isset($_GET['show']) && $_GET['show'] == 2 && $viewer->getIdentity()) {
      $users = $viewer->membership()->getMembershipsOfIds();
    }
    $action = isset($_GET['action']) ? $_GET['action'] : (isset($params['action']) ? $params['action'] : 'browse');
    $this->view->params = $params;
    $this->view->widgetName = 'browse-wishlists';
    $this->view->page = $page = isset($_GET['page']) ? $_GET['page'] : $this->_getParam('page', 1);
    $this->view->all_params = $values = array('paginationType' => $paginationType, 'width' => $width, 'height' => $height, 'information' => $information, 'alphabet' => $alphabet, 'itemCount' => $itemCount, 'popularity' => $popularity,'category_id'=>$category_id,'brand'=>$brand, 'show' => $show, 'users' => $users, 'title' => $title, 'action' => $action, 'page' => $page,'description_truncation'=>$description_truncation, 'socialshare_icon_limit' => $socialshare_icon_limit, 'socialshare_enable_plusicon' => $socialshare_enable_plusicon);
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('wishlists', 'courses')->getWishlistPaginator($values);
    $paginator->setItemCountPerPage($itemCount);
    $paginator->setCurrentPageNumber($page);
    $this->view->count = $paginator->getTotalItemCount();
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }
}
