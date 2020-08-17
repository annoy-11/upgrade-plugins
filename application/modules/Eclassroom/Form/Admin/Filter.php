<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Filter.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Admin_Filter extends Engine_Form {
  public function init() {
   $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');
    $this->addElement('Text', 'classroom_title', array(
        'label' => 'Classroom Title',
        'placeholder' => 'Enter Classroom Title',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $this->addElement('Text', 'owner_name', array(
        'label' => 'Owner Name',
        'placeholder' => 'Enter Owner Name',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
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
    
    $categories = Engine_Api::_()->getDbTable('categories', 'courses')->getCategory(array('column_name' => array('category_id','category_name')));
    $data[''] = 'Choose a Category';
    foreach ($categories as $category) {
      $data[$category['category_id']] = $category['category_name'];
      $categoryId = $category['category_id'];
    }
    if (count($categories) > 1) {
      $this->addElement('Select', 'category_id', array(
          'label' => "Category",
          'required' => true,
          'multiOptions' => $data,
          'decorators' => array(
              'ViewHelper',
              array('Label', array('tag' => null, 'placement' => 'PREPEND')),
              array('HtmlTag', array('tag' => 'div'))
          ),
          'onchange' => "showSubCategory(this.value)",
      ));
      //Add Element: Sub Category
      $this->addElement('Select', 'subcat_id', array(
          'label' => "Sub Category",
          'onchange' => "showSubSubCategory(this.value)",
      ));
      //Add Element: Sub Category
      $this->addElement('Select', 'subsubcat_id', array(
          'label' => "Sub Sub Category",
      ));
    }
    $this->addElement('Select', 'featured', array(
        'label' => "Featured",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $this->addElement('Select', 'sponsored', array(
        'label' => "Sponsored",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $this->addElement('Select', 'hot', array(
        'label' => "Hot",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $this->addElement('Select', 'verified', array(
        'label' => "Verified",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $this->addElement('Select', 'is_approved', array(
        'label' => "Approved",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $this->addElement('Select', 'offtheday', array(
        'label' => "Of the Day",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $this->addElement('Select', 'discount', array(
        'label' => "Discount",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $this->addElement('Button', 'search', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
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
    //Set default action without URL-specified params
    $params = array();
    foreach (array_keys($this->getValues()) as $key) {
      $params[$key] = null;
    }
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble($params));
  }

}
