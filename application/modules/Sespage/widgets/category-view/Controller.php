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
class Sespage_Widget_CategoryViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->widgetId = $widgetId = (isset($_POST['widget_id']) ? $_POST['widget_id'] : $this->view->identity);
    $this->view->params = $params = Engine_Api::_()->sespage()->getWidgetParams($widgetId);
    $limit_data = $params['page_limit'];

    $categoryId = (isset($_POST['category_id']) ? $_POST['category_id'] : 0);
    if ($categoryId) {
      $category = Engine_Api::_()->getItem('sespage_category', $categoryId);
      $this->view->category = $category;
    } else {
      $category = Engine_Api::_()->core()->getSubject('sespage_category');
      $this->view->category = $category;
      if (!$category) {
        return $this->setNoRender();
      }
    }

    $this->view->category_id = $category->category_id;

    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $show_subcatcriterias = $params['show_subcatcriteria'];
    foreach ($show_subcatcriterias as $show_subcatcriteria)
      $this->view->{$show_subcatcriteria . 'SubcatActive'} = $show_subcatcriteria;

    $innerCatData = array();
    if (!$is_ajax) {
      if ($category->subcat_id == 0 && $category->subsubcat_id == 0) {
        $innerCatData = Engine_Api::_()->getDbTable('categories', 'sespage')->getModuleSubcategory(array('category_id' => $category->category_id, 'column_name' => '*', 'countPages' => true, 'getcategory0' => true));
        $columnCategory = 'category_id';
      } else if ($category->subsubcat_id == 0) {
        $innerCatData = Engine_Api::_()->getDbTable('categories', 'sespage')->getModuleSubsubcategory(array('countPages' => true, 'category_id' => $category->category_id, 'column_name' => '*', 'countPages' => true, 'getcategory0' => true));
        $columnCategory = 'subcat_id';
      } else
        $columnCategory = 'subsubcat_id';
      $this->view->innerCatData = $innerCatData;
      //breadcum
      $this->view->breadcrumb = Engine_Api::_()->getDbTable('categories', 'sespage')->getBreadcrumb($category);
      $value['info'] = $params['info'];
      if ($params['show_popular_pages']) {
        $this->view->paginatorc = Engine_Api::_()->getDbTable('pages', 'sespage')
                ->getPagePaginator(array_merge($value, array('search' => 1, 'fetchAll' => true, 'limit' => 3, $columnCategory => $category->getIdentity())));
      }
    }

    $this->view->paginator = array();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('pages', 'sespage')->getPagePaginator(array($columnCategory => $category->category_id, 'getcategory0' => true), false);
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($page);
    $this->view->widgetName = 'category-view';
    // initialize type variable type
    $this->view->page = $page;

    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    } else {
      // Do not render if nothing to show
      if ($paginator->getTotalItemCount() <= 0) {
        
      }
    }
  }

}
