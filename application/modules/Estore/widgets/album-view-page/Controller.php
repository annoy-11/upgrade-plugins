<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Widget_AlbumViewPageController extends Engine_Content_Widget_Abstract {

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
      $store =  Engine_Api::_()->getItem('stores', $album->store_id);
    } else {
      $album =  Engine_Api::_()->getItem('estore_album', $_POST['album_id']);
      $store =  Engine_Api::_()->getItem('estore_album', $_POST['store_id']);
    }

    $this->view->storeItem = $store;
    $this->view->album = $album;
    $this->view->album_id = $param['id'] = $album->album_id;
    $this->view->store_id = $param['store_id'] = $album->store_id;

    $photoTable = Engine_Api::_()->getItemTable('estore_photo');

    // Do other stuff
    $this->view->mine = $mine  = true;
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    if($viewer->getIdentity() > 0) {

        $storeApi = Engine_Api::_()->estore();

        $editStoreRolePermission = $storeApi->getStoreRolePermission($store->getIdentity(),'allow_plugin_content','edit');

        $this->view->canEdit = $viewPermission = $editStoreRolePermission ? $editStoreRolePermission : $store->authorization()->isAllowed($viewer, 'edit');
        $this->view->canComment =  $store->authorization()->isAllowed($viewer, 'comment');


        $editStoreRolePermission = $storeApi->getStoreRolePermission($store->getIdentity(),'allow_plugin_content','edit');

        $this->view->canEditMemberLevelPermission =  $editStoreRolePermission ? $editStoreRolePermission : $store->authorization()->isAllowed($viewer, 'edit');

        $deleteStoreRolePermission = $storeApi->getStoreRolePermission($store->getIdentity(),'allow_plugin_content','delete');

        $this->view->canDeleteMemberLevelPermission  = $deleteStoreRolePermission ? $deleteStoreRolePermission : $store->authorization()->isAllowed($viewer, 'delete');
    }

    if(!$is_ajax) {
        // Prepare data
        $this->view->albumUser = $albumUser = Engine_Api::_()->getItem('user', $album->owner_id);
        if (!$albumUser->isSelf($viewer)) {
            $album->getTable()->update(array('view_count' => new Zend_Db_Expr('view_count + 1')), array('album_id = ?' => $album->getIdentity()));
            $this->view->mine = $mine = false;
        } else {
            $this->view->mine = $mine = false;
        }
    } else {
        if (!$album->getOwner()->isSelf($viewer)) {
            $this->view->mine = $mine = false;
        }
    }

    $this->view->paginator = $paginator = $photoTable->getPhotoPaginator(array('album' => $album));

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber ($pageCount);
    $this->view->page = $pageCount + 1;

    if($is_ajax || $is_related) {
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
