<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Widget_CategoryAssociateBusinessesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->widgetName = 'category-associate-businesses';
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->params = $params = Engine_Api::_()->sesbusiness()->getWidgetParams($widgetId);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $sesbusiness_sesbusinesswidget = Zend_Registry::isRegistered('sesbusiness_sesbusinesswidget') ? Zend_Registry::get('sesbusiness_sesbusinesswidget') : null;
    if (empty($sesbusiness_sesbusinesswidget)) {
      return $this->setNoRender();
    }
    $show_category_criterias = $params['show_category_criteria'];
    foreach ($show_category_criterias as $show_category_criteria)
      $this->view->{$show_category_criteria . 'Active'} = $show_category_criteria;

    $this->view->paginatorCategory = $paginatorCategory = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getCategory(array('hasBusiness' => true, 'criteria' => $params['criteria'], 'order' => $params['popularty'],'paginator' => 'yes'));

    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $paginatorCategory->setItemCountPerPage($params['category_limit']);
    $paginatorCategory->setCurrentPageNumber ($page);
    if ($paginatorCategory->getTotalItemCount() > 0) {
      foreach ($paginatorCategory as $key => $valuePaginator) {
        $countArray[] = $valuePaginator->total_business_categories;
        $pageData['business_data'][$valuePaginator->category_id] = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getBusinessSelect(array('category_id' => $valuePaginator->category_id, 'limit' => $params['business_limit'], 'order' => $params['popularty'], 'info' => $params['order'], 'fetchAll' => true));
      }
    } else {
      if (!$is_ajax)
        return $this->setNoRender();
    }
    $this->view->countArray = $countArray;
    $this->view->resultArray = $pageData;

    // Set item count per page and current page number
    $this->view->page = $page;
    $this->view->paginatorCategory = $paginatorCategory;
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }

}
