<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Wishlist.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Admin_Wishlist extends Engine_Form {

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
    $subform->addElement('Text', 'date_to', array('placeholder'=>'to'));
    $subform->addElement('Text', 'date_from', array('placeholder'=>'from'));
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

    $isEnablePackage = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesproductpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproductpackage.enable.package', 1);
    if($isEnablePackage){
        $packages = Engine_Api::_()->getDbTable('packages','sesproductpackage')->getPackage(array('default' => true));
        $packagesArray = array(''=>'');
        foreach($packages as $package){
            $packagesArray[$package['package_id']]	= $package['title'];
        }
        if(count($packagesArray) > 2) {
            $this->addElement('Select', 'package_id', array(
                'label' => "Packages",
                'required' => true,
                'multiOptions' => $packagesArray,
            ));
        }
    }

    $this->addElement('Button', 'search', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
    ));

    //Set default action without URL-specified params
    $params = array();
    foreach (array_keys($this->getValues()) as $key) {
      $params[$key] = null;
    }
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble($params));
  }
}
