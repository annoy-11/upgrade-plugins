<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessoffer_Widget_TabbedWidgetOfferController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    $this->view->is_search = !empty($_POST['is_search']) ? true : false;
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;
    $this->view->loadJs = true;
    $this->view->optionsListGrid = array('tabbed' => true, 'paggindData' => true);
    $this->view->can_create = Engine_Api::_()->authorization()->isAllowed('businesses', null, 'create');
    $this->view->params = $params = Engine_Api::_()->sesbusiness()->getWidgetParams($widgetId);
    $sesbusinessoffer_widget = Zend_Registry::isRegistered('sesbusinessoffer_widget') ? Zend_Registry::get('sesbusinessoffer_widget') : null;
    if(empty($sesbusinessoffer_widget))
      return $this->setNoRender();
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
        else if ($defaultValue == 'mostSPfavourite')
            $valueLabel = 'Most Favourite';
        else if ($defaultValue == 'mostSPfollowed')
            $valueLabel = 'Most Followed';
          else if ($defaultValue == 'new')
            $valueLabel = 'New';
          else if ($defaultValue == 'featured')
            $valueLabel = 'Featured';
          else if ($defaultValue == 'hot')
            $valueLabel = 'Hot';
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
        $params['order'] = 'creation_date';
        break;
      case 'mostSPviewed':
        $params['order'] = 'view_count';
        break;
      case 'mostSPliked':
        $params['order'] = 'like_count';
        break;
      case 'mostSPcommented':
        $params['order'] = 'comment_count';
        break;
      case 'mostSPfavourite':
        $params['order'] = 'favourite_count';
        break;
      case 'mostSPfollowed':
        $params['order'] = 'follow_count';
        break;
      case 'hot':
        $params['order'] = 'hot';
        break;
      case 'featured':
        $params['order'] = 'featured';
        break;
      case 'new':
        $params['order'] = 'new';
        break;
    }
    $this->view->view_type = $viewType = isset($_POST['type']) ? $_POST['type'] : (count($params['enableTabs']) > 1 ? $params['openViewType'] : $params['enableTabs'][0]);
    $limit_data = $params["limit_data_$viewType"];
    $this->view->optionsEnable = $optionsEnable = $params['enableTabs'];
    if (count($optionsEnable) > 1) {
      $this->view->bothViewEnable = true;
    }

    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $this->view->widgetName = 'tabbed-widget-offer';
    $business = isset($_POST['business']) ? $_POST['business'] : 1;
    $this->view->business = $business;
    $value = array();
    $params = array_merge($params, $value);

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('businessoffers', 'sesbusinessoffer')
            ->getOffersPaginator($params);
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($business);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }
}
