<?php

class Sesinviter_Widget_ManageSearchController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    // Make form
    $this->view->form = $form = new Sesinviter_Form_ManageSearch();

    // Process form
    $p = Zend_Controller_Front::getInstance()->getRequest()->getParams();
    $form->isValid($p);
    $values = $form->getValues();
    $this->view->formValues = array_filter($values);
    $this->view->assign($values);
  }
}
