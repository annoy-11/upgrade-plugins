<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Widget_BrowseWishlistsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {

    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->viewmore = $this->_getParam('viewMore', 0);
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

    $alphabet = isset($_GET['alphabet']) ? $_GET['alphabet'] : (isset($params['alphabet']) ? $params['alphabet'] : '');
    $itemCount = isset($params['page']) ? $params['page'] : $this->_getParam('itemCount', 10);
    $popularity = isset($_GET['popularity']) ? $_GET['popularity'] : $popularity;

    $title = isset($_GET['title_name']) ? $_GET['title_name'] : (isset($params['title_name']) ? $params['title_name'] : '');
    $show = isset($_GET['show']) ? $_GET['show'] : (isset($params['show']) ? $params['show'] : 1);
		$brand = isset($_GET['brand']) ? $_GET['brand'] : (isset($params['brand']) ? $params['brand'] : '');
		$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
    $users = array();
    if (isset($_GET['show']) && $_GET['show'] == 2 && $viewer->getIdentity()) {
      $users = $viewer->membership()->getMembershipsOfIds();
    }
    $action = isset($_GET['action']) ? $_GET['action'] : (isset($params['action']) ? $params['action'] : 'browse');
    $page = isset($_GET['page']) ? $_GET['page'] : $this->_getParam('page', 1);


    $this->view->all_params = $values = array('paginationType' => $paginationType, 'width' => $width, 'height' => $height, 'information' => $information, 'alphabet' => $alphabet, 'itemCount' => $itemCount, 'popularity' => $popularity,'category_id'=>$category_id,'brand'=>$brand, 'show' => $show, 'users' => $users, 'title' => $title, 'action' => $action, 'page' => $page,'description_truncation'=>$description_truncation, 'socialshare_icon_limit' => $socialshare_icon_limit, 'socialshare_enable_plusicon' => $socialshare_enable_plusicon);

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('wishlists', 'sesproduct')->getWishlistPaginator($values);
    $paginator->setItemCountPerPage($itemCount);
    $paginator->setCurrentPageNumber($page);
    $this->view->count = $paginator->getTotalItemCount();
  }
}
