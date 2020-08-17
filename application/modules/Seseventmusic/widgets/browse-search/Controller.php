<?php

class Seseventmusic_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $requestParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
    
    $searchOptionsType = $this->_getParam('searchOptionsType', array('searchBox', 'view', 'show')); 
    if(empty($searchOptionsType))
      return $this->setNoRender();

    $this->view->form = $formFilter = new Seseventmusic_Form_SearchAlbums();

    if ($formFilter->isValid($requestParams))
      $values = $formFilter->getValues();
    else
      $values = array();

    $this->view->formValues = array_filter($values);

    if (@$values['show'] == 2 && $viewer->getIdentity())
      $values['users'] = $viewer->membership()->getMembershipsOfIds();

    unset($values['show']);
  }

}
