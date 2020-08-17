<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_OtherModulesProfileSescrowdfundingsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    $this->view->defaultOptionsArray = $defaultOptionsArray = $this->_getParam('search_type',array('recentlySPcreated','mostSPviewed','mostSPliked','mostSPcommented','mostSPrated','mostSPfavourite','featured', 'week', 'month'));

    if (isset($_POST['params']))
      $params = $_POST['params'];

    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    
    if(!$is_ajax) {
			if( !Engine_Api::_()->core()->hasSubject() ) {
				return $this->setNoRender();
			}
      // Get subject and check auth
      $subject = Engine_Api::_()->core()->getSubject();
      if (!$subject->authorization()->isAllowed($viewer, 'view')) {
        return $this->setNoRender();
      }
    }

    $defaultOpenTab = array();
    $defaultOptions = $arrayOptions = array();
    if (!$is_ajax && is_array($defaultOptionsArray)) {
      foreach ($defaultOptionsArray as $key => $defaultValue) {
        if ($this->_getParam($defaultValue . '_order'))
          $order = $this->_getParam($defaultValue . '_order');
        else
          $order = (777 + $key);
        if ($this->_getParam($defaultValue.'_label'))
          $valueLabel = $this->_getParam($defaultValue . '_label'). '||' . $defaultValue;
        else {
          if ($defaultValue == 'recentlySPcreated')
            $valueLabel = 'Recently Created'. '||' . $defaultValue;
          else if ($defaultValue == 'mostSPviewed')
            $valueLabel = 'Most Viewed'. '||' . $defaultValue;
          else if ($defaultValue == 'mostSPliked')
            $valueLabel = 'Most Liked'. '||' . $defaultValue;
          else if ($defaultValue == 'mostSPcommented')
            $valueLabel = 'Most Commented'. '||' . $defaultValue;
          else if ($defaultValue == 'mostSPrated')
            $valueLabel = 'Most Rated'. '||' . $defaultValue;
          else if ($defaultValue == 'mostSPdonated')
            $valueLabel = 'Most Donated'. '||' . $defaultValue;
          else if ($defaultValue == 'featured')
            $valueLabel = 'Featured'. '||' . $defaultValue;
          else if ($defaultValue == 'week')
            $valueLabel = 'This Week'. '||' . $defaultValue;
					else if ($defaultValue == 'month')
            $valueLabel = 'This Month'. '||' . $defaultValue;
        }
        $arrayOptions[$order] = $valueLabel;
      }
      ksort($arrayOptions);
      $counter = 0;
      foreach ($arrayOptions as $key => $valueOption) {
        $key = explode('||', $valueOption);
        if ($counter == 0)
          $this->view->defaultOpenTab = $defaultOpenTab = $key[1];
        $defaultOptions[$key[1]] = $key[0];
        $counter++;
      }
    }

    $this->view->defaultOptions = $defaultOptions;

    if (isset($_GET['openTab']) || $is_ajax) {
      $this->view->defaultOpenTab = $defaultOpenTab = (isset($_GET['openTab']) ? str_replace('_', 'SP', $_GET['openTab']) : ($this->_getParam('openTab') != NULL ? $this->_getParam('openTab') : (isset($params['openTab']) ? $params['openTab'] : '' )));
    }

		//simple list view
		$this->view->title_truncation_simplelist = $title_truncation_simplelist = isset($params['title_truncation_simplelist']) ? $params['title_truncation_simplelist'] : $this->_getParam('title_truncation_simplelist', '100');
		$this->view->width_simplelist = $width_simplelist = isset($params['width_simplelist']) ? $params['width_simplelist'] : $this->_getParam('width_simplelist','140');
    $this->view->height_simplelist = $height_simplelist = isset($params['height_simplelist']) ? $params['height_simplelist'] : $this->_getParam('height_simplelist','160');
		$this->view->description_truncation_simplelist = $description_truncation_simplelist = isset($params['description_truncation_simplelist']) ? $params['description_truncation_simplelist'] : $this->_getParam('description_truncation_simplelist', '100');
		$this->view->limit_data_simplelist = $limit_data_simplelist = isset($params['limit_data_simplelist']) ? $params['limit_data_simplelist'] : $this->_getParam('limit_data_simplelist', '10');



		$this->view->htmlTitle = $htmlTitle = isset($params['htmlTitle']) ? $params['htmlTitle'] : $this->_getParam('htmlTitle','1');
		$this->view->tab_option = $tab_option = isset($params['tabOption']) ? $params['tabOption'] : $this->_getParam('tabOption','vertical');
    $this->view->height_list = $defaultHeightList = isset($params['height_list']) ? $params['height_list'] : $this->_getParam('height_list','160');

    $this->view->width_list = $defaultWidthList = isset($params['width_list']) ? $params['width_list'] : $this->_getParam('width_list','140');

    $this->view->height_grid = $defaultHeightGrid = isset($params['height_grid']) ? $params['height_grid'] : $this->_getParam('height_grid','160');

    $this->view->width_grid = $defaultWidthGrid = isset($params['width_grid']) ? $params['width_grid'] : $this->_getParam('width_grid','140');

    $this->view->width_pinboard = $defaultWidthPinboard = isset($params['width_pinboard']) ? $params['width_pinboard'] : $this->_getParam('width_pinboard','300');

    $this->view->height = $defaultHeight = isset($params['height']) ? $params['height'] : $this->_getParam('height', '200px');

    $this->view->title_truncation_list = $title_truncation_list = isset($params['title_truncation_list']) ? $params['title_truncation_list'] : $this->_getParam('title_truncation_list', '100');

    $this->view->title_truncation_grid = $title_truncation_grid = isset($params['title_truncation_grid']) ? $params['title_truncation_grid'] : $this->_getParam('title_truncation_grid', '100');

    $this->view->title_truncation_pinboard = $title_truncation_pinboard = isset($params['title_truncation_pinboard']) ? $params['title_truncation_pinboard'] : $this->_getParam('title_truncation_pinboard', '100');

    $this->view->description_truncation_list = $description_truncation_list = isset($params['description_truncation_list']) ? $params['description_truncation_list'] : $this->_getParam('description_truncation_list', '100');

    $this->view->description_truncation_grid = $description_truncation_grid = isset($params['description_truncation_grid']) ? $params['description_truncation_grid'] : $this->_getParam('description_truncation_grid', '100');

    $this->view->description_truncation_pinboard = $description_truncation_pinboard = isset($params['description_truncation_pinboard']) ? $params['description_truncation_pinboard'] : $this->_getParam('description_truncation_pinboard', '100');

    $this->view->show_limited_data = $show_limited_data = isset($params['show_limited_data']) ? $params['show_limited_data'] : $this->_getParam('show_limited_data', 0);
     $this->view->category_id = $category_id = isset($params['category_id']) ? $params['category_id'] : $this->_getParam('category_id', 0);
     
    $this->view->resource_id = $value['resource_id'] = $resource_id = isset($_GET['resource_id']) ? $_GET['resource_id'] : (isset($params['resource_id']) ?  $params['resource_id'] : Engine_Api::_()->core()->getSubject()->getIdentity());
    
    $this->view->resource_type = $value['resource_type'] = $resource_type = isset($_GET['resource_type']) ? $_GET['resource_type'] : (isset($params['resource_type']) ?  $params['resource_type'] : Engine_Api::_()->core()->getSubject()->getType());

    //Need to Discuss
    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'rating', 'ratingStar', 'by', 'title', 'featuredLabel','sponsoredLabel','verifiedLabel', 'category','description_list','description_grid','description_pinboard', 'favouriteButton','likeButton', 'socialSharing', 'view', 'creationDate', 'readmore'));
    if(is_array($show_criterias)) {
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }

    $this->view->limit_data_pinboard = $limit_data_pinboard = isset($params['limit_data_pinboard']) ? $params['limit_data_pinboard'] : $this->_getParam('limit_data_pinboard', '10');

    $this->view->limit_data_grid = $limit_data_grid = isset($params['limit_data_grid']) ? $params['limit_data_grid'] : $this->_getParam('limit_data_grid', '10');

    $this->view->limit_data_list = $limit_data_list = isset($params['limit_data_list']) ? $params['limit_data_list'] : $this->_getParam('limit_data_list', '10');

    $this->view->bothViewEnable = false;
    if (!$is_ajax) {
      $optionsEnable = $this->_getParam('enableTabs', array('list', 'simplelist', 'advlist', 'advlist2', 'grid', 'grid2', 'advgrid', 'supergrid', 'pinboard', 'map'));
      if($optionsEnable == '')
      $this->view->optionsEnable = array();
      else
      $this->view->optionsEnable = $optionsEnable;
      $view_type = $this->_getParam('openViewType', 'list');
      if (count($optionsEnable) > 1) {
        $this->view->bothViewEnable = true;
      }
    }

    $this->view->view_type = $view_type = (isset($_POST['type']) ? $_POST['type'] : (isset($params['view_type']) ? $params['view_type'] : $view_type));
    $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
    $params = array('height' => $defaultHeight,'openTab' => $defaultOpenTab,'height_list' => $defaultHeightList, 'width_list' => $defaultWidthList,'height_grid' => $defaultHeightGrid, 'width_grid' => $defaultWidthGrid,'width_pinboard'=>$defaultWidthPinboard,'limit_data_pinboard'=>$limit_data_pinboard,'limit_data_list'=>$limit_data_list,'limit_data_grid'=>$limit_data_grid,'pagging' => $loadOptionData, 'show_criterias' => $show_criterias, 'view_type' => $view_type,  'description_truncation_list' => $description_truncation_list, 'title_truncation_list' => $title_truncation_list, 'title_truncation_grid' => $title_truncation_grid,'title_truncation_pinboard'=>$title_truncation_pinboard,'description_truncation_grid'=>$description_truncation_grid,'description_truncation_pinboard'=>$description_truncation_pinboard, 'show_limited_data' => $show_limited_data,'title_truncation_simplelist'=>$title_truncation_simplelist,'width_simplelist'=>$width_simplelist,'height_simplelist'=>$height_simplelist,'description_truncation_simplelist'=>$description_truncation_simplelist,'limit_data_simplelist'=>$limit_data_simplelist,'category_id'=>$category_id, 'resource_id' => $resource_id, 'resource_type' => $resource_type);
    $this->view->loadJs = true;

    //Custom list grid view options
    $this->view->can_create = Engine_Api::_()->authorization()->isAllowed('crowdfunding', null, 'create');

    $type = '';
    switch ($defaultOpenTab) {
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
      case 'mostSPdonated':
        $popularCol = 'donate_count';
        $type = 'donate';
        break;
      case 'featured':
        $popularCol = 'featured';
        $type = 'featured';
        $fixedData = 'featured';
        break;
      case 'week':
        $popularCol = 'week';
        $type = 'week';
        break;
      case 'month':
        $popularCol = 'month';
        $type = 'month';
        break;
    }

    $this->view->type = $type;
    $value['popularCol'] = isset($popularCol) ? $popularCol : '';
    $value['fixedData'] = isset($fixedData) ? $fixedData : '';
    $value['draft'] = 0;
    $value['search'] = 1;
    $options = array('tabbed' => true, 'paggindData' => true);
    $this->view->optionsListGrid = $options;
    $this->view->widgetName = 'other-modules-profile-sescrowdfundings';
    $params = array_merge($params, $value);

    //Get Crowdfunding
    $paginator = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->getSescrowdfundingsPaginator($params);
    $this->view->paginator = $paginator;

    //Set item count per page and current page number
    $limit_data = $this->view->{'limit_data_'.$view_type};
    $paginator->setItemCountPerPage($limit_data);
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;
    $paginator->setCurrentPageNumber($page);
    $this->view->params = $params;
    if ($is_ajax)
      $this->getElement()->removeDecorator('Container');

  }
}
