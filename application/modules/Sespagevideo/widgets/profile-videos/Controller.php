<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagevideo_Widget_ProfileVideosController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {

    $viewer = Engine_Api::_()->user()->getViewer();

		$this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
		if (isset($_POST['params']))
      $params = $_POST['params'];
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
		 $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
    if (empty($_POST['is_ajax'])) {
      //Get subject and check auth
      $subject = Engine_Api::_()->core()->getSubject();
      if (!Engine_Api::_()->core()->hasSubject())
        return $this->setNoRender();
      if (!$subject->authorization()->isAllowed($viewer, 'view'))
        return $this->setNoRender();
    } else if($is_ajax){
			$subject = Engine_Api::_()->getItem('sespage_page', $params['parent_id']);
		}

		$viewer = Engine_Api::_()->user()->getViewer();

	  //Privacy Check
    $this->view->allowVideo  = Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'video');

		$this->view->canUpload = $canUpload = $subject->authorization()->isAllowed($viewer, 'video');

		if($viewer->getIdentity()) {
      $this->view->can_edit = Engine_Api::_()->authorization()->getPermission($viewer, 'pagevideo', 'edit');
      $this->view->can_delete = Engine_Api::_()->authorization()->getPermission($viewer, 'pagevideo', 'delete');
		}

    //Default option for widget
    $this->view->parent_id = $parent_id = isset($params['parent_id']) ? $params['parent_id'] : $subject->getIdentity();
    $this->view->parent_type = $parent_type = isset($params['parent_type']) ? $params['parent_type'] : $subject->getType();

    $this->view->socialshare_enable_plusicon = $socialshare_enable_plusicon =isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
		$this->view->socialshare_icon_limit = $socialshare_icon_limit =isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);


		$this->view->height_list = $defaultHeightList = isset($params['height_list']) ? $params['height_list'] : $this->_getParam('height_list','160');
    $this->view->width_list = $defaultWidthList = isset($params['width_list']) ? $params['width_list'] : $this->_getParam('width_list','140');
		$this->view->height_grid = $defaultHeightGrid = isset($params['height_grid']) ? $params['height_grid'] : $this->_getParam('height_grid','160');
    $this->view->width_grid = $defaultWidthGrid = isset($params['width_grid']) ? $params['width_grid'] : $this->_getParam('width_grid','140');
		$this->view->width_pinboard = $defaultWidthPinboard = isset($params['width_pinboard']) ? $params['width_pinboard'] : $this->_getParam('width_pinboard','300');
    $this->view->title_truncation_list = $title_truncation_list = isset($params['title_truncation_list']) ? $params['title_truncation_list'] : $this->_getParam('title_truncation_list', '100');
    $this->view->title_truncation_grid = $title_truncation_grid = isset($params['title_truncation_grid']) ? $params['title_truncation_grid'] : $this->_getParam('title_truncation_grid', '100');
		$this->view->title_truncation_pinboard = $title_truncation_pinboard = isset($params['title_truncation_pinboard']) ? $params['title_truncation_pinboard'] : $this->_getParam('title_truncation_pinboard', '100');
    $this->view->description_truncation_list = $description_truncation_list = isset($params['description_truncation_list']) ? $params['description_truncation_list'] : $this->_getParam('description_truncation_list', '100');
		$this->view->description_truncation_grid = $description_truncation_grid = isset($params['description_truncation_grid']) ? $params['description_truncation_grid'] : $this->_getParam('description_truncation_grid', '100');
		$this->view->description_truncation_pinboard = $description_truncation_pinboard = isset($params['description_truncation_pinboard']) ? $params['description_truncation_pinboard'] : $this->_getParam('description_truncation_pinboard', '100');
    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'rating', 'by', 'title', 'featuredLabel', 'sponsoredLabel', 'watchLater', 'category', 'descriptionlist','descriptiongrid','descriptionpinboard', 'duration', 'hotLabel', 'favouriteButton', 'likeButton', 'socialSharing', 'view'));
    if(is_array($show_criterias)){
			foreach ($show_criterias as $show_criteria)
      	$this->view->{$show_criteria . 'Active'} = $show_criteria;
		}
		$this->view->bothViewEnable = false;
    if (!$is_ajax) {
      $this->view->optionsEnable = $optionsEnable = $this->_getParam('enableTabs', array('list', 'grid', 'pinboard'));
      $view_type = $this->_getParam('openViewType', 'list');
      if (count($optionsEnable) > 1)
        $this->view->bothViewEnable = true;
    }
		 $this->view->limit_data_pinboard = $limit_data_pinboard = isset($params['limit_data_pinboard']) ? $params['limit_data_pinboard'] : $this->_getParam('limit_data_pinboard', '10');
		$this->view->limit_data_grid = $limit_data_grid = isset($params['limit_data_grid']) ? $params['limit_data_grid'] : $this->_getParam('limit_data_grid', '10');
		$this->view->limit_data_list = $limit_data_list = isset($params['limit_data_list']) ? $params['limit_data_list'] : $this->_getParam('limit_data_list', '10');

		 $this->view->limit_data_pinboard = $limit_data_pinboard = isset($params['limit_data_pinboard']) ? $params['limit_data_pinboard'] : $this->_getParam('limit_data_pinboard', '10');
		$this->view->limit_data_grid = $limit_data_grid = isset($params['limit_data_grid']) ? $params['limit_data_grid'] : $this->_getParam('limit_data_grid', '10');
		$this->view->limit_data_list = $limit_data_list = isset($params['limit_data_list']) ? $params['limit_data_list'] : $this->_getParam('limit_data_list', '10');

		 $this->view->view_type = $view_type = (isset($_POST['type']) ? $_POST['type'] : (isset($params['view_type']) ? $params['view_type'] : $view_type));
		$this->view->viewTypeStyle = $viewTypeStyle = (isset($_POST['viewTypeStyle']) ? $_POST['viewTypeStyle'] : (isset($params['viewTypeStyle']) ? $params['viewTypeStyle'] : $this->_getParam('viewTypeStyle','fixed')));
		$limit_data = $this->view->{'limit_data_'.$view_type};
		$show_limited_data = isset($params['show_limited_data']) ? $params['show_limited_data'] :$this->_getParam('show_limited_data', 'no');
		if($show_limited_data == 'yes')
			$this->view->show_limited_data = true;
    $params = $this->view->params = array('height_list' => $defaultHeightList, 'width_list' => $defaultWidthList,'height_grid' => $defaultHeightGrid, 'width_grid' => $defaultWidthGrid,'width_pinboard' => $defaultWidthPinboard,'limit_data_pinboard' => $limit_data_pinboard,'limit_data_list'=>$limit_data_list,'limit_data_grid'=>$limit_data_grid, 'pagging' => $loadOptionData, 'show_criterias' => $show_criterias, 'view_type' => $view_type, 'description_truncation_list' => $description_truncation_list, 'title_truncation_list' => $title_truncation_list, 'title_truncation_grid' => $title_truncation_grid,'title_truncation_pinboard'=>$title_truncation_pinboard,'description_truncation_grid'=>$description_truncation_grid,'description_truncation_pinboard'=>$description_truncation_pinboard,'show_limited_data'=>$show_limited_data,'viewTypeStyle' =>$viewTypeStyle,'parent_id'=>$parent_id,'parent_type'=>$parent_type, 'socialshare_enable_plusicon' => $socialshare_enable_plusicon, 'socialshare_icon_limit' => $socialshare_icon_limit);
    $this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;
		$this->view->loadJs = true;
		$options = array('tabbed' => true,'loadJs' => true, 'paggindData' => true);
		$this->view->optionsListGrid = $options;
    $this->view->widgetName = 'profile-videos';
    $this->view->showTabType = $this->_getParam('showTabType', '1');

		$sort = $this->_getParam('sort', null);
		$search = $this->_getParam('search', null);

    // initialize type variable type
    $paginator = Engine_Api::_()->getDbTable('videos', 'sespagevideo')->getVideo(array('parent_id' => $parent_id, 'parent_type' => $parent_type, 'criteria' => 10, 'text' => $search, 'sort' => $sort));

    $this->view->paginator = $paginator;
    // Add count to title if configured
    if ($paginator->getTotalItemCount() > 0) {
      $this->_childCount = $paginator->getTotalItemCount();
    }

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', $limit_data));
    $this->view->page = $page;
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax)
      $this->getElement()->removeDecorator('Container');
		 //Do not render if nothing to show and cannot upload
//     if ($paginator->getTotalItemCount() <= 0 && !$canUpload) {
//       return $this->setNoRender();
//     }

  }
  public function getChildCount() {
    return $this->_childCount;
  }

}
