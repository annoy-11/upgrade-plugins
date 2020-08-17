<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Form_Search extends Engine_Form {

  public function init() {
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'));
      //->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    $this->setAction($view->url(array('module' => 'sesforum', 'controller' => 'index', 'action' => 'search'), 'sesforum_search', true));
    parent::init();

    $this->addElement('Text', 'query', array(
      'label' => 'Topic Name:',
			'placeholder' => 'Search'
    ));

    $this->addElement('Select', 'search_type', array(
        'label' => 'Browse By:',
        'multiOptions' => array("topics" =>"Forum Topics","posts"=>"Forum Posts"),
    ));


    $this->addElement('Button', 'submit', array(
      'label' => 'Search',
      'type' => 'submit'
    ));
  }
}
