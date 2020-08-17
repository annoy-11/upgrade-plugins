<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Widget_CategoryAssociateStoresController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->widgetName = 'category-associate-stores';
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->params = $params = Engine_Api::_()->estore()->getWidgetParams($widgetId);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $estore_estorewidget = Zend_Registry::isRegistered('estore_estorewidget') ? Zend_Registry::get('estore_estorewidget') : null;
    if (empty($estore_estorewidget)) {
      return $this->setNoRender();
    }
    $show_category_criterias = $params['show_category_criteria'];
    foreach ($show_category_criterias as $show_category_criteria)
      $this->view->{$show_category_criteria . 'Active'} = $show_category_criteria;

    $this->view->paginatorCategory = $paginatorCategory = Engine_Api::_()->getDbTable('categories', 'estore')->getCategory(array('hasStore' => true, 'criteria' => $params['criteria'], 'order' => $params['popularty'],'paginator' => 'yes'));

    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $paginatorCategory->setItemCountPerPage($params['category_limit']);
    $paginatorCategory->setCurrentPageNumber ($page);
    if ($paginatorCategory->getTotalItemCount() > 0) {
      foreach ($paginatorCategory as $key => $valuePaginator) {
        $countArray[] = $valuePaginator->total_store_categories;
        $pageData['store_data'][$valuePaginator->category_id] = Engine_Api::_()->getDbTable('stores', 'estore')->getStoreSelect(array('category_id' => $valuePaginator->category_id, 'limit' => $params['store_limit'], 'order' => $params['popularty'], 'info' => $params['order'], 'fetchAll' => true));
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
