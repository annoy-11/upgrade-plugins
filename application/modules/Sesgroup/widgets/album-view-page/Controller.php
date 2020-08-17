<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Widget_AlbumViewPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

		//option params
		if(isset($_POST['params']))
			$params = json_decode($_POST['params'],true);
		$this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
		$this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
		$this->view->is_related = $is_related = isset($_POST['is_related']) ? true : false;
    if(!isset($_POST['is_related'])){
      $pageCount = isset($_POST['page']) ? $_POST['page'] : 1 ;
      $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
      $this->view->height = $defaultHeight =isset($params['height']) ? $params['height'] : $this->_getParam('height', '340px');
      $this->view->width = $defaultWidth= isset($params['width']) ? $params['width'] :$this->_getParam('width', '140px');
      $this->view->limit_data = $limit_data = isset($params['limit_data']) ? $params['limit_data'] :$this->_getParam('limit_data', '20');
      $this->view->title_truncation = $title_truncation = isset($params['title_truncation']) ? $params['title_truncation'] :$this->_getParam('title_truncation', '45');
      $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria',array('like','comment','rating','by','title','socialSharing','view','photoCount','favouriteCount','featured','sponsored','favouriteButton','likeButton','downloadCount'));
      $this->view->fixHover = $fixHover = isset($params['fixHover']) ? $params['fixHover'] :$this->_getParam('fixHover', 'fix');
      $this->view->insideOutside =  $insideOutside = isset($params['insideOutside']) ? $params['insideOutside'] : $this->_getParam('insideOutside', 'inside');
      foreach($show_criterias as $show_criteria)
        $this->view->$show_criteria = $show_criteria;
      $this->view->view_type = $view_type = isset($params['view_type']) ? $params['view_type'] : $this->_getParam('view_type', 'masonry');
      $params = $this->view->params = array('height'=>$defaultHeight,'limit_data' => $limit_data,'pagging'=>$loadOptionData,'show_criterias'=>$show_criterias,'view_type'=>$view_type,'title_truncation' =>$title_truncation,'width'=>$defaultWidth,'insideOutside' =>$insideOutside,'fixHover'=>$fixHover);
    }

    if(Engine_Api::_()->core()->hasSubject()){
      $album = Engine_Api::_()->core()->getSubject();
      $group =  Engine_Api::_()->getItem('sesgroup_group', $album->group_id);
    } else {
      $album =  Engine_Api::_()->getItem('sesgroup_album', $_POST['album_id']);
      $group =  Engine_Api::_()->getItem('sesgroup_group', $_POST['group_id']);
    }
    $sesgroup_sesgroupwidget = Zend_Registry::isRegistered('sesgroup_sesgroupwidget') ? Zend_Registry::get('sesgroup_sesgroupwidget') : null;
    if(empty($sesgroup_sesgroupwidget)) {
      return $this->setNoRender();
    }
		$this->view->groupItem = $group;
    $this->view->album = $album;
    $this->view->album_id = $param['id'] = $album->album_id;
    $this->view->group_id = $param['group_id'] = $album->group_id;

    $photoTable = Engine_Api::_()->getItemTable('sesgroup_photo');

    // Do other stuff
    $this->view->mine = $mine  = true;
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
		if($viewer->getIdentity() > 0) {

      $editGroupRolePermission = Engine_Api::_()->sesgroup()->getGroupRolePermission($group->getIdentity(),'allow_plugin_content','edit');

			$this->view->canEdit = $viewPermission = $editGroupRolePermission ? $editGroupRolePermission : $group->authorization()->isAllowed($viewer, 'edit');
			$this->view->canComment =  $group->authorization()->isAllowed($viewer, 'comment');

// 			$createGroupRolePermission = Engine_Api::_()->sesgroup()->getGroupRolePermission($page->getIdentity(),'allow_plugin_content','create');
//
// 			$this->view->canCreateMemberLevelPermission =  $createGroupRolePermission ? $createGroupRolePermission : Engine_Api::_()->authorization()->getPermission($viewer, 'sesgroup_group', 'create');

			$editGroupRolePermission = Engine_Api::_()->sesgroup()->getGroupRolePermission($group->getIdentity(),'allow_plugin_content','edit');

			$this->view->canEditMemberLevelPermission   =  $editGroupRolePermission ? $editGroupRolePermission : $group->authorization()->isAllowed($viewer, 'edit');

		//	Engine_Api::_()->authorization()->getPermission($viewer,'sesgroup_group', 'edit');

			$deleteGroupRolePermission = Engine_Api::_()->sesgroup()->getGroupRolePermission($group->getIdentity(),'allow_plugin_content','delete');

			$this->view->canDeleteMemberLevelPermission  = $deleteGroupRolePermission ? $deleteGroupRolePermission : $group->authorization()->isAllowed($viewer, 'delete');

			//Engine_Api::_()->authorization()->getPermission($viewer,'sesgroup_group', 'delete');




		//	var_dump($createGroupRolePermission); die;
		}

    if(!$is_ajax) {
			// Prepare data
			$this->view->albumUser = $albumUser = Engine_Api::_()->getItem('user', $album->owner_id);
			if (!$albumUser->isSelf(Engine_Api::_()->user()->getViewer())) {
				$album->getTable()->update(array('view_count' => new Zend_Db_Expr('view_count + 1')), array('album_id = ?' => $album->getIdentity()));
				$this->view->mine = $mine = false;
			} else {
					$this->view->mine = $mine = false;
			}
		} else {
			if (!$album->getOwner()->isSelf(Engine_Api::_()->user()->getViewer())) {
				$this->view->mine = $mine = false;
			}
		}
		$this->view->paginator = $paginator = $photoTable->getPhotoPaginator(array('album' => $album));
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber ($pageCount);
		$this->view->page = $pageCount + 1;

		$viewer = Engine_Api::_()->user()->getViewer();

		if($is_ajax || $is_related){
			$this->getElement()->removeDecorator('Container');
		} else if(!$is_ajax) {
		  $getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
			if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0){
				$this->view->doctype('XHTML1_RDFA');
				$this->view->docActive = true;
			}
		}
  }
}
