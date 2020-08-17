<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespage_Widget_ProfilePhotosController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {

	  // Default param options
    if(isset($_POST['params']))
      $params = json_decode($_POST['params'],true);

    if(isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $this->view->is_ajax = $value['is_ajax'] = isset($_POST['is_ajax']) ? true : false;

    $value['page'] = isset($_POST['page']) ? $_POST['page'] : 1 ;

    $this->view->album_parent_id =  $id = isset($params['album_parent_id']) ? $params['album_parent_id'] : Zend_Controller_Front::getInstance()->getRequest()->getParam('id', null);

    $value['page_id'] = $this->view->page_id =  $page_id = Engine_Api::_()->getDbTable('pages', 'sespage')->getPageId($id);
    $this->view->pageItem  = $subject = Engine_Api::_()->getItem('sespage_page', $page_id);

    $value['identityForWidget'] = $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    $this->view->view_type =$view_type =isset($params['view_type']) ? $params['view_type'] : $this->_getParam('view_type', '1');
    $this->view->height = $value['defaultHeight'] =isset($params['height']) ? $params['height'] : $this->_getParam('height', '200');

    $this->view->socialshare_enable_plusicon = $value['socialshare_enable_plusicon'] =isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $value['socialshare_icon_limit'] = isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);

    $this->view->width = $value['defaultWidth'] =isset($params['width']) ? $params['width'] : $this->_getParam('width', '200');
    $this->view->limit_data = $value['limit_data'] = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data', '20');
    $this->view->load_content = $value['load_content'] = isset($params['load_content']) ? $params['load_content'] : $this->_getParam('load_content', 'auto_load');
    $this->view->title_truncation = $value['title_truncation'] = isset($params['title_truncation']) ? $params['title_truncation'] : $this->_getParam('title_truncation', '45');
    $value['show_criterias'] = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria',array('like','comment','by','title','socialSharing','view','photoCount','featured','sponsored','likeButton'));
    $this->view->fixHover = $fixHover = isset($params['fixHover']) ? $params['fixHover'] :$this->_getParam('fixHover', 'fix');
    $this->view->insideOutside =  $insideOutside = isset($params['insideOutside']) ? $params['insideOutside'] : $this->_getParam('insideOutside', 'inside');

    if(count($value['show_criterias']) > 0){
      foreach($value['show_criterias'] as $show_criteria)
        $this->view->$show_criteria = $show_criteria;
    }
    if(isset($value['sort']) && $value['sort'] != '')
    $value['getParamSort'] = str_replace('SP','_',$value['sort']);
    else
    $value['getParamSort'] = 'creation_date';

		$sort = $this->_getParam('sort', null);
		if($sort) {
      $value['getParamSort'] = $sort;
		}
		$value['search'] = $this->_getParam('search', null);

    switch($value['getParamSort']) {
      case 'most_viewed':
        $value['order'] = 'view_count';
        break;
      case 'most_liked':
			$value['order'] = 'like_count';
			break;
					case 'most_commented':
			$value['order'] = 'comment_count';
			break;
					case 'creation_date':
			default:
			$value['order'] = 'creation_date';
			break;
    }

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    $params = $this->view->params = array('album_parent_id' => $id,'width'=>$value['defaultWidth'],'height'=>$value['defaultHeight'],'limit_data' =>$value['limit_data'],'load_content'=>$value['load_content'],'show_criterias'=>$value['show_criterias'],'title_truncation'=>$value['title_truncation'],'insideOutside'=>$insideOutside,'fixHover'=>$fixHover,'view_type'=>$view_type, 'socialshare_enable_plusicon' => $value['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $value['socialshare_icon_limit']);

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('albums', 'sespage')->getAlbumSelect($value);

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($value['limit_data']);
    $this->view->page = $value['page'] ;
    $paginator->setCurrentPageNumber($value['page']);

    if($value['is_ajax'])
      $this->getElement()->removeDecorator('Container');
    
    $allowed = true;
    if (SESPAGEPACKAGE == 1) {
      if (isset($subject)) {
        $package = Engine_Api::_()->getItem('sespagepackage_package', $subject->package_id);
      }
      if (!isset($package)) {
        $packageId = Engine_Api::_()->getDbTable('packages', 'sespagepackage')->getDefaultPackage();
        $package = Engine_Api::_()->getItem('sespagepackage_package', $packageId);
      }
      $params = json_decode($package->params, true);
      if (empty($params['album'])) {
          return $this->setNoRender();
      }
    }

    
	$getPageRolePermission = Engine_Api::_()->sespage()->getPageRolePermission($subject->getIdentity(),'post_content','album',false);
    $levelId = !empty($viewer->getIdentity()) ? $viewer->level_id : 5;
    $canUpload = $getPageRolePermission ? $getPageRolePermission : $subject->authorization()->isAllowed($levelId, 'album');
    $this->view->canUpload = !$allowed ? false : $canUpload;
    $this->view->page_album_count = $page_album_count = Engine_Api::_()->authorization()->getPermission($levelId, 'sespage_page', 'page_album_count');

    //Manage Apps Check
    $isCheck = Engine_Api::_()->getDbTable('managepageapps', 'sespage')->isCheck(array('page_id' => $page_id, 'columnname' => 'photos'));
    if(empty($isCheck))
      return $this->setNoRender();

    // Do not render if nothing to show and cannot upload
//     if ($paginator->getTotalItemCount() <= 0 && !$canUpload) {
//       return $this->setNoRender();
//     }

    // Add count to title if configured
    if ($paginator->getTotalItemCount() > 0) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }

  public function getChildCount() {
    return $this->_childCount;
  }
}
