<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Filter.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecoupon_Form_Admin_Filter extends Engine_Form {
  public function init() {
      $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
      $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');
      $this->addElement('Text', 'title', array(
          'label' => 'Coupon Title',
          'placeholder' => 'Enter Coupon Title',
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
      $multiOptions = array();
      $integratedModules = Engine_Api::_()->getDbtable('types', 'ecoupon')->getIntegratedModules(1);
      $integratedModuleArray = array();
      $multiOptions[''] = '';
      $multiOptions['all'] = 'Select All Integrated';
      if(!empty($integratedModules)){
        foreach($integratedModules as $integratedModule){
          $multiOptions[$integratedModule->item_type] = $integratedModule->title;
        }
      }
      $this->addElement('Select', 'item_type', array(
          'label' => "Type",
          'required' => false,
          'multiOptions' => $multiOptions,
          'decorators' => array(
              'ViewHelper',
              array('Label', array('tag' => null, 'placement' => 'PREPEND')),
              array('HtmlTag', array('tag' => 'div'))
          ),
      ));
      $this->addElement('Select', 'discount_type', array(
        'label' => "Discount Type",
        'required' => false,
        'multiOptions' => array("" => 'Select', "1" => "Fixed", "0" => "Percentage"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
      ));
      $this->addElement('Text', 'discount_min', array(
            'label' => 'Min',
            'id' => 'min',
            'placeholder'=>'min.',
            'value' => 0,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            )
      ));
      $this->addElement('Text', 'discount_max', array(
            'label' => 'Max',
            'id' => 'max',
            'placeholder'=>'max.',
            'value' => 100,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            )
      ));
      $this->addElement('Select', 'validity', array(
        'label' => "Coupon Validity",
        'required' => false,
        'multiOptions' => array("" => 'Select', "1" => "Active", "0" => "Expired"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
      ));
      $this->addElement('Select', 'enabled', array(
        'label' => "Coupon Status",
        'required' => false,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
      ));
      $this->addElement('Select', 'approved', array(
        'label' => "Approved",
        'required' => false,
        'multiOptions' => array("" => 'Select', "1" => "Yes", "0" => "No"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
      ));
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
      $this->addElement('Button', 'search', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
      ));
  }
}
