<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_CategoryViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
 
    // Default option for tabbed widget
    if (isset($_POST['params']))
      $params = ($_POST['params']);
      
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    $this->view->loadOptionData = $loadOptionData = isset($params['pagging']) ? $params['pagging'] : $this->_getParam('pagging', 'auto_load');
    $this->view->limit_data = $limit_data = isset($params['crowdfunding_limit']) ? $params['crowdfunding_limit'] : $this->_getParam('crowdfunding_limit', '10');
    $this->view->limit = ($page - 1) * $limit_data;
    $this->view->description_truncation = $descriptionLimit = isset($params['description_truncation']) ? $params['description_truncation'] : $this->_getParam('description_truncation', '150');
    $this->view->viewType = isset($params['viewType']) ? $params['viewType'] : $this->_getParam('viewType', 'list');
    $categoryId = isset($params['category_id']) ? $params['category_id'] : '';
    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'rating', 'ratingStar', 'by', 'title', 'featuredLabel', 'sponsoredLabel','favourite','description','creationDate', 'readmore'));
    
		if(is_array($show_criterias)){
			foreach ($show_criterias as $show_criteria)
				$this->view->{$show_criteria . 'Active'} = $show_criteria;
		}
		
    $this->view->width = $width = isset($params['width']) ? $params['width'] : $this->_getParam('width', '250px');
    $this->view->height = $height = isset($params['height']) ? $params['height'] : $this->_getParam('height', '160px');
    $params = array('viewType' => $this->view->viewType,'crowdfunding_limit' => $limit_data, 'description_truncation' => $descriptionLimit, 'pagging' => $loadOptionData, 'show_criterias' => $show_criterias,'category_id' => $categoryId, 'width' => $width, 'height' => $height);
    if (Engine_Api::_()->core()->hasSubject()) {
      $this->view->category = $category = Engine_Api::_()->core()->getSubject();
      $category_id = $category->category_id;
    } else {
      $this->view->category = $category = Engine_Api::_()->getItem('sescrowdfunding_category', $params['category_id']);
      $category_id = $params['category_id'];
    }

    $columnCategory = 'category_id';
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->getSescrowdfundingsPaginator(array($columnCategory => $category->category_id, 'status' => 1));
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber($page);
    $this->view->widgetName = 'category-view';
    $this->view->page = $page;
    $params = array_merge($params, array('category_id' => $category_id));
    $this->view->params = $params;
    if ($is_ajax)
      $this->getElement()->removeDecorator('Container');
  }
}