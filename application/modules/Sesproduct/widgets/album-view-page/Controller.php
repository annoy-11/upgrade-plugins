<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Widget_AlbumViewPageController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
		//option params
		if(isset($_POST['params']))
			$params = json_decode($_POST['params'],true);
		$this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
		$this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
		$this->view->is_related = $is_related = isset($_POST['is_related']) ? true : false;
	if(!isset($_POST['is_related'])){
		$page = isset($_POST['page']) ? $_POST['page'] : 1 ;
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

			$product =  Engine_Api::_()->getItem('sesproduct', $album->product_id);
		}else{
			$album =  Engine_Api::_()->getItem('sesproduct_album', $_POST['album_id']);
			$product =  Engine_Api::_()->getItem('sesproduct', $album->product_id);
		}
		$this->view->allow_create = true;
		$this->view->product = $product;
		 $this->view->album = $album;
		 $this->view->album_id = $param['id'] = $album->album_id;
		 $this->view->product_id = $param['product_id'] = $album->product_id;
		if(!$is_ajax && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesproductpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproductpackage.enable.package', 1)){
			$package = $product->getPackage();
			$viewAllowed = $package->getItemModule();
			if(!$viewAllowed)
				return $this->setNoRender();
			//allow upload photo
			$this->view->allow_create = $allow_create = $package->allowUploadPhoto($product);
		}
    $sesproduct_photos = Zend_Registry::isRegistered('sesproduct_photos') ? Zend_Registry::get('sesproduct_photos') : null;

	 $photoTable = Engine_Api::_()->getItemTable('sesproduct_photo');
		 // Do other stuff
			$this->view->mine = $mine  = true;
			$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

		if($viewer->getIdentity() > 0){
			$this->view->canEdit = $viewPermission = $product->authorization()->isAllowed($viewer, 'edit');
			$this->view->canComment =  $product->authorization()->isAllowed($viewer, 'comment');
			$this->view->canCreateMemberLevelPermission =  Engine_Api::_()->authorization()->getPermission($viewer, 'sesproduct', 'create');

			$this->view->canEditMemberLevelPermission   =  Engine_Api::_()->authorization()->getPermission($viewer,'sesproduct', 'edit');
			$this->view->canDeleteMemberLevelPermission  = Engine_Api::_()->authorization()->getPermission($viewer,'sesproduct', 'delete');
		}
    if (empty($sesproduct_photos))
      return $this->setNoRender();
    if(!$is_ajax){
			// Prepare data
			$this->view->albumUser = $albumUser = Engine_Api::_()->getItem('user', $album->owner_id);
			if (!$albumUser->isSelf(Engine_Api::_()->user()->getViewer())) {
				$album->getTable()->update(array(
						'view_count' => new Zend_Db_Expr('view_count + 1'),
								), array(
						'album_id = ?' => $album->getIdentity(),
				));
				$this->view->mine = $mine = false;
			}else{
					$this->view->mine = $mine = false;
			}
		}
		$this->view->paginator = $paginator = $photoTable->getPhotoPaginator(array(
        'album' => $album,
    ));
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($page);
		$this->view->page = $page + 1;

		$viewer = Engine_Api::_()->user()->getViewer();

		if($is_ajax || $is_related){
			$this->getElement()->removeDecorator('Container');
		}else if(!$is_ajax){
		  $getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
			if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0){
				$this->view->doctype('XHTML1_RDFA');
				$this->view->docActive = true;
			}
		}

  }
}
