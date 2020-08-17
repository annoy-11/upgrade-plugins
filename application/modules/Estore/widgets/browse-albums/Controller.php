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
class Estore_Widget_BrowseAlbumsController extends Engine_Content_Widget_Abstract {

	public function indexAction() {

		// Default param options
		if(isset($_POST['params'])) {
			$params = json_decode($_POST['params'],true);
		}

		if(isset($_POST['searchParams']) && $_POST['searchParams'])
			parse_str($_POST['searchParams'], $searchArray);

		$this->view->is_ajax = $value['is_ajax'] = isset($_POST['is_ajax']) ? true : false;
		$value['page'] = isset($_POST['page']) ? $_POST['page'] : 1 ;
		$value['identityForWidget'] = $identityForWidget = $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : $this->view->identity;
	  $this->view->view_type =$view_type =isset($params['view_type']) ? $params['view_type'] : $this->_getParam('view_type', '1');
		$this->view->height = $value['defaultHeight'] =isset($params['height']) ? $params['height'] : $this->_getParam('height', '200');
		$this->view->width = $value['defaultWidth'] =isset($params['width']) ? $params['width'] : $this->_getParam('width', '200');
		$this->view->limit_data = $value['limit_data'] = isset($params['limit_data']) ? $params['limit_data'] : $this->_getParam('limit_data', '20');
		$this->view->load_content = $value['load_content'] = isset($params['load_content']) ? $params['load_content'] : $this->_getParam('load_content', 'auto_load');
    $estore_estorewidget = Zend_Registry::isRegistered('estore_estorewidget') ? Zend_Registry::get('estore_estorewidget') : null;
    if(empty($estore_estorewidget)) {
      return $this->setNoRender();
    }
		$value['sort'] = isset($searchArray['sort']) ? $searchArray['sort'] :  (isset($_GET['sort']) ? $_GET['sort'] : (isset($params['sort']) ?  $params['sort'] : $this->_getParam('sort', 'mostSPliked'))) ;
    $value['show'] = isset($searchArray['show']) ? $searchArray['show'] :  (isset($_GET['show']) ? $_GET['show'] : (isset($params['show']) ?  $params['show'] : ''));
		$value['search'] = isset($searchArray['search']) ? $searchArray['search'] :  (isset($_GET['search']) ? $_GET['search'] : (isset($params['search']) ?  $params['search'] : '')) ;

		$value['user_id'] = isset($_GET['user_id']) ? $_GET['user_id'] : (isset($params['user_id']) ?  $params['user_id'] : '');

		$this->view->socialshare_enable_plusicon = $value['socialshare_enable_plusicon'] = isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
		$this->view->socialshare_icon_limit = $value['socialshare_icon_limit'] = isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);

		$this->view->showdefaultalbum = $value['showdefaultalbum'] = isset($params['showdefaultalbum']) ? $params['showdefaultalbum'] : $this->_getParam('showdefaultalbum', 0);


		$this->view->title_truncation = $value['title_truncation'] = isset($params['title_truncation']) ? $params['title_truncation'] : $this->_getParam('title_truncation', '45');
		$value['show_criterias'] = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria',array('like','comment','by','title','socialSharing','view','photoCount','favouriteCount','favouriteButton','likeButton', 'featured', 'sponsored'));
		$this->view->fixHover = $fixHover = isset($params['fixHover']) ? $params['fixHover'] :$this->_getParam('fixHover', 'fix');
		$this->view->insideOutside =  $insideOutside = isset($params['insideOutside']) ? $params['insideOutside'] : $this->_getParam('insideOutside', 'inside');


		foreach($value['show_criterias'] as $show_criteria)
			$this->view->$show_criteria = $show_criteria;
		if(isset($value['sort']) && $value['sort'] != ''){
			$value['getParamSort'] = str_replace('SP','_',$value['sort']);
		}else
			$value['getParamSort'] = 'creation_date';
		switch($value['getParamSort']) {
      case 'most_viewed':
        $value['order'] = 'view_count';
        break;
			case 'most_favourite':
        $value['order'] = 'favourite_count';
        break;
			case 'most_liked':
				$value['order'] = 'like_count';
				break;
			case 'most_commented':
				$value['order'] = 'comment_count';
				break;
			case 'featured':
				$value['order'] = 'featured';
				break;
			case 'sponsored':
				$value['order'] = 'sponsored';
				break;
      case 'creation_date':
      default:
        $value['order'] = 'creation_date';
        break;
    }

		$this->view->viewer = Engine_Api::_()->user()->getViewer();
		$params = $this->view->params = array('showdefaultalbum' => $value['showdefaultalbum'], 'width'=>$value['defaultWidth'],'height'=>$value['defaultHeight'],'limit_data' => $value['limit_data'],'sort'=>$value['sort'],'search'=>$value['search'],'load_content'=>$value['load_content'],'show_criterias'=>$value['show_criterias'],'title_truncation' =>$value['title_truncation'],'insideOutside' =>$insideOutside,'fixHover'=>$fixHover,'user_id'=>$value['user_id'],'view_type'=>$view_type,'show'=>$value['show'], 'socialshare_icon_limit' => $value['socialshare_icon_limit'], 'socialshare_enable_plusicon' => $value['socialshare_enable_plusicon']);
		$this->view->canCreate = Engine_Api::_()->authorization()->isAllowed('album', null, 'create');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('albums', 'estore')->getAlbumSelect($value);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($value['limit_data']);
		$this->view->page = $value['page'] ;
    $paginator->setCurrentPageNumber ($value['page']);
		if($value['is_ajax'])
			$this->getElement()->removeDecorator('Container');
			else{
			// Do not render if nothing to show
			if( $paginator->getTotalItemCount() <= 0 ) {
					return $this->setNoRender();
			}
		}
	}
}
