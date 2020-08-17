<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagereview_Widget_TabbedWidgetReviewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->identityForWidget = $this->view->identityObject = empty($_POST['identityObject']) ? $this->view->identity : $_POST['identityObject'];
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    $this->view->is_search = !empty($_POST['is_search']) ? true : false;
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;
    $this->view->loadJs = true;
    $this->view->optionsListGrid = array('tabbed' => true, 'paggindData' => true);
    $params = $this->_getAllParams();
    $params = array_merge($params, (array) $params['params']);
    unset($params["params"]);
    $this->view->params = $params;
    $this->view->gridlist = $params['gridlist'] ? $params['gridlist'] : 0;
    $this->view->socialshare_enable_plusicon = $params['socialshare_enable_plusicon'] ? $params['socialshare_enable_plusicon'] : null;
    $this->view->socialshare_icon_limit = $params['socialshare_icon_limit'] ? $params['socialshare_icon_limit'] : null;
    $this->view->width = isset($params['width']) ? $params['width'] : $this->_getParam('width', '100');
    $this->view->height = isset($params['height']) ? $params['height'] : $this->_getParam('height', '100');
    $this->view->tabOption = $params['tabOption'] ? $params['tabOption'] : 0;
    $this->view->title_truncation = $params['title_truncation'] ? $params['title_truncation'] : 15;
    $this->view->description_truncation = $params['description_truncation'] ? $params['description_truncation'] : 45;
    $this->view->show_limited_data = $show_limited_data = isset($params['show_limited_data']) ? $params['show_limited_data'] : $this->_getParam('show_limited_data', 'no');
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
          if ($defaultValue == 'recentlySPcreated')
            $valueLabel = 'Recently Created';
          else if ($defaultValue == 'mostSPviewed')
            $valueLabel = 'Most Viewed';
          else if ($defaultValue == 'mostSPliked')
            $valueLabel = 'Most Liked';
          else if ($defaultValue == 'mostSPcommented')
            $valueLabel = 'Most Commented';
          else if ($defaultValue == 'mostrated')
            $valueLabel = 'Most Voted';
          else if ($defaultValue == 'featured')
            $valueLabel = 'Featured';
          else if ($defaultValue == 'verified')
            $valueLabel = 'Verified';
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
      case 'recentlySPcreated':
        $params['info'] = 'creation_date';
        break;
      case 'mostSPviewed':
        $params['info'] = 'view_count';
        break;
      case 'mostSPliked':
        $params['info'] = 'like_count';
        break;
      case 'mostSPcommented':
        $params['info'] = 'comment_count';
        break;
      case 'mostrated':
        $params['info'] = 'most_rated';
        break;
      case 'featured':
        $params['info'] = 'featured';
        break;
      case 'verified':
        $params['info'] = 'verified';
        break;
    }
    $this->view->limit_data = $limit_data = isset($params['limit_data']) ? $params["limit_data"] : $this->_getParam('limit_data', '10');
    $this->view->optionsEnable = $optionsEnable = $params['enableTabs'];
    if (count($optionsEnable) > 1) {
      $this->view->bothViewEnable = true;
    }

    $show_criterias = $this->_getParam('show_criteria', array('featuredLabel', 'verifiedLabel'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $this->view->stats = isset($params['stats']) ? $params['stats'] : $this->_getParam('stats', array('featured', 'sponsored', 'likeCount', 'commentCount', 'viewCount', 'title', 'postedBy', 'pros', 'cons', 'description', 'creationDate', 'recommended', 'parameter', 'rating'));
    $this->view->widgetName = 'tabbed-widget-review';
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;
    $value = array();
    $select = Engine_Api::_()->getItemTable('pagereview')->getPageReviewSelect($params);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    //Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
