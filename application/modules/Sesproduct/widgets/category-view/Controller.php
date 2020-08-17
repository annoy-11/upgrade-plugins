<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Widget_CategoryViewController extends Engine_Content_Widget_Abstract {
  public function indexAction() {

    // Default option for tabbed widget
    if (isset($_POST['params']))
      $params = ($_POST['params']);
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
    $this->view->limit_data = $limit_data = isset($params['product_limit']) ? $params['product_limit'] : $this->_getParam('product_limit', '10');
    $this->view->limit = ($page - 1) * $limit_data;
    $this->view->description_truncation_list = $this->view->description_truncation_grid = $this->view->description_truncation = $descriptionLimit = isset($params['description_truncation']) ? $params['description_truncation'] : $this->_getParam('description_truncation', '150');

    $this->view->title_truncation_list = $this->view->title_truncation_grid = $this->view->title_truncation = $titleLimit = isset($params['title_truncation']) ? $params['title_truncation'] : $this->_getParam('title_truncation', '150');

    $this->view->viewType = $viewType = isset($params['viewType']) ? $params['viewType'] : $this->_getParam('viewType', 'list');
    if($viewType == 'list'){
        $this->view->width_list = $this->_getParam('width',350);
        $this->view->height = $this->_getParam('height',200);
    }else {
        $this->view->width_grid = $this->_getParam('width',350);
        $this->view->height_grid = $this->_getParam('height',200);
    }

    $categoryId = isset($params['category_id']) ? $params['category_id'] : '';
    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'rating', 'ratingStar', 'by', 'title', 'featuredLabel', 'sponsoredLabel','favourite','description','creationDate', 'readmore'));
    $this->view->show_subcat = $show_subcat = isset($params['show_subcat']) ? $params['show_subcat'] : $this->_getParam('show_subcat', '1');
		if(is_array($show_criterias)){
			foreach ($show_criterias as $show_criteria)
				$this->view->{$show_criteria . 'Active'} = $show_criteria;
		}
    $show_subcatcriterias = isset($params['show_subcatcriteria']) ? $params['show_subcatcriteria'] : $this->_getParam('show_subcatcriteria', array('countProduct', 'icon', 'title'));
		if(is_array($show_subcatcriterias)){
			foreach ($show_subcatcriterias as $show_subcatcriteria)
				$this->view->{$show_subcatcriteria . 'SubcatActive'} = $show_subcatcriteria;
		}
    $this->view->widthSubcat = $widthSubcat = isset($params['widthSubcat']) ? $params['widthSubcat'] : $this->_getParam('widthSubcat', '250px');
    $this->view->heightSubcat = $heightSubcat = isset($params['heightSubcat']) ? $params['heightSubcat'] : $this->_getParam('heightSubcat', '160px');
    $this->view->width = $width = isset($params['width']) ? $params['width'] : $this->_getParam('width', '250px');
    $this->view->height = $height = isset($params['height']) ? $params['height'] : $this->_getParam('height', '160px');
		$this->view->textProduct = $textProduct = isset($params['textProduct']) ? $params['textProduct'] : $this->_getParam('textProduct', 'Products we love');
    $params = array('viewType' => $this->view->viewType,'product_limit' => $limit_data, 'description_truncation' => $descriptionLimit,'title_truncation'=>$titleLimit, 'pagging' => $loadOptionData, 'show_criterias' => $show_criterias,'category_id' => $categoryId, 'width' => $width, 'height' => $height, 'show_subcat' => $show_subcat, 'show_subcatcriteria' => $show_subcatcriterias, 'widthSubcat' => $widthSubcat, 'heightSubcat', $heightSubcat,'textProduct'=>$textProduct);
    if (Engine_Api::_()->core()->hasSubject()) {
      $this->view->category = $category = Engine_Api::_()->core()->getSubject();
      $category_id = $category->category_id;
    } else {
      $this->view->category = $category = Engine_Api::_()->getItem('sesproduct_category', $params['category_id']);
      $category_id = $params['category_id'];
    }
    $innerCatData = array();
    $columnCategory = 'category_id';
    if (!$is_ajax) {
      if ($category->subcat_id == 0 && $category->subsubcat_id == 0) {
        if($category->category_id)
        $innerCatData = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getModuleSubcategory(array('category_id' => $category->category_id, 'column_name' => '*', 'countProducts' => true));
        $columnCategory = 'category_id';
      } else if ($category->subsubcat_id == 0) {
        $innerCatData = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getModuleSubsubcategory(array('countProducts' => true, 'category_id' => $category->category_id, 'column_name' => '*'));
        $columnCategory = 'subcat_id';
      } else
        $columnCategory = 'subsubcat_id';
      $this->view->innerCatData = $innerCatData;
      //breadcum
      $this->view->breadcrumb = $breadcrumb = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getBreadcrumb($category);
    }
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getSesproductsPaginator(array($columnCategory => $category->category_id, 'status' => 1));
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($page);
    $this->view->widgetName = 'category-view';
    // initialize type variable type
    $this->view->page = $page;
    $params = array_merge($params, array('category_id' => $category_id));
    $this->view->params = $params;
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    } else {
      // Do not render if nothing to show
      if ($paginator->getTotalItemCount() <= 0) {

      }
    }
  }

}
