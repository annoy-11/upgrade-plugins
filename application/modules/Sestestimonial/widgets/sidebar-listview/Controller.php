<?php

class Sestestimonial_Widget_SidebarListViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->all_params = $all_params = $this->_getAllParams();

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('testimonials', 'sestestimonial')->getTestimonials($all_params);
    $paginator->setItemCountPerPage($all_params['limit']);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $paginator->getTotalItemCount();
  }
}
