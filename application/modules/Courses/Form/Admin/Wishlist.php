<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Wishlist.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Form_Admin_Wishlist extends Engine_Form {

  public function init() {
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');
    $this->addElement('Text', 'name', array(
        'label' => 'Wishlist Title',
        'placeholder' => 'Enter Wishlist Title',
    ));
    $this->addElement('Text', 'owner_name', array(
        'label' => 'Owner Name',
        'placeholder' => 'Enter Owner Name',
    ));
    //date
    $subform = new Engine_Form(array(
        'description' => 'Creation Date Ex (yyyy-mm-dd)',
        'elementsBelongTo'=> 'date',
        'decorators' => array(
            'FormElements',
            array('Description', array('placement' => 'PREPEND', 'tag' => 'label', 'class' => 'form-label')),
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper', 'id' =>'integer-wrapper'))
        )
    ));
    $subform->addElement('Text', 'date_to', array('placeholder'=>'to','autocomplete'=>'off'));
    $subform->addElement('Text', 'date_from', array('placeholder'=>'from','autocomplete'=>'off'));
    $this->addSubForm($subform, 'date');

    $this->addElement('Select', 'is_sponsored', array(
        'label' => "Sponsored",
        'required' => false,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
    ));

    $this->addElement('Select', 'is_featured', array(
        'label' => "Featured",
        'required' => false,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
    ));
    $this->addElement('Select', 'is_private', array(
        'label' => "Private",
        'required' => false,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
    ));
    $this->addElement('Hidden', 'order', array(
        'order' => 10004,
    ));
    $this->addElement('Hidden', 'order_direction', array(
        'order' => 10002,
    ));

    $this->addElement('Hidden', 'order_id', array(
        'order' => 10003,
    ));
    
    $this->addElement('Button', 'search', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
    ));
    $this->addElement('Dummy','#loadingimgecourse', array(
        'content' => '<img src="application/modules/Core/externals/images/loading.gif" style="display:none;" id="courses-search-order-img" alt="Loading" />',
    ));
    //Set default action without URL-specified params
    $params = array();
    foreach (array_keys($this->getValues()) as $key) {
      $params[$key] = null;
    }
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble($params));
  }
}
