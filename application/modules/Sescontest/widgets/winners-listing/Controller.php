<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescontest_Widget_WinnersListingController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $searchArray = array();
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->is_search = $is_search = !empty($_POST['is_search']) ? true : false;
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;
    $this->view->loadJs = true;

    $this->view->params = $params = Engine_Api::_()->sescontest()->getWidgetParams($widgetId);
    if (!empty($searchArray)) {
      foreach ($searchArray as $key => $search) {
        $params[$key] = $search;
      }
    }

    $this->view->view_type = $viewType = isset($_POST['type']) ? $_POST['type'] : (count($params['enableTabs']) > 1?$params['openViewType']:$params['enableTabs'][0]);
    $limit_data = $params["limit_data_$viewType"];
    $this->view->optionsEnable = $optionsEnable = $params['enableTabs'];
    if (count($optionsEnable) > 1) {
      $this->view->bothViewEnable = true;
    }
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $this->view->widgetName = 'winners-listing';
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;

    if (isset($params['search']))
      $params['contest_text'] = addslashes($params['search']);

    if (isset($params['search_entry']))
      $params['entry_text'] = addslashes($params['search_entry']);
    $params['winner'] = 1;
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('participants', 'sescontest')->getWinnerPaginator($params);
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
