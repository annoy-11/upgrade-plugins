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
class Sescontest_Widget_BrowseEntriesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $searchArray = array();
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->is_search = $is_search = !empty($_POST['is_search']) ? true : false;
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;
    $this->view->loadJs = true;

    $db = Engine_Db_Table::getDefaultAdapter();
    $params = $db->select()
            ->from('engine4_core_content', 'params')
            ->where('`content_id` = ?', $widgetId)
            ->query()
            ->fetchColumn();
    $this->view->params = $params = json_decode($params, true);
    if (!empty($searchArray)) {
      foreach ($searchArray as $key => $search) {
        $params[$key] = $search;
      }
    }
    $sescontest_browse = Zend_Registry::isRegistered('sescontest_browse') ? Zend_Registry::get('sescontest_browse') : null;
    if(empty($sescontest_browse)) {
      return $this->setNoRender();
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

    $this->view->widgetName = 'browse-entries';
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;

    if (isset($params['search']))
      $params['text'] = addslashes($params['search']);

    if (isset($params['search_entry']))
      $params['entry_text'] = addslashes($params['search_entry']);

    if (isset($_GET['contest_id']) && !empty($_GET['contest_id']))
      $params['contest_id'] = $_GET['contest_id'];

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('participants', 'sescontest')->getParticipantPaginator($params);
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
