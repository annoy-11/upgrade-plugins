<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Widget_AlbumTabbedWidgetController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

		// Default option for tabbed widget
		if(isset($_POST['params']))
			$params = json_decode($_POST['params'],true);

		if(isset($_POST['searchParams']) && $_POST['searchParams'])
			parse_str($_POST['searchParams'], $searchArray);

		$this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;

		$page = isset($_POST['page']) ? $_POST['page'] : 1 ;

		$this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';

		$this->view->defaultOptionsArray = $defaultOptionsArray = $this->_getParam('search_type');
		$this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');

		if(!$is_ajax) {

			//order tabs
			if(count($defaultOptionsArray) == 0)
					return $this->setNoRender();
			$defaultOptions = $arrayOptions = array();
			foreach($defaultOptionsArray as $key=>$defaultValue){
				if( $this->_getParam($defaultValue.'_order'))
					$order = $this->_getParam($defaultValue.'_order').'||'.$defaultValue;
				else
					$order = (999+$key).'||'.$defaultValue;
				if( $this->_getParam($defaultValue.'_label'))
						$valueLabel = $this->_getParam($defaultValue.'_label');
				else{
					if($defaultValue == 'recentlySPcreated')
						$valueLabel ='Recently Created';
					else if($defaultValue == 'mostSPviewed')
						$valueLabel = 'Most Viewed';
					else if($defaultValue == 'mostSPliked')
						$valueLabel = 'Most Liked';
					else if($defaultValue == 'mostSPcommented')
						$valueLabel = 'Most Commented';
					else if($defaultValue == 'mostSPfavourite')
						$valueLabel = 'Most Favourite';
					else if($defaultValue == 'featured')
						$valueLabel = 'Featured';
					else if($defaultValue == 'sponsored')
						$valueLabel = 'Sponsored';
				}
				$arrayOptions[$order] = $valueLabel;
			}
			ksort($arrayOptions);
			$counter = 0;
			foreach($arrayOptions as $key => $valueOption){
				$key = explode('||',$key);
			if($counter == 0)
				$this->view->defaultOpenTab = $defaultOpenTab = $key[1];
				$defaultOptions[$key[1]]=$valueOption;
				$counter++;
			}
			$this->view->defaultOptions = $defaultOptions;
			$this->view->tab_option = $this->_getParam('tab_option','filter');
		}
    $sesbusiness_sesbusinesswidget = Zend_Registry::isRegistered('sesbusiness_sesbusinesswidget') ? Zend_Registry::get('sesbusiness_sesbusinesswidget') : null;
    if(empty($sesbusiness_sesbusinesswidget)) {
      return $this->setNoRender();
    }
		//default params
		if(isset($_GET['openTab']) || $is_ajax) {
		 $this->view->defaultOpenTab = $defaultOpenTab = !empty($searchArray['sort']) ? $searchArray['sort'] : (!empty($_GET['openTab']) ? $_GET['openTab'] : ($this->_getParam('openTab',false) ? $this->_getParam('openTab') : (!empty($params['openTab']) ? $params['openTab'] : '' )));
		}

		$defaultOptions =isset($params['defaultOptions']) ? $params['defaultOptions'] : $defaultOptions;

		$this->view->height = $defaultHeight =isset($params['height']) ? $params['height'] : $this->_getParam('height', '160px');
		$this->view->width = $defaultWidth= isset($params['width']) ? $params['width'] :$this->_getParam('width', '140px');

		$this->view->limit_data = $limit_data = isset($params['limit_data']) ? $params['limit_data'] :$this->_getParam('limit_data', '9');

    $this->view->socialshare_enable_plusicon = $socialshare_enable_plusicon = isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] :$this->_getParam('socialshare_enable_plusicon', 1);
		$this->view->socialshare_icon_limit = $socialshare_icon_limit = isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] :$this->_getParam('socialshare_icon_limit', 2);

		$this->view->show_limited_data = $show_limited_data = isset($params['show_limited_data']) ? $params['show_limited_data'] :$this->_getParam('show_limited_data', 'no');
 	  $this->view->limit = ($page-1)*$limit_data;
		$this->view->title_truncation = $title_truncation = isset($params['title_truncation']) ? $params['title_truncation'] :$this->_getParam('title_truncation', '45');

		$show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria',array('like','comment','by','title','socialSharing','view','photoCount','favouriteCount','favouriteButton','likeButton'));
		$this->view->fixHover = $fixHover = isset($params['fixHover']) ? $params['fixHover'] :$this->_getParam('fixHover', 'fix');
		$this->view->insideOutside =  $insideOutside = isset($params['insideOutside']) ? $params['insideOutside'] : $this->_getParam('insideOutside', 'inside');

		foreach($show_criterias as $show_criteria)
			$this->view->$show_criteria = $show_criteria;

		$value['sort'] = isset($searchArray['sort']) ? $searchArray['sort'] :  (isset($_GET['sort']) ? $_GET['sort'] : (isset($params['sort']) ?  $params['sort'] : '')) ;

		$value['showdefaultalbum'] = isset($searchArray['showdefaultalbum']) ? $searchArray['showdefaultalbum'] :  (isset($_GET['showdefaultalbum']) ? $_GET['showdefaultalbum'] : (isset($params['showdefaultalbum']) ?  $params['showdefaultalbum'] : 0)) ;

		$value['search'] = isset($searchArray['search']) ? $searchArray['search'] :  (isset($_GET['search']) ? $_GET['search'] : (isset($params['search']) ?  $params['search'] : '')) ;

		$value['show'] = isset($searchArray['show']) ? $searchArray['show'] :  (isset($_GET['show']) ? $_GET['show'] : (isset($params['show']) ?  $params['show'] : ''));

	  $this->view->albumPhotoOption =  $albumPhotoOption = isset($params['albumPhotoOption']) ? $params['albumPhotoOption'] : $this->_getParam('photo_album', 'photo');

		$this->view->description_truncation = $description_truncation = isset($params['description_truncation']) ? $params['description_truncation'] : $this->_getParam('description_truncation', '80');

		$this->view->params = $params = array('height'=>$defaultHeight,'width' => $defaultWidth,'limit_data' => $limit_data,'albumPhotoOption' =>$albumPhotoOption,'openTab'=>$defaultOpenTab,'pagging'=>$loadOptionData,'show_criterias'=>$show_criterias,'title_truncation' =>$title_truncation,'insideOutside' =>$insideOutside,'fixHover'=>$fixHover,'defaultOptions'=>$defaultOptions,'sort'=>$value['sort'],'search'=>$value['search'],'show_limited_data'=>$show_limited_data,'show'=>$value['show'],'description_truncation'=>$description_truncation, 'socialshare_enable_plusicon' => $socialshare_enable_plusicon, 'socialshare_icon_limit' => $socialshare_icon_limit);

    if(!$show_limited_data)
      $this->view->show_limited_data = 'no';

		$this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;

		// initialize type variable type
		$type = '';
		if(!$is_ajax) {
			$defaultOpenTab = (isset($_GET['sort']) && $_GET['sort'] ? $_GET['sort'] : $defaultOpenTab);
		}
		switch($defaultOpenTab){
			case 'recentlySPcreated':
				$popularCol = 'creation_date';
			break;
			case 'mostSPviewed':
				$popularCol = 'view_count';
			break;
			case 'mostSPliked':
				$popularCol = 'like_count';
			break;
			case 'mostSPcommented':
				$popularCol = 'comment_count';
			break;
  		case 'mostSPfavourite':
				$popularCol = 'favourite_count';
				$type = 'favourite';
			break;
  		case 'featured':
				$popularCol = 'featured';
			break;
  		case 'sponsored':
				$popularCol = 'sponsored';
			break;
			default:
        return $this->setNoRender();
			break;
		}
		$this->view->type = $type;
		$this->view->itemOrigTitle = isset($defaultOptions[$defaultOpenTab]) ? $defaultOptions[$defaultOpenTab] : 'items';
		$value['order'] = isset($popularCol) ? $popularCol : 'creation_date';
		$value['fixedData'] = 	isset($fixedData) ? $fixedData : '';

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('albums', 'sesbusiness')->getAlbumSelect($value);

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage',$limit_data));
		$this->view->page = $page ;
    $paginator->setCurrentPageNumber ($page);
		if($is_ajax)
			$this->getElement()->removeDecorator('Container');
		else {
			// Do not render if nothing to show
			if( $paginator->getTotalItemCount() <= 0 ) {
				$nameFunction = 'count'.ucfirst($albumPhotoOption).'s';
				$checkAlbumCount = Engine_Api::_()->getDbTable($albumPhotoOption.'s', 'sesbusiness')->$nameFunction();
				if( $checkAlbumCount <= 0 ) {
					return $this->setNoRender();
				}
			}
		}
  }
}
