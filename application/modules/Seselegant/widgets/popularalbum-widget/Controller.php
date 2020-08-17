<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seselegant_Widget_PopularalbumWidgetController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {

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
		if(!$is_ajax){
  		$this->view->defaultOpenTab = $defaultOpenTab = $defaultOptionsArray;

		}

		$this->view->height = $defaultHeight =isset($params['height']) ? $params['height'] : $this->_getParam('height', '160px');
		$this->view->width = $defaultWidth= isset($params['width']) ? $params['width'] :$this->_getParam('width', '140px');

		$this->view->limit_data = $limit_data = isset($params['limit_data']) ? $params['limit_data'] :$this->_getParam('limit_data', '9');

 	  $this->view->limit = ($page-1)*$limit_data;

		$show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria',array('like','comment','by','title','view','photoCount','favouriteCount','downloadCount'));


		foreach($show_criterias as $show_criteria)
			$this->view->$show_criteria = $show_criteria;

		$params = $this->view->params = array('height'=>$defaultHeight,'width' => $defaultWidth,'limit_data' => $limit_data,'show_criterias'=>$show_criterias);

		//Initialize type variable type
		$type = '';
		if(!$is_ajax){
			$defaultOpenTab = (isset($_GET['sort']) && $_GET['sort'] ? $_GET['sort'] : $defaultOpenTab);
		}

		switch($defaultOpenTab){
			case 'recentlySPcreated':
				$popularCol = 'creation_date';
				$type = 'creation';
			break;
			case 'mostSPviewed':
				$popularCol = 'view_count';
				$type = 'view';
			break;
			case 'mostSPliked':
				$popularCol = 'like_count';
				$type = 'like';
			break;
			case 'mostSPcommented':
				$popularCol = 'comment_count';
				$type = 'comment';
			break;
			case 'mostSPrated':
				$popularCol = 'rating';
				$type = 'rating';
			break;
			case 'featured':
				$popularCol = 'is_featured';
				$type = 'is_featured';
				$fixedData = 'is_featured';
			break;
			case 'sponsored':
				$popularCol = 'is_sponsored';
				$type = 'is_sponsored';
				$fixedData = 'is_sponsored';
			break;
			case 'mostSPfavourite':
				$popularCol = 'favourite_count';
				$type = 'favourite';
			break;
			case 'mostSPdownloaded':
				$popularCol = 'download_count';
				$type = 'download';
			break;
			default:
				return $this->setNoRender();
			break;
		}
		$this->view->type = $type;
		$this->view->itemOrigTitle = isset($defaultOptions[$defaultOpenTab]) ? $defaultOptions[$defaultOpenTab] : 'items';
		$value['popularCol'] = isset($popularCol) ? $popularCol : 'creation_date';
		$value['fixedData'] = 	isset($fixedData) ? $fixedData : '';

		//fetch data
		$albumTable = Engine_Api::_()->getDbTable('albums', 'album');


		$tableName = $albumTable->info('name');
		$new_select = $albumTable->select()
			->from($tableName)

			->where($tableName.'.photo_id !=?','')
			->order($value['popularCol'] . ' DESC');
		if(isset($value['fixedData']) && $value['fixedData'] != ''){
			$new_select = $new_select->where($tableName.'.'.$value['fixedData'].' =?',1);
		}

        $paginator =   Zend_Paginator::factory($new_select);
    $this->view->paginator = $paginator ;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage',$limit_data));
		$this->view->page = $page ;
    $paginator->setCurrentPageNumber($page);
		$this->view->canCreate = Engine_Api::_()->authorization()->isAllowed('album', null, 'create');
  }
}
