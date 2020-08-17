<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php 2015-03-10 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Form_Search extends Engine_Form {

  public function init() {

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $front = Zend_Controller_Front::getInstance();
    $module = $front->getRequest()->getModuleName();
    $controller = $front->getRequest()->getControllerName();
    $action = $front->getRequest()->getActionName();

    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');

    if ($module == 'sesteam' && $controller == 'index' && ($action == 'nonsiteteam' || $action == 'browsenonsiteteam')) {
      $this->setAction($view->url(array('module' => 'sesteam', 'controller' => 'index', 'action' => 'browsenonsiteteam'), 'sesteam_teampage', true));
    } else {
      $this->setAction($view->url(array('module' => 'sesteam', 'controller' => 'index', 'action' => 'browse'), 'sesteam_teampage', true));
    }
    parent::init();

    $this->addElement('Text', 'sesteam_title', array(
        'label' => 'Name',
        'placeholder' => 'Search Name',
    ));

    $designations = Engine_Api::_()->getDbtable('designations', 'sesteam')->getDesignations();
    if (count($designations) > 1) {
      $this->addElement('Select', 'designation_id', array(
          'label' => 'Designation',
          'multiOptions' => $designations,
      ));
    }

    $this->addElement('Button', 'execute', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
  }

}