<?php

class Sesdocument_Widget_DocumentCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '200');
    $this->view->alignContent = $this->_getParam('alignContent', 'center');
    $this->view->order = $order = isset($params['order']) ? $params['order'] : $this->_getParam('order', '');   
    $params['criteria'] = $this->_getParam('criteria', '');
     
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countDocuments', 'icon'));
    
    if (in_array('countDocuments', $show_criterias) || $params['criteria'] == 'most_document')
      $params['countDocuments'] = true;

    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
    
    $params['order'] = $order;
   
    // Get events category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sesdocument')->getCategory($params);

    if (count($paginator) == 0)
      return;
  }

}
