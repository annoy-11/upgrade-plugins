<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesadvpoll_Widget_ManagePollsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

	$this->view->identityForWidget = $this->view->identityObject = empty($_POST['identityObject']) ? $this->view->identity : $_POST['identityObject'];
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
	$this->view->params = $params = !$is_ajax ? $this->_getAllParams() : json_decode($this->_getParam('params'),true);
    $showCriteria = $params['show_criteria'];
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->title_truncation = $params['title_truncation']?$params['title_truncation']:45;
    $this->view->gridlist = $params['gridlist']?$params['gridlist']:0;
    $this->view->description_truncation = $params['description_truncation']?$params['description_truncation']:45;
    $this->view->socialshare_enable_plusicon = @$params['socialshare_enable_plusicon'] ? @$params['socialshare_enable_plusicon']:null;
    $this->view->socialshare_icon_limit = $params['socialshare_icon_limit']?$params['socialshare_icon_limit']:null;

    $sesadvpoll_widget = Zend_Registry::isRegistered('sesadvpoll_widget') ? Zend_Registry::get('sesadvpoll_widget') : null;
    if(empty($sesadvpoll_widget))
      return $this->setNoRender();
   $this->view->show_criteria = $show_criterias = isset($params['show_criteria']) ? $params['show_criteria'] : $this->_getParam('show_criteria', array('like','vote','description','in', 'comment','by','favourite','title', 'favouriteButton', 'likeButton', 'socialSharing', 'view'));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
        $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }

    $this->view->height = isset($params['height']) ?$params['height']:200;
    $this->view->width = isset($params['width']) ?$params['width']:320;

	$this->view->show_limited_data = $show_limited_data = isset($params['show_limited_data']) ? $params['show_limited_data'] :$this->_getParam('show_limited_data', 'no');
    $page = $this->view->page = isset($_POST['page']) ? $_POST['page'] : 1 ;
    $this->view->limit_data = $value['limit_data'] = $limit_data = isset($params['limit_data']) ? $params['limit_data'] :$this->_getParam('limit_data', '20');
    $this->view->load_content = $load_content =  isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');

    $this->view->widgetName = 'manage-polls';
    if($viewer->getIdentity()) {
      $this->view->can_edit = Engine_Api::_()->authorization()->getPermission($viewer, 'sesadvpoll', 'edit');
      $this->view->can_delete = Engine_Api::_()->authorization()->getPermission($viewer, 'sesadvpoll', 'delete');
    }
    //$value['order'] = $sort = $this->_getParam('sort', null);
    $value['text'] = $search = $this->_getParam('search', null);

	$searchArray = array();
	if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);



	$searchArray = array_merge($searchArray,$value);
	if(!count($_POST)){
	$p = Zend_Controller_Front::getInstance()->getRequest()->getParams();
	$searchArray = array_merge($searchArray,$p);
	}

	$searchArray['user_id'] = $viewer->getIdentity();

    // initialize type variable type
    $paginator = Engine_Api::_()->getDbTable('polls', 'sesadvpoll')->getPollsPaginator($searchArray);
    $this->view->paginator = $paginator;
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage($limit_data);
	$this->view->page = $this->view->page+1;

    // Add count to title if configured
	if($is_ajax)
		$this->getElement()->removeDecorator('Container');
  }
}
