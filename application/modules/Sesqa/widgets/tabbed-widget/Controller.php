<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_Widget_TabbedWidgetController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    // Default option
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'],true);
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax',false);    
    
    $this->view->viewType = $value['viewType'] = isset($params['viewType']) ? $params['viewType'] : $this->_getParam('viewType','list1');
    $this->view->title = isset($params['title']) ? $params['title'] : $this->_getParam('title','');
    $this->view->showOptions = $showOptions = $defaultOptionsArray = $value['showOptions'] = isset($params['showOptions']) ? $params['showOptions'] : $this->_getParam('show_criteria',array('like','favourite','tags','vote','answer','view','recentactivity','likeBtn','favBtn','share'));
    if(!$showOptions)
        $this->view->showOptions = $showOptions = $defaultOptionsArray = $value['showOptions'] = array();
    
    $defaultOptionsArray = $this->_getParam('search_type',array('recentlySPcreated','mostSPviewed','mostSPliked','mostSPcommented','mostSPvoted','mostSPfavourite','homostSPanswered','unanswered','featured','sponsored','hot'));
		
    if (!$is_ajax && is_array($defaultOptionsArray)) {
			$this->view->tab_option = $this->_getParam('showTabType','advance');
      $defaultOptions = $arrayOptions = array();
      foreach ($defaultOptionsArray as $key => $defaultValue) {
        if ($this->_getParam($defaultValue . '_order'))
          $order = $this->_getParam($defaultValue . '_order') ;
        else
          $order = (777 + $key);
        if ($this->_getParam($defaultValue . '_label'))
          $valueLabel = $this->_getParam($defaultValue . '_label'). '||' . $defaultValue;
        else {
          if($defaultValue == "unanswered")
             $valueLabel = 'Unanswered'. '||' . $defaultValue;
          else if($defaultValue == "featured")
             $valueLabel = 'Featured'. '||' . $defaultValue;
           else if($defaultValue == "verified")
             $valueLabel = 'Verified'. '||' . $defaultValue;
          else if($defaultValue == "sponsored")
             $valueLabel = 'Sponsored'. '||' . $defaultValue;
          else if($defaultValue == "hot")
             $valueLabel = 'Hot'. '||' . $defaultValue;
					else if ($defaultValue == 'recentlySPcreated')
            $valueLabel = 'Recently Created'. '||' . $defaultValue;
					else if ($defaultValue == 'mostSPviewed')
            $valueLabel = 'Most Viewed'. '||' . $defaultValue;
					else if ($defaultValue == 'mostSPliked')
            $valueLabel = 'Most Liked'. '||' . $defaultValue;
					else if ($defaultValue == 'mostSPcommented')
            $valueLabel = 'Most Commented'. '||' . $defaultValue;
					else if ($defaultValue == 'mostSPvoted')
            $valueLabel = 'Most Voted'. '||' . $defaultValue;
					else if ($defaultValue == 'mostSPfavourite')
            $valueLabel = 'Most Favourite'. '||' . $defaultValue;
					else if ($defaultValue == 'homostSPanswered')
            $valueLabel = 'Most Answered'. '||' . $defaultValue;
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
      $this->view->defaultOptions = $defaultOptions;
    }
		
    if (isset($_GET['openTab']) || $is_ajax) {
      $this->view->defaultOpenTab = $defaultOpenTab = isset($searchArray['order']) ? $searchArray['order'] : ($this->_getParam('defaultOpenTab',false) ? $this->_getParam('defaultOpenTab') : (isset($params['order']) ? $params['order'] : ''));
    }
		    
    $this->view->loadOptionData = $value['pagging'] = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'pagging');
    $this->view->titleTruncateLimit = $value['title_truncate'] = isset($params['title_truncate']) ? $params['title_truncate'] : $this->_getParam('title_truncate',200);
    $this->view->widgetIdentity = $this->_getParam('widgetIdentity', $this->view->identity);
    $this->view->show_limited_data = $this->_getParam('show_limited_data',false);
    //search data
    if(empty($searchArray))
    $value['tag_id'] =  isset($searchArray['tag_id']) ? $searchArray['tag_id'] : (isset($_GET['tag_id']) ? $_GET['tag_id'] : (isset($params['tag_id']) ? $params['tag_id'] : $this->_getParam('tag_id','')));
    $this->view->height = $value['height'] =  isset($searchArray['height']) ? $searchArray['height'] : (isset($_GET['height']) ? $_GET['height'] : (isset($params['height']) ? $params['height'] : $this->_getParam('height','')));
    $this->view->width = $value['width'] =  isset($searchArray['width']) ? $searchArray['width'] : (isset($_GET['width']) ? $_GET['width'] : (isset($params['width']) ? $params['width'] : $this->_getParam('width','')));
    
    $value['locationEnable'] =  isset($searchArray['locationEnable']) ? $searchArray['locationEnable'] : (isset($_GET['locationEnable']) ? $_GET['locationEnable'] : (isset($params['locationEnable']) ? $params['locationEnable'] : $this->_getParam('locationEnable','0')));
    $value['category_id'] =  isset($searchArray['category_id']) ? $searchArray['category_id'] : (isset($_GET['category_id']) ? $_GET['category_id'] : (isset($params['category_id']) ? $params['category_id'] : $this->_getParam('category_id','')));
    $value['sort'] = isset($searchArray['sort']) ? $searchArray['sort'] : (isset($_GET['sort']) ? $_GET['sort'] : (isset($params['sort']) ? $params['sort'] : $this->_getParam('sort', 'mostSPliked')));
    $value['subcat_id'] = isset($searchArray['subcat_id']) ? $searchArray['subcat_id'] :  (isset($_GET['subcat_id']) ? $_GET['subcat_id'] : (isset($params['subcat_id']) ? $params['subcat_id'] : ''));
    $value['subsubcat_id'] = isset($searchArray['subsubcat_id']) ? $searchArray['subsubcat_id'] : (isset($_GET['subsubcat_id']) ? $_GET['subsubcat_id'] : (isset($params['subsubcat_id']) ? $params['subsubcat_id'] : ''));    
    $value['location'] = isset($searchArray['location']) ? $searchArray['location'] :  (isset($_GET['location']) ? $_GET['location'] : (isset($params['location']) ?  $params['location'] : ''));
		$value['lat'] = isset($searchArray['lat']) ? $searchArray['lat'] :  (isset($_GET['lat']) ? $_GET['lat'] : (isset($params['lat']) ?  $params['lat'] : ''));
		$value['show'] = isset($searchArray['show']) ? $searchArray['show'] :  (isset($_GET['show']) ? $_GET['show'] : (isset($params['show']) ?  $params['show'] : ''));
		$value['lng'] = isset($searchArray['lng']) ? $searchArray['lng'] :  (isset($_GET['lng']) ? $_GET['lng'] : (isset($params['lng']) ?  $params['lng'] : ''));
		$value['miles'] = isset($searchArray['miles']) ? $searchArray['miles'] :  (isset($_GET['miles']) ? $_GET['miles'] : (isset($params['miles']) ?  $params['miles'] : ''));
		$value['user_id'] = isset($_GET['user_id']) ? $_GET['user_id'] : (isset($params['user_id']) ?  $params['user_id'] : '');
		
		$value['country'] = isset($searchArray['country']) ? $searchArray['country'] :  (isset($_GET['country']) ? $_GET['country'] : (isset($params['country']) ?  $params['country'] : ''));
		$value['state'] = isset($searchArray['state']) ? $searchArray['state'] :  (isset($_GET['state']) ? $_GET['state'] : (isset($params['state']) ?  $params['state'] : ''));
		$value['city'] = isset($searchArray['city']) ? $searchArray['city'] :  (isset($_GET['city']) ? $_GET['city'] : (isset($params['city']) ?  $params['city'] : ''));
		$value['zip'] = isset($searchArray['zip']) ? $searchArray['zip'] :  (isset($_GET['zip']) ? $_GET['zip'] : (isset($params['zip']) ?  $params['zip'] : ''));
		
    $value['searchText'] = isset($_GET['searchText']) ? $_GET['searchText'] : (isset($searchArray['searchText']) ?  $searchArray['searchText'] :  ( !empty($_GET['title_name']) ? $_GET['title_name'] : "" ) );
    if (isset($_GET['alphabet']))
      $value['alphabet'] = isset($searchArray['alphabet']) ? $searchArray['alphabet'] :  (isset($_GET['alphabet']) ? $_GET['alphabet'] : (isset($params['alphabet']) ?  $params['alphabet'] : ''));
    if (isset($_GET['starttime']) && !empty($_GET['starttime']))
      $value['starttime'] = isset($searchArray['starttime']) ? $searchArray['starttime'] :  (isset($_GET['starttime']) ? $_GET['starttime'] : (isset($params['starttime']) ?  $params['starttime'] : ''));
    if (isset($_GET['endtime']) && !empty($_GET['endtime']))
      $value['endtime'] = isset($searchArray['endtime']) ? $searchArray['endtime'] :  (isset($_GET['endtime']) ? $_GET['endtime'] : (isset($params['endtime']) ?  $params['endtime'] : ''));

    if (isset($_GET['show']) && !empty($_GET['show']))
      $value['show'] = isset($searchArray['show']) ? $searchArray['show'] :  (isset($_GET['show']) ? $_GET['show'] : (isset($params['show']) ?  $params['show'] : ''));
    
     $this->view->socialshare_enable_plusicon = $value['socialshare_enable_plusicon'] = isset($params['socialshare_enable_plusicon']) ? $params['socialshare_enable_plusicon'] : $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $value['socialshare_icon_limit'] = isset($params['socialshare_icon_limit']) ? $params['socialshare_icon_limit'] : $this->_getParam('socialshare_icon_limit', 2);
    
    if (isset($defaultOpenTab) && $defaultOpenTab != '') {
      $value['getParamSort'] = str_replace('SP', '_', $defaultOpenTab);
    } else
      $value['getParamSort'] = 'creation_date';
    
    if (isset($value['getParamSort'])) {
      switch ($value['getParamSort']) {
        case 'most_viewed':
          $value['popularCol'] = 'view_count';
          break;
        case 'most_liked':
          $value['popularCol'] = 'like_count';
          break;
        case 'most_commented':
          $value['popularCol'] = 'comment_count';
          break;
        case 'most_favourite':
          $value['popularCol'] = 'favourite_count';
          break;
        case 'homost_answered':
          $value['popularCol'] = 'answer_count';
          break;
        case 'most_voted':
          $value['popularCol'] = 'vote_count';
          break;
        case 'unanswered':
          $value['popularCol'] = "unanswered";
        break;
        case 'featured':
          $value['fixedColumn'] = "featured";
        break;
        case 'sponsored':
          $value['fixedColumn'] = "sponsored";
        break;
        case 'verified':
          $value['fixedColumn'] = "verified";
        break;
        case 'hot':
          $value['fixedColumn'] = "hot";
        break;
        case 'new':
          $value['fixedColumn'] = "new";
        break;
        case 'recently_created':
        default:
          $value['popularCol'] = 'creation_date';
          break;
      }
    }
    
    $this->view->canCreate =  Engine_Api::_()->authorization()->isAllowed('sesqa_question', null, 'create');
    $this->view->widgetName = 'tabbed-widget';
    $value['search'] = 1;
    $value['draft'] = 1;
    $this->view->params = $value;
    $page = $this->view->page = $this->_getParam('page', 1);
    $paginator = $this->view->paginator = Engine_Api::_()->getDbTable('questions','sesqa')->getQuestionPaginator($value);
    $limit = isset($params['limit']) ? $params['limit'] : $this->_getParam('limit', '10');
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit);
    $paginator->setCurrentPageNumber($page);
    if($is_ajax){
      $this->getElement()->removeDecorator('Container');
    }
  }
}
