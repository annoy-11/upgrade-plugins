<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Widget_ProfilePagesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $getParams = '';
    $searchArray = array();
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);
    else {
      $getParams = !empty($_POST['getParams']) ? $_POST['getParams'] : $_SERVER['QUERY_STRING'];
      parse_str($getParams, $get_array);
    }
    $this->view->getParams = $getParams;
    $this->view->view_more = isset($_POST['view_more']) ? true : false;
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->is_search = $is_search = !empty($_POST['is_search']) ? true : false;
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->loadMoreLink = $this->_getParam('openTab') != NULL ? true : false;
    $this->view->params = $params = Engine_Api::_()->sespage()->getWidgetParams($widgetId);

    if (empty($_POST['is_ajax'])) {
      //Don't render this if not authorized
      $viewer = Engine_Api::_()->user()->getViewer();
      if (!Engine_Api::_()->core()->hasSubject()) {
        return $this->setNoRender();
      }
      //Get subject and check auth
      $subject = Engine_Api::_()->core()->getSubject();
      if (!$subject->authorization()->isAllowed($viewer, 'view')) {
        return $this->setNoRender();
      }
      $userId = $subject->user_id;
    } else
      $userId = $_POST['identityObject'];
    $this->view->identityObject = $userId;
   
    if (isset($get_array)) {
      foreach ($get_array as $key => $getvalue) {
        $params[$key] = $getvalue;
      }
      if (isset($params['tag_id']))
        $params['tag'] = Engine_Api::_()->getItem('core_tag', $params['tag_id'])->text;
    }
    if (!empty($searchArray)) {
      foreach ($searchArray as $key => $search) {
        $params[$key] = $search;
      }
    }
    $sespage_sespagewidget = Zend_Registry::isRegistered('sespage_sespagewidget') ? Zend_Registry::get('sespage_sespagewidget') : null;
    if (empty($sespage_sespagewidget)) {
      return $this->setNoRender();
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

    $this->view->widgetName = 'profile-pages';
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;
    $value = array();
    $value['status'] = 1;
    $value['search'] = 1;
    $value['draft'] = "1";
    $value['user_id'] = $userId;
    if (isset($params['search']))
      $params['text'] = addslashes($params['search']);
    $params['tag'] = isset($_GET['tag_id']) ? $_GET['tag_id'] : '';
    $params = array_merge($params, $value);
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('pages', 'sespage')
            ->getPagePaginator($params);
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($page);
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
