<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinesspoll_Widget_ProfilePollsController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {
	$this->view->identityForWidget = $this->view->identityObject = empty($_POST['identityObject']) ? $this->view->identity : $_POST['identityObject'];
    $this->view->params = $params = $this->_getAllParams();
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $showCriteria = $params['show_criteria'];
    $viewer = Engine_Api::_()->user()->getViewer();
 $business_id;
		$viewer_id = $viewerId = $viewer->getIdentity();
		$levelId = ($viewerId) ? $viewer->level_id : Engine_Api::_()->getDbtable('levels', 'authorization')->getPublicLevel()->level_id;
    if (empty($_POST['is_ajax'])) {
      //Get subject and check auth
      $subject = Engine_Api::_()->core()->getSubject();
      if (!Engine_Api::_()->core()->hasSubject())
        return $this->setNoRender();
			if(!Engine_Api::_()->getDbTable('managebusinessapps', 'sesbusiness')->isCheck(array('business_id'=>$subject->business_id,'columnname'=>'sesbusinesspoll')))
				return $this->setNoRender();
      if (!Engine_Api::_()->authorization()->getPermission($levelId, 'sesbusinesspoll_poll', 'view'))
        return $this->setNoRender();
    } else if($is_ajax) {
      $subject = Engine_Api::_()->getItem('sesbusinesspoll_poll', $_POST['page_id']);
    }
    $sesbusinesspoll_widget = Zend_Registry::isRegistered('sesbusinesspoll_widget') ? Zend_Registry::get('sesbusinesspoll_widget') : null;
    if(empty($sesbusinesspoll_widget))
      return $this->setNoRender();
	$this->view->title_truncation = $params['title_truncation']?$params['title_truncation']:45;
    $this->view->description_truncation = $params['description_truncation']?$params['description_truncation']:45;
    $this->view->socialshare_enable_plusicon = $params['socialshare_enable_plusicon']?$params['socialshare_enable_plusicon']:1;
	$this->view->gridlist = $params['gridlist']?$params['gridlist']:0;
    $this->view->show_criteria = $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like','description','in', 'comment','by','favourite','title', 'favouriteButton', 'likeButton', 'socialSharing', 'view'));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
        $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }

    // for View
		
	$this->view->show_limited_data = $show_limited_data = isset($params['show_limited_data']) ? $params['show_limited_data'] :$this->_getParam('show_limited_data', 'no');
    $page = $this->view->page = isset($_POST['page']) ? $_POST['page'] : 1 ;
    $this->view->limit_data = $value['limit_data'] = $limit_data = isset($params['limit_data']) ? $params['limit_data'] :$this->_getParam('limit_data', '20');
    $this->view->load_content = $load_content =  isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
    $this->view->business_id = $business_id = isset($params['business_id']) ? $params['business_id'] : $subject->getIdentity();
    //Privacy Check

//    $table = Engine_Api::_()->getItemTable('sesbusiness_managebusinessapps');
//    echo '<pre>';
//    print_r($table);die;
//    $select = $table->select('sesbusinesspoll')
//      ->where('business_id = ?', $business_id);
//    $sesbusinesspoll = $select->query()->fetchColumn();
//    echo '<pre>';
//    print_r($sesbusinesspoll);die;

//    $album = $table->fetchRow($select);
    $this->view->allowPoll  = Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'poll');
		$this->view->canUpload = Engine_Api::_()->authorization()->getPermission($levelId, 'sesbusinesspoll_poll', 'create');
    $this->view->widgetName = 'profile-polls';
    if($viewer->getIdentity()) {
      $this->view->can_edit = Engine_Api::_()->authorization()->getPermission($viewer, 'sesbusinesspoll', 'edit');
      $this->view->can_delete = Engine_Api::_()->authorization()->getPermission($viewer, 'sesbusinesspoll', 'delete');
    }
    $value['order'] = $sort = $this->_getParam('sort', null);
    $value['text'] = $search = $this->_getParam('search', null);
    $value['business_id'] = $subject->business_id;
    // initialize type variable type
    $paginator = Engine_Api::_()->getDbTable('polls', 'sesbusinesspoll')->getPollsPaginator($value);
    $this->view->paginator = $paginator;
    $paginator->setCurrentPageNumber($page);

    $paginator->setItemCountPerPage($limit_data);
	$this->view->page = $this->view->page+1;
	
    // Add count to title if configured
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
