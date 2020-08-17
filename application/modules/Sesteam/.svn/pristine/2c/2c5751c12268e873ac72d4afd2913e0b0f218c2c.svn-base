<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Widget_SearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewType = $this->_getParam('viewType', 'horizontal');
    $this->view->sesteamType = $this->_getParam('sesteamType', 'teammember');

    $requestParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();

    //Get browse params
    $this->view->form = $formFilter = new Sesteam_Form_Search();

    if ($formFilter->isValid($requestParams))
      $values = $formFilter->getValues();
    else
      $values = array();
      if(!empty($_POST['sesteam_title']))
          $formFilter->sesteam_title->setValue($_POST['sesteam_title']);
    $this->view->formValues = array_filter($values);
  }

}