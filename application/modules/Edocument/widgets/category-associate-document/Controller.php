<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Edocument_Widget_CategoryAssociateDocumentController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $params = array();
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'], true);
    $this->view->loadOptionData = $loadOptionData = isset($params['loadOptionData']) ? $params['loadOptionData'] : $this->_getParam('pagging', 'auto_load');
    $this->view->category_limit = $category_limit = isset($params['category_limit']) ? $params['category_limit'] : $this->_getParam('category_limit', '10');
    $this->view->document_description_truncation = $document_description_truncation = isset($params['document_description_truncation']) ? $params['document_description_truncation'] : $this->_getParam('document_description_truncation', '300');
    $this->view->document_limit = $document_limit = isset($params['document_limit']) ? $params['document_limit'] : $this->_getParam('document_limit', '8');
    $this->view->count_document = $count_document = isset($params['count_document']) ? $params['count_document'] : $this->_getParam('count_document', '1');
    $this->view->width = $width = isset($params['width']) ? $params['width'] : $this->_getParam('width', '250px');
    $this->view->height = $height = isset($params['height']) ? $params['height'] : $this->_getParam('height', '160px');
    $this->view->seemore_text = $seemore_text = isset($params['seemore_text']) ? $params['seemore_text'] : $this->_getParam('seemore_text', '+ See all [category_name]');
    $this->view->allignment_seeall = $allignment_seeall = isset($params['allignment_seeall']) ? $params['allignment_seeall'] : $this->_getParam('allignment_seeall', 'left');
    $this->view->identityForWidget = $identityForWidget = isset($_POST['identity']) ? $_POST['identity'] : '';
    $this->view->popularity_document = $popularity_document = isset($params['popularity_document']) ? $params['popularity_document'] : $this->_getParam('popularity_document', 'like_count');
    $criteriaData = isset($params['criteria']) ? $params['criteria'] : $this->_getParam('criteria', 'alphabetical');
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->widgetName = 'category-associate-document';
    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'view', 'rating', 'ratingStar', 'by', 'title', 'featuredLabel', 'sponsoredLabel', 'favourite', 'creationDate', 'readmore'));
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    if ($popularity_document == 'featured' || $popularity_document == 'sponsored') {
      $fixedData = $popularity_document;
      $popularCol = '';
    } else {
      $fixedData = '';
      $popularCol = $popularity_document;
    }
    // initialize type variable type
    $this->view->params = $params = array('loadOptionData' => $loadOptionData, 'category_limit' => $category_limit, 'document_limit' => $document_limit,'document_description_truncation' => $document_description_truncation, 'count_document' => $count_document, 'seemore_text' => $seemore_text, 'allignment_seeall' => $allignment_seeall, 'show_criterias' => $show_criterias, 'height' => $height, 'width' => $width, 'criteria' => $criteriaData, 'popularity_document' => $popularity_document);
    $documentData = $countArray = array();
    $this->view->paginatorCategory = $paginatorCategory = Engine_Api::_()->getDbTable('categories', 'edocument')->getCategory(array('hasDocument' => true, 'criteria' => $criteriaData, 'documentDesc' => 'desc'), array('paginator' => 'yes'));
    $paginatorCategory->setItemCountPerPage($category_limit);
    $paginatorCategory->setCurrentPageNumber($page);
    if ($paginatorCategory->getTotalItemCount() > 0) {
      foreach ($paginatorCategory as $key => $valuePaginator) {
        $countArray[] = $valuePaginator->total_documents_categories;
        $documentData['document_data'][$valuePaginator->category_id] = Engine_Api::_()->getDbTable('edocuments', 'edocument')->getEdocumentsPaginator(array('category_id' => $valuePaginator->category_id, 'status' => 1, 'limit' => $document_limit, 'popularCol' => $popularCol, 'fixedData' => $fixedData, 'fetchAll' => 0), false);
      }
    } else {
      if (!$is_ajax)
        return $this->setNoRender();
    }
    $this->view->countArray = $countArray;
    $this->view->resultArray = $documentData;
    // Set item count per page and current page number
    $this->view->page = $page;
    $this->view->paginatorCategory = $paginatorCategory;
    if ($is_ajax) {
      $this->getElement()->removeDecorator('Container');
    }
  }
}
