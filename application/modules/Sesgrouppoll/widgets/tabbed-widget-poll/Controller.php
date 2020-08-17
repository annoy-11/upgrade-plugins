<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgrouppoll_Widget_TabbedWidgetPollController extends Engine_Content_Widget_Abstract {
  public function indexAction(){
  $this->view->identityForWidget = $this->view->identityObject = empty($_POST['identityObject']) ? $this->view->identity : $_POST['identityObject'];
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    $this->view->is_search = !empty($_POST['is_search']) ? true : false;
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
	$this->view->group_id = $groupId = isset($_POST['group_id']) ? $_POST['group_id'] : $this->_getParam('group_id','');
    $this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;
    $this->view->loadJs = true;
    $this->view->optionsListGrid = array('tabbed' => true, 'paggindData' => true);
	$params = $this->_getAllParams();
	$params = array_merge($params,(array)$params['params']);
	unset($params["params"]);
    $this->view->params = $params ;
	$this->view->gridlist = $params['gridlist']?$params['gridlist']:0;
	$this->view->socialshare_enable_plusicon = $params['socialshare_enable_plusicon']?$params['socialshare_enable_plusicon']:null;
	$this->view->socialshare_icon_limit = $params['socialshare_icon_limit']?$params['socialshare_icon_limit']:null;
	$this->view->tabOption = $params['tabOption']?$params['tabOption']:0;
	$this->view->title_truncation = $title_truncation = $params['title_truncation']?$params['title_truncation']:15;
	
    //$this->view->load_content  = $page = $this->_getParam('pagging',1);
	$this->view->show_limited_data = $show_limited_data = isset($params['show_limited_data']) ? $params['show_limited_data'] :$this->_getParam('show_limited_data', 'no');
    //START WORK FOR TABS
    $defaultOpenTab = array();
    $defaultOptions = $arrayOptions = array();
    $defaultOptionsArray = $params['search_type'];
    $arrayOptn = array();
    if (!$is_ajax && is_array($defaultOptionsArray)) {
      foreach ($defaultOptionsArray as $key => $defaultValue) {
        if ($this->_getParam($defaultValue . '_order'))
          $order = $this->_getParam($defaultValue . '_order');
        else
          $order = (1000 + $key);
        $arrayOptn[$order] = $defaultValue;
        if ($this->_getParam($defaultValue . '_label'))
          $valueLabel = $this->_getParam($defaultValue . '_label');
        else {
          if ($defaultValue == 'open')
            $valueLabel = 'Open Polls';
          elseif ($defaultValue == 'close')
            $valueLabel = 'Closed Polls';
          elseif ($defaultValue == 'recentlySPcreated')
            $valueLabel = 'Recently Created';
          else if ($defaultValue == 'mostSPviewed')
            $valueLabel = 'Most Viewed';
          else if ($defaultValue == 'mostSPliked')
            $valueLabel = 'Most Liked';
          else if ($defaultValue == 'mostSPcommented')
            $valueLabel = 'Most Commented';
          else if ($defaultValue == 'mostSPfavourite')
            $valueLabel = 'Most Favourited';
					else if ($defaultValue == 'mostvoted')
            $valueLabel = 'Most Voted';
        }
        $arrayOptions[$order] = $valueLabel;
      }
      ksort($arrayOptions);
      $counter = 0;
      foreach ($arrayOptions as $key => $valueOption) {
        //$key = explode('||', $key);
        if ($counter == 0)
          $this->view->defaultOpenTab = $defaultOpenTab = $arrayOptn[$key];
        $defaultOptions[$arrayOptn[$key]] = $valueOption;
        $counter++;
      }
    }
    $this->view->defaultOptions = $defaultOptions;
    //END WORK OF TABS
    if (isset($_GET['openTab']) || $is_ajax) {
      $this->view->defaultOpenTab = $defaultOpenTab = (isset($_GET['openTab']) ? str_replace('_', 'SP', $_GET['openTab']) : ($this->_getParam('openTab') != NULL ? $this->_getParam('openTab') : (isset($params['openTab']) ? $params['openTab'] : '' )));
    }
    switch ($defaultOpenTab) {
      case 'open':
        $params['sort'] = 'open';
        break;
      case 'close':
        $params['sort'] = 'close';
        break;
      case 'recentlySPcreated':
        $params['sort'] = 'creation_date';
        break;
      case 'mostSPviewed':
        $params['sort'] = 'view_count';
        break;
      case 'mostSPliked':
        $params['sort'] = 'like_count';
        break;
      case 'mostSPcommented':
        $params['sort'] = 'comment_count';
        break;
      case 'mostSPfavourite':
        $params['sort'] = 'favourite_count';
        break;
			case 'mostvoted':
        $params['sort'] = 'vote_count';
        break;
    }
   // $this->view->view_type = $viewType = isset($_POST['type']) ? $_POST['type'] : (count($params['enableTabs']) > 1 ? $params['openViewType'] : $params['enableTabs'][0]);
   // $limit_data = $params["limit_data_$viewType"];
    $this->view->limit_data = $limit_data = isset($params['limit_data'])?$params["limit_data"]:$this->_getParam('limit_data', '10');
    $this->view->optionsEnable = $optionsEnable = $params['enableTabs'];
    if (count($optionsEnable) > 1) {
      $this->view->bothViewEnable = true;
    }
    //$show_criterias = $params['show_criteria'];
	$this->view->show_criteria = $show_criterias = isset($params['show_criteria']) ? $params['show_criteria'] : $this->_getParam('show_criteria', array('like','vote','description','in', 'comment','by','favourite','title', 'favouriteButton', 'likeButton', 'socialSharing', 'view'));
   // foreach ($show_criterias as $show_criteria)
     // $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->widgetName = 'tabbed-widget-poll';
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    //$this->view->page = $page;
    $value = array();
    //$params = array_merge($params, $value);

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('polls', 'sesgrouppoll')
            ->getPollsPaginator($params);	
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($page);
	$this->view->page = $page+1;
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
