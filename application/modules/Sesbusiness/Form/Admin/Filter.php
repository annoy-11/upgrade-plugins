<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Filter.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Admin_Filter extends Engine_Form {

  public function init() {

    $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');

    $this->addElement('Text', 'name', array(
        'label' => 'Business Title',
        'placeholder' => 'Enter Business Title',
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
    $this->addElement('Text', 'creation_date', array(
        'label' => 'Creation Date Ex(yyyy-mm-dd)',
        'placeholder' => 'Enter Creation Date',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $categories = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getCategory(array('column_name' => '*'));
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
    if (SESBUSINESSPACKAGE == 1) {
      $packages = Engine_Api::_()->getDbTable('packages', 'sesbusinesspackage')->getPackage(array('default' => true));
      $packagesArray = array('' => 'Select');
      foreach ($packages as $package) {
        $packagesArray[$package['package_id']] = $package['title'];
      }
      if (count($packagesArray) > 1) {
        $this->addElement('Select', 'package_id', array(
            'label' => "Packages",
            'required' => true,
            'multiOptions' => $packagesArray,
            'decorators' => array(
                'ViewHelper',
                array('Label', array('tag' => null, 'placement' => 'PREPEND')),
                array('HtmlTag', array('tag' => 'div'))
            ),
        ));
      }
    }
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

    $this->addElement('Hidden', 'business_id', array(
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
