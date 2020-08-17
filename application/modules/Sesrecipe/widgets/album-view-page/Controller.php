<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesrecipe_Widget_AlbumViewPageController extends Engine_Content_Widget_Abstract
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
// 	$sesevent_eventalbumphotos = Zend_Registry::isRegistered('sesevent_eventalbumphotos') ? Zend_Registry::get('sesevent_eventalbumphotos') : null;
// 	if(empty($sesevent_eventalbumphotos)) {
// 		return $this->setNoRender();
// 	}
	if(Engine_Api::_()->core()->hasSubject()){
			$album = Engine_Api::_()->core()->getSubject();
		
			$recipe =  Engine_Api::_()->getItem('sesrecipe_recipe', $album->recipe_id);		
		}else{
			$album =  Engine_Api::_()->getItem('sesrecipe_album', $_POST['album_id']);
			$recipe =  Engine_Api::_()->getItem('sesrecipe_recipe', $_POST['recipe_id']);		
		}
		$this->view->allow_create = true;
		$this->view->recipe = $recipe;
		 $this->view->album = $album;
		 $this->view->album_id = $param['id'] = $album->album_id;
		 $this->view->recipe_id = $param['recipe_id'] = $album->recipe_id;
		if(!$is_ajax && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesrecipepackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipepackage.enable.package', 1)){
			$package = $recipe->getPackage();
			$viewAllowed = $package->getItemModule();
			if(!$viewAllowed)
				return $this->setNoRender();
			//allow upload photo
			$this->view->allow_create = $allow_create = $package->allowUploadPhoto($recipe);
		}
    $sesrecipe_photos = Zend_Registry::isRegistered('sesrecipe_photos') ? Zend_Registry::get('sesrecipe_photos') : null;

	 $photoTable = Engine_Api::_()->getItemTable('sesrecipe_photo');
		 // Do other stuff
			$this->view->mine = $mine  = true;
			$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
			
		if($viewer->getIdentity() > 0){
			$this->view->canEdit = $viewPermission = $recipe->authorization()->isAllowed($viewer, 'edit');
			$this->view->canComment =  $recipe->authorization()->isAllowed($viewer, 'comment');
			$this->view->canCreateMemberLevelPermission =  Engine_Api::_()->authorization()->getPermission($viewer, 'sesrecipe_recipe', 'create');
			
			$this->view->canEditMemberLevelPermission   =  Engine_Api::_()->authorization()->getPermission($viewer,'sesrecipe_recipe', 'edit');
			$this->view->canDeleteMemberLevelPermission  = Engine_Api::_()->authorization()->getPermission($viewer,'sesrecipe_recipe', 'delete');
		}
    if (empty($sesrecipe_photos))
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
		
// 		if(!$is_ajax){
// 			$this->view->canDownload = 0;
// 			$this->view->defaultOptionsArray = $defaultOptionsArray = $this->_getParam('search_type');
// 			$defaultOptions = $arrayOptions = array();
// 			foreach($defaultOptionsArray as $key=>$defaultValue){
// 				if( $this->_getParam($defaultValue.'_order'))
// 					$order = $this->_getParam($defaultValue.'_order').'||'.$defaultValue;
// 				else
// 					$order = (999+$key).'||'.$defaultValue;
// 				if( $this->_getParam($defaultValue.'_label'))
// 						$valueLabel = $this->_getParam($defaultValue.'_label');
// 				else{
// 					if($defaultValue == 'RecentAlbum')
// 						$valueLabel ='[USER_NAME]\'s Recent Albums';
// 					else if($defaultValue == 'Like')
// 						$valueLabel = 'People Who Like This';
// 					else if($defaultValue == 'TaggedUser')
// 						$valueLabel = 'People Who Are Tagged In This Album';
// 					else if($defaultValue == 'Fav')
// 						$valueLabel = 'People Who Added This As Favourite';
// 				}
// 				$arrayOptions[$order] = $valueLabel;
// 			}
// 			ksort($arrayOptions);
// 			$counter = 0;
// 			foreach($arrayOptions as $key => $valueOption){
// 				$key = explode('||',$key);
// 			if($counter == 0)
// 				$this->view->defaultOpenTab = $defaultOpenTab = $key[1];
// 				$defaultOptions[$key[1]]=$valueOption;
// 				$counter++;
// 			}
// 			$this->view->defaultOptions = $defaultOptions;
// 			
// 		}
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