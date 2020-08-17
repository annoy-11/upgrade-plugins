<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfaq_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->viewType = $this->_getParam('viewType', 'horizontal');
    $requestParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();

    $this->view->form = $formFilter = new Sesfaq_Form_Search();
    $sesfaq_browsesearch = Zend_Registry::isRegistered('sesfaq_browsesearch') ? Zend_Registry::get('sesfaq_browsesearch') : null;
    if(empty($sesfaq_browsesearch)) {
      return $this->setNoRender();
    }
    if ($formFilter->isValid($requestParams))
      $values = $formFilter->getValues();
    else
      $values = array();
    $this->view->formValues = array_filter($values);
  }

}
