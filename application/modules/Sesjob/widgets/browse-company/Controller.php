<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesjob_Widget_BrowseCompanyController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $searchArray = array();
    if (isset($_POST['params']))
    $params = $_POST['params'];

    if (isset($_POST['searchParams']) && $_POST['searchParams'])
    parse_str($_POST['searchParams'], $searchArray);

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->is_search =  $is_search = !empty($_POST['is_search']) ? true : false;
    $searchParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
    $form = new Sesjob_Form_SearchCompany(array('searchTitle' => 'yes','browseBy' => 'yes','categoriesSearch' => 'yes','searchFor'=>'job','FriendsSearch'=>'yes','defaultSearchtype'=>'mostSPliked','locationSearch' => 'yes','kilometerMiles' => 'yes','hasPhoto' => 'yes'));

    if ($is_search)
        $form->populate($searchArray);
    elseif ($is_ajax)
        $form->populate($params);
    else
        $form->populate($searchParams);

    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->identityForWidget = $identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : $this->view->identity;

    $sesjob_browsejobs = Zend_Registry::isRegistered('sesjob_browsejobs') ? Zend_Registry::get('sesjob_browsejobs') : null;
    $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
    $this->view->height_list = $defaultHeightList = isset($params['height_list']) ? $params['height_list'] : $this->_getParam('height_list','160');
    $this->view->width_list = $defaultWidthList = isset($params['width_list']) ? $params['width_list'] : $this->_getParam('width_list','140');
    $this->view->height_grid = $defaultHeightGrid = isset($params['height_grid']) ? $params['height_grid'] : $this->_getParam('height_grid','160');
    $this->view->width_grid = $defaultWidthGrid = isset($params['width_grid']) ? $params['width_grid'] : $this->_getParam('width_grid','140');
    $this->view->width_grid_photo = $defaultWidthGridPhoto = isset($params['width_grid_photo']) ? $params['width_grid_photo'] : $this->_getParam('width_grid_photo','140');

    $this->view->height = $defaultHeight = isset($params['height']) ? $params['height'] : $this->_getParam('height', '200px');
    $this->view->show_item_count = $show_item_count = isset($params['show_item_count']) ? $params['show_item_count'] :  $this->_getParam('show_item_count',0);

    $this->view->title_truncation_list = $title_truncation_list = isset($params['title_truncation_list']) ? $params['title_truncation_list'] : $this->_getParam('title_truncation_list', '100');
    $this->view->title_truncation_grid = $title_truncation_grid = isset($params['title_truncation_grid']) ? $params['title_truncation_grid'] : $this->_getParam('title_truncation_grid', '100');

    $this->view->description_truncation_list = $description_truncation_list = isset($params['description_truncation_list']) ? $params['description_truncation_list'] : $this->_getParam('description_truncation_list', '100');
    $this->view->description_truncation_grid = $description_truncation_grid = isset($params['description_truncation_grid']) ? $params['description_truncation_grid'] : $this->_getParam('description_truncation_grid', '100');


    if (empty($sesjob_browsejobs))
      return $this->setNoRender();

    $text =  isset($searchArray['search']) ? $searchArray['search'] : (!empty($params['search']) ? $params['search'] : (isset($_GET['search']) && ($_GET['search'] != '') ? $_GET['search'] : ''));
    //search data
    $value['sort'] = isset($searchArray['sort']) ? $searchArray['sort'] : (isset($_GET['sort']) ? $_GET['sort'] : (isset($params['sort']) ? $params['sort'] : $this->_getParam('sort', 'mostSPliked')));

    $value['industry_id'] =  isset($searchArray['industry_id']) ? $searchArray['industry_id'] : (isset($_GET['industry_id']) ? $_GET['industry_id'] : (isset($params['industry_id']) ? $params['industry_id'] : $this->_getParam('category')));

    $value['alphabet'] = isset($_GET['alphabet']) ? $_GET['alphabet'] : (isset($params['alphabet']) ? $params['alphabet'] : '');
    $value['date'] = isset($_GET['date']) ? $_GET['date'] : (isset($params['date']) ? $params['date'] : '');
    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('title', 'category','description_list','description_grid', 'socialSharing', 'view', 'creationDate', 'readmore'));

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $paramsUser = $request->getParams();

    $value['user_id'] = isset($_GET['user_id']) ? $_GET['user_id'] : (isset($params['user_id']) ?  $params['user_id'] : (isset($paramsUser['user_id']) ? $paramsUser['user_id'] : ''));
    if(is_array($show_criterias)){
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }

    $this->view->bothViewEnable = false;
    if (!$is_ajax) {
        $this->view->optionsEnable = $optionsEnable = $this->_getParam('enableTabs', array('list','grid'));
        $view_type = $this->_getParam('openViewType', 'list');
        if (count($optionsEnable) > 1) {
            $this->view->bothViewEnable = true;
        }
    }
    $this->view->limit_data_grid = $limit_data_grid = isset($params['limit_data_grid']) ? $params['limit_data_grid'] : $this->_getParam('limit_data_grid', '10');
    $this->view->limit_data_list = $limit_data_list = isset($params['limit_data_list']) ? $params['limit_data_list'] : $this->_getParam('limit_data_list', '10');

    $this->view->view_type = $view_type = (isset($_POST['type']) ? $_POST['type'] : (isset($params['view_type']) ? $params['view_type'] : $view_type));

    //List View1
    $this->view->socialshare_enable_listview1plusicon = $socialshare_enable_listview1plusicon =isset($params['socialshare_enable_listview1plusicon']) ? $params['socialshare_enable_listview1plusicon'] : $this->_getParam('socialshare_enable_listview1plusicon', 1);
    $this->view->socialshare_icon_listview1limit = $socialshare_icon_listview1limit =isset($params['socialshare_icon_listview1limit']) ? $params['socialshare_icon_listview1limit'] : $this->_getParam('socialshare_icon_listview1limit', 2);

    //Grid View 1
    $this->view->socialshare_enable_gridview1plusicon = $socialshare_enable_gridview1plusicon =isset($params['socialshare_enable_gridview1plusicon']) ? $params['socialshare_enable_gridview1plusicon'] : $this->_getParam('socialshare_enable_gridview1plusicon', 1);
    $this->view->socialshare_icon_gridview1limit = $socialshare_icon_gridview1limit =isset($params['socialshare_icon_gridview1limit']) ? $params['socialshare_icon_gridview1limit'] : $this->_getParam('socialshare_icon_gridview1limit', 2);

    $params = array('width_grid_photo' => $defaultWidthGridPhoto,'alphabet' => $value['alphabet'], 'height' => $defaultHeight,'height_list' => $defaultHeightList, 'width_list' => $defaultWidthList,'height_grid' => $defaultHeightGrid, 'width_grid' => $defaultWidthGrid,'limit_data_list'=>$limit_data_list,'limit_data_grid'=>$limit_data_grid,'pagging' => $loadOptionData, 'show_criterias' => $show_criterias, 'view_type' => $view_type,  'description_truncation_list' => $description_truncation_list, 'title_truncation_list' => $title_truncation_list, 'title_truncation_grid' => $title_truncation_grid,'description_truncation_grid'=>$description_truncation_grid,'industry_id'=>$value['industry_id'], 'sort' => $value['sort'],'user_id'=>$value['user_id'],'date'=>$value['date'], 'show_item_count'=>$show_item_count, 'socialshare_enable_listview1plusicon' => $socialshare_enable_listview1plusicon, 'socialshare_icon_listview1limit' => $socialshare_icon_listview1limit, 'socialshare_enable_gridview1plusicon' => $socialshare_enable_gridview1plusicon, 'socialshare_icon_gridview1limit' => $socialshare_icon_gridview1limit);

    $this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;
    $this->view->loadJs = true;

    // custom list grid view options
    $this->view->can_create = Engine_Api::_()->authorization()->isAllowed('sesjob_job', null, 'create');

    $this->view->category = $value['industry_id'];
    $this->view->text = $value['text']  = stripslashes($text);
    if (isset($value['sort']) && $value['sort'] != '') {
      $value['getParamSort'] = str_replace('SP', '_', $value['sort']);
    } else
      $value['getParamSort'] = 'creation_date';

		if (isset($value['getParamSort'])) {
			switch ($value['getParamSort']) {
// 				case 'most_viewed':
// 					$value['popularCol'] = 'view_count';
// 					break;
// 				case 'most_liked':
// 					$value['popularCol'] = 'like_count';
// 					break;
// 				case 'most_commented':
// 					$value['popularCol'] = 'comment_count';
// 					break;
// 				case 'most_favourite':
// 					$value['popularCol'] = 'favourite_count';
// 					break;
// 				case 'sponsored':
// 					$value['popularCol'] = 'sponsored';
// 					$value['fixedData'] = 'sponsored';
// 					break;
// 				case 'verified':
// 					$value['popularCol'] = 'verified';
// 					$value['fixedData'] = 'verified';
// 				break;
// 				case 'featured':
// 					$value['popularCol'] = 'featured';
// 					$value['fixedData'] = 'featured';
// 					break;
// 				case 'most_rated':
// 					$value['popularCol'] = 'rating';
// 					break;
				case 'recently_created':
					default:
					$value['popularCol'] = 'creation_date';
					break;
			}
		}
    $this->view->widgetName = 'browse-company';
    $params = array_merge($params, $value,array('search'=>addslashes($text)));

    $paginator = Engine_Api::_()->getDbtable('companies', 'sesjob')->getCompaniesPaginator($params);
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $limit_data = $this->view->{'limit_data_'.$view_type};
    $paginator->setItemCountPerPage($limit_data);
    $this->view->page = $page;
    $paginator->setCurrentPageNumber($page);
    unset($params['text']);
    $this->view->params = $params;
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    } else {
      // Do not render if nothing to show
      if ($paginator->getTotalItemCount() <= 0) {
        //silence
      }
    }
  }
}
