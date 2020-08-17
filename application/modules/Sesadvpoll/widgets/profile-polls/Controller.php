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
class Sesadvpoll_Widget_ProfilePollsController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {

	$this->view->identityForWidget = $this->view->identityObject = empty($_POST['identityObject']) ? $this->view->identity : $_POST['identityObject'];

    $this->view->params = $params = $this->_getAllParams();

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $sesadvpoll_widget = Zend_Registry::isRegistered('sesadvpoll_widget') ? Zend_Registry::get('sesadvpoll_widget') : null;
    if(empty($sesadvpoll_widget))
      return $this->setNoRender();
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    $levelId = ($viewerId) ? $viewer->level_id : Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id;

    if (empty($_POST['is_ajax'])) {
      //Get subject and check auth
      $subject = Engine_Api::_()->core()->getSubject();
      if (!Engine_Api::_()->core()->hasSubject())
        return $this->setNoRender();

      if (!Engine_Api::_()->authorization()->getPermission($levelId, 'sesadvpoll_poll', 'view'))
        return $this->setNoRender();
    } else if($is_ajax) {
      $subject = Engine_Api::_()->getItem('sesadvpoll_poll', @$_POST['poll_id']);
    }

	$this->view->title_truncation = @$params['title_truncation'] ? @$params['title_truncation'] : 45;
    $this->view->description_truncation = @$params['description_truncation'] ? @$params['description_truncation'] : 45;
    $this->view->socialshare_enable_plusicon = @$params['socialshare_enable_plusicon'] ? @$params['socialshare_enable_plusicon'] : 1;
	$this->view->gridlist = @$params['gridlist']?@$params['gridlist']:0;
    $this->view->show_criteria = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like','description','vote','in', 'comment','by','favourite','title', 'favouriteButton', 'likeButton', 'socialSharing', 'view'));

	$this->view->show_limited_data = isset($params['show_limited_data']) ? $params['show_limited_data'] :$this->_getParam('show_limited_data', 'no');

    $this->view->height = isset($params['height']) ? $params['height'] : 200;
    $this->view->width = isset($params['width']) ? $params['width'] : 320;

    $page = $this->view->page = isset($_POST['page']) ? $_POST['page'] : 1 ;
    $this->view->limit_data = $value['limit_data'] = $limit_data = isset($params['limit_data']) ? $params['limit_data'] :$this->_getParam('limit_data', '20');
    $this->view->load_content =  isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
    $this->view->user_id = isset($params['user_id']) ? $params['user_id'] : @$subject->getIdentity();

    $value['order'] = $this->_getParam('sort', null);
    $value['text'] = $this->_getParam('search', null);
    $value['user_id'] = @$subject->user_id;

    $paginator = Engine_Api::_()->getDbTable('polls', 'sesadvpoll')->getPollsPaginator($value);
    $this->view->paginator = $paginator;
    $paginator->setCurrentPageNumber($page);

    $paginator->setItemCountPerPage($limit_data);
	$this->view->page = $this->view->page+1;

	if($is_ajax)
		$this->getElement()->removeDecorator('Container');
    if ($paginator->getTotalItemCount() > 0) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }
  public function getChildCount() {
    return $this->_childCount;
  }
}
